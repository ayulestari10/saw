<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
        $this->data['username'] = $this->session->userdata('username');
        if (!isset($this->data['username']))
        {
            $this->session->sess_destroy();
            redirect('login');
            exit;
        }

        $this->data['hak_akses'] = $this->session->userdata('hak_akses');
        if ($this->data['hak_akses'] != 'staff')
        {
            $this->session->sess_destroy();
            redirect('login');
            exit;   
        }
	}

	public function index()
	{

	}

	public function data_tanah()
    {
        $this->load->model('saw_m');
        $this->load->model('kriteria_m');
        $this->load->model('nilai_sifat_tanah_m');
        $this->load->model('sifat_kimia_tanah_m');
        $this->load->model('bobot_m');

        if ($this->POST('simpan'))
        {
            $this->sifat_kimia_tanah_m->insert([
                'kode_lab'      => $this->POST('kode_lab'),
                'kode_sampel'   => $this->POST('kode_sampel'),
                'nama_tanaman'  => $this->POST('nama_tanaman'),
                'tahun_tanaman' => $this->POST('tahun_tanaman')
            ]);

            $kode_lab = $this->POST('kode_lab');
            $label_id = $this->POST('label_id');
            $label_value = $this->POST('label_value');
            for ($i = 0; $i < count($label_value); $i++)
            {
                $id_kriteria = $label_id[$i];
                $nilai = $label_value[$i];
                $bobot = $this->bobot_m->get_row(['id_kriteria' => $id_kriteria, 'min_range <=' => $nilai, 'max_range >=' => $nilai]);
                if ($bobot)
                {
                    $this->nilai_sifat_tanah_m->insert([
                        'id_kriteria'   => $id_kriteria,
                        'id_bobot'      => $bobot->id_bobot,
                        'kode_lab'      => $kode_lab,
                        'nilai'         => $nilai
                    ]);
                }
            }

            $this->flashmsg('Data tanah berhasil disimpan');
            redirect('admin/data_tanah');
            exit;
        }

        if ($this->POST('get') && $this->POST('kode_lab'))
        {
            $tanah = $this->sifat_kimia_tanah_m->get_row(['kode_lab' => $this->POST('kode_lab')]);
            $tanah = (array)$tanah;
            $tanah['nilai'] = $this->nilai_sifat_tanah_m->get(['kode_lab' => $this->POST('kode_lab')]);
            $tanah['nilai'] = (array)$tanah['nilai'];
            echo json_encode($tanah);
            exit;
        }

        $this->data['tanah']        = $this->sifat_kimia_tanah_m->get();
        $arr = [];
        $i = 0;
        foreach ($this->data['tanah'] as $tanah)
        {
            $nilai = $this->nilai_sifat_tanah_m->get(['kode_lab' => $tanah->kode_lab]);
            $bobot = [];
            foreach ($nilai as $row)
            {
                $kriteria = $this->kriteria_m->get_row(['id_kriteria' => $row->id_kriteria]);
                $bobot[$kriteria->nama] = $row->nilai;
            }

            $arr[$i]['nilai']   = $bobot;
            $arr[$i++]['data']  = $tanah;            
        }

        $this->data['tanah']        = $arr;
        $this->data['kriteria']     = $this->kriteria_m->get();
        $this->data['title']        = 'Data Tanah Lab FP Kecil';
        $this->data['content']      = 'pegawai/data_tanah';
        $this->template($this->data, 'pegawai');
    }
}
