<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Backup extends CI_Controller
{

	var $template = 'template';
	
	function __construct()
	{
		parent::__construct();
		/*if ($this->session->has_userdata('logged_in') !== TRUE) {
			redirect('login');
		}*/
	}

	function dbBackup()
	{
		
		$last_line = exec("/Applications/AMPPS/mysql/bin/mysqldump -u rootp -pmysql wp45 > backup696.sql",$output,$status);
		//var_dump($status);exit;
		if (!$status) {
			echo "got it";
		}else{
			echo "fuck";
		}

	}
	
	
}

?>