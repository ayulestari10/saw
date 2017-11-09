<?php 

class Saw_m extends MY_Model 
{
	public function __construct()
	{
		parent::__construct();
		$this->data['table_name']	= 'nilai_sifat_tanah';
		$this->data['primary_key']	= 'id_nilai';
	}

	public function defuzzification($data)
	{
		$this->load->model('bobot_m');
		$this->load->model('kriteria_m');

		$hasil = 0;
		foreach ($data as $row)
		{
			$nilai = $this->bobot_m->get_row(['id_bobot' => $row->id_bobot])->nilai;
			$bobot = $this->kriteria_m->get_row(['id_kriteria' => $row->id_kriteria])->bobot;
			$hasil += $this->crisping($row->id_kriteria, $nilai) * $bobot;
		}

		return $hasil;
	}

	public function crisping($id_kriteria, $bobot)
	{
		return $bobot / $this->get_threshold($id_kriteria)->nilai_max;
	}

	public function get_nilai($cond = '')
	{
		if (is_array($cond) or (is_string($cond) && strlen($cond) > 3))
			$this->db->where($cond);
		$this->db->select(['id_penilaian', 'id_bobot', 'id_kriteria', 'kode_lab', 'fuzzy', 'nilai']);
		$this->db->from($this->data['table_name']);
		$this->db->join('bobot', $this->data['table_name'] . '.id_bobot = bobot.id_bobot');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_threshold($id_kriteria, $type = 'MAX')
	{
		$this->db->select([$type . '(nilai) AS nilai_' . strtolower($type)]);
		$this->db->from($this->data['table_name']);
		$this->db->join('bobot', $this->data['table_name'] . '.id_bobot = bobot.id_bobot');
		$this->db->where([$this->data['table_name'] . '.id_kriteria' => $id_kriteria]);
		$query = $this->db->get();
		return $query->row();
	}

	public function sort_desc()
	{
		$this->load->model('sifat_kimia_tanah_m');
		$this->load->model('nilai_sifat_tanah_m');
		$tanah = $this->sifat_kimia_tanah_m->get();
		$sifat_tanah = [];
		foreach ($tanah as $row)
		{

		}
	}
}