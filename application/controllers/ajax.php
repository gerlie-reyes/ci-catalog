<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('main_m');
        date_default_timezone_set('Asia/Manila');
    }

    function get_cities(){
        $pid = $this->input->post('pid');
        $cities = $this->main_m->get_all_cities($pid);

        if($cities && !empty($cities)){
            $return = array();
            foreach($cities as $city){
                $return[] = $city['name'];
            }

            echo json_encode($return);
        }
        
    }
}