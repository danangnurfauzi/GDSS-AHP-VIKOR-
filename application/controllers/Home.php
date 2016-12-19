<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Home extends CI_Controller
{

	var $template = 'template';
	
	function __construct()
	{
		parent::__construct();
		if ($this->session->has_userdata('logged_in') !== TRUE) {
			redirect('login');
		}
	}

	public function dashboard()
	{
		$data['page'] 		= 'page/dashboard_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['role'] 	= $this->session->userdata('role');

    	$this->load->view($this->template, $data);
	}

	public function pengguna()
	{
		$this->load->helper('MY_app_helper');
		$data['page'] 		= 'page/pengguna_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['role'] 		= $this->session->userdata('role');

		$data['list']		= $this->db->query('SELECT * FROM pengguna');

    	$this->load->view($this->template, $data);
	}

	public function penggunaTambah()
	{
		$data['page'] 		= 'page/penggunaTambah_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['role'] 	= $this->session->userdata('role');

		if (($this->input->post('Submit')) == 'Submit') {

			$this->db->trans_begin();

			$this->db->set('nama',$this->input->post('nama'));
			$this->db->set('username',$this->input->post('username'));
			$this->db->set('password','123456789');
			$this->db->set('role',$this->input->post('role'));
			$this->db->insert('pengguna');

			if ($this->db->trans_status() === FALSE)
			{
			        $this->db->trans_rollback();
			        $this->session->set_flashdata('error', 'Data Gagal Di Tambah.');
					redirect('home/pengguna');
			}
			else
			{
			        $this->db->trans_commit();
			        $this->session->set_flashdata('success', 'Data Berhasil Di Tambah.');
					redirect('home/pengguna');
			}
		} 

    	$this->load->view($this->template, $data);
	}

	public function penggunaHapus($id)
	{
		$this->db->where('userId',$id);
		$this->db->delete('pengguna');
		$this->session->set_flashdata('success', 'Data Berhasil Di Hapus.');
		redirect('home/pengguna');
	}

	public function penggunaEdit($id)
	{
		$data['page'] 		= 'page/penggunaEdit_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['role'] 	= $this->session->userdata('role');

		$data['isi']		= $this->db->query('SELECT * FROM pengguna WHERE userId = '.$id)->row();

		if (($this->input->post('Submit')) == 'Submit') {

			$this->db->trans_begin();

			$this->db->set('nama',$this->input->post('nama'));
			$this->db->set('username',$this->input->post('username'));
			//$this->db->set('password','123456789');
			$this->db->set('role',$this->input->post('role'));
			$this->db->where('userId',$id);
			$this->db->update('pengguna');

			if ($this->db->trans_status() === FALSE)
			{
			        $this->db->trans_rollback();
			        $this->session->set_flashdata('error', 'Data Gagal Di Edit.');
					redirect('home/pengguna');
			}
			else
			{
			        $this->db->trans_commit();
			        $this->session->set_flashdata('success', 'Data Berhasil Di Edit.');
					redirect('home/pengguna');
			}
		}

    	$this->load->view($this->template, $data);
	}

	public function kriteria()
	{
		$data['page'] 		= 'page/kriteria_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['role'] 	= $this->session->userdata('role');

		$data['list']	= $this->db->query('SELECT * FROM kriteria');

    	$this->load->view($this->template, $data);
	}

	public function kriteriaTambah()
	{
		$data['page'] 		= 'page/kriteriaTambah_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['role'] 	= $this->session->userdata('role');

		if (($this->input->post('Submit')) == 'Submit') {

			$this->db->trans_begin();

			$this->db->set('kriteriaNama',$this->input->post('kriteria'));
			$this->db->set('kriteriaKode',$this->input->post('kode'));
			$this->db->set('kriteriaKeterangan',$this->input->post('keterangan'));
			$this->db->insert('kriteria');

			if ($this->db->trans_status() === FALSE)
			{
			        $this->db->trans_rollback();
			        $this->session->set_flashdata('error', 'Data Gagal Di Tambah.');
					redirect('home/kriteria');
			}
			else
			{
			        $this->db->trans_commit();
			        $this->session->set_flashdata('success', 'Data Berhasil Di Tambah.');
					redirect('home/kriteria');
			}
		}

    	$this->load->view($this->template, $data);
	}

	public function kriteriaHapus($id)
	{
		$this->db->where('kriteriaId',$id);
		$this->db->delete('kriteria');
		$this->session->set_flashdata('success', 'Data Berhasil Di Hapus.');
		redirect('home/kriteria');
	}

	public function kriteriaEdit($id)
	{
		$data['page'] 		= 'page/kriteriaEdit_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['role'] 	= $this->session->userdata('role');

		$data['isi']		= $this->db->query('SELECT * FROM kriteria WHERE kriteriaId = '.$id)->row();

		if (($this->input->post('Submit')) == 'Submit') {

			$this->db->trans_begin();

			$this->db->set('kriteriaNama',$this->input->post('kriteria'));
			$this->db->set('kriteriaKode',$this->input->post('kode'));
			$this->db->set('kriteriaKeterangan',$this->input->post('keterangan'));
			$this->db->where('kriteriaId',$id);
			$this->db->update('kriteria');

			if ($this->db->trans_status() === FALSE)
			{
			        $this->db->trans_rollback();
			        $this->session->set_flashdata('error', 'Data Gagal Di Edit.');
					redirect('home/kriteria');
			}
			else
			{
			        $this->db->trans_commit();
			        $this->session->set_flashdata('success', 'Data Berhasil Di Edit.');
					redirect('home/kriteria');
			}
		}

    	$this->load->view($this->template, $data);
	}

	public function parameter()
	{
		$data['page'] 		= 'page/parameter_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['role'] 	= $this->session->userdata('role');

		$data['list']	= $this->db->query('SELECT * FROM parameter INNER JOIN kriteria ON kriteriaId = parameterKriteriaId');

    	$this->load->view($this->template, $data);
	}

	public function parameterTambah()
	{
		$data['page'] 		= 'page/parameterTambah_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['role'] 	= $this->session->userdata('role');

		$data['kriteria']	= $this->db->query('SELECT * FROM kriteria');

		if (($this->input->post('Submit')) == 'Submit') {

			$this->db->trans_begin();

			$this->db->set('parameterKriteriaId',$this->input->post('kriteria'));
			$this->db->set('parameterNama',$this->input->post('parameter'));
			$this->db->set('parameterKode',$this->input->post('kode'));
			$this->db->set('parameterKeterangan',$this->input->post('keterangan'));
			$this->db->insert('parameter');

			if ($this->db->trans_status() === FALSE)
			{
			        $this->db->trans_rollback();
			        $this->session->set_flashdata('error', 'Data Gagal Di Tambah.');
					redirect('home/parameter');
			}
			else
			{
			        $this->db->trans_commit();
			        $this->session->set_flashdata('success', 'Data Berhasil Di Tambah.');
					redirect('home/parameter');
			}
		}

    	$this->load->view($this->template, $data);
	}

	public function parameterEdit($id)
	{
		$data['page'] 		= 'page/parameterEdit_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['role'] 	= $this->session->userdata('role');

		$data['kriteria']	= $this->db->query('SELECT * FROM kriteria');
		$data['isi']		= $this->db->query('SELECT * FROM parameter INNER JOIN kriteria ON kriteriaId = parameterKriteriaId WHERE parameterId = '.$id)->row();

		if (($this->input->post('Submit')) == 'Submit') {

			$this->db->trans_begin();

			$this->db->set('parameterKriteriaId',$this->input->post('kriteria'));
			$this->db->set('parameterNama',$this->input->post('parameter'));
			$this->db->set('parameterKode',$this->input->post('kode'));
			$this->db->set('parameterKeterangan',$this->input->post('keterangan'));
			$this->db->where('parameterId',$id);
			$this->db->update('parameter');

			if ($this->db->trans_status() === FALSE)
			{
			        $this->db->trans_rollback();
			        $this->session->set_flashdata('error', 'Data Gagal Di Ubah.');
					redirect('home/parameter');
			}
			else
			{
			        $this->db->trans_commit();
			        $this->session->set_flashdata('success', 'Data Berhasil Di Ubah.');
					redirect('home/parameter');
			}
		}

    	$this->load->view($this->template, $data);
	}

	public function parameterHapus($id)
	{
		$this->db->where('parameterId',$id);
		$this->db->delete('parameter');
		$this->session->set_flashdata('success', 'Data Berhasil Di Hapus.');
		redirect('home/parameter');
	}

	public function alternatifKaryawan()
	{
		$data['page'] 		= 'page/alternatifKaryawan_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['role'] 	= $this->session->userdata('role');
		
		$data['list']		= $this->db->query('SELECT * FROM alternatif_karyawan a
												INNER JOIN simsdm_karyawan k ON a.altKaryawanIdk = k.id
												INNER JOIN simsdm_jabatan j ON k.id_jabatan = j.jabatan_id
												INNER JOIN simsdm_jenjang jj ON k.jenjang = jj.jenjang_id
												INNER JOIN simsdm_golongan g ON k.golongan = g.gol_id
												INNER JOIN simsdm_loker_satuan s ON k.karyawan_satuan = s.sat_kode												
												WHERE k.id_jabatan = 90 AND k.status_karyawan < 3
												');

    	$this->load->view($this->template, $data);
	}

	public function alternatifKaryawanTambah()
	{
		$data['page'] 		= 'page/alternatifKaryawanTambah_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['role'] 	= $this->session->userdata('role');

		$data['jenjang']	= $this->db->query('SELECT * FROM jenjang');
		$data['golongan']	= $this->db->query('SELECT * FROM golongan');

		if (($this->input->post('Submit')) == 'Submit') {

			$this->db->trans_begin();

			$this->db->set('altKaryawanNama',$this->input->post('nama'));
			$this->db->set('altKaryawanKode',$this->input->post('kode'));
			$this->db->set('altKaryawanJenjang',$this->input->post('jenjang'));
			$this->db->set('altKaryawanGolongan',$this->input->post('golongan'));
			$this->db->insert('alternatif_karyawan');

			if ($this->db->trans_status() === FALSE)
			{
			        $this->db->trans_rollback();
			        $this->session->set_flashdata('error', 'Data Gagal Di Tambah.');
					redirect('home/alternatifKaryawan');
			}
			else
			{
			        $this->db->trans_commit();
			        $this->session->set_flashdata('success', 'Data Berhasil Di Tambah.');
					redirect('home/alternatifKaryawan');
			}
		}

    	$this->load->view($this->template, $data);
	}

	public function alternatifKaryawanEdit($id)
	{
		$data['page'] 		= 'page/alternatifKaryawanEdit_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['role'] 	= $this->session->userdata('role');
		
		$data['jenjang']	= $this->db->query('SELECT * FROM jenjang');
		$data['golongan']	= $this->db->query('SELECT * FROM golongan');
		$data['isi']		= $this->db->query('SELECT * FROM alternatif_karyawan WHERE altKaryawanId = '.$id)->row();

		if (($this->input->post('Submit')) == 'Submit') {

			$this->db->trans_begin();

			$this->db->set('altKaryawanNama',$this->input->post('nama'));
			$this->db->set('altKaryawanKode',$this->input->post('kode'));
			$this->db->set('altKaryawanJenjang',$this->input->post('jenjang'));
			$this->db->set('altKaryawanGolongan',$this->input->post('golongan'));
			$this->db->where('altKaryawanId',$id);
			$this->db->update('alternatif_karyawan');

			if ($this->db->trans_status() === FALSE)
			{
			        $this->db->trans_rollback();
			        $this->session->set_flashdata('error', 'Data Gagal Di Edit.');
					redirect('home/alternatifKaryawan');
			}
			else
			{
			        $this->db->trans_commit();
			        $this->session->set_flashdata('success', 'Data Berhasil Di Edit.');
					redirect('home/alternatifKaryawan');
			}
		}

    	$this->load->view($this->template, $data);
	}

	public function alternatifKaryawanHapus($id)
	{
		$this->db->where('altKaryawanId',$id);
		$this->db->delete('alternatif_karyawan');
		$this->session->set_flashdata('success', 'Data Berhasil Di Hapus.');
		redirect('home/alternatifKaryawan');
	}

	public function dataKaryawan()
	{
		$data['page'] 		= 'page/dataKaryawan_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['role'] 		= $this->session->userdata('role');
		
		$data['list']		= $this->db->query('SELECT * FROM simsdm_karyawan k 
												INNER JOIN simsdm_jabatan j ON k.id_jabatan = j.jabatan_id
												INNER JOIN simsdm_jenjang jj ON k.jenjang = jj.jenjang_id
												INNER JOIN simsdm_golongan g ON k.golongan = g.gol_id
												INNER JOIN simsdm_loker_satuan s ON k.karyawan_satuan = s.sat_kode
												LEFT JOIN alternatif_karyawan a ON a.altKaryawanIdk = k.id
												WHERE k.id_jabatan = 90 AND k.status_karyawan < 3
												');

		//$data['checked'] = $this->db->query()

    	$this->load->view($this->template, $data);
	}

	public function postAlternatif()
	{
		//print_r($_POST['karyawan']);exit;

		$this->db->trans_begin();

		foreach ($_POST['karyawan'] as $key => $value) {
			
			$alternatif = $this->db->query('SELECT * FROM alternatif_karyawan');

			$jumlahAlternatif = $alternatif->num_rows();

			for ($i=1; $i <= $jumlahAlternatif; $i++) { 
				$urut[] = $i;
			}

			foreach ($alternatif->result() as $row) {
				$angka = substr_replace($row->altKaryawanKode, '_', 1 , 0 );
				$pisah = explode('_', $angka);
				$exis[] = $pisah[1];
			}

			$check = array_diff($urut, $exis);

			if ( empty($check) )
			{
				//echo "sama";exit;
				$alternatifHit = $this->db->query('SELECT * FROM alternatif_karyawan');
				$jum = $alternatifHit->num_rows() + 1;
				$K = 'K'.$jum;
				$this->db->set('altKaryawanIdk',$value);
				$this->db->set('altKaryawanKode',$K);
				$this->db->insert('alternatif_karyawan');

			}else{
				//echo "beda";exit;
				$sempal = array_values( array_diff( $urut , $exis ) );
				//print_r($sempal);exit;
				//$alternatifHit = $this->db->query('SELECT * FROM alternatif_karyawan');
				//$jum = $alternatifHit->num_rows() + 1;
				$K = 'K'.$sempal[0];
				$this->db->set('altKaryawanIdk',$value);
				$this->db->set('altKaryawanKode',$K);
				$this->db->insert('alternatif_karyawan');

			}	

		}

		if ($this->db->trans_status() === FALSE)
		{
		        $this->db->trans_rollback();
		        $this->session->set_flashdata('error', 'Data Gagal Di Tambah.');
				redirect('home/dataKaryawan');
		}
		else
		{
		        $this->db->trans_commit();
		        $this->session->set_flashdata('success', 'Data Berhasil Di Tambah.');
				redirect('home/dataKaryawan');
		}

		//print_r($exis);

	}

}

?>