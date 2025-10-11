<?php
class Page extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('url', 'form');
		$this->load->library('form_validation');
		$this->load->model('StudentModel');
		$this->load->model('SettingsModel');
		$this->load->library('user_agent');
		if ($this->session->userdata('logged_in') !== TRUE) {
			redirect('login');
		}
	}



	// Access for School IT
	function IT()
	{
		//Allowing access to school IT only
		if ($this->session->userdata('level') === 'IT') {
			//date_default_timezone_set('Asia/Manila'); # add your city to set local time zone
			$result['data18'] = $this->SettingsModel->getSchoolInfo();
			$this->load->view('dashboard_school_it', $result);
		} else {
			echo "Access Denied";
		}
	}


public function userAccounts()
	{
		// Load the user accounts data and pass it to the view
		$result['data'] = $this->StudentModel->userAccounts();
		$this->load->view('user_accounts', $result);

		// Check if the form has been submitted
		if ($this->input->post('submit')) {
			// Sanitize and retrieve data from the form
			$username = $this->input->post('username', TRUE); // TRUE for XSS filtering
			$IDNumber = $this->input->post('IDNumber', TRUE);
			$password = sha1($this->input->post('password')); // Consider using a more secure hashing method
			$acctLevel = $this->input->post('acctLevel', TRUE);
			$fName = $this->input->post('fName', TRUE);
			$mName = $this->input->post('mName', TRUE);
			$lName = $this->input->post('lName', TRUE);
			$completeName = $fName . ' ' . $lName;
			$email = $this->input->post('email', TRUE);
			$dateCreated = date("Y-m-d");

			// Use query builder to check if the username already exists
			$this->db->where('username', $username);
			$query = $this->db->get('o_users');

			if ($query->num_rows() > 0) {
				// Set flash message and redirect if username exists
				$this->session->set_flashdata('danger', '<div class="alert alert-danger text-center"><b>The username is already taken. Please choose a different one.</b></div>');
				redirect('Page/userAccounts');
			} else {
				// Prepare data for insertion
				$data = array(
					'username' => $username,
					'password' => $password,
					'position' => $acctLevel,
					'fName' => $fName,
					'mName' => $mName,
					'lName' => $lName,
					'email' => $email,
					'avatar' => 'avatar.png',
					'acctStat' => 'active',
					'dateCreated' => $dateCreated,
					'IDNumber' => $IDNumber
				);

				// Insert data into the database
				$this->db->insert('o_users', $data);

				// Set success flash message and redirect
				$this->session->set_flashdata('success', '<div class="alert alert-success text-center"><b>New account has been created successfully.</b></div>');
				redirect('Page/userAccounts');
			}
		}
	}











}