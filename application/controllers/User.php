<?php

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($_SESSION['user_logged'] == FALSE) 
		{
			$this->session->set_flashdata("error", "Please Log IN First");
			redirect("auth/login");
		}
	}

	public function profile()
	{
		if ($_SESSION['user_logged'] == FALSE) 
		{
			$this->session->set_flashdata("error", "Please Log IN First");
			redirect("auth/login");
		}
		$this->load->view('profile');
	}
}