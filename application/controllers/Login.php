<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Login extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('login_view');
	}

	public function verifikasi()
	{
		$result = $this->db->query('select * from pengguna where username = "'.$_POST['username'].'" AND password = "'.$_POST['password'].'"');

		if ($result->num_rows() > 0) {

			$userdata = array(
							'nama'		=> $result->row()->nama,
							'username'	=> $result->row()->username,
							'role'		=> $result->row()->role,
							'userId'	=> $result->row()->userId,
							'logged_in'	=> TRUE
							);

			$this->session->set_userdata($userdata);

			redirect('home/dashboard');
		}else{
			$this->session->set_flashdata('error', 'Username atau Password Salah.');
			redirect('login');
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();

		redirect('login');
	}

}

?>