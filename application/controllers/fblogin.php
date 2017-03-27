<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fblogin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('facebook_m');
        date_default_timezone_set('Asia/Manila');
        $this->load->model('main_m');

        //  $this->data['fb_data'] = $this->session->userdata('fb_data');
        //$this->output->enable_profiler(TRUE);
    }

    function index() {
        
    }

    function do_login() {
        $result = $this->facebook_m->get_user();

        if ($result['is_true']) {
            $this->session->set_userdata(array('fb_data' => $this->facebook->api('/'.$result['facebook_uid'])));
            echo '<script type="text/javascript" charset="utf-8">
                        top.location.href = "' . site_url('fblogin/fb', 'refresh') . '";
                        </script>';
        } else {
            $allow_url = $this->facebook->getLoginURL($this->config->item('facebook_login_parameters'));
            echo '<script type="text/javascript" charset="utf-8">
                        top.location.href = "' . $allow_url . '"; 
                        </script>';
        }
    }

    public function logout() {
        $this->auth->logout();
    }

    public function fb() {
        $result = $this->facebook_m->get_user();
        if ($result['is_true']) {
            $info = $this->facebook->api('/me');
            $this->session->set_userdata(array('fb_data' => $info));
            
            $fbid = $info['id'];
            if (!$this->main_m->check_allow($fbid)) {
                $this->main_m->save_info($info);
                redirect('main/register', 'refresh');
            } else {
                if ($this->main_m->check_registered($fbid)) {
                    if ($this->main_m->check_confirmed($fbid)) {
                        $this->session->set_userdata(array('uid' => $result['facebook_uid'], 'is_logged_infb' => TRUE));
                        redirect('main', 'refresh');
                    } else {
                        redirect('main/resend_confirmation', 'refresh');
                    }
                } else {
                    redirect('main/register', 'refresh');
                }
            }
        } else {
            redirect('fblogin/do_login', 'refresh');
        }
    }

    public function test() {
        $this->load->view("pages/fblogin", array("title" => "Test"));
    }

}