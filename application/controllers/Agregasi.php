<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Agregasi extends CI_Controller
{

	var $template = 'template';
	
	function __construct()
	{
		parent::__construct();
		if ($this->session->has_userdata('logged_in') !== TRUE) {
			redirect('login');
		}
	}

	public function rankingDm()
	{
		$data['page'] 		= 'page/rankingDm_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['userId']		= $this->session->userdata('userId');
		$data['role']		= $this->session->userdata('role');

		$decisionMaker 		= $this->db->query('SELECT * FROM pengguna WHERE role NOT IN (0,3) ORDER BY role DESC');
		$daftarAlternatif 	= $this->db->query('SELECT * FROM alternatif_karyawan');
		//$rankDm				= $this->db->query('')

		$setRankMatriksDm = array();
		$a=0;
		foreach ($daftarAlternatif->result() as $baris) {
			$b=0;
			foreach ($decisionMaker->result() as $kolom) {
				$urutan = $this->db->query('SELECT * FROM rank_alternatif WHERE raAltKaryawanId = '.$baris->altKaryawanId.' AND raUserId = '.$kolom->userId)->row()->raUrutan;
				$setRankMatriksDm[$a][$b] = $urutan;
				$b++;
			}
			$a++;
		}

		$data['matriks'] 			= $setRankMatriksDm;
		$data['decisionMaker'] 		= $decisionMaker;
		$data['daftarAlternatif'] 	= $daftarAlternatif;

		$this->load->view($this->template, $data);
	}

	public function borda()
	{
		$data['page'] 		= 'page/borda_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['userId']		= $this->session->userdata('userId');
		$data['role']		= $this->session->userdata('role');

		$decisionMaker 		= $this->db->query('SELECT * FROM pengguna WHERE role NOT IN (0,3) ORDER BY role DESC');
		$daftarAlternatif 	= $this->db->query('SELECT * FROM alternatif_karyawan');
		//$rankDm				= $this->db->query('')

		$setRankMatriksDm = array();
		$a=0;
		foreach ($daftarAlternatif->result() as $baris) {
			$b=0;
			foreach ($decisionMaker->result() as $kolom) {
				$urutan = $this->db->query('SELECT * FROM rank_alternatif WHERE raAltKaryawanId = '.$baris->altKaryawanId.' AND raUserId = '.$kolom->userId)->row()->raUrutan;
				$setRankMatriksDm[$a][$b] = $urutan;
				$b++;
			}
			$a++;
		}

		$point = array();
		for ($c=1; $c <= $daftarAlternatif->num_rows(); $c++) { 
			$pointSet = $daftarAlternatif->num_rows() - $c;
			$point[$c] = $pointSet;
		}

		$setMatriksPoint = array();
		for ($d=0; $d < $daftarAlternatif->num_rows(); $d++) { 
			for ($e=0; $e < $decisionMaker->num_rows(); $e++) { 
				$set 						= $setRankMatriksDm[$d][$e];
				$setMatriksPoint[$d][$e] 	= $point[$set];
			}
		}

		$jumlahPoint = array();
		for ($f=0; $f < $daftarAlternatif->num_rows() ; $f++) { 
			$jum = 0;
			for ($g=0; $g < $decisionMaker->num_rows(); $g++) { 
				$jum = $jum + $setMatriksPoint[$f][$g];
			}
			$jumlahPoint[] = $jum;
		}

		$data['matriks'] 			= $setMatriksPoint;
		$data['decisionMaker'] 		= $decisionMaker;
		$data['daftarAlternatif'] 	= $daftarAlternatif;
		$data['point']				= $point;
		$data['jumlahPoint']		= $jumlahPoint;

		$this->load->view($this->template, $data);
	}	

	public function bordaBobotDm()
	{
		$data['page'] 		= 'page/bordaBobotDm_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['userId']		= $this->session->userdata('userId');
		$data['role']		= $this->session->userdata('role');

		$decisionMaker 		= $this->db->query('SELECT * FROM pengguna WHERE role NOT IN (0,3) ORDER BY role DESC');
		$daftarAlternatif 	= $this->db->query('SELECT * FROM alternatif_karyawan');
		//$rankDm				= $this->db->query('')

		$setRankMatriksDm = array();
		$a=0;
		foreach ($daftarAlternatif->result() as $baris) {
			$b=0;
			foreach ($decisionMaker->result() as $kolom) {
				$urutan = $this->db->query('SELECT * FROM rank_alternatif WHERE raAltKaryawanId = '.$baris->altKaryawanId.' AND raUserId = '.$kolom->userId)->row()->raUrutan;
				$setRankMatriksDm[$a][$b] = $urutan;
				$b++;
			}
			$a++;
		}

		$point = array();
		for ($c=1; $c <= $daftarAlternatif->num_rows(); $c++) { 
			$pointSet = $daftarAlternatif->num_rows() - $c;
			$point[$c] = $pointSet;
		}

		$setMatriksPoint = array();
		for ($d=0; $d < $daftarAlternatif->num_rows(); $d++) { 
			for ($e=0; $e < $decisionMaker->num_rows(); $e++) { 
				$set 						= $setRankMatriksDm[$d][$e];
				$setMatriksPoint[$d][$e] 	= $point[$set];
			}
		}

		$setMatriksPointBobot = array();
		$h=0;
		foreach ($daftarAlternatif->result() as $bariss) {
			$i=0;
			foreach ($decisionMaker->result() as $kolomm) {
				$bobot = $this->db->query('SELECT * FROM bobot_dm WHERE bdUserId = '.$kolomm->userId)->row()->bdNilai;
				$setMatriksPointBobot[$h][$i] = $setMatriksPoint[$h][$i] * $bobot;
				$i++;
			}
			$h++;
		}

		//echo "<pre>";
		//print_r($setMatriksPointBobot);exit;

		$jumlahPoint = array();
		for ($f=0; $f < $daftarAlternatif->num_rows() ; $f++) { 
			$jum = 0;
			for ($g=0; $g < $decisionMaker->num_rows(); $g++) { 
				$jum = $jum + $setMatriksPointBobot[$f][$g];
			}
			$jumlahPoint[] = $jum;
		}

		$data['matriks'] 			= $setMatriksPointBobot;
		$data['decisionMaker'] 		= $decisionMaker;
		$data['daftarAlternatif'] 	= $daftarAlternatif;
		$data['point']				= $point;
		$data['jumlahPoint']		= $jumlahPoint;

		$this->load->view($this->template, $data);
	}

	public function rankingKelompok()
	{
		$data['page'] 		= 'page/rankingKeputusanKelompok_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['userId']		= $this->session->userdata('userId');
		$data['role']		= $this->session->userdata('role');

		$decisionMaker 		= $this->db->query('SELECT * FROM pengguna WHERE role NOT IN (0,3) ORDER BY role DESC');
		$daftarAlternatif 	= $this->db->query('SELECT * FROM alternatif_karyawan');
		//$rankDm				= $this->db->query('')

		$setRankMatriksDm = array();
		$a=0;
		foreach ($daftarAlternatif->result() as $baris) {
			$b=0;
			foreach ($decisionMaker->result() as $kolom) {
				$urutan = $this->db->query('SELECT * FROM rank_alternatif WHERE raAltKaryawanId = '.$baris->altKaryawanId.' AND raUserId = '.$kolom->userId)->row()->raUrutan;
				$setRankMatriksDm[$a][$b] = $urutan;
				$b++;
			}
			$a++;
		}

		$point = array();
		for ($c=1; $c <= $daftarAlternatif->num_rows(); $c++) { 
			$pointSet = $daftarAlternatif->num_rows() - $c;
			$point[$c] = $pointSet;
		}

		$setMatriksPoint = array();
		for ($d=0; $d < $daftarAlternatif->num_rows(); $d++) { 
			for ($e=0; $e < $decisionMaker->num_rows(); $e++) { 
				$set 						= $setRankMatriksDm[$d][$e];
				$setMatriksPoint[$d][$e] 	= $point[$set];
			}
		}

		$setMatriksPointBobot = array();
		$h=0;
		foreach ($daftarAlternatif->result() as $bariss) {
			$i=0;
			foreach ($decisionMaker->result() as $kolomm) {
				$bobot = $this->db->query('SELECT * FROM bobot_dm WHERE bdUserId = '.$kolomm->userId)->row()->bdNilai;
				$setMatriksPointBobot[$h][$i] = $setMatriksPoint[$h][$i] * $bobot;
				$i++;
			}
			$h++;
		}

		$jumlahPoint = array();
		for ($f=0; $f < $daftarAlternatif->num_rows() ; $f++) { 
			$jum = 0;
			for ($g=0; $g < $decisionMaker->num_rows(); $g++) { 
				$jum = $jum + $setMatriksPointBobot[$f][$g];
			}
			$jumlahPoint[] = $jum;
		}

		arsort($jumlahPoint);
		
		//echo "<pre>";
		//print_r($jumlahPoint);exit;

		$alternatifArray = array();
		foreach ($daftarAlternatif->result() as $row) {
			$alternatifArray[] = $row->altKaryawanId;
		}

		$data['alternatifArray']	= $alternatifArray;
		$data['jumlahPoint']		= $jumlahPoint;
		$data['daftarAlternatif']	= $daftarAlternatif;

		$this->load->view($this->template, $data);
	}	

}

?>