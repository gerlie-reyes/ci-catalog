<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');

        //echo current_url();
        // if(current_url() == "http://sneakertrade.ph/"){
        //     redirect('http://siteforged.com/sneakertrade.ph/main/coming_soon', 'refresh');
        // }

        $this->load->model('facebook_m');
        $this->load->model('main_m');
        $this->load->helper("security");

        $this->data['fb_data'] = $this->session->userdata('fb_data');
        
        if($this->session->userdata('is_logged_in') || $this->session->userdata('is_logged_infb')){
            $this->data['logged_in_data'] = $this->data['userdata'] = $this->main_m->get_user_info($this->session->userdata('uid'));
        }

        date_default_timezone_set('Asia/Manila');
    }

    function coming_soon(){
        //$this->data['title'] = "Sneakertrade";
        //$this->data['page'] = "coming_soon";

        $this->load->view('pages/coming_soon', $this->data);
    }

    function index() {
        $this->data['title'] = "Sneakertrade PH";
        $this->data['page'] = "main";

        $this->data['latest_ads'] = $this->main_m->get_ads(6, 0, 'date_posted');

        $this->load->view('template', $this->data);
    }

    function signup() {
        $this->data['title'] = "Sign up With Facebook";
        $this->data['page'] = "fblogin";

        $user = $this->facebook_m->get_user();
        $fbid = $this->data['fb_data']['id'];

        if (!$this->session->userdata('is_logged_in') || !$this->session->userdata('is_logged_infb')) {
            $this->load->view('template', $this->data);
        } else if($this->main_m->check_registered($fbid) && !$this->main_m->check_confirmed($fbid)){
                redirect('main/resend_confirmation', 'refresh');
        } else if($this->main_m->check_registered($fbid) && $this->main_m->check_confirmed($this->data['fb_data']['id'])){ 
            redirect('main', 'refresh');
        } else {
            redirect('main/register', 'refresh');
        }
    }

    function register() {
        $this->data['title'] = "Register";
        $this->data['page'] = "register";
        $this->data['locations'] = $this->main_m->get_all_cities();
        $this->data['provinces'] = array_merge(array('0' => 'Select Province'), $this->main_m->get_all_provinces());


        $user = $this->facebook_m->get_user();
        $fbid = $this->data['fb_data']['id'];
        if (!$user['is_true']) {
            redirect('main/signup', 'refresh');
        } else if($this->main_m->check_registered($fbid) && !$this->main_m->check_confirmed($fbid)){
                redirect('main/resend_confirmation', 'refresh');
        } else if($this->main_m->check_registered($fbid) && $this->main_m->check_confirmed($this->data['fb_data']['id'])){ 
            redirect('main', 'refresh');
        } else {
            if ($this->input->post('submit_reg')) {
                $this->form_validation->set_rules('first_name', 'First Name', 'required');
                $this->form_validation->set_rules('last_name', 'Last Name', 'required');
                $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[users.email]');
                $this->form_validation->set_rules('location', 'Location', 'required');
                $this->form_validation->set_rules('mobile', 'Mobile', 'required');
                $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|is_unique[users.username]|alpha_dash');
                $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|matches[passconf]');
                $this->form_validation->set_rules('agreed', 'Terms & Conditions', 'callback_check_agreed');
                
                $this->form_validation->set_message('is_unique', 'The %s you have entered already exists.');

                if ($this->form_validation->run() == TRUE) {
                    $fbid = $this->input->post('fbid', TRUE);
                    $email = $this->input->post('email', TRUE);
                    //verify if the fbid of logged in user is the same as the passed fbid from the form
                    if ($fbid == $this->data['fb_data']['id']) {
                        $update_data = $this->input->post(NULL, TRUE);
                        $update_data['password'] = do_hash($this->input->post('password'));
                        $update_data['registration_hash'] = $registration_hash = $this->_generate_hash($email);
                        $update_data['uid'] = $this->_generate_unique_id();
                        unset($update_data['passconf']);
                        unset($update_data['submit_reg']);
                        unset($update_data['agreed']);

                        $updated = $this->main_m->update_user($update_data);

                        if ($updated) {
                            $this->_send_reg_mail($email, $registration_hash);
                        }
                    }
                    //redirect('main/thank-you', 'refresh');
                    redirect('main/confirm-registration', 'refresh');
                }
                //$this->data['fb_data']['email'] = "asdasd";
                $this->load->view('template', $this->data);
            } else {
                $this->data['fb_data'] = $this->session->userdata('fb_data');
                $this->load->view('template', $this->data);
            }
        }
    }

    function confirm_reg(){
        $this->data['title'] = "Thank you for registering";
        $this->data['page'] = "confirm_reg";
        $this->load->view('template', $this->data);
    }

    function check_password(){
        if (preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $this->input->post('password'))){
            return TRUE;
        } else {
            $this->form_validation->set_message('check_password', 'Your password must contain numbers, small letters and at least 1 capital letter.');
            return FALSE;
        }
    }

    function check_agreed() {
        if ($this->input->post('agreed')) {
            return TRUE;
        }
        $this->form_validation->set_message('check_agreed', 'You need to agree to the Terms and Conditions.');
        return FALSE;
    }

    private function _generate_hash($email) {
        return do_hash($email . "|" . time());
    }

    private function _generate_unique_id(){
        return random_string('alnum',20)."_".time(); 
    }

    private function _generate_request_input($email) {
        return do_hash($email . "|" . time()).':'.time();
    }

    public function thank_you() {
        $this->data['title'] = "Thank you for registering";
        $this->data['page'] = "thank_you_reg";
        $this->load->view('template', $this->data);
    }

    private function _send_reg_mail($email, $registration_hash) {
        $this->load->library('email');

        $this->email->from('no-reply@sneakertrade.ph', 'SneakerTradePH');
        $this->email->to($email);

        $this->email->subject('Sneakertrade | Registration');
        $this->email->message('Thank you for registering at SneakerTrade.ph. Please confirm your registration by clicking on this link:' . site_url('main/confirm-email/'.$this->data['fb_data']['id'].'/'.$registration_hash));

        $this->email->send();
    }
    
    public function confirm_email($fbid = "", $hash = ""){
        if($hash && $this->main_m->confirm_reg($fbid, $hash)){
            $this->session->set_userdata(array('is_logged_in' => TRUE, 'uid' => $fbid));
            redirect("main/thank-you");
        } else {
            //hash not existing error
            echo "Your registration has expired.";
        }
    }

    public function resend_confirmation() {
        $this->data['title'] = "Resend confirmation email";
        $this->data['page'] = "resend_confirm";

        if($this->input->post('resend')){
            $fbid_post = $this->input->post('fbid');
            $uinfo = $this->main_m->get_user_info($fbid_post);
            if($uinfo->active == 1){
                redirect('main', 'refresh');
            }

            if($fbid_post == $this->data['fb_data']['id']){ //double check logged in and paassed fbid from form
                $email = $this->input->post('email');
              //  $uinfo = $this->main_m->get_user_info($fbid_post);
                $registration_hash = $this->_generate_hash($email);
                $this->_send_reg_mail($email, $registration_hash);

                $this->main_m->update_user(array('email' => $email, 'registration_hash' => $registration_hash, 'fbid' => $fbid_post));

                $this->data['resent_msg'] = "A new confirmation email has been sent to $email.";
            } else {
                $this->data['resent_error'] = "You are not logged in. Please login using your Facebook account.";

            }
        }

        $this->load->view('template', $this->data);
    }
    
    public function dologin() {
        $username = $this->input->post("username", TRUE);
        $password = $this->input->post("password", TRUE);
        
        $user = $this->main_m->check_login($username, do_hash($password));
        if($user){
            $this->session->set_userdata(array('is_logged_in' => TRUE,'uid' => $user->fbid));
        } else {
            $this->session->set_flashdata('login_error', 'Incorrect username and password.');
        }
        redirect('main', 'refresh');
    }

    public function logout() {
        $this->session->unset_userdata('uid');
        $this->session->unset_userdata('is_logged_in');
        $this->session->unset_userdata('fb_data');
        $this->auth->logout();
    }

    public function forgot_password() {
        $this->data['title'] = "Forgot password";
        $this->data['page'] = "forgot_password";
        //$fbid = $this->data['userdata']->fbid;

        if($this->input->post()){
            $email = $this->input->post('email');
            $uinfo = $this->main_m->get_uinfo($email);
            if($uinfo && $uinfo->active == 1){
                $request_input = $this->_generate_request_input($email);
                $link = site_url('change-password/'.$request_input);

                $config['mailtype'] = 'html';
                $this->load->library('email', $config);
                $this->email->from('no-reply@sneakertrade.ph', 'SneakerTradePH');
                $this->email->to($email);

                $this->email->subject('SneakertradePH | Reset Your Password');
                $view = $this->load->view('pages/reset_password_mail', array('name' => $uinfo->first_name, 'username' => $uinfo->username, 'link' => $link), TRUE);
                $this->email->message($view);
                $this->email->send();

                $this->main_m->update_user(array('fbid' => $uinfo->fbid,
                                                 'request_input' => $request_input));

                $this->data['sent'] = "A link to reset your password has been sent to $email.";
            } else {
                $this->data['error'] = "The email you have provided does not exist in our database.";
            }

             
        } /* else {
            $this->data['error'] = "You are not logged in. Please login using your Facebook account.";

        }*/
    

        $this->load->view('template', $this->data);
    }

    public function change_password($request_input){
        list($hash, $reqtime) = explode(':', $request_input);
        $time = time();
        $diff = $time - $reqtime;
        $user = $this->main_m->get_request_change($request_input);
        if($diff / 3600 >= 24 || !$user){
            $this->data['error'] = "Your request to change your password has expired. You can request again to change it.";
        } else {
            if($this->input->post()){
                $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|matches[passconf]');

                if ($this->form_validation->run() == TRUE) {
                    $save_data = array('password' => do_hash($this->input->post('password', TRUE)), 'fbid' => $user->fbid, 'request_input' => NULL);
                    $this->main_m->update_user($save_data);
                    $this->data['changed'] = "Your password has been changed.";
                }
            }
        }

        $this->data['title'] = "Change password";
        $this->data['page'] = "change_password";
        $this->data['request_input'] = $request_input;

        $this->load->view('template', $this->data);
    }

    public function post_ad(){
        $this->data['title'] = "Post an Ad";
        $this->data['page'] = "post_ad";

        if(!$this->session->userdata('is_logged_in') && !$this->session->userdata('is_logged_infb')) {
            redirect('main/signup', 'refresh');
        }

        if($this->input->post()){
            $this->form_validation->set_rules('captcha', 'Captcha', 'required|callback_check_captcha');
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('condition', 'Condition', 'required');
            $this->form_validation->set_rules('size', 'Size', 'required|numeric');
            $this->form_validation->set_rules('price', 'Selling Price', 'required|numeric');
            $this->form_validation->set_rules('description', 'Product description', 'required');
            $this->form_validation->set_rules('primary_photo', 'Primary Photo', 'required');

            if($this->form_validation->run() == TRUE){
                $save_data = $this->input->post(NULL, TRUE);
                $save_data['images'] = json_encode($this->input->post('images', TRUE));
                $save_data['author'] = $this->data['userdata']->uid;
                $save_data['unique_id'] = $unique_id = $this->_generate_unique_id();
                unset($save_data['captcha']);
 
                if($this->main_m->save_product($save_data)){
                    //save thumbnail of primary photo
                    save_thumb($this->input->post('primary_photo'));
                    
                    $this->session->set_flashdata('saved', "Your product has been posted.");
                    redirect('products/view/'.$unique_id.'/'.title_url($save_data['title']), 'refresh');
                }
            }

            $this->data['images'] = $this->input->post('images');
        }

        $this->data['captcha_img'] = $this->_generate_captcha();

        $this->load->view('template', $this->data);
    }

    private function _generate_captcha(){
        $vals = array(
            'img_path'  => './includes/captcha/',
            'img_url'   => base_url().'includes/captcha/',
            'img_width' => 100,
            'img_height' => 30,
            'expiration' => 7200
            );

        $cap = create_captcha($vals);

        $data = array(
            'captcha_time'  => $cap['time'],
            'ip_address'    => $this->input->ip_address(),
            'word'  => $cap['word']
            );

        $this->main_m->save_captcha($data);
        return $cap['image'];
    }

    public function check_captcha(){
        $verified = $this->main_m->verify_captcha($this->input->post('captcha'), $this->input->ip_address());
        if($verified){
            return TRUE;
        }
        $this->form_validation->set_message('check_captcha', 'The %s you have entered is incorrect.');
        return FALSE;
    }

    public function do_upload(){
        if(!$this->session->userdata('is_logged_in') && !$this->session->userdata('is_logged_infb')) {
            echo json_encode(array('errors' => 'Please login to upload files.')); die();
        }
        // Detect form submission.
        //if($this->input->post()){
        
            $path = './includes/uploads/';
            $this->load->library('upload');
            
            // Define file rules
            $this->upload->initialize(array(
                "upload_path"       =>  $path,
                "allowed_types"     =>  "gif|jpg|png|jpeg",
                "max_size" => "2000"
            ));
            
            if($this->upload->do_multi_upload("uploadfile")){
                
                $data['upload_data'] = $upload_data = $this->upload->get_multi_upload_data();

                echo json_encode($upload_data);
                
            } else {    
                // Output the errors
                //$errors = array('error' => $this->upload->display_errors());               
            
                echo json_encode(array('errors' => $this->upload->display_errors()));
            }
            
        // } else {
        //    echo json_encode(array('errors' => 'An error occured. Please try again.'));
        // }
        // Exit to avoid further execution
        exit;
    }
    
    public function about() {
        $this->data['title'] = "About";
        $this->data['page'] = "about";
        $this->load->view('template', $this->data);
    }

    public function disclaimers() {
        $this->data['title'] = "Disclaimers";
        $this->data['page'] = "disclaimers";
        $this->load->view('template', $this->data);
    }

    public function terms() {
        $this->data['title'] = "Terms of Use";
        $this->data['page'] = "terms";
        $this->load->view('template', $this->data);
    }


    public function users(){
        $users = $this->main_m->get_users();


        echo "TOTAL: ".count($users)."<br>";

        $active = 0;
        foreach ($users as $user) {
            if($user->active == 1){ 
                $active++;
            }
        }
        echo "ACTIVE: ".$active."<br>";

        $fb_only = 0;
        foreach ($users as $user) {
            if($user->active == 0 && $user->registration_hash == NULL){
                $fb_only++;
            }
        }
        echo "ALLOW FB ONLY: ".$fb_only."<br>";

        $not_confirm = 0;
        foreach ($users as $user) {
            if($user->active == 0 && $user->registration_hash != NULL){
                $not_confirm++;
            }
        }
        echo "DID NOT CONFIRM EMAIL: ".$not_confirm."<br>";
    }

}