<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Parameter extends CI_Controller
{

	var $template = 'template';
	
	function __construct()
	{
		parent::__construct();
		if ($this->session->has_userdata('logged_in') !== TRUE) {
			redirect('login');
		}
	}

	public function bobot($kriteriaId)
	{
		$data['page'] 		= 'page/bobotParameter_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['userId']		= $this->session->userdata('userId');
		$data['role']		= $this->session->userdata('role');

		$data['param']		= $this->db->query('SELECT * FROM parameter WHERE parameterKriteriaId = "'.$kriteriaId.'"');

		$data['isi']		= $this->db->query('SELECT * FROM matriks_perbandingan_parameter WHERE mppUserId = '.$this->session->userdata('userId') .' AND mppKriteriaId = '.$kriteriaId);
		//echo $this->db->last_query();exit;

		$data['bobot']		= $this->db->query('SELECT * FROM bobot_parameter INNER JOIN parameter ON bpParameterId = parameterId WHERE bpUserId = '.$data['userId'].' AND parameterKriteriaId = '.$kriteriaId);

    	$this->load->view($this->template, $data);
	}

	public function bobotRev($kriteriaId)
	{
		$this->load->helper('MY_app_helper');
		$data['page'] 		= 'page/bobotParameterRev_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['userId']		= $this->session->userdata('userId');
		$data['role']		= $this->session->userdata('role');

		$param 				= $this->db->query('SELECT * FROM parameter WHERE parameterKriteriaId = "'.$kriteriaId.'"');
		$data['param']		= $param;

		$data['isi']		= $this->db->query('SELECT * FROM matriks_perbandingan_parameter WHERE mppUserId = '.$this->session->userdata('userId') .' AND mppKriteriaId = '.$kriteriaId);
		//echo $this->db->last_query();exit;

		$data['bobot']		= $this->db->query('SELECT * FROM bobot_parameter INNER JOIN parameter ON bpParameterId = parameterId WHERE bpUserId = '.$data['userId'].' AND parameterKriteriaId = '.$kriteriaId);

		$matriks = array();
    	$matriksPosisi = array();
    	$i=0;
    	foreach ($param->result() as $baris) {
    		$j=0;
    		foreach ($param->result() as $kolom) {
    			
    			if ($j > $i) {
    				$matriks[] = $baris->parameterId.$kolom->parameterId;
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

	public function cekKonsistensi($kriteriaId)
	{
		//echo "<pre>";
		//print_r($_POST); 

		$this->db->where('mppUserId',$this->session->userdata('userId'));
		$this->db->where('mppKriteriaId',$kriteriaId);
		$this->db->delete('matriks_perbandingan_parameter');

		$this->db->where('bpUserId',$this->session->userdata('userId'));
		$this->db->where('bpKriteriaId',$kriteriaId);
		$this->db->delete('bobot_parameter');

		$kompetensi = $this->db->query('SELECT * FROM parameter WHERE parameterKriteriaId = "'.$kriteriaId.'"');

		$jumlahKriteriaKompetensi = $kompetensi->num_rows();

		
		$konversiArray = array();
		foreach ($kompetensi->result() as $row) {
			$konversiArray[] = $row->parameterId;
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

		$bobotKriteria = $this->db->query('SELECT * FROM bobot_kriteria WHERE bkUserId = '.$this->session->userdata('userId').' AND bkKriteriaId = '.$kriteriaId)->row()->bkNilai;
		$eigenVectorPerKriteria = array();
		for ($t=0; $t < count($eigenVector) ; $t++) { 
			$eigenVectorPerKriteria[] = $eigenVector[$t] * $bobotKriteria;
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

			for ($m=0; $m < $jumlahKriteriaKompetensi; $m++) { 
				
				for ($n=0; $n < $jumlahKriteriaKompetensi; $n++) { 
					
					$this->db->set('mppParameterBaris',$m.$n);
					$this->db->set('mppParameterKolom',$konversiArray[$m].$konversiArray[$n]);
					$this->db->set('mppUserId',$this->session->userdata('userId'));
					$this->db->set('mppNilai',$matriks[$m][$n]);
					$this->db->set('mppKriteriaId',$kriteriaId);
					$this->db->insert('matriks_perbandingan_parameter');

				}

				$this->db->set('bpUserId',$this->session->userdata('userId'));
				$this->db->set('bpParameterId',$konversiArray[$m]);
				$this->db->set('bpNilai',$eigenVectorPerKriteria[$m]);
				$this->db->set('bpKriteriaId',$kriteriaId);
				$this->db->insert('bobot_parameter');

			}

			$this->session->set_flashdata('success', 'NILAI PERBANDINGAN SUDAH KONSISTEN.');
			redirect('parameter/bobotRev/'.$this->uri->segment(3));

		}else{

			for ($m=0; $m < $jumlahKriteriaKompetensi; $m++) { 
				
				for ($n=0; $n < $jumlahKriteriaKompetensi; $n++) { 
					
					$this->db->set('mppParameterBaris',$m.$n);
					$this->db->set('mppParameterKolom',$konversiArray[$m].$konversiArray[$n]);
					$this->db->set('mppUserId',$this->session->userdata('userId'));
					$this->db->set('mppNilai',$matriks[$m][$n]);
					$this->db->set('mppKriteriaId',$kriteriaId);
					$this->db->insert('matriks_perbandingan_parameter');

				}				

			}

			$this->session->set_flashdata('error', 'NILAI PERBANDINGAN BELUM KONSISTEN MOHON DI PERBAIKI.');
			redirect('parameter/bobotRev/'.$this->uri->segment(3));
		}

		//echo "<pre>";
		//print_r($CI);exit;

		//redirect('kriteria/kompetensi');
	}

	public function parameterUbahNilai($kriteriaId)
	{
		$this->db->where('mppUserId',$this->session->userdata('userId'));
		$this->db->where('mppKriteriaId',$kriteriaId);
		$this->db->delete('matriks_perbandingan_parameter');

		$this->db->where('bpUserId',$this->session->userdata('userId'));
		$this->db->where('bpKriteriaId',$kriteriaId);
		$this->db->delete('bobot_parameter');
		
		redirect('parameter/bobotRev/'.$kriteriaId);
	}

}

?>