<?php
class Main_m extends CI_Model {
    function __construct()
    {
	   parent::__construct();
    }

    public function check_allow($fbid){ 
        return $this->db->where(array('fbid' => $fbid))->count_all_results('users');
    }
    
    public function check_registered($fbid) {
        return $this->db->where(array('fbid' => $fbid, 'mobile !=' => ''))->count_all_results('users');
    }
    
    public function check_confirmed($fbid) {
        return $this->db->where('fbid', $fbid)->where('mobile !=', '')->where('registration_hash IS NULL', null, false)->count_all_results('users');
    }

    public function save_info($info){
        //fname, lname, fbid, token, gender, location
        $token = $this->facebook_m->get_access_token();
        
        $data = array(  'fbid' => $info['id'],
                        'first_name' => isset($info['first_name']) ? $info['first_name'] : '',
                        'last_name' => isset($info['last_name']) ? $info['last_name'] : '',
                        'mobile' => isset($info['email']) ? $info['mobile'] : '',
                        'email' => isset($info['email']) ? $info['email'] : '',
                        'fb_token' => isset($info['access_token']) ? $info['access_token'] : '',
                        'gender' => isset($info['gender']) ? $info['gender'] : '',
                        'location' => isset($info['location']['name']) ? $info['location']['name'] : '',
                        'date_reg' => date('Y-m-d H:i:s'),
                        'ip_address' => $this->input->ip_address()
                        );
        $this->db->insert('users', $data);
    }

    public function update_user($data){
        $this->db->where('fbid', $data['fbid'])->update('users', $data);
        return 1;
    }
    
    public function confirm_reg($fbid, $hash) {
        if($this->db->where(array('fbid' => $fbid, 'registration_hash' => $hash))->count_all_results('users')){
            $this->db->where('registration_hash', $hash)->update('users', array('active' => 1, 'registration_hash' => NULL));
            return 1;
        }
    }
    
    public function check_login($username, $password){
        $query = $this->db->where(array('username' => $username, 'password' => $password, 'active' => 1))->get('users');
        if($query->num_rows() > 0){
            return $query->row();  
        }
    }

    public function get_user_info($id){
        $query = $this->db->where(array('uid' => $id))->or_where('fbid', $id)->get('users');
        if($query->num_rows() > 0){
            return $query->row();  
        }
    }

    public function get_uinfo($email){
        $query = $this->db->where(array('email' => $email))->get('users');
        if($query->num_rows() > 0){
            return $query->row();  
        }
    }

    public function save_feedback($data){
        $data['date_posted'] = date("Y-m-d H:i:s");
        $this->db->insert('feedbacks', $data);
    }

    public function update_feedback($data, $id){
        $data['date_posted'] = date("Y-m-d H:i:s");
        $this->db->where('id', $id)->update('feedbacks', $data);
    }

    public function check_feedback_exists($uid, $fbid){
        $query = $this->db->where(array('uid_to' => $uid, 'fbid_from' => $fbid))->get('feedbacks');
        if($query->num_rows()){
            return $query->result_array();
        }

    }

    public function count_feedbacks($id, $get = array()){
        if(isset($get['feedback_type'])){
            $this->db->where('feedback_type', intval($get['feedback_type']));
        }

        return $this->db->where(array('uid_to' => $id))->count_all_results('feedbacks');
    }

    public function get_user_feedbacks($id, $limit=0, $offset=0, $get = array()){
        $this->db
              ->where(array('uid_to' => $id))
              ->join('users', 'feedbacks.fbid_from=users.fbid');
//echo "FB:".$get['feedback_type']; exit;
        if(isset($get['feedback_type']) && $get['feedback_type'] != ''){
            $this->db->where('feedback_type', intval($get['feedback_type']));
        }

        if($limit){
            $this->db->limit($limit, $offset);
        }
                      
        $query = $this->db->get('feedbacks');
        if($query->num_rows() > 0){
            return $query->result_array();  
        }
    }

    public function get_request_change($request_input){
        $query = $this->db->where('request_input', $request_input)->get('users');
        if($query->num_rows() > 0){
            return $query->row();
        }
    }

    public function save_captcha($data){
        $this->db->insert('captcha', $data);
    }
    public function verify_captcha($word, $ip_address){
        // First, delete old captchas
        $expiration = time()-7200; // Two hour limit
        $this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);  

        // Then see if a captcha exists:
        $sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
        $binds = array($word, $ip_address, $expiration);
        $query = $this->db->query($sql, $binds);
        $row = $query->row();

        if ($row->count > 0)
        {
            return TRUE;
        }
    }

    public function save_product($data){
        $data['active'] = 1;
        $data['date_posted'] = date("Y-m-d H:i:s");

        $this->db->insert('products', $data);
        return $this->db->insert_id();
    }

    public function count_total_ads($get=array()){
        $this->db->where('products.active', 1)
                 ->join('users', 'users.uid=products.author');

        if(isset($get['condition'])){
            $this->db->where('condition', $get['condition']);
        }

        if(isset($get['size'])){
            $this->db->where('size', intval($get['size']));
        }

        if(isset($get['location'])){
            $this->db->like('users.location', $get['location']);
        }

        if(isset($get['price_from']) && isset($get['price_to']) && $get['price_to'] >= $get['price_from']){
            $this->db->where('price >=', intval($get['price_from']))->where('price <=', intval($get['price_to']));
        }

        if(isset($get['uid'])){
            $this->db->where('users.uid', $get['uid']);
        }

        if(isset($get['search'])){
            $search_str = '(';
            $search_arr = explode(" ", $get['search']);
            foreach ($search_arr as $search) {
                $search_str .= "`title` LIKE '%$search%' OR `description` LIKE '%$search%' OR ";
            }
            $search_str = rtrim($search_str, ' OR ').')';
            $this->db->where($search_str);
        }

        return $this->db->count_all_results('products');
    }

    public function get_ads($limit=0, $offset=0, $sort_by=null, $sorting='DESC', $get=array()){
        $this->db->where('products.active', 1)
                 ->join('users', 'users.uid=products.author');
        if($limit){
            $this->db->limit($limit, $offset);
        }
        if($sort_by){
            $this->db->order_by($sort_by, $sorting);
        }

        if(isset($get['condition'])){
            $this->db->where('condition', $get['condition']);
        }

        if(isset($get['size_from']) && isset($get['size_to']) && $get['size_to'] >= $get['size_from']){
            $this->db->where('size >=', intval($get['size_from']))->where('size <=', intval($get['size_to']));
        }

        if(isset($get['location'])){
            $this->db->like('users.location', $get['location']);
        }

        if(isset($get['price_from']) && isset($get['price_to']) && $get['price_to'] >= $get['price_from']){
            $this->db->where('price >=', intval($get['price_from']))->where('price <=', intval($get['price_to']));
        }

        if(isset($get['uid'])){
            $this->db->where('users.uid', $get['uid']);
        }

        if(isset($get['search'])){
            $search_str = '(';
            $search_arr = explode(" ", $get['search']);
            foreach ($search_arr as $search) {
                $search_str .= "`title` LIKE '%$search%' OR `description` LIKE '%$search%' OR ";
            }
            $search_str = rtrim($search_str, ' OR ').')';
            $this->db->where($search_str);
        }

        $query = $this->db->get('products');

       // echo $this->db->last_query();

        if($query->num_rows()){
            return $query->result_array();
        }
    }

    public function get_product_info($id,$active = 1){
    	if($active != 0){
    		$this->db->where('products.active', $active);
    	}
        $query = $this->db->select('products.*, users.username, users.first_name, users.last_name, users.location, users.fbid, users.uid, users.mobile, users.email')->where(array('unique_id' => $id, 'users.active' => 1))->join('users', 'users.uid=products.author')->get('products');
        if($query->num_rows()){
            return $query->row();
        }
    }

    public function save_report($data){
        $data['date_posted'] = date("Y-m-d H:i:s");
        $this->db->insert('reports', $data);
    }

    public function check_valid_edit($id, $author){
        return $this->db->where(array('unique_id' => $id, 'author' => $author))->count_all_results('products');
    }

    public function update_product($data, $id){
        $data['date_updated'] = date("Y-m-d H:i:s");

        $this->db->where('unique_id', $id)->update('products', $data);
        return 1;
    }

    public function get_all_cities($pid = 0){ 
        if($pid){
            $this->db->where('province_id', $pid);
        }
        $q = $this->db->get('cities');

        if($q->num_rows()){
            return $q->result_array();
        }
    }

    public function get_all_provinces(){ 
        $q = $this->db->get('provinces');

        $provices = array();
        if($q->num_rows()){
            $result = $q->result_array();
            foreach($result as $province){
                $provinces[$province['id']] = $province['name'];
            }
            return $provinces;
        }
    }




    public function get_users(){
        $query = $this->db->get('users');
        if($query->num_rows() > 0){
            return $query->result();  
        }
    }
}
?>