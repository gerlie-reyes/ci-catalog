<?php
if(!function_exists("get_fbpic")){
	function get_fbpic($fbid, $type = 'normal'){
		return "http://graph.facebook.com/$fbid/picture?type=".$type;
	}
}

if(!function_exists('my_pagination')){
	function my_pagination($base_url, $total_rows, $uri_segment, $posts_per_page, $tag_open_class, $suffix = '', $first_url=''){
		$CI =& get_instance();
	
		$config['base_url'] = $base_url;
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $posts_per_page; 
		$config['uri_segment'] = $uri_segment;
		$config['num_links'] = 5;
		$config['full_tag_open'] = '<div class="'.$tag_open_class.'"><ul class="pagination pull-right">';
		$config['full_tag_close'] = '</ul></div>';
		$config['cur_tag_open'] = '<li><a onclick="return false;" style="color:#666666;">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['last_link'] = '&gt;&gt;';
		$config['first_link'] = '&lt;&lt;';
		$config['suffix'] = $suffix;
		$config['first_url'] = $first_url;
		
		$CI->pagination->initialize($config); 
		
		return $CI->pagination->create_links();
	}
}

if(!function_exists('title_url')){
	function title_url($title){
		$title = preg_replace('/[^A-Za-z0-9\-]/', '-', $title);
		return str_replace("+", "-", urlencode(strtolower($title)));
	}
}

if(!function_exists('compute_feedbacks')){
	function compute_feedbacks($uid){
		$ci =& get_instance();
		$ci->load->model('main_m');
		$ufeedbacks = $ci->main_m->get_user_feedbacks($uid);
		$feedbacks = count($ufeedbacks);
		$pos = 0;
		$neg = 0;

		if($ufeedbacks) foreach ($ufeedbacks as $feedback) {
		    if($feedback['feedback_type'] == 1){
		        $pos++;
		    } else {
		    	$neg++;
		    }
		}

		//$positive = $feedbacks > 0 ? number_format($pos / $feedbacks * 100) : 0;
		//return $feedbacks . ',' . $positive;

		$result = $pos - $neg;
		return $result;
	}
}

function save_thumb($filename){
	$ci =& get_instance();

	//save thumbnail of primary photo
	$r_config['image_library'] = 'gd2';
	$r_config['create_thumb'] = TRUE;
	$r_config['maintain_ratio'] = TRUE;
	$r_config['width']  = 170;
	$r_config['height'] = 143;
	$r_config['thumb_marker'] = '';
	$r_config['quality'] = '100';
	$r_config['source_image']   = './includes/uploads/'.$filename;
	$r_config['new_image'] = './includes/uploads/thumbnails/'.$filename;
	$ci->load->library('image_lib'); 

	$ci->image_lib->initialize($r_config);
	$ci->image_lib->resize();
	$ci->image_lib->clear();
}
?>