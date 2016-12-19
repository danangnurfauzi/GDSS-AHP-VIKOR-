<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Dm extends CI_Controller
{

	var $template = 'template';
	
	function __construct()
	{
		parent::__construct();
		if ($this->session->has_userdata('logged_in') !== TRUE) {
			redirect('login');
		}
	}

	public function pembobotan()
	{
		$this->load->helper('MY_app_helper');
		$data['page'] 		= 'page/pembobotanDm_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['userId']		= $this->session->userdata('userId');
		$data['role']		= $this->session->userdata('role');

		$param 				= $this->db->query('SELECT * FROM pengguna WHERE role NOT IN (0,3)');
		$data['param']		= $param;

		$data['isi']		= $this->db->query('SELECT * FROM matriks_perbandingan_dm');
		//echo $this->db->last_query();exit;

		$data['bobot']		= $this->db->query('SELECT * FROM bobot_dm INNER JOIN pengguna ON bdUserId = userId');

		$matriks = array();
    	$matriksPosisi = array();
    	$i=0;
    	foreach ($param->result() as $baris) {
    		$j=0;
    		foreach ($param->result() as $kolom) {
    			
    			if ($j > $i) {
    				$matriks[] = $baris->userId.$kolom->userId;
    				$matriksPosisi[] = $i.$j;
    			}

    			$j++;
    		}

    		$i++;
    	}

    	//print_r($matriks);exit; 
    	$data['matriks'] = $matriks;
    	$data['matriksPosisi'] = $matriksPosisi;

    	$data['nilaiKepentingan'] = $this->db->query('SELECT * FROM tingkat_kepentingan');

    	$this->load->view($this->template, $data);
	}

	public function cekKonsistensi()
	{
		//echo "<pre>";
		//print_r($_POST);

		$this->db->query('TRUNCATE TABLE matriks_perbandingan_dm');
	
		$this->db->query('TRUNCATE TABLE bobot_dm');

		$dm = $this->db->query('SELECT * FROM pengguna WHERE role NOT IN (0,3)');

		$jumlahDm = $dm->num_rows();

		
		$konversiArray = array();
		foreach ($dm->result() as $row) {
			$konversiArray[] = $row->userId;
		}

		//echo "<pre>";
		//print_r($konversiArray[1]);exit;

		$i=0;

		$matriks = array();

		foreach ($dm->result() as $baris) {
			
			$j=0;

			foreach ($dm->result() as $kolom) {
				
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
		for ($p=0; $p < $dm->num_rows(); $p++) { 
			$b=0;
			$hasilKalian = 1;
			for ($q=0; $q < $dm->num_rows() ; $q++) { 
				$hasilKalian = $hasilKalian * $matriks[$a][$b];
				$b++;
			}
			$perkalian[$p] = $hasilKalian; 
			$a++;
		}

		$nAkarPangkat = array();
		for ($r=0; $r < count($perkalian) ; $r++) { 
			$nAkarPangkat[] = pow($perkalian[$r],1/$dm->num_rows()); 
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

		$CI = ($lamda - $jumlahDm) / ($jumlahDm - 1);

		$IR = $this->db->query('SELECT * FROM indeks_random_ahp WHERE irJumlahKriteria = '.$jumlahDm)->row()->irNilai;

		$CR = $CI/$IR;

		if ($CR < 0.1) {
			//echo "pass";

			for ($m=0; $m < $jumlahDm; $m++) { 
				
				for ($n=0; $n < $jumlahDm; $n++) { 
					
					$this->db->set('mpdDmBaris',$m.$n);
					$this->db->set('mpdDmKolom',$konversiArray[$m].$konversiArray[$n]);
					$this->db->set('mpdUserId',$this->session->userdata('userId'));
					$this->db->set('mpdNilai',$matriks[$m][$n]);					
					$this->db->insert('matriks_perbandingan_dm');

				}
				
				$this->db->set('bdUserId',$konversiArray[$m]);
				$this->db->set('bdNilai',$eigenVector[$m]);				
				$this->db->insert('bobot_dm');

			}

			$this->session->set_flashdata('success', 'NILAI PERBANDINGAN SUDAH KONSISTEN.');
			redirect('dm/pembobotan/'.$this->uri->segment(3));

		}else{

			for ($m=0; $m < $jumlahDm; $m++) { 
				
				for ($n=0; $n < $jumlahDm; $n++) { 
					
					$this->db->set('mpdDmBaris',$m.$n);
					$this->db->set('mpdDmKolom',$konversiArray[$m].$konversiArray[$n]);
					$this->db->set('mpdUserId',$this->session->userdata('userId'));
					$this->db->set('mpdNilai',$matriks[$m][$n]);					
					$this->db->insert('matriks_perbandingan_dm');

				}				

			}

			$this->session->set_flashdata('error', 'NILAI PERBANDINGAN BELUM KONSISTEN MOHON DI PERBAIKI.');
			redirect('dm/pembobotan/'.$this->uri->segment(3));
		}

		//echo "<pre>";
		//print_r($CI);exit;

		//redirect('kriteria/kompetensi');
	}

}

?>