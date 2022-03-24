<?php

use Dompdf\Dompdf;

class Barang extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('role_id') != 1 &&  $this->session->userdata('role_id') != 2 && $this->session->userdata('role_id') != 3) redirect();
		$this->data['aktif'] = 'barang';
		$this->load->library('form_validation');
		$this->load->model('M_barang', 'm_barang');
	}

	public function index()
	{
		$this->data['title'] = 'Data Menu';
		$this->data['all_menu'] = $this->m_barang->lihat();
		$this->data['no'] = 1;

		$this->load->view('barang/lihat', $this->data);
	}

	public function tambah()
	{
		if ($this->session->userdata('role_id') == 3) {
			$this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
			redirect('penjualan');
		}

		$this->data['title'] = 'Tambah Menu';

		$this->load->view('barang/tambah', $this->data);
	}

	public function proses_tambah()
	{
		// if ($this->session->login['role'] == 'kasir') {
		// 	$this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
		// 	redirect('penjualan');
		// }

		// rules
		$this->form_validation->set_rules('kode_menu', 'Kode Menu', 'required|trim|exact_length[6]|is_unique[data_menu.kode_menu]|integer', [
			'required' => 'Field Kode Menu Harus Diisi!',
			'min_length' => 'Pasword Harus 6 Digit Angka!',
			'is_unique' => 'Kode menu ini sudah terdaftar!',
			'integer' => 'Kode menu harus berupa 6 digit angka'
		]);
		$this->form_validation->set_rules('nama_menu', 'Nama Menu', 'required|trim', [
			'required' => 'Field Nama Menu Harus Diisi!',
		]);
		$this->form_validation->set_rules('satuan', 'Satuan', 'required|trim', [
			'required' => 'Field Satuan Menu Harus Diisi!',
		]);
		$this->form_validation->set_rules('harga', 'Harga Menu', 'required|trim', [
			'required' => 'Field Harga Menu Harus Diisi!',
		]);

		if ($this->form_validation->run() == false) {
			$this->data['title'] = 'Tambah Menu';
			$this->load->view('barang/tambah', $this->data);
		} else {
			$data = [
				'kode_menu' => $this->input->post('kode_menu'),
				'nama_menu' => $this->input->post('nama_menu'),
				'satuan' => $this->input->post('satuan'),
				'harga_menu' => $this->input->post('harga'),
			];

			if ($this->m_barang->tambah($data)) {
				$this->session->set_flashdata('success', 'Menu <strong>Berhasil</strong> Ditambahkan!');
				redirect('barang');
			} else {
				$this->session->set_flashdata('error', 'Menu <strong>Gagal</strong> Ditambahkan!');
				redirect('barang');
			}
		}
	}

	public function ubah($kode_menu)
	{
		// if ($this->session->login['role'] == 'kasir') {
		// 	$this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
		// 	redirect('penjualan');
		// }

		$this->data['title'] = 'Ubah Menu';
		$this->data['menu'] = $this->m_barang->lihat_id($kode_menu);

		$this->load->view('barang/ubah', $this->data);
	}

	public function proses_ubah($kode_menu)
	{
		// if ($this->session->login['role'] == 'kasir') {
		// 	$this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
		// 	redirect('penjualan');
		// }

		// rules
		$this->form_validation->set_rules('kode_menu', 'Kode Menu', 'required|trim|exact_length[6]|integer', [
			'required' => 'Field Kode Menu Harus Diisi!',
			'min_length' => 'Pasword Harus 6 Digit Angka!',
			'integer' => 'Kode menu harus berupa 6 digit angka'
		]);
		$this->form_validation->set_rules('nama_menu', 'Nama Menu', 'required|trim', [
			'required' => 'Field Nama Menu Harus Diisi!',
		]);
		$this->form_validation->set_rules('satuan', 'Satuan', 'required|trim', [
			'required' => 'Field Satuan Menu Harus Diisi!',
		]);
		$this->form_validation->set_rules('harga', 'Harga Menu', 'required|trim', [
			'required' => 'Field Harga Menu Harus Diisi!',
		]);

		if ($this->form_validation->run() == false) {
			$this->data['title'] = 'Tambah Menu';
			$this->load->view('barang/tambah', $this->data);
		} else {

			$data = [
				'kode_menu' => $this->input->post('kode_menu'),
				'nama_menu' => $this->input->post('nama_menu'),
				'satuan' => $this->input->post('satuan'),
				'harga_menu' => $this->input->post('harga'),
			];

			if ($this->m_barang->ubah($data, $kode_menu)) {
				$this->session->set_flashdata('success', 'Menu <strong>Berhasil</strong> Diubah!');
				redirect('barang');
			} else {
				$this->session->set_flashdata('error', 'Menu <strong>Gagal</strong> Diubah!');
				redirect('barang');
			}
		}
	}

	public function hapus($kode_menu)
	{
		// if ($this->session->login['role'] == 'kasir') {
		// 	$this->session->set_flashdata('error', 'Hapus data hanya untuk admin!');
		// 	redirect('penjualan');
		// }

		if ($this->m_barang->hapus($kode_menu)) {
			$this->session->set_flashdata('success', 'Menu <strong>Berhasil</strong> Dihapus!');
			redirect('barang');
		} else {
			$this->session->set_flashdata('error', 'Menu <strong>Gagal</strong> Dihapus!');
			redirect('barang');
		}
	}

	// public function export()
	// {
	// 	$dompdf = new Dompdf();
	// 	// $this->data['perusahaan'] = $this->m_usaha->lihat();
	// 	$this->data['all_barang'] = $this->m_barang->lihat();
	// 	$this->data['title'] = 'Laporan Data Barang';
	// 	$this->data['no'] = 1;

	// 	$dompdf->setPaper('A4', 'Landscape');
	// 	$html = $this->load->view('barang/report', $this->data, true);
	// 	$dompdf->load_html($html);
	// 	$dompdf->render();
	// 	$dompdf->stream('Laporan Data Barang Tanggal ' . date('d F Y'), array("Attachment" => false));
	// }
}
