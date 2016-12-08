<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class User extends CI_Controller {

	
	public function __construct() {
		
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->model('user_model');
		$this->load->model('blogs_model');

		
	}
	
	
	public function index() {
		

		
	}
	
	/**
	 * register function.
	 * 
	 * @access public
	 * @return void
	 */
	public function register() {
		
		
		$data = new stdClass();
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// set validation rules
		$this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[4]|is_unique[users.username]', array('is_unique' => 'This username already exists. Please choose another one.'));
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');
		
		if ($this->form_validation->run() === false) {
			
		
			$this->load->view('header');
			$this->load->view('user/register/register', $data);
			$this->load->view('footer');
			
		} else {
			
			
			$username = $this->input->post('username');
			$email    = $this->input->post('email');
			$password = $this->input->post('password');
			
			if ($this->user_model->create_user($username, $email, $password)) {
				
			
				$this->load->view('header');
				$this->load->view('user/register/register_success', $data);
				$this->load->view('footer');
				
			} else {
				
				
				$data->error = 'There was a problem creating your new account. Please try again.';
				
			
				$this->load->view('header');
				$this->load->view('user/register/register', $data);
				$this->load->view('footer');
				
			}
			
		}
		
	}
		
	/**
	 * login function.
	 * 
	 * @access public
	 * @return void
	 */
	public function login() {
		
		
		//$data = new stdClass();	
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($this->form_validation->run() == false) {
			
			if($this->session->userdata('logged_in')){
			  $user_id=$this->session->userdata('user_id');	
              $data['blogs'] = $this->blogs_model->get_blogs_data($user_id);
              $this->load->view('header');
			  $this->load->view('blogs/blogs', $data);
			  $this->load->view('footer');
			}else{
			  $this->load->view('header');
			  $this->load->view('user/login/login');
			  $this->load->view('footer');	
			}
			
			
		} else {
			
			
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			
			if ($this->user_model->resolve_user_login($username, $password)) {
				
				$user_id = $this->user_model->get_user_id_from_username($username);
				$user    = $this->user_model->get_user($user_id);
				
				// set session user datas
				$_SESSION['user_id']      = (int)$user->id;
				$_SESSION['username']     = (string)$user->username;
				$_SESSION['logged_in']    = (bool)true;
				// $this->session->set_userdata('user_id',$user->id);
				// $this->session->set_userdata('username',(string)$user->username);
				// $this->session->set_userdata('logged_in',(bool)true);
							
				// user login ok
				// echo $user->id;
				$data['blogs']= $this->blogs_model->get_blogs_data($user->id);
				// print_r($blogs);
				// exit();
				$this->load->view('header');
				$this->load->view('blogs/blogs', $data);
				$this->load->view('footer');
				
			} else {
				
				
				$data->error = 'Wrong username or password.';				
			
				$this->load->view('header');
				$this->load->view('user/login/login', $data);
				$this->load->view('footer');
				
			}
			
		}
		
	}
	
	/**
	 * logout function.
	 * 
	 * @access public
	 * @return void
	 */
	public function logout() {
		
	
		$data = new stdClass();
		
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			
			
			foreach ($_SESSION as $key => $value) {
				unset($_SESSION[$key]);
			}
			
			
			$this->load->view('header');
			$this->load->view('user/logout/logout_success', $data);
			$this->load->view('footer');
			
		} else {
			
			
			redirect('/user/login');
			
		}
		
	}
	
}
