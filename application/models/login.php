<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Model {

	public function login_user($post) {
		// add user to db
		// VALIDATION
		$this->form_validation->set_rules("email", "Email Address", "trim|required|valid_email");
		$this->form_validation->set_rules("password", "Password", "trim|required");
		// END VALIDATION RULES
		if($this->form_validation->run() === FALSE) {
		     $this->session->set_flashdata("errors", validation_errors());
		     return FALSE;
		} else {
			$query = "SELECT * FROM users WHERE email = ? AND password = ?";
			$values = array($post['email'], $post['password']);
			$user = $this->db->query($query, $values)->row_array();
			if(empty($user)) {
				$this->session->set_flashdata("errors", "Email or password you entered is invalid.");
				return FALSE;
			} else {
				$this->session->set_userdata('id', $user['id']);
				return TRUE;
			}
		}
	}
	public function register_user($post) {
		// add user to db
		// VALIDATION
		$this->form_validation->set_rules("first_name", "First Name", "trim|required|alpha");
		$this->form_validation->set_rules("last_name", "Last Name", "trim|required|alpha");
		$this->form_validation->set_rules("alias", "Alias", "trim|required|alpha");
		$this->form_validation->set_rules("email", "Email Address", "trim|required|valid_email|is_unique[users.email]");
		$this->form_validation->set_rules("password", "Password", "trim|required|min_length[8]");
		$this->form_validation->set_rules("password_confirm", "Confirm Password", "trim|required|matches[password]");
		// END VALIDATION RULES
		if($this->form_validation->run() === FALSE) {
		     $this->session->set_flashdata("errors", validation_errors());
		} else {
			$query = "INSERT INTO users (first_name, last_name, alias, email, password, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
			$values = array($post['first_name'], $post['last_name'], $post['alias'], $post['email'], $post['password']);
			$this->db->query($query, $values);
		}
	}

	public function get_user_info() {
		$query = "SELECT first_name FROM users WHERE id = ?";
		$values = $this->session->userdata('id');
		$user = $this->db->query($query, $values)->row_array();
		return $this->db->query($query, $values)->row_array();
	}
	public function get_quotes() {
		$query = "SELECT users.alias as username, quotes.id, quotes.quote, quotes.author FROM quotes LEFT JOIN users ON quotes.users_id = users.id WHERE quotes.id NOT IN (SELECT quotes_id FROM favorites WHERE users_id = ?)";
		$values = $this->session->userdata('id');
		$quotes = $this->db->query($query, $values)->result_array();
		return $this->db->query($query, $values)->result_array();
	}
	public function add_quote($post) {
		$this->form_validation->set_rules("quote", "Quote", "trim|required");
		$this->form_validation->set_rules("author", "Author", "trim|required");
		// END VALIDATION RULES
		if($this->form_validation->run() === FALSE) {
		     $this->session->set_flashdata("errors", validation_errors());
		     return FALSE;
		} else {
			$query = "INSERT INTO quotes (quote, author, users_id, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())";
			$values = array($post['quote'], $post['author'], $this->session->userdata('id'));
			$this->db->query($query, $values);
		}
	}
	public function add_favorite($post) {
			$query = "INSERT INTO favorites (users_id, quotes_id, created_at, updated_at) VALUES (?, ?, NOW(), NOW())";
			$values = array($this->session->userdata('id'), $post['favorited']);
			$this->db->query($query, $values);
	}
	public function remove_favorite($post) {
		$query = "DELETE FROM favorites WHERE id = ?";
		$values = $post['unfavorited'];
		$this->db->query($query, $values);
	}
	public function get_favorites() {
		$query = "SELECT users.alias as username, quotes.quote, quotes.author, favorites.users_id, favorites.id as favorite FROM quotes JOIN users ON quotes.users_id = users.id JOIN favorites ON quotes.id = quotes_id WHERE favorites.users_id = ? ORDER BY favorites.id ASC";
		$values = array($this->session->userdata('id'));
		$favorites = $this->db->query($query, $values)->result_array();
		return $this->db->query($query, $values)->result_array();
	}

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */