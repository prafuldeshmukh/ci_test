<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Blogs extends CI_Controller {

	
	public function __construct() {		
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->model('blogs_model');
		
	}	
	
	public function index() {		
      $user_id=$this->session->userdata('user_id');	
      if(isset($user_id)){
      $data['blogs'] = $this->blogs_model->get_blogs_data($user_id);
      $this->load->view('header');
	  $this->load->view('blogs/blogs',$data);
	  $this->load->view('footer');  
	}else{
		 redirect('user/login');
	}
		
	}

	public function create() {
		
		
		$data = new stdClass();
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('content', 'Content', 'trim|required');
		
		if ($this->form_validation->run() === false) {
			
		
			$this->load->view('header');
			$this->load->view('blogs/create', $data);
			$this->load->view('footer');
			
		} else {
			
			
			$title = $this->input->post('title');
			$content    = $this->input->post('content');
			$user_id=$this->session->userdata('user_id');	
			if ($this->blogs_model->create_blogs($user_id,$title,$content)) {				
			    $this->session->set_flashdata('msg', 'The blogs has been created');
				 redirect('user/login');
				
			} else {
				
				
				$data->error = 'There was a problem creating your blogs. Please try again.';
				
			
				$this->load->view('header');
				$this->load->view('blogs/create', $data);
				$this->load->view('footer');
				
			}
			
		}
		
	}


	public function edit() {		
		
		//$data = new stdClass();
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('content', 'Content', 'trim|required');
		
		if ($this->form_validation->run() === false) {
			
		    $id=$this->uri->segment(3);
		    $info=$this->blogs_model->get_id($id);
		    // print_r($info);
		    // exit();
            $data['blogs_single']=$this->blogs_model->get_single_blogs_data($info->id);
            // print_r($data['blogs_single']);
            // exit();
		    $this->load->view('header');
			$this->load->view('blogs/edit', $data);
			$this->load->view('footer');
			
		} else {
			
			
			$title = $this->input->post('title');
			$content    = $this->input->post('content');
			$user_id=$this->session->userdata('user_id');
			$id=$this->uri->segment(3);
			$info=$this->blogs_model->get_id($id);
			if ($this->blogs_model->update_blogs($info->id,$user_id,$title,$content)) {				
			    $this->session->set_flashdata('msg', 'The blogs has been updated');
				 redirect('user/login');
				
			} else {				
				
				$data->error = 'There was a problem creating your blogs. Please try again.';				
			
				$this->load->view('header');
				$this->load->view('blogs/create', $data);
				$this->load->view('footer');
				
			}
			
		}
		
	}

	public function delete($id){
        $this->db->where('id', $id);
        $this->db->delete('entry');
        $this->session->set_flashdata('msg', 'The blogs has been deleted');
		redirect('user/login');

	}
	
	
	
	
}
