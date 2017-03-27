<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Profile extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('facebook_m');
        $this->load->model('main_m');
        $this->load->helper("security");

        $this->data['title'] = "SneakerTrade PH";
        $this->data['fb_data'] = $this->session->userdata('fb_data');
        $this->data['userdata'] = $uinfo = $this->user_info($this->uri->segment(3));
        $this->data['logged_in_data'] = $this->user_info($this->session->userdata('uid'));
        
        //if uid is passed, looking at other profile.
        //if no uid is passed, looking at own profile.
        if(isset($uinfo->uid)){
            $this->data['ufeedbacks'] = compute_feedbacks($uinfo->uid);
        }
        

        date_default_timezone_set('Asia/Manila');
    }

    function index($uid = '') {
        $this->view($uid);
    }

    function view($uid = '') {
        $this->data['page'] = "profile_member_ads";       

        if($uid == '' && !$this->session->userdata('is_logged_in') && !$this->session->userdata('is_logged_infb')){
            redirect('main/signup', 'refresh]');
        }

        $this->data['userdata'] = $userdata = $this->user_info($uid);
        $this->data['uid'] = $uid = $uid != '' ? $uid : $userdata->uid;




        /*member ads*/
        $query = '';
        $get = $this->input->get(NULL, TRUE);
        $get['uid'] = $uid;
        if($get){
            $query = '/?';
            $query .= http_build_query($get);
        }
        
        $uri_segment = $uid == '' ? 3 : 4;
        $post_per_page = 25;
        $base_url = site_url("profile/view/$uid/");
        $total_rows = $this->main_m->count_total_ads($get);
        $offset = $this->uri->segment($uri_segment);
        $sort_by = isset($get['sort_by']) ? $get['sort_by'] : 'price';

        $products = $this->main_m->get_ads($post_per_page, $offset, $sort_by, 'ASC', $get);

        $this->data['products'] = $products;
        $this->data['pagination'] = my_pagination($base_url, $total_rows, $uri_segment, $post_per_page, 'products', $query, $base_url.'/0'.$query);
        /*end member ads*/




        $this->load->view('template', $this->data);
    }

    function user_info($uid = ''){
        if($uid){
        	return $this->main_m->get_user_info($uid);
        } else{
        	if($this->session->userdata('is_logged_in') || $this->session->userdata('is_logged_infb')){
	            return $this->main_m->get_user_info($this->session->userdata('uid'));
	        } else {
	        	//redirect('main', 'refresh');
	        	return FALSE;
	        }
        }
    }

    function feedbacks($uid = '') {
        $this->data['title'] = "SneakerTrade PH | Sign Up";
        $this->data['page'] = "profile_feedbacks";

        if($uid == '' && !$this->session->userdata('is_logged_in') && !$this->session->userdata('is_logged_infb')){
            redirect('main/signup', 'refresh]');
        }

        $query = '';
        $get = $this->input->get(NULL, TRUE);
        if($get){
            $query = '/?';
            $query .= http_build_query($get);
        }



        $this->data['uid'] = $uid = $uid != '' ? $uid : $this->data['userdata']->uid;
        $total_rows = $this->main_m->count_feedbacks($uid, $get);
        $base_url = site_url('profile/feedbacks/'.$uid.'/');
        $post_per_page = 15;
        $offset = $this->uri->segment(4);

        $this->data['feedbacks'] = $this->main_m->get_user_feedbacks($uid, $post_per_page, $offset, $get);
        $this->data['pagination'] = my_pagination($base_url, $total_rows, 4, $post_per_page, 'feedbacks', $query, $base_url.'/0'.$query);

        $this->load->view('template', $this->data);
    }
    
    function new_feedback($uid = '') {
        $this->data['page'] = "profile_new_feedback";
        $this->data['uid'] = $uid;       

        $valid_info = $this->_validate_feedback($uid);
        if(isset($valid_info->err)){
        	$this->data['err'] = $valid_info->err;
        }

        $fbid = $this->session->userdata('uid'); 
        $this->data['existing'] = $existing = $this->main_m->check_feedback_exists($uid, $fbid);

        //echo "<pre>".print_r($existing, 1)."</pre>";
        
        
        if($_POST && !isset($valid_info->err)){
        	$this->form_validation->set_rules('feedback_type', 'Feedback', 'required|integer');
        	$this->form_validation->set_rules('comment', 'Message', 'required');

        	if ($this->form_validation->run() == TRUE) {
        		$save_data = $this->input->post(NULL, TRUE);
        		$save_data['fbid_from'] = $fbid;
        		$save_data['uid_to'] = $uid;

                if(!$existing){
                    $this->main_m->save_feedback($save_data);
                } else {
                    $this->main_m->update_feedback($save_data, $existing[0]['id']);
                }

        		$this->session->set_flashdata('feedback_saved', TRUE);
        		redirect('profile/view/'.$uid, 'refresh');
        	}
        }

        
        $this->load->view('template', $this->data);
    }

    private function _validate_feedback($uid) {
    	$receiver_info = $this->main_m->get_user_info($uid);
    	$fbid = $this->session->userdata('uid');
    	$return = new stdClass();

    	if(!$this->session->userdata('is_logged_in') && !$this->session->userdata('is_logged_infb')){
            $return->err = "You need to be logged in to rate or report a member.";
        }else if(!$uid){
        	$return->err = "Error: Choose feedback receiver.";
        } else if(!$receiver_info){
        	$return->err = "Error: User does not exist.";
        }/* else if($this->main_m->check_feedback_exists($uid, $fbid)){
        	$return->err = "Error: You have already sent a feedback to this seller.";
        }*/ else{
    		if($receiver_info->fbid == $fbid){
        		$return->err = "Error: Cannot comment on your own account.";
        	} else {
        		$return = $receiver_info;
        	}
        }

        return $return;
    }
    
    function report($uid = '') { 
        $this->data['title'] = "SneakerTrade PH | Report a User";
        $this->data['page'] = "profile_report";
        $this->data['uid'] = $uid = $uid != '' ? $uid : $this->data['userdata']->uid;

        $valid_info = $this->_validate_feedback($uid);
        if(isset($valid_info->err)){
            $this->data['err'] = $valid_info->err;
        }

        $valid_info = $this->validate_report($uid);
        if(isset($valid_info->err)){
            $this->data['err'] = $valid_info->err; //echo $valid_info->err; exit;
        } else if($_POST && !isset($valid_info->err)){
            $this->form_validation->set_rules('reason', 'Reason', 'required');
            $this->form_validation->set_rules('message', 'Message', 'required');

            $fbid = $this->session->userdata('uid');
            if ($this->form_validation->run() == TRUE) {
                $save_data = $this->input->post(NULL, TRUE);
                $save_data['fbid_from'] = $fbid;
                $save_data['uid_to'] = $uid;
                $this->main_m->save_report($save_data);

                $this->session->set_flashdata('report_saved', TRUE);
                redirect('profile/report/'.$uid, 'refresh');
            }
        }
 

        $this->load->view('template', $this->data);
    }

    public function validate_report($uid){
        $receiver_info = $this->main_m->get_user_info($uid);
        $fbid = $this->session->userdata('uid');
        
        $return = new stdClass();
        if(!$uid){
            $return->err = 'Error: Choose feedback receiver.'; 
        } else if(!$receiver_info){
            $return->err = 'Error: User does not exist.';
        } else{
            if($receiver_info->fbid == $fbid){
                $return->err = 'Error: Cannot report your own account.';
            } else {
                $return = $receiver_info;
            }
        }
        return $return;
    }

    function edit(){
        $this->data['title'] = "SneakerTrade PH | Edit Profile";
        $this->data['page'] = "profile_edit";

        $fbid = $this->data['userdata']->fbid;
        if(!$this->session->userdata('is_logged_in') && !$this->session->userdata('is_logged_infb')){
            redirect('main/signup');
        } else if($this->uri->segment(3) && $this->data['logged_in_data']->uid != $this->uri->segment(3)){
            redirect('profile', 'refresh');
        } else if($this->main_m->check_registered($fbid) && !$this->main_m->check_confirmed($fbid)){
            redirect('main/resend_confirmation', 'refresh');
        } else {
            if ($this->input->post()) {
                $this->form_validation->set_rules('first_name', 'First Name', 'required');
                $this->form_validation->set_rules('last_name', 'Last Name', 'required');
                $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|callback_verify_email_edit');
                $this->form_validation->set_rules('location', 'Location', 'required');
                $this->form_validation->set_rules('mobile', 'Mobile', 'required');

                $this->form_validation->set_rules('password', 'Password', 'matches[passconf]');

                //$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|matches[passconf]');
               // $this->form_validation->set_rules('agreed', 'Terms & Conditions', 'callback_check_agreed');
                $this->form_validation->set_message('is_unique', 'The %s you have entered already exists.');
                $this->form_validation->set_message('verify_email_edit', 'The %s you have entered already exists.');

                if ($this->form_validation->run() == TRUE) {
                   $fbid = $this->data['userdata']->fbid;

                    $email = $this->input->post('email', TRUE);
                    $update_data = $this->input->post(NULL, TRUE);
                    $update_data['fbid'] = $fbid;
                    unset($update_data['passconf']);
                    unset($update_data['username']);
                    unset($update_data['agreed']);

                    if($this->input->post('password')){
                        $update_data['password'] = do_hash($this->input->post('password'));
                    } else {
                        unset($update_data['password']);
                    }

                    $updated = $this->main_m->update_user($update_data);

                    if ($updated) {
                        $this->session->set_flashdata('message', "Your profile has been updated");
                        redirect('profile', 'refresh');
                    }
                }
            } else {
                $this->data['fb_data'] = $this->session->userdata('fb_data');
            }
        }

        $this->load->view('template', $this->data);
    }

    public function verify_email_edit(){
        $email = $this->input->post('email');
        $user_info = $this->main_m->get_uinfo($email);
        $uid = $this->data['userdata']->uid;
        if($user_info && $user_info->uid == $uid){
            return TRUE;
        }
        return FALSE;
    }
    function check_agreed() {
        if ($this->input->post('agreed')) {
            return TRUE;
        }
        $this->form_validation->set_message('check_agreed', 'You need to agree to the Terms and Conditions.');
        return FALSE;
    }
    function check_password(){
        if (preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $this->input->post('password'))){
            return TRUE;
        } else {
            $this->form_validation->set_message('check_password', 'Your password must contain alphanumeric characters and atleast 1 capital letter.');
            return FALSE;
        }
    }

    public function udata()
    {
        echo "<pre>".print_r($this->session->all_userdata(), 1)."</pre>";
    }
}