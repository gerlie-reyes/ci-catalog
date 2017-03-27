<?php
class Upload extends CI_Controller {

    public function __construct() {
    
        parent::__construct();
        // Load the helpers
        $this->load->helper(array('form', 'url'));
    }

    public function index() {
        
    }
    
    /**
     * Multiple upload functionality will fallback to CodeIgniters default do_upload() 
     * method so configuration is backwards compatible between do_upload() and the new do_multi_upload() 
     * method provided by Multi File Upload extension.
     *
     */
    public function do_upload(){
    
        // Detect form submission.
        if($this->input->post('submit')){
        
            $path = './includes/uploads/';
            $this->load->library('upload');
            
            /**
             * Refer to https://ellislab.com/codeigniter/user-guide/libraries/file_uploading.html 
             * for full argument documentation.
             *
             */  
             
            // Define file rules
            $this->upload->initialize(array(
                "upload_path"       =>  $path,
                "allowed_types"     =>  "gif|jpg|png",
                "max_size" => "400"
            ));
            
            if($this->upload->do_multi_upload("uploadfile")){
                
                $data['upload_data'] = $this->upload->get_multi_upload_data();
                
                echo '<p class = "bg-success">' . count($data['upload_data']) . 'File(s) successfully uploaded.</p>';
                
            } else {    
                // Output the errors
                $errors = array('error' => $this->upload->display_errors('<p class = "bg-danger">', '</p>'));               
            
                foreach($errors as $k => $error){
                    echo $error;
                }
                
            }
            
        } else {
            echo '<p class = "bg-danger">An error occured, please try again later.</p>';
            
        }
        // Exit to avoid further execution
        exit();
    }
}