<?php

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_transaksi', 'm_transaksi');
        $this->load->model('M_laporan', 'm_laporan');
        $this->load->model('Tgl_indo');
        $this->data['aktif'] = 'laporan';
    }

    public function index()
    {
        $this->data['title'] = 'Pendapatan';
        $this->data['all_laporan_transaksi'] = $this->m_laporan->get_all_laporan();
        $this->data['pendapatan'] = $this->m_laporan->pendapatan();

        $this->load->view('laporan/pendapatan', $this->data);
    }
}
