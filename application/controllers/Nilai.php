<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Nilai extends CI_Controller
{

	var $template = 'template';
	
	function __construct()
	{
		parent::__construct();
		if ($this->session->has_userdata('logged_in') !== TRUE) {
			redirect('login');
		}
		$this->load->helper('MY_app');
	}

	public function nilaiAlternatif()
	{
		
		$data['page'] 		= 'page/nilaiAlternatif_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['role'] 		= $this->session->userdata('role');

		$data['list']		= $this->db->query('SELECT * FROM alternatif_karyawan a INNER JOIN simsdm_karyawan k ON a.altKaryawanIdk = k.id');

    	$this->load->view($this->template, $data);
	}

	public function nilaiKriteriaEdit($idAlternatif)
	{
		$data['page'] 		= 'page/nilaiKriteriaEdit_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['role'] 		= $this->session->userdata('role');

		$data['kriteria']	= $this->db->query('SELECT * FROM kriteria INNER JOIN nilai_kriteria_alternatif ON nkKriteriaId = kriteriaId AND nkAltKaryawanId = '.$idAlternatif);

		//echo $this->db->last_query();exit;

    	$this->load->view($this->template, $data);
	}

	public function nilaiKriteriaInput($idAlternatif)
	{
		$data['page'] 		= 'page/nilaiKriteriaInput_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['role'] 		= $this->session->userdata('role');

		$data['kriteria']	= $this->db->query('SELECT * FROM kriteria WHERE kriteriaRole = 1');

		//echo $this->db->last_query();exit;

    	$this->load->view($this->template, $data);
	}

	function setDataNilaiKriteria($idAlternatif)
	{
		//print_r( $_POST );
		$cek = $this->db->query('SELECT * FROM nilai_kriteria_alternatif WHERE nkAltKaryawanId = '.$idAlternatif);

		if ($cek->num_rows() > 0) {

			$kriteria = $this->db->query('SELECT * FROM kriteria INNER JOIN nilai_kriteria_alternatif ON nkKriteriaId = kriteriaId AND nkAltKaryawanId = '.$idAlternatif);
			$this->db->trans_begin();
			foreach ($kriteria->result() as $row) {
				$this->db->set('nkNilai',$_POST['kriteria_'.$row->kriteriaId]);
				$this->db->where('nkAltKaryawanId',$idAlternatif);
				$this->db->where('nkKriteriaId',$row->kriteriaId);
				$this->db->update('nilai_kriteria_alternatif');
			}
			
			if ($this->db->trans_status() === FALSE)
			{
			        $this->db->trans_rollback();
			        $this->session->set_flashdata('error', 'Data Gagal Di Edit.');
					redirect('nilai/nilaiAlternatif');
			}else
			{
			        $this->db->trans_commit();
			        $this->session->set_flashdata('success', 'Data Berhasil Di Edit.');
					redirect('nilai/nilaiAlternatif');
			}
			
		}else{

			$kriteria = $this->db->query('SELECT * FROM kriteria WHERE kriteriaRole = 1');
			$this->db->trans_begin();
			foreach ($kriteria->result() as $row) {
				$this->db->set('nkNilai',$_POST['kriteria_'.$row->kriteriaId]);
				$this->db->set('nkAltKaryawanId',$idAlternatif);
				$this->db->set('nkKriteriaId',$row->kriteriaId);
				$this->db->insert('nilai_kriteria_alternatif');
			}
			
			if ($this->db->trans_status() === FALSE)
			{
			        $this->db->trans_rollback();
			        $this->session->set_flashdata('error', 'Data Gagal Di Input.');
					redirect('nilai/nilaiAlternatif');
			}else
			{
			        $this->db->trans_commit();
			        $this->session->set_flashdata('success', 'Data Berhasil Di Input.');
					redirect('nilai/nilaiAlternatif');
			}
			
		}
	}

	public function nilaiParameterEdit($idAlternatif)
	{
		$data['page'] 		= 'page/nilaiParameterEdit_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['role'] 		= $this->session->userdata('role');

		$data['parameter']	= $this->db->query('SELECT * FROM parameter INNER JOIN nilai_parameter_alternatif ON npParameterId = parameterId AND npAltKaryawanId = '.$idAlternatif);

		//echo $this->db->last_query();exit;

    	$this->load->view($this->template, $data);
	}

	public function nilaiParameterInput($idAlternatif)
	{
		$data['page'] 		= 'page/nilaiParameterInput_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['role'] 		= $this->session->userdata('role');

		$data['parameter']	= $this->db->query('SELECT * FROM parameter');

		//echo $this->db->last_query();exit;

    	$this->load->view($this->template, $data);
	}

	function setDataNilaiParameter($idAlternatif)
	{
		//print_r( $_POST );
		$cek = $this->db->query('SELECT * FROM nilai_parameter_alternatif WHERE npAltKaryawanId = '.$idAlternatif);

		if ($cek->num_rows() > 0) {

			$kriteria = $this->db->query('SELECT * FROM parameter INNER JOIN nilai_parameter_alternatif ON npKriteriaId = parameterId AND npAltKaryawanId = '.$idAlternatif);
			$this->db->trans_begin();
			foreach ($kriteria->result() as $row) {
				$this->db->set('npNilai',$_POST['kriteria_'.$row->parameterId]);
				$this->db->where('npAltKaryawanId',$idAlternatif);
				$this->db->where('npParameterId',$row->parameterId);
				$this->db->update('nilai_parameter_alternatif');
			}
			
			if ($this->db->trans_status() === FALSE)
			{
			        $this->db->trans_rollback();
			        $this->session->set_flashdata('error', 'Data Gagal Di Edit.');
					redirect('nilai/nilaiAlternatif');
			}else
			{
			        $this->db->trans_commit();
			        $this->session->set_flashdata('success', 'Data Berhasil Di Edit.');
					redirect('nilai/nilaiAlternatif');
			}
			
		}else{

			$kriteria = $this->db->query('SELECT * FROM parameter');
			$this->db->trans_begin();
			foreach ($kriteria->result() as $row) {
				$this->db->set('npNilai',$_POST['kriteria_'.$row->parameterId]);
				$this->db->set('npAltKaryawanId',$idAlternatif);
				$this->db->set('npParameterId',$row->parameterId);
				$this->db->insert('nilai_parameter_alternatif');
			}
			
			if ($this->db->trans_status() === FALSE)
			{
			        $this->db->trans_rollback();
			        $this->session->set_flashdata('error', 'Data Gagal Di Input.');
					redirect('nilai/nilaiAlternatif');
			}else
			{
			        $this->db->trans_commit();
			        $this->session->set_flashdata('success', 'Data Berhasil Di Input.');
					redirect('nilai/nilaiAlternatif');
			}
			
		}
	}

}

?>