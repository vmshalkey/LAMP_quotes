<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logins extends CI_Controller {

	public function index() {
		$this->load->view('login_home');
	}
	public function login_user() {
		if($this->login->login_user($this->input->post())){
			redirect('/welcome');
		} else {
			redirect('/');
		}
	}
	public function register_user() {
		$this->login->register_user($this->input->post());
		redirect('/');
	}

	public function show() {
		$user = $this->login->get_user_info();
		$quotes = $this->login->get_quotes();
		$favorites = $this->login->get_favorites();
		$this->load->view("welcome", array("user" => $user, "quotes" => $quotes, "favorites" => $favorites));
	}
	public function add_quote() {
		$this->login->add_quote($this->input->post());
		redirect('welcome');
	}
	public function logoff_user() {
		$this->session->sess_destroy();
		redirect('/');
	}
	public function add_favorite() {
		$this->login->add_favorite($this->input->post());
		redirect('welcome');
	}
	public function remove_favorite() {
		$this->login->remove_favorite($this->input->post());
		redirect('welcome');
	}
}

/* End of file logins.php */
/* Location: ./application/controllers/logins.php */