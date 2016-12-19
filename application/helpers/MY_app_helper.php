<?php

	function cekNilaiKriteria($id)
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('nilai_kriteria_alternatif');
		$CI->db->where('nkAltKaryawanId',$id);
		$result = $CI->db->get();

		if ($result->num_rows() > 0) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function cekNilaiParameter($id)
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('nilai_parameter_alternatif');
		$CI->db->where('npAltKaryawanId',$id);
		$result = $CI->db->get();

		if ($result->num_rows() > 0) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function getKriteria($id,$field)
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('kriteria');
		$CI->db->where('kriteriaId',$id);
		$result = $CI->db->get();

		if ($result->num_rows() > 0) {
			return $result->row()->$field;
		}else{
			return FALSE;
		}
	}

	function getSubKriteria($id,$ids,$field)
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('parameter');
		$CI->db->where('parameterId',$id);
		$CI->db->where('parameterKriteriaId',$ids);
		$result = $CI->db->get();

		if ($result->num_rows() > 0) {
			return $result->row()->$field;
		}else{
			return FALSE;
		}
	}

	function getRolePengguna($idRole)
	{
		switch ($idRole) {
			case '0':
				echo 'Admin';
				break;
			
			case '1':
				echo 'Direktur';
				break;

			case '2':
				echo 'Asisten Direktur';
				break;

			case '3':
				echo 'Kepala Biro';
				break;
		}
	}

	function getUser($id,$field)
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('pengguna');
		$CI->db->where('userId',$id);
		$result = $CI->db->get();

		if ($result->num_rows() > 0) {
			return $result->row()->$field;
		}else{
			return FALSE;
		}
	}

?>