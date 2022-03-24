<?php

use Dompdf\Dompdf;

class Pegawai extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('role_id') != 1) redirect();
        $this->data['aktif'] = 'pegawai';
        $this->load->library('form_validation');
        $this->load->model('M_pegawai', 'm_pegawai');
    }

    public function index()
    {
        $this->data['title'] = 'Managemen Pegawai';
        $this->data['all_pegawai'] = $this->m_pegawai->lihat();
        $this->load->view('pegawai/index', $this->data);
    }

    public function tambah()
    {

        //rules
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim', [
            'required' => 'Field ini harus diisi!'
        ]);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'required' => 'Field Email Harus Diisi!',
            'valid_email' => 'Email Harus Valid!',
            'is_unique' => 'Email ini sudah terdaftar!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]', [
            'required' => 'Field Password Harus Diisi!',
            'min_length' => 'Pasword Harus Lebih 3 Karakter Atau Lebih!',
        ]);

        if ($this->form_validation->run() == false) {
            $this->data['title'] = 'Tambah Pegawai';
            $this->load->view('pegawai/tambah', $this->data);
        } else {
            $data = [
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'password' => htmlspecialchars($this->input->post('password', true)),
                'role_id' => $this->input->post('role', true),
                'is_active' => $this->input->post('status', true),
                'date_created' => time()
            ];

            if ($this->m_pegawai->tambah($data)) {
                $this->session->set_flashdata('success', 'Data Pegawai <strong>Berhasil</strong> Ditambahkan!');
                redirect('pegawai');
            } else {
                $this->session->set_flashdata('error', 'Data Pegawai <strong>Gagal</strong> Ditambahkan!');
                redirect('pegawai');
            }
        }
    }

    public function ubah($id)
    {

        //rules
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim', [
            'required' => 'Field ini harus diisi!'
        ]);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email', [
            'required' => 'Field Email Harus Diisi!',
            'valid_email' => 'Email Harus Valid!',
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]', [
            'required' => 'Field Nama Harus Diisi!',
            'min_length' => 'Pasword Harus Lebih 3 Karakter Atau Lebih!',
        ]);

        $this->data['title'] = 'Ubah Pegawai';
        $this->data['pegawai'] = $this->m_pegawai->lihat_id($id);

        if ($this->form_validation->run() == false) {
            $this->load->view('pegawai/ubah', $this->data);
        } else {
            $data = [
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'password' => htmlspecialchars($this->input->post('password', true)),
                'role_id' => $this->input->post('role', true),
                'is_active' => $this->input->post('status', true)
            ];

            if ($this->m_pegawai->ubah($data, $id)) {
                $this->session->set_flashdata('success', 'Data Pegawai <strong>Berhasil</strong> Diubah!');
                redirect('pegawai');
            } else {
                $this->session->set_flashdata('error', 'Data Pegawai <strong>Gagal</strong> Diubah!');
                redirect('pegawai');
            }
        }
    }

    public function hapus($id)
    {
        if ($this->m_pegawai->hapus($id)) {
            $this->session->set_flashdata('success', 'Data Pegawai <strong>Berhasil</strong> Dihapus!');
            redirect('pegawai');
        } else {
            $this->session->set_flashdata('error', 'Data Pegawai <strong>Gagal</strong> Dihapus!');
            redirect('pegawai');
        }
    }
}
