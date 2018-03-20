<?php 

class Kepala_bagian extends MY_Controller
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
        if ($this->data['hak_akses'] != 'kabagian')
        {
            $this->session->sess_destroy();
            redirect('login');
            exit;   
        }
    }

    public function index()
    {
        $this->data['title']        = 'Dashboard Kepala Bagian' . $this->title;
        $this->data['content']      = 'kepala-bagian/dashboard';
        $this->template($this->data, 'kepala-bagian');
    }

    // public function kriteria()
    // {
    //     $this->load->model('kriteria_m');

    //     if ($this->POST('simpan'))
    //     {
    //     	$this->kriteria_m->insert([
    //     		'nama'	=> $this->POST('nama'),
    //     		'bobot'	=> $this->POST('bobot'),
    //     		'nilai'	=> $this->POST('nilai')
    //     	]);

    //     	$this->flashmsg('<i class="fa fa-success"></i> Data berhasil disimpan');
    //     	redirect('kepala-bagian/kriteria');
    //     	exit;
    //     }

    //     if ($this->POST('get') && $this->POST('id_kriteria'))
    //     {
    //     	$this->data['kriteria'] = $this->kriteria_m->get_row(['id_kriteria' => $this->POST('id_kriteria')]);
    //     	echo json_encode($this->data['kriteria']);
    //     	exit;
    //     }

    //     if ($this->POST('delete') && $this->POST('id_kriteria'))
    //     {
    //     	$this->kriteria_m->delete($this->POST('id_kriteria'));
    //     	$this->flashmsg('<i class="fa fa-success"></i> Data berhasil dihapus');
    //     	redirect('kepala-bagian/kriteria');
    //     	exit;
    //     }

    //     if ($this->POST('edit') && $this->POST('id_kriteria'))
    //     {
    //     	$this->kriteria_m->update($this->POST('id_kriteria'), [
    //     		'nama'	=> $this->POST('nama'),
    //     		'bobot'	=> $this->POST('bobot'),
    //     		'nilai'	=> $this->POST('nilai')
    //     	]);

    //     	$this->flashmsg('<i class="fa fa-success"></i> Data berhasil di-edit');
    //     	redirect('kepala-bagian/kriteria');
    //     	exit;
    //     }

    //     $this->data['kriteria'] = $this->kriteria_m->get();
    //     $this->data['title']    = 'Kriteria' . $this->title;
    //     $this->data['content']  = 'kepala-bagian/kriteria';
    //     $this->template($this->data, 'kepala-bagian');
    // }

    // public function data_tanah()
    // {
    //     $this->load->model('saw_m');
    //     $this->load->model('kriteria_m');
    //     $this->load->model('nilai_sifat_tanah_m');
    //     $this->load->model('sifat_kimia_tanah_m');
    //     $this->load->model('bobot_m');

    //     if ($this->POST('simpan'))
    //     {
    //         $this->sifat_kimia_tanah_m->insert([
    //             'kode_lab'      => $this->POST('kode_lab'),
    //             'kode_sampel'   => $this->POST('nama_tanaman') . '(' . $this->POST('tahun_tanaman') . ')',
    //             'nama_tanaman'  => $this->POST('nama_tanaman'),
    //             'tahun_tanaman' => $this->POST('tahun_tanaman')
    //         ]);

    //         $kode_lab = $this->POST('kode_lab');
    //         $label_id = $this->POST('label_id');
    //         $label_value = $this->POST('label_value');
    //         for ($i = 0; $i < count($label_value); $i++)
    //         {
    //             $id_kriteria = $label_id[$i];
    //             $nilai = $label_value[$i];
    //             $bobot = $this->bobot_m->get_row(['id_kriteria' => $id_kriteria, 'min_range <=' => $nilai, 'max_range >=' => $nilai]);
    //             if ($bobot)
    //             {
    //                 $this->nilai_sifat_tanah_m->insert([
    //                     'id_kriteria'   => $id_kriteria,
    //                     'id_bobot'      => $bobot->id_bobot,
    //                     'kode_lab'      => $kode_lab,
    //                     'nilai'         => $nilai
    //                 ]);
    //             }
    //         }

    //         $this->flashmsg('Data tanah berhasil disimpan');
    //         redirect('kepala-bagian/data_tanah');
    //         exit;
    //     }

    //     if ($this->POST('edit'))
    //     {
    //         $this->sifat_kimia_tanah_m->update($this->POST('kode_lab'), [
    //             'kode_lab'      => $this->POST('edit_kode_lab'),
    //             'kode_sampel'   => $this->POST('edit_nama_tanaman') . '(' . $this->POST('edit_tahun_tanaman') . ')',
    //             'nama_tanaman'  => $this->POST('edit_nama_tanaman'),
    //             'tahun_tanaman' => $this->POST('edit_tahun_tanaman')
    //         ]);   

    //         $kode_lab = $this->POST('kode_lab');
    //         $label_id = $this->POST('label_id');
    //         $label_value = $this->POST('label_value');
    //         for ($i = 0; $i < count($label_value); $i++)
    //         {
    //             $id_kriteria = $label_id[$i];
    //             $nilai = $label_value[$i];
    //             $bobot = $this->bobot_m->get_row(['id_kriteria' => $id_kriteria, 'min_range <=' => $nilai, 'max_range >=' => $nilai]);
    //             if ($bobot)
    //             {
    //                 $this->nilai_sifat_tanah_m->update_where([
    //                     'id_kriteria'   => $id_kriteria,
    //                     'kode_lab'      => $this->POST('kode_lab')
    //                 ], [
    //                     'id_bobot'      => $bobot->id_bobot,
    //                     'nilai'         => $nilai
    //                 ]);
    //             }
    //         }

    //         $this->nilai_sifat_tanah_m->update_where(['kode_lab' => $this->POST('kode_lab')], [
    //             'kode_lab'  => $this->POST('edit_kode_lab')
    //         ]);

    //         $this->flashmsg('Data tanah berhasil di-edit');
    //         redirect('kepala-bagian/data-tanah');
    //         exit;
    //     }

    //     if ($this->POST('get') && $this->POST('kode_lab'))
    //     {
    //         $tanah = $this->sifat_kimia_tanah_m->get_row(['kode_lab' => $this->POST('kode_lab')]);
    //         $tanah = (array)$tanah;
    //         $tanah['nilai'] = $this->nilai_sifat_tanah_m->get(['kode_lab' => $this->POST('kode_lab')]);
    //         $tanah['nilai'] = (array)$tanah['nilai'];
    //         echo json_encode($tanah);
    //         exit;
    //     }

    //     if ($this->POST('delete') && $this->POST('kode_lab'))
    //     {
    //         $this->sifat_kimia_tanah_m->delete($this->POST('kode_lab'));
    //         $this->flashmsg('<i class="fa fa-success"></i> Data berhasil dihapus');
    //         redirect('kepala-bagian/data-tanah');
    //         exit;
    //     }

    //     $this->data['tanah']        = $this->sifat_kimia_tanah_m->get();
    //     $arr = [];
    //     $i = 0;
    //     foreach ($this->data['tanah'] as $tanah)
    //     {
    //         $nilai = $this->nilai_sifat_tanah_m->get(['kode_lab' => $tanah->kode_lab]);
    //         $bobot = [];
    //         foreach ($nilai as $row)
    //         {
    //             $kriteria = $this->kriteria_m->get_row(['id_kriteria' => $row->id_kriteria]);
    //             $bobot[$kriteria->nama] = $row->nilai;
    //         }

    //         $arr[$i]['nilai']   = $bobot;
    //         $arr[$i++]['data']  = $tanah;            
    //     }

    //     $this->data['tanah']        = $arr;
    //     $this->data['kriteria']     = $this->kriteria_m->get();
    //     $this->data['title']        = 'Data Tanah' . $this->title;
    //     $this->data['content']      = 'kepala-bagian/data_tanah';
    //     $this->template($this->data, 'kepala-bagian');
    // }

    // public function data_bobot()
    // {
    //     $this->load->model('bobot_m');
    //     $this->load->model('kriteria_m');

    //     if ($this->POST('simpan'))
    //     {
    //         $this->bobot_m->insert([
    //             'fuzzy'         => $this->POST('fuzzy'),
    //             'id_kriteria'   => $this->POST('id_kriteria'),
    //             'min_range'     => $this->POST('min_range'),
    //             'max_range'     => $this->POST('max_range')
    //         ]);

    //         $this->flashmsg('<i class="fa fa-success"></i> Data berhasil disimpan');
    //         redirect('kepala-bagian/data-bobot');
    //         exit;
    //     }

    //     if ($this->POST('get') && $this->POST('id_bobot'))
    //     {
    //         $this->data['bobot'] = $this->bobot_m->get_row(['id_bobot' => $this->POST('id_bobot')]);
    //         $kriteria_opt = [];
    //         $this->data['kriteria'] = $this->kriteria_m->get();
    //         foreach ($this->data['kriteria'] as $kriteria) $kriteria_opt[$kriteria->id_kriteria] = $kriteria->nama;
    //         $this->data['bobot']->dropdown = form_dropdown('id_kriteria', $kriteria_opt, $this->data['bobot']->id_kriteria, ['class' => 'form-control', 'id' => 'id_kriteria']);
    //         echo json_encode($this->data['bobot']);
    //         exit;
    //     }

    //     if ($this->POST('delete') && $this->POST('id_bobot'))
    //     {
    //         $this->bobot_m->delete($this->POST('id_bobot'));
    //         $this->flashmsg('<i class="fa fa-success"></i> Data berhasil dihapus');
    //         redirect('kepala-bagian/data-bobot');
    //         exit;
    //     }

    //     if ($this->POST('edit') && $this->POST('id_bobot'))
    //     {
    //         $this->bobot_m->update($this->POST('id_bobot'), [
    //             'fuzzy'         => $this->POST('fuzzy'),
    //             'id_kriteria'   => $this->POST('id_kriteria'),
    //             'min_range'     => $this->POST('min_range'),
    //             'max_range'     => $this->POST('max_range')
    //         ]);

    //         $this->flashmsg('<i class="fa fa-success"></i> Data berhasil di-edit');
    //         redirect('kepala-bagian/data-bobot');
    //         exit;
    //     }

    //     $this->data['kriteria']     = $this->kriteria_m->get();
    //     $this->data['bobot']        = $this->bobot_m->get_bobot();
    //     $this->data['title']        = 'Data Bobot | ' . $this->title;
    //     $this->data['content']      = 'kepala-bagian/bobot';
    //     $this->template($this->data, 'kepala-bagian');
    // }

    public function hasil()
    {
        $this->load->model('saw_m');

        if ($this->POST('ubah') && $this->POST('tahun')) {
            $this->data['hasil']    = $this->saw_m->sort_desc(['year(create_at)' => $this->POST('tahun')]);
            echo json_encode($this->data['hasil']);
            exit;

        } else {
            $this->data['hasil']    = $this->saw_m->sort_desc(['year(create_at)' => date('Y')]);
        }

       
        $this->data['title']    = 'Hasil Perhitungan';
        $this->data['tahun']    = $this->sifat_kimia_tanah_m->get_year();
        $this->data['content']  = 'kepala-bagian/hasil';
        $this->template($this->data, 'kepala-bagian');
    }

    public function cara_perhitungan()
    {
        $this->data['title']    = 'Cara Perhitungan';
        $this->data['content']  = 'kepala-bagian/cara_perhitungan';
        $this->template($this->data, 'kepala-bagian');
    }

    public function laporan_cara_perhitungan()
    {
        $this->load->model('saw_m');
        $this->data['hasil']    = $this->saw_m->sort_desc();
        $html = $this->load->view('admin/laporan', $this->data, true);
        $pdfFilePath = 'Laporan Detail Perhitungan - ' . date('Y-m-d') . '.pdf';
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");   
        $this->load->view('admin/laporan', $this->data);

        
        // $this->data['title']    = 'Laporan';
        // $this->load->view('admin/laporan', $this->data);
    }
}