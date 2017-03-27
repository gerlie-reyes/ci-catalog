<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Products extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('facebook_m');
        $this->load->model('main_m');
        $this->load->helper("security");

        $this->data['fb_data'] = $this->session->userdata('fb_data');
        
        if($this->session->userdata('is_logged_in') || $this->session->userdata('is_logged_infb')){
            $this->data['userdata'] = $this->data['logged_in_data'] = $this->main_m->get_user_info($this->session->userdata('uid'));
        }

        date_default_timezone_set('Asia/Manila');
    }

    function index(){
    	$this->q();
    }

    function q() {
        $this->data['title'] = "View Products";
        $this->data['page'] = "all_ads";

        $query = '';
        $get = $this->input->get();
        if($get){
        	$query = '/?';
        	$query .= http_build_query($get);
        }

        //echo "<pre>".print_r($get, 1)."</pre>"; exit;
        
        
		$uri_segment = 3;
		$post_per_page = 16;
		$base_url = site_url('products/q/');
        $total_rows = $this->main_m->count_total_ads($this->input->get(NULL, TRUE));
        $offset = $this->uri->segment($uri_segment);
        $sort_by = isset($get['price_from']) ? 'price' : 'date_posted';

        $products = $this->main_m->get_ads($post_per_page, $offset, $sort_by, 'DESC', $this->input->get(NULL, TRUE));

        $this->data['products'] = $products;
        $this->data['pagination'] = my_pagination($base_url, $total_rows, 3, $post_per_page, 'products', $query, $base_url.'/0'.$query);

        $this->load->view('template', $this->data);
    }	

    public function view($id=FALSE){
        $this->data['title'] = "View Product Information";
        $this->data['page'] = "single_ad";

        if(!$id){
            $this->data['error'] = "Please enter a product ID.";
        } else {
            $this->data['ad'] = $ad = $this->main_m->get_product_info($id, 0);
            if(!$ad){
                $this->data['error'] = "There is no result.";
            }else{
            //echo "<pre>"; print_r($ad);
            	if($ad->active == 2){
            		$this->data['error'] = "The shoes is already sold.";
            	}
            }
        }

        $this->load->view('template', $this->data);
    }

    public function edit($id=FALSE){
        $this->data['title'] = "Edit an Ad";
        $this->data['page'] = "edit_ad";
//echo "<pre>" . print_r($this->main_m->check_valid_edit($id, $this->data['userdata']->uid), 1) . "</pre>"; exit;
        if(!$this->session->userdata('is_logged_in') && !$this->session->userdata('is_logged_infb')) {
            redirect('main/signup', 'refresh');
        } else if(!$id){
            $this->data['error'] = "Error: Please provide a post ID to edit. ";
        } else if(!$this->main_m->check_valid_edit($id, $this->data['userdata']->uid)){
            $this->data['error'] = "Error: You can only edit your own post.";
        } else {
            $this->data['ad_info'] = $ad = $this->main_m->get_product_info($id);

            if($this->input->post()){
                $this->form_validation->set_rules('title', 'Title', 'required');
                $this->form_validation->set_rules('condition', 'Condition', 'required');
                $this->form_validation->set_rules('size', 'Size', 'required|numeric');
                $this->form_validation->set_rules('price', 'Selling Price', 'required|numeric');
                $this->form_validation->set_rules('description', 'Product description', 'required');
                $this->form_validation->set_rules('primary_photo', 'Primary Photo', 'required');

                if($this->form_validation->run() == TRUE){
                    $save_data = $this->input->post(NULL, TRUE);
                    $save_data['images'] = json_encode($this->input->post('images', TRUE));
     
                    if($this->main_m->update_product($save_data, $id)){
                        //save thumbnail of primary photo
                        save_thumb($this->input->post('primary_photo'));

                        $this->session->set_flashdata('saved', "Your product changes has been updated.");
                        redirect('products/view/'.$id.'/'.title_url($ad->title), 'refresh');
                    }
                }

                $this->data['images'] = $this->input->post('images');
            }
        }

        $this->load->view('template', $this->data);
    }

    public function sold(){
        $id = $this->input->post('id');
        $data = array('active' => 2);
        $this->main_m->update_product($data, $id);
        echo "1";
    }

    public function save_all_thumbs(){
        $products = $this->main_m->get_ads();

        foreach($products as $prod){
            save_thumb($prod['primary_photo']);
                    
            echo $prod['primary_photo']."<br>";
        }

    }
}