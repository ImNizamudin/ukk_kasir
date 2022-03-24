<?php

class Transaksi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_transaksi', 'm_transaksi');
        $this->load->model('M_pegawai', 'm_pegawai');
        $this->load->model('M_laporan', 'm_laporan');
        $this->load->model('Tgl_indo');
        $this->data['aktif'] = 'transaksi';
    }

    public function index()
    {

        date_default_timezone_set("Asia/Jakarta");
        $tglHariIni = date('Y-m-d');

        $this->data['tglHariIni'] = $tglHariIni;

        $aktif = 'transaksi';
        $title = 'Pesan';

        $tgl1 = $this->input->post('tgl1');
        $tgl2 = $this->input->post('tgl2');
        $id_pegawai = $this->input->post('pegawai');

        if ($tgl1 && $tgl2) {
            $transaksi = $this->m_transaksi->searchByTgl($tgl1, $tgl2);
            if ($id_pegawai) {
                $transaksi = $this->m_transaksi->searchById($id_pegawai);
            }
        } else {
            $transaksi = $this->m_transaksi->get_all_transaksi();
            if ($id_pegawai) {
                $transaksi = $this->m_transaksi->searchById($id_pegawai);
            }
        }

        $pegawai = $this->m_pegawai->lihatKasir();

        $this->data = [
            'result_transaksi' => $transaksi,
            'result_pegawai' => $pegawai,
            'aktif' => $aktif,
            'title' => $title
        ];

        $this->load->view('transaksi/index', $this->data);
    }

    public function detail($nofak_jual)
    {
        $this->data['title'] = 'Detail Pesanan';
        $this->data['pesanan'] = $this->m_transaksi->get_details($nofak_jual);
        $this->data['detail_pesanan'] = $this->m_transaksi->get_menu_details($nofak_jual);

        $this->load->view('transaksi/transaksi_detail', $this->data);
    }
}
