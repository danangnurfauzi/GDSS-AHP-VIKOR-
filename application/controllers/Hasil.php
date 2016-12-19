<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Hasil extends CI_Controller
{

	var $template = 'template';
	
	function __construct()
	{
		parent::__construct();
		if ($this->session->has_userdata('logged_in') !== TRUE) {
			redirect('login');
		}
	}

	public function individu()
	{
		$data['page'] 		= 'page/hasilIndividu_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['userId']		= $this->session->userdata('userId');
		$data['role']		= $this->session->userdata('role');

		$data['rank']		= $this->db->query('SELECT * FROM rank_alternatif INNER JOIN alternatif_karyawan ON altKaryawanId = raAltKaryawanId AND raUserId = '.$data['userId'].' WHERE raUserId = '.$data['userId']);

		$this->load->view($this->template, $data);
	}

	public function kompetensiRank()
	{
		$data['page'] 		= 'page/kompetensiRank_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['userId']		= $this->session->userdata('userId');
		$data['role']		= $this->session->userdata('role');

		$data['rank']		= $this->db->query('SELECT * FROM rank_alternatif INNER JOIN alternatif_karyawan ON altKaryawanId = raAltKaryawanId AND raUserId = '.$data['userId'].' WHERE raUserId = '.$data['userId']);

		$this->load->view($this->template, $data);
	}
 
	public function hitungIndividuRank()
	{		
		$data['username'] 	= $this->session->userdata('username');
		$data['userId']		= $this->session->userdata('userId');
		$data['role']		= $this->session->userdata('role');

		$nilaiManajemenAlternatif = $this->db->query('SELECT * FROM nilai_kriteria_alternatif');

		$daftarAlternatif = $this->db->query('SELECT * FROM alternatif_karyawan');

		$tabelKolomManajemen = $this->db->query('SELECT * FROM kriteria WHERE kriteriaRole = '.$data['role']);

		//buat matriks alternatif dan kriteria
		$setMatriks = array();
		$a=0;
		foreach ($daftarAlternatif->result() as $baris) {
			$b=0;
			foreach ($tabelKolomManajemen->result() as $kolom) {
				$nilaiParameter = $this->db->query('SELECT * FROM nilai_kriteria_alternatif WHERE nkAltKaryawanId = '.$baris->altKaryawanId.' AND nkKriteriaId = '.$kolom->kriteriaId)->row()->nkNilai;
				$setMatriks[$a][$b] = $nilaiParameter;
				$b++;
			}
			$a++;
		}

		//nilai matriks di kuadratkan
		$matriksKuadrat = array();
		$c=0;
		foreach ($daftarAlternatif->result() as $baris) {
			$d=0;
			foreach ($tabelKolomManajemen->result() as $kolom) {
				$nilaiParameter = $this->db->query('SELECT * FROM nilai_kriteria_alternatif WHERE nkAltKaryawanId = '.$baris->altKaryawanId.' AND nkKriteriaId = '.$kolom->kriteriaId)->row()->nkNilai;
				$matriksKuadrat[$c][$d] = pow($nilaiParameter, 2);
				$d++;
			}
			$c++;
		}

		//hitung jumlah baris setelah di kuadratkan
		$jumlahBarisMatriks = array();
		$e=0;
		foreach ($daftarAlternatif->result() as $row) {
			$f=0;
			$jumlah = 0;
			foreach ($tabelKolomManajemen->result() as $column) {
				$jumlah = $jumlah + $matriksKuadrat[$e][$f];
				$f++;
			}

			$jumlahBarisMatriks[] = $jumlah;
			$e++;
		}

		//hitung hasil jumlah kuadrat di akarkan
		$akarMatriks = array();
		for ($g=0; $g < count($jumlahBarisMatriks) ; $g++) { 
			$akarMatriks[$g] = sqrt($jumlahBarisMatriks[$g]);
		}

		//matriks ternormalisasi
		$normalisasi = array();
		for ($h=0; $h < $daftarAlternatif->num_rows() ; $h++) { 
			for ($i=0; $i < $tabelKolomManajemen->num_rows() ; $i++) { 
				//$nilaiParameter = $this->db->query('SELECT * FROM nilai_kriteria_alternatif WHERE nkAltKaryawanId = '.$baris->altKaryawanId.' AND nkKriteriaId = '.$kolom->kriteriaId)->row()->nkNilai;
				$normalisasi[$h][$i] = $setMatriks[$h][$i]/$akarMatriks[$h];  //round($nilaiParameter / $akarMatriks[$i],3);
			}
		}		

		//hitung matriks ternormalisasi dikalikan dengan hasil pembobotan user
		$nilaiBobot = array();
		$j=0;
		foreach ($daftarAlternatif->result() as $baris) {
			$k=0;
			foreach ($tabelKolomManajemen->result() as $kolom) {
				$nilaiParameter = $this->db->query('SELECT * FROM nilai_kriteria_alternatif WHERE nkAltKaryawanId = '.$baris->altKaryawanId.' AND nkKriteriaId = '.$kolom->kriteriaId)->row()->nkNilai;
				$bobot = $this->db->query('SELECT * FROM bobot_kriteria WHERE bkUserId = '.$this->session->userdata('userId').' AND bkKriteriaId = '.$kolom->kriteriaId)->row()->bkNilai;
				//$nilaiBobot[$j][$k] = round($normalisasi[$j][$k] * $bobot,3);
				$nilaiBobot[$j][$k] = $normalisasi[$j][$k] * $bobot;
				$k++;
			}
			$j++;
		}		

		//hitung jumlah nilai pembobotan alternatif;
		$jumlahNilaiBobot = array();
		$l=0;
		foreach ($daftarAlternatif->result() as $row) {
			$m=0;
			$jumlahs = 0;
			foreach ($tabelKolomManajemen->result() as $column) {
				$jumlahs = $jumlahs + $nilaiBobot[$l][$m];
				$m++;
			}

			$jumlahNilaiBobot[] = $jumlahs;
			$l++;
		}

		$fBintang = array();
		for ($n=0; $n < $tabelKolomManajemen->num_rows() ; $n++) { 			
			$tempMax = array();
			for ($o=0; $o < $daftarAlternatif->num_rows() ; $o++) { 
				$tempMax[] = $nilaiBobot[$o][$n];
			}

			$fBintang[] = max($tempMax);

		}
		
		$fMin = array();
		for ($p=0; $p < $tabelKolomManajemen->num_rows() ; $p++) { 
			$tempMin = array();
			for ($q=0; $q < $daftarAlternatif->num_rows() ; $q++) { 
				$tempMin[] = $nilaiBobot[$q][$p];
			}

			$fMin[] = min($tempMin);

		}

		$solusi = array();
		for ($r=0; $r < $daftarAlternatif->num_rows(); $r++) { 
			for ($s=0; $s < $tabelKolomManajemen->num_rows(); $s++) { 
				$solusi[$r][$s] = $jumlahNilaiBobot[$r] * ( ($fBintang[$s]-$nilaiBobot[$r][$s]) / ($fBintang[$s] - $fMin[$s]) );
				//$solusi[$r][$s] = $jumlahNilaiBobot[$r]." * ".$fBintang[$s]." - ".$nilaiBobot[$r][$s]." / ".$fBintang[$s]." - ".$fMin[$s];
			}
		}

		$Si = array();
		for ($r=0; $r < $daftarAlternatif->num_rows(); $r++) { 
			$jumlahSi=0;
			for ($s=0; $s < $tabelKolomManajemen->num_rows(); $s++) { 
				$jumlahSi = $jumlahSi + $solusi[$r][$s];
			}
			$Si[] = $jumlahSi;
		}

		$Ri = array();
		for ($t=0; $t < $daftarAlternatif->num_rows() ; $t++) { 
			$tempMaxRi = array();
			for ($u=0; $u < $tabelKolomManajemen->num_rows() ; $u++) { 
				$tempMaxRi[] = $solusi[$t][$u];				
			}
			//print_r($tempMaxRi);exit;
			$Ri[] = max($tempMaxRi);
		}

		$SMin 		= max($Si);
		$SBintang 	= min($Si);
		$SSelisish	= $SMin - $SBintang;

		$RMin		= max($Ri);
		$RBintang	= min($Ri);
		$RSelisih	= $RMin - $RBintang;

		$SiSBintang = array();
		for ($v=0; $v < count($Si); $v++) { 
			$SiSBintang[] = $Si[$v] - $SBintang;
		}

		$RiRBintang = array();
		for ($w=0; $w < count($Ri) ; $w++) { 
			$RiRBintang[] = $Ri[$w] - $RBintang;
		}

		$indeksQ = array();
		for ($x=0; $x < $daftarAlternatif->num_rows(); $x++) { 
			$indeksQ[] = (0.5*($SiSBintang[$x]/$SSelisish))+((1-0.5)*($RiRBintang[$x]/$RSelisih));
		}

		$alternatifArray = array();
		foreach ($daftarAlternatif->result() as $row) {
			$alternatifArray[] = $row->altKaryawanId;
		}

		asort($indeksQ);
		$rank = array();
		$y=1;
		foreach ($indeksQ as $key => $value) {
			//echo "$key = $value <br />";
			$this->db->set('raAltKaryawanId',$alternatifArray[$key]);
			$this->db->set('raNilaiQ',$value);
			$this->db->set('raUrutan',$y);
			$this->db->set('raUserId',$this->session->userdata('userId'));
			$this->db->insert('rank_alternatif');
			$y++;
		}
		
		redirect('hasil/individu/');	
	}

	public function hitungIndividuKompetensiRank()
	{		
		$data['username'] 	= $this->session->userdata('username');
		$data['userId']		= $this->session->userdata('userId');
		$data['role']		= $this->session->userdata('role');

		$this->db->where('raUserId',$data['userId']);
		$this->db->delete('rank_alternatif');

		$nilaiManajemenAlternatif = $this->db->query('SELECT * FROM nilai_parameter_alternatif');

		$daftarAlternatif = $this->db->query('SELECT * FROM alternatif_karyawan');

		$tabelKolomManajemen = $this->db->query('SELECT * FROM parameter');

		//buat matriks alternatif dan kriteria
		$setMatriks = array();
		$a=0;
		foreach ($daftarAlternatif->result() as $baris) {
			$b=0;
			foreach ($tabelKolomManajemen->result() as $kolom) {
				$nilaiParameter = $this->db->query('SELECT * FROM nilai_parameter_alternatif WHERE npAltKaryawanId = '.$baris->altKaryawanId.' AND npParameterId = '.$kolom->parameterId)->row()->npNilai;
				$setMatriks[$a][$b] = $nilaiParameter;
				$b++;
			}
			$a++;
		}

		//nilai matriks di kuadratkan
		$matriksKuadrat = array();
		$c=0;
		foreach ($daftarAlternatif->result() as $baris) {
			$d=0;
			foreach ($tabelKolomManajemen->result() as $kolom) {
				$nilaiParameter = $this->db->query('SELECT * FROM nilai_parameter_alternatif WHERE npAltKaryawanId = '.$baris->altKaryawanId.' AND npParameterId = '.$kolom->parameterId)->row()->npNilai;
				$matriksKuadrat[$c][$d] = pow($nilaiParameter, 2);
				$d++;
			}
			$c++;
		}

		//hitung jumlah baris setelah di kuadratkan
		$jumlahBarisMatriks = array();
		$e=0;
		foreach ($daftarAlternatif->result() as $row) {
			$f=0;
			$jumlah = 0;
			foreach ($tabelKolomManajemen->result() as $column) {
				$jumlah = $jumlah + $matriksKuadrat[$e][$f];
				$f++;
			}

			$jumlahBarisMatriks[] = $jumlah;
			$e++;
		}

		//hitung hasil jumlah kuadrat di akarkan
		$akarMatriks = array();
		for ($g=0; $g < count($jumlahBarisMatriks) ; $g++) { 
			$akarMatriks[$g] = round(sqrt($jumlahBarisMatriks[$g]),3);
		}

		//matriks ternormalisasi
		$normalisasi = array();
		for ($h=0; $h < $daftarAlternatif->num_rows() ; $h++) { 
			for ($i=0; $i < $tabelKolomManajemen->num_rows() ; $i++) { 
				//$nilaiParameter = $this->db->query('SELECT * FROM nilai_kriteria_alternatif WHERE nkAltKaryawanId = '.$baris->altKaryawanId.' AND nkKriteriaId = '.$kolom->kriteriaId)->row()->nkNilai;
				$normalisasi[$h][$i] = round($setMatriks[$h][$i]/$akarMatriks[$h],3);  //round($nilaiParameter / $akarMatriks[$i],3);
			}
		}		

		//hitung matriks ternormalisasi dikalikan dengan hasil pembobotan user
		$nilaiBobot = array();
		$j=0;
		foreach ($daftarAlternatif->result() as $baris) {
			$k=0;
			foreach ($tabelKolomManajemen->result() as $kolom) {
				$nilaiParameter = $this->db->query('SELECT * FROM nilai_parameter_alternatif WHERE npAltKaryawanId = '.$baris->altKaryawanId.' AND npParameterId = '.$kolom->parameterId)->row()->npNilai;
				$bobot = $this->db->query('SELECT * FROM bobot_parameter WHERE bpUserId = '.$this->session->userdata('userId').' AND bpParameterId = '.$kolom->parameterId)->row()->bpNilai;
				//$nilaiBobot[$j][$k] = round($normalisasi[$j][$k] * $bobot,3);
				$nilaiBobot[$j][$k] = $normalisasi[$j][$k] * $bobot;
				$k++;
			}
			$j++;
		}		

		//hitung jumlah nilai pembobotan alternatif;
		$jumlahNilaiBobot = array();
		$l=0;
		foreach ($daftarAlternatif->result() as $row) {
			$m=0;
			$jumlahs = 0;
			foreach ($tabelKolomManajemen->result() as $column) {
				$jumlahs = $jumlahs + $nilaiBobot[$l][$m];
				$m++;
			}

			$jumlahNilaiBobot[] = $jumlahs;
			$l++;
		}

		$fBintang = array();
		for ($n=0; $n < $tabelKolomManajemen->num_rows() ; $n++) { 			
			$tempMax = array();
			for ($o=0; $o < $daftarAlternatif->num_rows() ; $o++) { 
				$tempMax[] = $nilaiBobot[$o][$n];
			}

			$fBintang[] = max($tempMax);

		}
		
		$fMin = array();
		for ($p=0; $p < $tabelKolomManajemen->num_rows() ; $p++) { 
			$tempMin = array();
			for ($q=0; $q < $daftarAlternatif->num_rows() ; $q++) { 
				$tempMin[] = $nilaiBobot[$q][$p];
			}

			$fMin[] = min($tempMin);

		}

		$solusi = array();
		for ($r=0; $r < $daftarAlternatif->num_rows(); $r++) { 
			for ($s=0; $s < $tabelKolomManajemen->num_rows(); $s++) { 
				$solusi[$r][$s] = round($jumlahNilaiBobot[$r] * ( ($fBintang[$s]-$nilaiBobot[$r][$s]) / ($fBintang[$s] - $fMin[$s]) ) , 3 );
				//$solusi[$r][$s] = $jumlahNilaiBobot[$r]." * ".$fBintang[$s]." - ".$nilaiBobot[$r][$s]." / ".$fBintang[$s]." - ".$fMin[$s];
			}
		}

		$Si = array();
		for ($r=0; $r < $daftarAlternatif->num_rows(); $r++) { 
			$jumlahSi=0;
			for ($s=0; $s < $tabelKolomManajemen->num_rows(); $s++) { 
				$jumlahSi = $jumlahSi + $solusi[$r][$s];
			}
			$Si[] = $jumlahSi;
		}

		$Ri = array();
		for ($t=0; $t < $daftarAlternatif->num_rows() ; $t++) { 
			$tempMaxRi = array();
			for ($u=0; $u < $tabelKolomManajemen->num_rows() ; $u++) { 
				$tempMaxRi[] = $solusi[$t][$u];				
			}
			//print_r($tempMaxRi);exit;
			$Ri[] = max($tempMaxRi);
		}

		$SMin 		= max($Si);
		$SBintang 	= min($Si);
		$SSelisish	= $SMin - $SBintang;

		$RMin		= max($Ri);
		$RBintang	= min($Ri);
		$RSelisih	= $RMin - $RBintang;

		$SiSBintang = array();
		for ($v=0; $v < count($Si); $v++) { 
			$SiSBintang[] = $Si[$v] - $SBintang;
		}

		$RiRBintang = array();
		for ($w=0; $w < count($Ri) ; $w++) { 
			$RiRBintang[] = $Ri[$w] - $RBintang;
		}

		$indeksQ = array();
		for ($x=0; $x < $daftarAlternatif->num_rows(); $x++) { 
			$indeksQ[] = (0.5*($SiSBintang[$x]/$SSelisish))+((1-0.5)*($RiRBintang[$x]/$RSelisih));
		}

		$alternatifArray = array();
		foreach ($daftarAlternatif->result() as $row) {
			$alternatifArray[] = $row->altKaryawanId;
		}

		asort($indeksQ);
		$rank = array();
		$y=1;
		foreach ($indeksQ as $key => $value) {
			//echo "$key = $value <br />";
			$this->db->set('raAltKaryawanId',$alternatifArray[$key]);
			$this->db->set('raNilaiQ',$value);
			$this->db->set('raUrutan',$y);
			$this->db->set('raUserId',$this->session->userdata('userId'));
			$this->db->insert('rank_alternatif');
			$y++;
		}
		
		redirect('hasil/kompetensiRank/');	
	}

	public function cekPerankingan()
	{
		$data['page'] 		= 'page/cekPerankingan_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['userId']		= $this->session->userdata('userId');
		$data['role']		= $this->session->userdata('role');

		$data['rank']		= $this->db->query('
												select p.nama, COUNT(r.raUserId) AS jumlah
												from pengguna p
												left join rank_alternatif r on r.raUserId = p.userId
												where role NOT IN (0,3)
												GROUP BY p.userId
												');

		$this->load->view($this->template, $data);
	}

	public function rankingKelompok()
	{
		$data['page'] 		= 'page/rankingKelompok_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['userId']		= $this->session->userdata('userId');
		$data['role']		= $this->session->userdata('role');

		$data['rank']		= $this->db->query('SELECT * FROM rank_alternatif_kelompok INNER JOIN alternatif_karyawan ON altKaryawanId = rkAltKaryawanId');

		$this->load->view($this->template, $data);
	}

	public function hitungRankingKelompok()
	{
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

		$alternatifArray = array();
		foreach ($daftarAlternatif->result() as $row) {
			$alternatifArray[] = $row->altKaryawanId;
		}

		arsort($jumlahPoint);
		$rank = array();
		$y=1;
		foreach ($jumlahPoint as $key => $value) {
			//echo "$key = $value <br />";
			$this->db->set('rkAltKaryawanId',$alternatifArray[$key]);
			$this->db->set('rkPoint',$value);
			$this->db->set('rkUrutan',$y);			
			$this->db->insert('rank_alternatif_kelompok');
			$y++;
		}
		
		redirect('hasil/rankingKelompok/');	

		//echo "<pre>";
		//print_r($jumlahPoint);
	}

	public function agregasiKeputusan()
	{
		$data['page'] 		= 'page/agregasiKeputusan_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['userId']		= $this->session->userdata('userId');
		$data['role']		= $this->session->userdata('role');

		$decisionMaker 		= $this->db->query('SELECT * FROM pengguna ORDER BY role DESC');
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

		$alternatifArray = array();
		foreach ($daftarAlternatif->result() as $row) {
			$alternatifArray[] = $row->altKaryawanId;
		}

		arsort($jumlahPoint);
		$rank = array();
		/*$y=1;
		foreach ($jumlahPoint as $key => $value) {
			//echo "$key = $value <br />";
			$this->db->set('rkAltKaryawanId',$alternatifArray[$key]);
			$this->db->set('rkPoint',$value);
			$this->db->set('rkUrutan',$y);			
			$this->db->insert('rank_alternatif_kelompok');
			$y++;
		}
		
		redirect('hasil/rankingKelompok/');	*/

		//echo "<pre>";
		//print_r($jumlahPoint);
	}

	public function matriksKeputusan()
	{
		$data['page'] 		= 'page/matriksKeputusan_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['userId']		= $this->session->userdata('userId');
		$data['role']		= $this->session->userdata('role');

		$daftarAlternatif = $this->db->query('SELECT * FROM alternatif_karyawan');

		if ($data['role'] == '0') {
			$tabelKolomManajemen = $this->db->query('SELECT * FROM parameter');	
		}else{
			$tabelKolomManajemen = $this->db->query('SELECT * FROM kriteria WHERE kriteriaRole = '.$data['role']);
		}
		
		$data['daftarAlternatif'] 	 = $daftarAlternatif;
		$data['tabelKolomManajemen'] = $tabelKolomManajemen;

		//buat matriks alternatif dan kriteria
		$setMatriks = array();
		$a=0;
		foreach ($daftarAlternatif->result() as $baris) {
			$b=0;
			foreach ($tabelKolomManajemen->result() as $kolom) {
				$nilaiParameter = $this->db->query('SELECT * FROM nilai_parameter_alternatif WHERE npAltKaryawanId = '.$baris->altKaryawanId.' AND npParameterId = '.$kolom->parameterId)->row()->npNilai;
				$setMatriks[$a][$b] = $nilaiParameter;
				$b++;
			}
			$a++;
		}

		$data['matriks'] = $setMatriks;

		$this->load->view($this->template, $data);
	}

	public function matriksKeputusanTernormalisasi()
	{
		$data['page'] 		= 'page/matriksKeputusanTernormalisasi_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['userId']		= $this->session->userdata('userId');
		$data['role']		= $this->session->userdata('role');

		$daftarAlternatif = $this->db->query('SELECT * FROM alternatif_karyawan');

		if ($data['role'] == '0') {
			$tabelKolomManajemen = $this->db->query('SELECT * FROM parameter');	
		}else{
			$tabelKolomManajemen = $this->db->query('SELECT * FROM kriteria WHERE kriteriaRole = '.$data['role']);
		}
		
		$data['daftarAlternatif'] 	 = $daftarAlternatif;
		$data['tabelKolomManajemen'] = $tabelKolomManajemen;

		//buat matriks alternatif dan kriteria
		$setMatriks = array();
		$a=0;
		foreach ($daftarAlternatif->result() as $baris) {
			$b=0;
			foreach ($tabelKolomManajemen->result() as $kolom) {
				$nilaiParameter = $this->db->query('SELECT * FROM nilai_parameter_alternatif WHERE npAltKaryawanId = '.$baris->altKaryawanId.' AND npParameterId = '.$kolom->parameterId)->row()->npNilai;
				$setMatriks[$a][$b] = $nilaiParameter;
				$b++;
			}
			$a++;
		}

		//nilai matriks di kuadratkan
		$matriksKuadrat = array();
		$c=0;
		foreach ($daftarAlternatif->result() as $baris) {
			$d=0;
			foreach ($tabelKolomManajemen->result() as $kolom) {
				$nilaiParameter = $this->db->query('SELECT * FROM nilai_parameter_alternatif WHERE npAltKaryawanId = '.$baris->altKaryawanId.' AND npParameterId = '.$kolom->parameterId)->row()->npNilai;
				$matriksKuadrat[$c][$d] = pow($nilaiParameter, 2);
				$d++;
			}
			$c++;
		}

		//hitung jumlah baris setelah di kuadratkan
		$jumlahBarisMatriks = array();
		$e=0;
		foreach ($daftarAlternatif->result() as $row) {
			$f=0;
			$jumlah = 0;
			foreach ($tabelKolomManajemen->result() as $column) {
				$jumlah = $jumlah + $matriksKuadrat[$e][$f];
				$f++;
			}

			$jumlahBarisMatriks[] = $jumlah;
			$e++;
		}

		//hitung hasil jumlah kuadrat di akarkan
		$akarMatriks = array();
		for ($g=0; $g < count($jumlahBarisMatriks) ; $g++) { 
			$akarMatriks[$g] = round(sqrt($jumlahBarisMatriks[$g]),3);
		}

		//matriks ternormalisasi
		$normalisasi = array();
		for ($h=0; $h < $daftarAlternatif->num_rows() ; $h++) { 
			for ($i=0; $i < $tabelKolomManajemen->num_rows() ; $i++) { 
				//$nilaiParameter = $this->db->query('SELECT * FROM nilai_kriteria_alternatif WHERE nkAltKaryawanId = '.$baris->altKaryawanId.' AND nkKriteriaId = '.$kolom->kriteriaId)->row()->nkNilai;
				$normalisasi[$h][$i] = round($setMatriks[$h][$i]/$akarMatriks[$h],3);  //round($nilaiParameter / $akarMatriks[$i],3);
			}
		}	

		$data['matriks'] = $normalisasi;

		$this->load->view($this->template, $data);
	}

	public function matriksTernormalisasiTerbobot()
	{
		$data['page'] 		= 'page/matriksTernormalisasiTerbobot_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['userId']		= $this->session->userdata('userId');
		$data['role']		= $this->session->userdata('role');

		$daftarAlternatif = $this->db->query('SELECT * FROM alternatif_karyawan');

		if ($data['role'] == '0') {
			$tabelKolomManajemen = $this->db->query('SELECT * FROM parameter');	
		}else{
			$tabelKolomManajemen = $this->db->query('SELECT * FROM kriteria WHERE kriteriaRole = '.$data['role']);
		}
		
		$data['daftarAlternatif'] 	 = $daftarAlternatif;
		$data['tabelKolomManajemen'] = $tabelKolomManajemen;

		//buat matriks alternatif dan kriteria
		$setMatriks = array();
		$a=0;
		foreach ($daftarAlternatif->result() as $baris) {
			$b=0;
			foreach ($tabelKolomManajemen->result() as $kolom) {
				$nilaiParameter = $this->db->query('SELECT * FROM nilai_parameter_alternatif WHERE npAltKaryawanId = '.$baris->altKaryawanId.' AND npParameterId = '.$kolom->parameterId)->row()->npNilai;
				$setMatriks[$a][$b] = $nilaiParameter;
				$b++;
			}
			$a++;
		}

		//nilai matriks di kuadratkan
		$matriksKuadrat = array();
		$c=0;
		foreach ($daftarAlternatif->result() as $baris) {
			$d=0;
			foreach ($tabelKolomManajemen->result() as $kolom) {
				$nilaiParameter = $this->db->query('SELECT * FROM nilai_parameter_alternatif WHERE npAltKaryawanId = '.$baris->altKaryawanId.' AND npParameterId = '.$kolom->parameterId)->row()->npNilai;
				$matriksKuadrat[$c][$d] = pow($nilaiParameter, 2);
				$d++;
			}
			$c++;
		}

		//hitung jumlah baris setelah di kuadratkan
		$jumlahBarisMatriks = array();
		$e=0;
		foreach ($daftarAlternatif->result() as $row) {
			$f=0;
			$jumlah = 0;
			foreach ($tabelKolomManajemen->result() as $column) {
				$jumlah = $jumlah + $matriksKuadrat[$e][$f];
				$f++;
			}

			$jumlahBarisMatriks[] = $jumlah;
			$e++;
		}

		//hitung hasil jumlah kuadrat di akarkan
		$akarMatriks = array();
		for ($g=0; $g < count($jumlahBarisMatriks) ; $g++) { 
			$akarMatriks[$g] = round(sqrt($jumlahBarisMatriks[$g]),3);
		}

		//matriks ternormalisasi
		$normalisasi = array();
		for ($h=0; $h < $daftarAlternatif->num_rows() ; $h++) { 
			for ($i=0; $i < $tabelKolomManajemen->num_rows() ; $i++) { 
				//$nilaiParameter = $this->db->query('SELECT * FROM nilai_kriteria_alternatif WHERE nkAltKaryawanId = '.$baris->altKaryawanId.' AND nkKriteriaId = '.$kolom->kriteriaId)->row()->nkNilai;
				$normalisasi[$h][$i] = round($setMatriks[$h][$i]/$akarMatriks[$h],3);  //round($nilaiParameter / $akarMatriks[$i],3);
			}
		}	

		//hitung matriks ternormalisasi dikalikan dengan hasil pembobotan user
		$nilaiBobot = array();
		$j=0;
		foreach ($daftarAlternatif->result() as $baris) {
			$k=0;
			foreach ($tabelKolomManajemen->result() as $kolom) {
				$nilaiParameter = $this->db->query('SELECT * FROM nilai_parameter_alternatif WHERE npAltKaryawanId = '.$baris->altKaryawanId.' AND npParameterId = '.$kolom->parameterId)->row()->npNilai;
				$bobot = $this->db->query('SELECT * FROM bobot_parameter WHERE bpUserId = '.$this->session->userdata('userId').' AND bpParameterId = '.$kolom->parameterId)->row()->bpNilai;
				//$nilaiBobot[$j][$k] = round($normalisasi[$j][$k] * $bobot,3);
				$nilaiBobot[$j][$k] = round($normalisasi[$j][$k] * $bobot , 3);
				$k++;
			}
			$j++;
		}

		$data['matriks'] = $nilaiBobot;

		$this->load->view($this->template, $data);
	}

	public function utilityMeasure()
	{
		$data['page'] 		= 'page/utilityMeasure_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['userId']		= $this->session->userdata('userId');
		$data['role']		= $this->session->userdata('role');

		$daftarAlternatif = $this->db->query('SELECT * FROM alternatif_karyawan');

		if ($data['role'] == '0') {
			$tabelKolomManajemen = $this->db->query('SELECT * FROM parameter');	
		}else{
			$tabelKolomManajemen = $this->db->query('SELECT * FROM kriteria WHERE kriteriaRole = '.$data['role']);
		}
		
		$data['daftarAlternatif'] 	 = $daftarAlternatif;
		$data['tabelKolomManajemen'] = $tabelKolomManajemen;

		//buat matriks alternatif dan kriteria
		$setMatriks = array();
		$a=0;
		foreach ($daftarAlternatif->result() as $baris) {
			$b=0;
			foreach ($tabelKolomManajemen->result() as $kolom) {
				$nilaiParameter = $this->db->query('SELECT * FROM nilai_parameter_alternatif WHERE npAltKaryawanId = '.$baris->altKaryawanId.' AND npParameterId = '.$kolom->parameterId)->row()->npNilai;
				$setMatriks[$a][$b] = $nilaiParameter;
				$b++;
			}
			$a++;
		}

		//nilai matriks di kuadratkan
		$matriksKuadrat = array();
		$c=0;
		foreach ($daftarAlternatif->result() as $baris) {
			$d=0;
			foreach ($tabelKolomManajemen->result() as $kolom) {
				$nilaiParameter = $this->db->query('SELECT * FROM nilai_parameter_alternatif WHERE npAltKaryawanId = '.$baris->altKaryawanId.' AND npParameterId = '.$kolom->parameterId)->row()->npNilai;
				$matriksKuadrat[$c][$d] = pow($nilaiParameter, 2);
				$d++;
			}
			$c++;
		}

		//hitung jumlah baris setelah di kuadratkan
		$jumlahBarisMatriks = array();
		$e=0;
		foreach ($daftarAlternatif->result() as $row) {
			$f=0;
			$jumlah = 0;
			foreach ($tabelKolomManajemen->result() as $column) {
				$jumlah = $jumlah + $matriksKuadrat[$e][$f];
				$f++;
			}

			$jumlahBarisMatriks[] = $jumlah;
			$e++;
		}

		//hitung hasil jumlah kuadrat di akarkan
		$akarMatriks = array();
		for ($g=0; $g < count($jumlahBarisMatriks) ; $g++) { 
			$akarMatriks[$g] = round(sqrt($jumlahBarisMatriks[$g]),3);
		}

		//matriks ternormalisasi
		$normalisasi = array();
		for ($h=0; $h < $daftarAlternatif->num_rows() ; $h++) { 
			for ($i=0; $i < $tabelKolomManajemen->num_rows() ; $i++) { 
				//$nilaiParameter = $this->db->query('SELECT * FROM nilai_kriteria_alternatif WHERE nkAltKaryawanId = '.$baris->altKaryawanId.' AND nkKriteriaId = '.$kolom->kriteriaId)->row()->nkNilai;
				$normalisasi[$h][$i] = round($setMatriks[$h][$i]/$akarMatriks[$h],3);  //round($nilaiParameter / $akarMatriks[$i],3);
			}
		}	

		//hitung matriks ternormalisasi dikalikan dengan hasil pembobotan user
		$nilaiBobot = array();
		$j=0;
		foreach ($daftarAlternatif->result() as $baris) {
			$k=0;
			foreach ($tabelKolomManajemen->result() as $kolom) {
				$nilaiParameter = $this->db->query('SELECT * FROM nilai_parameter_alternatif WHERE npAltKaryawanId = '.$baris->altKaryawanId.' AND npParameterId = '.$kolom->parameterId)->row()->npNilai;
				$bobot = $this->db->query('SELECT * FROM bobot_parameter WHERE bpUserId = '.$this->session->userdata('userId').' AND bpParameterId = '.$kolom->parameterId)->row()->bpNilai;
				//$nilaiBobot[$j][$k] = round($normalisasi[$j][$k] * $bobot,3);
				$nilaiBobot[$j][$k] = round($normalisasi[$j][$k] * $bobot , 3);
				$k++;
			}
			$j++;
		}

		//hitung jumlah nilai pembobotan alternatif;
		$jumlahNilaiBobot = array();
		$l=0;
		foreach ($daftarAlternatif->result() as $row) {
			$m=0;
			$jumlahs = 0;
			foreach ($tabelKolomManajemen->result() as $column) {
				$jumlahs = $jumlahs + $nilaiBobot[$l][$m];
				$m++;
			}

			$jumlahNilaiBobot[] = $jumlahs;
			$l++;
		}

		$fBintang = array();
		for ($n=0; $n < $tabelKolomManajemen->num_rows() ; $n++) { 			
			$tempMax = array();
			for ($o=0; $o < $daftarAlternatif->num_rows() ; $o++) { 
				$tempMax[] = $nilaiBobot[$o][$n];
			}

			$fBintang[] = max($tempMax);

		}
		
		$fMin = array();
		for ($p=0; $p < $tabelKolomManajemen->num_rows() ; $p++) { 
			$tempMin = array();
			for ($q=0; $q < $daftarAlternatif->num_rows() ; $q++) { 
				$tempMin[] = $nilaiBobot[$q][$p];
			}

			$fMin[] = min($tempMin);

		}

		$solusi = array();
		for ($r=0; $r < $daftarAlternatif->num_rows(); $r++) { 
			for ($s=0; $s < $tabelKolomManajemen->num_rows(); $s++) { 
				$solusi[$r][$s] = round($jumlahNilaiBobot[$r] * ( ($fBintang[$s]-$nilaiBobot[$r][$s]) / ($fBintang[$s] - $fMin[$s]) ) , 3 );
				//$solusi[$r][$s] = $jumlahNilaiBobot[$r]." * ".$fBintang[$s]." - ".$nilaiBobot[$r][$s]." / ".$fBintang[$s]." - ".$fMin[$s];
			}
		}

		$Si = array();
		for ($r=0; $r < $daftarAlternatif->num_rows(); $r++) { 
			$jumlahSi=0;
			for ($s=0; $s < $tabelKolomManajemen->num_rows(); $s++) { 
				$jumlahSi = $jumlahSi + $solusi[$r][$s];
			}
			$Si[] = $jumlahSi;
		}

		$Ri = array();
		for ($t=0; $t < $daftarAlternatif->num_rows() ; $t++) { 
			$tempMaxRi = array();
			for ($u=0; $u < $tabelKolomManajemen->num_rows() ; $u++) { 
				$tempMaxRi[] = $solusi[$t][$u];				
			}
			//print_r($tempMaxRi);exit;
			$Ri[] = max($tempMaxRi);
		}

		$data['matriksSi'] = $Si;
		$data['matriksRi'] = $Ri;

		$this->load->view($this->template, $data);
	}

	public function indeksVikor()
	{
		$data['page'] 		= 'page/indeksVikor_view';		
		$data['username'] 	= $this->session->userdata('username');
		$data['userId']		= $this->session->userdata('userId');
		$data['role']		= $this->session->userdata('role');

		$daftarAlternatif = $this->db->query('SELECT * FROM alternatif_karyawan');

		if ($data['role'] == '0') {
			$tabelKolomManajemen = $this->db->query('SELECT * FROM parameter');	
		}else{
			$tabelKolomManajemen = $this->db->query('SELECT * FROM kriteria WHERE kriteriaRole = '.$data['role']);
		}
		
		$data['daftarAlternatif'] 	 = $daftarAlternatif;
		$data['tabelKolomManajemen'] = $tabelKolomManajemen;

		//buat matriks alternatif dan kriteria
		$setMatriks = array();
		$a=0;
		foreach ($daftarAlternatif->result() as $baris) {
			$b=0;
			foreach ($tabelKolomManajemen->result() as $kolom) {
				$nilaiParameter = $this->db->query('SELECT * FROM nilai_parameter_alternatif WHERE npAltKaryawanId = '.$baris->altKaryawanId.' AND npParameterId = '.$kolom->parameterId)->row()->npNilai;
				$setMatriks[$a][$b] = $nilaiParameter;
				$b++;
			}
			$a++;
		}

		//nilai matriks di kuadratkan
		$matriksKuadrat = array();
		$c=0;
		foreach ($daftarAlternatif->result() as $baris) {
			$d=0;
			foreach ($tabelKolomManajemen->result() as $kolom) {
				$nilaiParameter = $this->db->query('SELECT * FROM nilai_parameter_alternatif WHERE npAltKaryawanId = '.$baris->altKaryawanId.' AND npParameterId = '.$kolom->parameterId)->row()->npNilai;
				$matriksKuadrat[$c][$d] = pow($nilaiParameter, 2);
				$d++;
			}
			$c++;
		}

		//hitung jumlah baris setelah di kuadratkan
		$jumlahBarisMatriks = array();
		$e=0;
		foreach ($daftarAlternatif->result() as $row) {
			$f=0;
			$jumlah = 0;
			foreach ($tabelKolomManajemen->result() as $column) {
				$jumlah = $jumlah + $matriksKuadrat[$e][$f];
				$f++;
			}

			$jumlahBarisMatriks[] = $jumlah;
			$e++;
		}

		//hitung hasil jumlah kuadrat di akarkan
		$akarMatriks = array();
		for ($g=0; $g < count($jumlahBarisMatriks) ; $g++) { 
			$akarMatriks[$g] = round(sqrt($jumlahBarisMatriks[$g]),3);
		}

		//matriks ternormalisasi
		$normalisasi = array();
		for ($h=0; $h < $daftarAlternatif->num_rows() ; $h++) { 
			for ($i=0; $i < $tabelKolomManajemen->num_rows() ; $i++) { 
				//$nilaiParameter = $this->db->query('SELECT * FROM nilai_kriteria_alternatif WHERE nkAltKaryawanId = '.$baris->altKaryawanId.' AND nkKriteriaId = '.$kolom->kriteriaId)->row()->nkNilai;
				$normalisasi[$h][$i] = round($setMatriks[$h][$i]/$akarMatriks[$h],3);  //round($nilaiParameter / $akarMatriks[$i],3);
			}
		}	

		//hitung matriks ternormalisasi dikalikan dengan hasil pembobotan user
		$nilaiBobot = array();
		$j=0;
		foreach ($daftarAlternatif->result() as $baris) {
			$k=0;
			foreach ($tabelKolomManajemen->result() as $kolom) {
				$nilaiParameter = $this->db->query('SELECT * FROM nilai_parameter_alternatif WHERE npAltKaryawanId = '.$baris->altKaryawanId.' AND npParameterId = '.$kolom->parameterId)->row()->npNilai;
				$bobot = $this->db->query('SELECT * FROM bobot_parameter WHERE bpUserId = '.$this->session->userdata('userId').' AND bpParameterId = '.$kolom->parameterId)->row()->bpNilai;
				//$nilaiBobot[$j][$k] = round($normalisasi[$j][$k] * $bobot,3);
				$nilaiBobot[$j][$k] = round($normalisasi[$j][$k] * $bobot , 3);
				$k++;
			}
			$j++;
		}

		//hitung jumlah nilai pembobotan alternatif;
		$jumlahNilaiBobot = array();
		$l=0;
		foreach ($daftarAlternatif->result() as $row) {
			$m=0;
			$jumlahs = 0;
			foreach ($tabelKolomManajemen->result() as $column) {
				$jumlahs = $jumlahs + $nilaiBobot[$l][$m];
				$m++;
			}

			$jumlahNilaiBobot[] = $jumlahs;
			$l++;
		}

		$fBintang = array();
		for ($n=0; $n < $tabelKolomManajemen->num_rows() ; $n++) { 			
			$tempMax = array();
			for ($o=0; $o < $daftarAlternatif->num_rows() ; $o++) { 
				$tempMax[] = $nilaiBobot[$o][$n];
			}

			$fBintang[] = max($tempMax);

		}
		
		$fMin = array();
		for ($p=0; $p < $tabelKolomManajemen->num_rows() ; $p++) { 
			$tempMin = array();
			for ($q=0; $q < $daftarAlternatif->num_rows() ; $q++) { 
				$tempMin[] = $nilaiBobot[$q][$p];
			}

			$fMin[] = min($tempMin);

		}

		$solusi = array();
		for ($r=0; $r < $daftarAlternatif->num_rows(); $r++) { 
			for ($s=0; $s < $tabelKolomManajemen->num_rows(); $s++) { 
				$solusi[$r][$s] = round($jumlahNilaiBobot[$r] * ( ($fBintang[$s]-$nilaiBobot[$r][$s]) / ($fBintang[$s] - $fMin[$s]) ) , 3 );
				//$solusi[$r][$s] = $jumlahNilaiBobot[$r]." * ".$fBintang[$s]." - ".$nilaiBobot[$r][$s]." / ".$fBintang[$s]." - ".$fMin[$s];
			}
		}

		$Si = array();
		for ($r=0; $r < $daftarAlternatif->num_rows(); $r++) { 
			$jumlahSi=0;
			for ($s=0; $s < $tabelKolomManajemen->num_rows(); $s++) { 
				$jumlahSi = $jumlahSi + $solusi[$r][$s];
			}
			$Si[] = $jumlahSi;
		}

		$Ri = array();
		for ($t=0; $t < $daftarAlternatif->num_rows() ; $t++) { 
			$tempMaxRi = array();
			for ($u=0; $u < $tabelKolomManajemen->num_rows() ; $u++) { 
				$tempMaxRi[] = $solusi[$t][$u];				
			}
			//print_r($tempMaxRi);exit;
			$Ri[] = max($tempMaxRi);
		}

		$SMin 		= max($Si);
		$SBintang 	= min($Si);
		$SSelisish	= $SMin - $SBintang;

		$RMin		= max($Ri);
		$RBintang	= min($Ri);
		$RSelisih	= $RMin - $RBintang;

		$SiSBintang = array();
		for ($v=0; $v < count($Si); $v++) { 
			$SiSBintang[] = $Si[$v] - $SBintang;
		}

		$RiRBintang = array();
		for ($w=0; $w < count($Ri) ; $w++) { 
			$RiRBintang[] = $Ri[$w] - $RBintang;
		}

		$indeksQ = array();
		for ($x=0; $x < $daftarAlternatif->num_rows(); $x++) { 
			$indeksQ[] = (0.5*($SiSBintang[$x]/$SSelisish))+((1-0.5)*($RiRBintang[$x]/$RSelisih));
		}

		$data['matriks'] = $indeksQ;

		$this->load->view($this->template, $data);
	}

}

?>