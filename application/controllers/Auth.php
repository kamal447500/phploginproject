<?php

class Auth extends CI_Controller
{

	public function logout()
	{
		unset($_SESSION);
		session_destroy();
		redirect("auth/login", "refresh");
	}

	public function login()
	{

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run() == TRUE) 
		{
			// check user exist in db

			$username = $_POST['username'];
			$password = md5($_POST['password']);

			$this->db->select('*');
			$this->db->from('users');
			
			$this->db->where(array('username' => $username, 'password' => $password));
			$query = $this->db->get();

			$user = $query->row();
			
			if ($user->email) 
			{
				
				$this->session->set_flashdata("success", "You are Logged In");

				$_SESSION['user_logged'] = TRUE;
				$_SESSION['username'] = $user->username;

				redirect("user/profile", "refresh");
			} else {
				$this->session->set_flashdata("error", "No such an User Account Detected");
				redirect("auth/login", "refresh");
			}

		}

		$this->load->view('login');

	}

	public function register()
	{

		if (isset($_POST['register'])) 
		{
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required|min_lenght[5]');
			$this->form_validation->set_rules('password', 'Confirm Password', 'required');
			$this->form_validation->set_rules('phone', 'Phone', 'required');

			if ($this->form_validation->run() == TRUE)
			{
				echo 'form validation';
				//add user in db

				$data = array(
					'username' => $_POST['username'],
					'email' => $_POST['email'],
					'password' => md5($_POST['password']),
					'gender' => $_POST['gender'],
					'created_date' => date('y-m-d'),
					'phone' => $_POST['phone']
				);
				$this->db->insert('users', $data);

				$this->session->set_flashdata("success", "your account has been registered. You can log in now");
				redirect("auth/login", "refresh");
			}
		}
		//load view
		$this->load->view('register');
	}
}