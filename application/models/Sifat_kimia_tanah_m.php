<?php 

class Sifat_kimia_tanah_m extends MY_Model 
{
	public function __construct()
	{
		parent::__construct();
		$this->data['table_name']	= 'sifat_kimia_tanah';
		$this->data['primary_key']	= 'kode_lab';
	}

	public function get_year(){
		$query = $this->db->query('SELECT DISTINCT year(create_at) FROM '. $this->data['table_name'] . ' ORDER BY year(create_at) ASC');
		// echo "<pre>";
		// var_dump($query->result());exit;
		// echo "</pre>";
		return $query->result();
	}
}