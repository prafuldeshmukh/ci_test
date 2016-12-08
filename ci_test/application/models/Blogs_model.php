<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blogs_model extends CI_Model {

	
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	
	// public function create_blogs($username, $email, $password) {
		
	// 	$data = array(
	// 		'username'   => $username,
	// 		'email'      => $email,
	// 		'password'   => $this->hash_password($password),
	// 		'created_at' => date('Y-m-j H:i:s'),
	// 	);
		
	// 	return $this->db->insert('users', $data);
		
	// }

	// public function update_blogs($username, $email, $password) {
		
	// 	$data = array(
	// 		'username'   => $username,
	// 		'email'      => $email,
	// 		'password'   => $this->hash_password($password),
	// 		'created_at' => date('Y-m-j H:i:s'),
	// 	);
		
	// 	return $this->db->insert('users', $data);
		
	// }
	

	// public function delete_blogs($username, $email, $password) {
		
	// 	$data = array(
	// 		'username'   => $username,
	// 		'email'      => $email,
	// 		'password'   => $this->hash_password($password),
	// 		'created_at' => date('Y-m-j H:i:s'),
	// 	);
		
	// 	return $this->db->insert('users', $data);
		
	// }

	// public function get_blogs_data(){

	// }

	public function get_blogs_data($user_id) {
		
		$this->db->from('entry');
		$this->db->where('user_id', $user_id);
		return $this->db->get()->result();
		
	}
	public function get_single_blogs_data($id) {
		
		$this->db->from('entry');
		$this->db->where('id', $id);
		return $this->db->get()->row();
		
	}
	public function get_id($url) {
		//$seo_url=$this->seo_url($title);
		$this->db->from('entry');
		$this->db->where('seo_url =', $url);
		return $this->db->get()->row();
		
	}
	public function create_blogs($user_id, $title, $content) {
		$seo_url=$this->seo_url($title);
		$data = array(
			'user_id'   => $user_id,
			'title'      => $title,
			'description' =>$content,
			'seo_url' =>$seo_url,
			'created_date' => date('Y-m-j H:i:s'),
			'updated_date' => date('Y-m-j H:i:s')
		);
		
		return $this->db->insert('entry', $data);
		
	}

	public function update_blogs($id,$user_id, $title, $content) {
		$seo_url=$this->seo_url($title);
		$data = array(
			'title'      => $title,
			'description' =>$content,
			'seo_url' =>$seo_url,
			'updated_date' => date('Y-m-j H:i:s')
		);
		$this->db->where('id',$id);
        return $this->db->update('entry',$data);		
		//return $this->db->update('entry', $data);
		
	}

	public function seo_url($str){
	if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
		$str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
	$str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
	$str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
	$str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
	$str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
	$str = strtolower( trim($str, '-') );
	return $str;
}
	
	
	
}
