<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Kriteria extends CI_Controller
{

	var $template = 'template';
	
	function __construct()
	{
		parent::__construct();
		if ($this->session->has_userdata('logged_in') !== TRUE) {
			redirect('login');
		}
	}

	public function kompetensi()
	{
		$data['page'] 		= 'page/kompetensi_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['userId']		= $this->session->userdata('userId');
		$data['role']		= $this->session->userdata('role');

		$data['komp']		= $this->db->query('SELECT * FROM kriteria WHERE kriteriaRole = "'.$this->session->userdata('role').'"');

		$data['isi']		= $this->db->query('SELECT * FROM matriks_perbandingan_kriteria WHERE mpkUserId = '.$this->session->userdata('userId'));
		
		$data['bobot']		= $this->db->query('SELECT * FROM bobot_kriteria INNER JOIN kriteria ON bkKriteriaId = kriteriaId WHERE bkUserId = '.$data['userId']);

    	$this->load->view($this->template, $data);
	}

	public function kompetensiRev()
	{
		$this->load->helper('MY_app_helper');
		$data['page'] 		= 'page/kompetensiRev_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['userId']		= $this->session->userdata('userId');
		$data['role']		= $this->session->userdata('role');

		$komp			= $this->db->query('SELECT * FROM kriteria WHERE kriteriaRole = "'.$this->session->userdata('role').'"');
		$data['komp'] 	= $komp;

		$data['isi']		= $this->db->query('SELECT * FROM matriks_perbandingan_kriteria WHERE mpkUserId = '.$this->session->userdata('userId'));
		
		$data['bobot']		= $this->db->query('SELECT * FROM bobot_kriteria INNER JOIN kriteria ON bkKriteriaId = kriteriaId WHERE bkUserId = '.$data['userId']);

		$data['nilaiKepentingan'] = $this->db->query('SELECT * FROM tingkat_kepentingan');

    	$matriks = array();
    	$matriksPosisi = array();
    	$i=0;
    	foreach ($komp->result() as $baris) {
    		$j=0;
    		foreach ($komp->result() as $kolom) {
    			
    			if ($j > $i) {
    				$matriks[] = $baris->kriteriaId.$kolom->kriteriaId;
    				$matriksPosisi[] = $i.$j;
    			}

    			$j++;
    		}

    		$i++;
    	}

    	//print_r($matriks);exit; 
    	$data['matriks'] = $matriks;
    	$data['matriksPosisi'] = $matriksPosisi;

    	$this->load->view($this->template, $data);
	}

	public function cekKonsistensi()
	{
		//echo "<pre>";
		//print_r($_POST);exit;

		$this->db->where('mpkUserId',$this->session->userdata('userId'));
		$this->db->delete('matriks_perbandingan_kriteria');

		$this->db->where('bkUserId',$this->session->userdata('userId'));
		$this->db->delete('bobot_kriteria');

		$kompetensi = $this->db->query('SELECT * FROM kriteria WHERE kriteriaRole = "'.$this->session->userdata('role').'"');

		$jumlahKriteriaKompetensi = $kompetensi->num_rows();

		
		$konversiArray = array();
		foreach ($kompetensi->result() as $row) {
			$konversiArray[] = $row->kriteriaId;
		}

		//echo "<pre>";
		//print_r($konversiArray[1]);exit;

		$i=0;

		$matriks = array();

		foreach ($kompetensi->result() as $baris) {
			
			$j=0;

			foreach ($kompetensi->result() as $kolom) {
				
				if($j > $i){

					$is_slash = strlen($_POST[$i.$j]);

					if($is_slash > 1)
					{
						$explode = explode('/', $_POST[$i.$j]);

						$fix = $explode[0] / $explode[1];

						$matriks[$i][$j] = $fix;

						$matriks[$j][$i] = 1 / $fix;

					}else
					{
						$matriks[$i][$j] = $_POST[$i.$j];

						$matriks[$j][$i] = 1 / $_POST[$i.$j];
					}
					
				}elseif($j == $i){

					$matriks[$i][$j] = 1;

				}

				$j++;

			}

			$i++;
		}

		//echo $matriks[0][3];exit;

		$perkalian = array();
		$a=0;
		for ($p=0; $p < $kompetensi->num_rows(); $p++) { 
			$b=0;
			$hasilKalian = 1;
			for ($q=0; $q < $kompetensi->num_rows() ; $q++) { 
				$hasilKalian = $hasilKalian * $matriks[$a][$b];
				$b++;
			}
			$perkalian[$p] = $hasilKalian; 
			$a++;
		}

		$nAkarPangkat = array();
		for ($r=0; $r < count($perkalian) ; $r++) { 
			$nAkarPangkat[] = pow($perkalian[$r],1/$kompetensi->num_rows()); 
		}

		$jumlah_nAkarPangkat = array_sum($nAkarPangkat);

		$eigenVector = array();
		for ($s=0; $s < count($nAkarPangkat); $s++) { 
			$eigenVector[] = $nAkarPangkat[$s] / $jumlah_nAkarPangkat;
		}

		$sumMatriksKolom = array();
		for ($e=0; $e < count($nAkarPangkat) ; $e++) { 
			$jumlahKolom = 0;
			for ($f=0; $f < count($nAkarPangkat) ; $f++) { 
				
				$jumlahKolom = $jumlahKolom + $matriks[$f][$e];

			}

			$sumMatriksKolom[] = $jumlahKolom;

		}

		$lamda = 0;
		for ($g=0; $g < count($nAkarPangkat); $g++) { 
			$kali = $sumMatriksKolom[$g] * $eigenVector[$g];
			$lamda = $lamda + $kali;
		}

		$CI = ($lamda - $jumlahKriteriaKompetensi) / ($jumlahKriteriaKompetensi - 1);

		$IR = $this->db->query('SELECT * FROM indeks_random_ahp WHERE irJumlahKriteria = '.$jumlahKriteriaKompetensi)->row()->irNilai;

		$CR = $CI/$IR;

		if ($CR < 0.1) {
			//echo "pass";

			$this->db->where('mpkUserId',$this->session->userdata('userId'));
			$this->db->delete('matriks_perbandingan_kriteria');

			for ($m=0; $m < $jumlahKriteriaKompetensi; $m++) { 
				
				for ($n=0; $n < $jumlahKriteriaKompetensi; $n++) { 
					
					$this->db->set('mpkKriteriaIdBaris',$m.$n);
					$this->db->set('mpkKriteriaIdKolom',$konversiArray[$m].$konversiArray[$n]);
					$this->db->set('mpkUserId',$this->session->userdata('userId'));
					$this->db->set('mpkNilai',$matriks[$m][$n]);
					$this->db->insert('matriks_perbandingan_kriteria');

				}

				$this->db->set('bkUserId',$this->session->userdata('userId'));
				$this->db->set('bkKriteriaId',$konversiArray[$m]);
				$this->db->set('bkNilai',$eigenVector[$m]);
				$this->db->insert('bobot_kriteria');

			}

			$this->session->set_flashdata('success', 'NILAI PERBANDINGAN SUDAH KONSISTEN.');
			if ($this->session->userdata('role') == '0' || $this->session->userdata('role') == '2') {
				redirect('kriteria/kompetensiRev');	
			}else{
				redirect('kriteria/manajemenRev');
			}
			

		}else{
			
			for ($m=0; $m < $jumlahKriteriaKompetensi; $m++) { 
				
				for ($n=0; $n < $jumlahKriteriaKompetensi; $n++) { 
					
					$this->db->set('mpkKriteriaIdBaris',$m.$n);
					$this->db->set('mpkKriteriaIdKolom',$konversiArray[$m].$konversiArray[$n]);
					$this->db->set('mpkUserId',$this->session->userdata('userId'));
					$this->db->set('mpkNilai',$matriks[$m][$n]);
					$this->db->insert('matriks_perbandingan_kriteria');

				}				

			}

			$this->session->set_flashdata('error', 'NILAI PERBANDINGAN BELUM KONSISTEN MOHON DI PERBAIKI.');
			if ($this->session->userdata('role') == '0' || $this->session->userdata('role') == '2') {
				redirect('kriteria/kompetensiRev');	
			}else{
				redirect('kriteria/manajemenRev');
			}
		}

		//echo "<pre>";
		//print_r($CI);exit;

		//redirect('kriteria/kompetensi');
	}

	public function kompetensiUbahNilai()
	{
		$this->db->where('mpkUserId',$this->session->userdata('userId'));
		$this->db->delete('matriks_perbandingan_kriteria');

		$this->db->where('bkUserId',$this->session->userdata('userId'));
		$this->db->delete('bobot_kriteria');

		$this->db->where('raUserId',$this->session->userdata('userId'));
		$this->db->delete('rank_alternatif');
		
		if ($this->session->userdata('role') == '0') {
			redirect('kriteria/kompetensiRev');	
		}else{
			redirect('kriteria/kompetensiRev');
		}
	}

	public function manajemen()
	{
		$data['page'] 		= 'page/manajemen_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['userId']		= $this->session->userdata('userId');
		$data['role']		= $this->session->userdata('role');

		$data['komp']		= $this->db->query('SELECT * FROM kriteria WHERE kriteriaRole = "'.$this->session->userdata('role').'"');

		$data['isi']		= $this->db->query('SELECT * FROM matriks_perbandingan_kriteria WHERE mpkUserId = '.$this->session->userdata('userId'));
		//echo $this->db->last_query();exit;
		$data['bobot']		= $this->db->query('SELECT * FROM bobot_kriteria INNER JOIN kriteria ON bkKriteriaId = kriteriaId WHERE bkUserId = '.$data['userId']);

    	$this->load->view($this->template, $data);
	}

	public function manajemenRev()
	{
		$this->load->helper('MY_app_helper');
		$data['page'] 		= 'page/manajemenRev_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['userId']		= $this->session->userdata('userId');
		$data['role']		= $this->session->userdata('role');

		$komp 				= $this->db->query('SELECT * FROM kriteria WHERE kriteriaRole = "'.$this->session->userdata('role').'"');
		$data['komp']		= $komp;

		$data['isi']		= $this->db->query('SELECT * FROM matriks_perbandingan_kriteria WHERE mpkUserId = '.$this->session->userdata('userId'));
		//echo $this->db->last_query();exit;
		$data['bobot']		= $this->db->query('SELECT * FROM bobot_kriteria INNER JOIN kriteria ON bkKriteriaId = kriteriaId WHERE bkUserId = '.$data['userId']);

		$data['nilaiKepentingan'] = $this->db->query('SELECT * FROM tingkat_kepentingan');

		$matriks = array();
    	$matriksPosisi = array();
    	$i=0;
    	foreach ($komp->result() as $baris) {
    		$j=0;
    		foreach ($komp->result() as $kolom) {
    			
    			if ($j > $i) {
    				$matriks[] = $baris->kriteriaId.$kolom->kriteriaId;
    				$matriksPosisi[] = $i.$j;
    			}

    			$j++;
    		}

    		$i++;
    	}

    	//print_r($matriks);exit; 
    	$data['matriks'] = $matriks;
    	$data['matriksPosisi'] = $matriksPosisi;

    	$this->load->view($this->template, $data);
	}

}

?>