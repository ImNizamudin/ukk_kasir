<?php
class Aktivitas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('M_log', 'm_log');
        $this->load->model('Tgl_indo');
        $this->load->library('upload');
        $this->data['aktif'] = 'Aktivitas';
    }

    public function index()
    {
        $this->data['title'] = 'Aktivitas';
        $this->data['all_aktivitas'] = $this->m_log->get_all_log();

        $this->load->view('aktivitas/index', $this->data);
    }
}
