<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('form_validation');
    }

    public function index()
    {
        //rules
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email', [
            'required' => 'Field Email Harus Diisi!',
            'valid_email' => 'Email Harus Valid!'
        ]);

        $this->form_validation->set_rules('password', 'Password', 'required|trim', [
            'required' => 'Field Password Harus Diisi!'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('login');
        } else {
            // validasi success
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->db->get_where('user', ['email' => $email])->row_array();

            // jika usernya ada
            if ($user) {
                // jika usernya aktif
                if ($user['is_active'] == 'aktif') {
                    // cek passwordnya
                    if ($password == $user['password']) {
                        $data = [
                            'email' => $user['email'],
                            'role_id' => $user['role_id'], //$user['role_id'],
                            'nama' => $user['nama'],
                            'iduser' => $user['id'],
                            'jam_masuk' => date('H:i:s')
                        ];
                        $this->session->set_userdata($data);
                        $this->session->set_flashdata('success', '<strong>Login</strong> Berhasil!');
                        redirect('dashboard');
                    } else {
                        $this->session->set_flashdata('error', 'Password Salah!');
                        redirect('auth');
                    }
                } else {
                    $this->session->set_flashdata('message', '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Email belum teraktivasi!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    ');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Email belum terdaftar!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                ');
                redirect('auth');
            }
        }
    }

    public function registration()
    {
        //rules
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim', [
            'required' => 'Field Nama Harus Diisi!'
        ]);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'required' => 'Field Email Harus Diisi!',
            'valid_email' => 'Email Harus Valid!',
            'is_unique' => 'Email ini sudah terdaftar!'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[8]|matches[password2]', [
            'required' => 'Field Nama Harus Diisi!',
            'min_length' => 'Pasword Harus Lebih 8 Karakter Atau Lebih!',
            'matches' => 'Password Tidak Sama!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Buat Akun - Book.U';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            $data = [
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'gambar' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 1,
                'date_created' => time()
            ];

            $this->db->insert('user', $data);
            $this->session->set_flashdata('message', '
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                      Anda berhasil membuat akun. Sliahkan login!
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
            ');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('nama');
        $this->session->unset_userdata('jam_masuk');

        $this->session->set_flashdata('success', 'Anda berhasil logout!');
        redirect('auth');
    }
}
