
<?php

class Pesan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['aktif'] = 'pesan';
        $this->load->model('M_transaksi', 'm_transaksi');
        $this->load->model('M_barang', 'm_barang');
        $this->load->model('M_laporan', 'm_laporan');
        $this->load->model('Tgl_indo');
        $this->load->library('form_validation');
        $this->load->library('cart');
    }

    public function index()
    {
        date_default_timezone_set("Asia/Jakarta");
        $tglHariIni = date('Y-m-d');

        $this->data['title'] = 'Order';
        $this->data['tglHariIni'] = $tglHariIni;
        $this->data['all_menu'] = $this->m_barang->lihat();

        $this->load->view('pesan/tambah_pesanan', $this->data);
    }

    function simpan_transaksi()
    {
        date_default_timezone_set("Asia/Jakarta");
        $tglHariIni = date('Y-m-d');

        $jumlah_item  = $this->input->post('qty');
        $kode_menu    = $this->input->post('kode_menu');
        $data = $this->db->get_where('tbl_menu', ['kode_menu' => $kode_menu])->row_array();
        $harga_jual = $data['hrg_jual'];

        $total_harga = $jumlah_item * $harga_jual;

        $a = $this->db->query("SELECT id_master_jual FROM tbl_master_jual ORDER BY id_master_jual DESC")->row_array();
        if ($a) {
            $nofak = $a['id_master_jual'];
            if ($nofak < 10) {
                $nofak = "000000" . $nofak;
            } else if ($nofak < 100) {
                $nofak = "00000" . $nofak;
            } else if ($nofak < 1000) {
                $nofak = "0000" . $nofak;
            } else if ($nofak < 10000) {
                $nofak = "000" . $nofak;
            } else if ($nofak < 100000) {
                $nofak = "00" . $nofak;
            } else if ($nofak < 100000) {
                $nofak = "0" . $nofak;
            }
        } else {
            $nofak = "0000001";
        }
        $no_faktur  = $this->input->post('no_faktur');
        if ($no_faktur == "") {
            echo  $nofak1 = $tglHariIni . $nofak;
            $data = array(
                'nofak_jual' => $nofak1,
                'tgl_jual' => $this->input->post('tgl_jual'),
                'total_harga' => $total_harga,
                'no_meja' => $this->input->post('no_meja'),
                'pengguna_id' => $this->session->userdata('idadmin')
            );
            $this->db->insert('tbl_master_jual', $data);
        } else {
            echo  $nofak1 = $no_faktur;

            $h = $this->db->get_where('tbl_master_jual', ['nofak_jual' => $no_faktur])->row_array();
            $ttl_harga = $h['total_harga'] + $total_harga;

            $data = array(
                'total_harga' => $ttl_harga
            );
            $this->db->where('nofak_jual', $no_faktur);
            $this->db->update('tbl_master_jual', $data);
        }
        $data = array(
            'nofak_jual' => $nofak1,
            'kode_menu' => $kode_menu,
            'jumlah_item' => $jumlah_item,
            'harga_jual' => $harga_jual
        );
        $this->db->insert('tbl_det_jual', $data);
    }

    function transaksi_hitung()
    {
        $nofak_jual = $this->input->post('nofak_jual');
        $h = $this->db->get_where('tbl_master_jual', ['nofak_jual' => $nofak_jual])->row_array();
        echo number_format($h['total_harga']);
    }

    function transaksi_hapus()
    {
        $id   = $this->input->post('id');
        $nofak = $this->input->post('nofak');

        $h1 = $this->db->get_where('tbl_master_jual', ['nofak_jual' => $nofak])->row_array();
        $total_harga1 = $h1['total_harga'];

        $h2 = $this->db->get_where('tbl_det_jual', ['id_det_jual' => $id])->row_array();
        $jumlah_item  = $h2['jumlah_item'];
        $harga_jual   = $h2['harga_jual'];

        $total_harga2 = $jumlah_item * $harga_jual;
        $total_harga  = $total_harga1 - $total_harga2;

        $this->db->where('id_det_jual', $id);
        $this->db->delete('tbl_det_jual');

        $h3 = $this->db->get_where('tbl_det_jual', ['nofak_jual' => $nofak])->num_rows();
        if ($h3 > 0) {
            $this->db->set('total_harga', $total_harga);
            $this->db->where('nofak_jual', $nofak);
            $this->db->update('tbl_master_jual');
        } else {
            $this->db->where('nofak_jual', $nofak);
            $this->db->delete('tbl_master_jual');
        }
    }

    function cetak_transaksi()
    {
        $akses = $this->session->userdata('akses');
        $pengguna_id = $this->input->post('pengguna_id');
        $x['data'] = $this->m_transaksi->get_laporan_transaksi($pengguna_id, $akses);
        $this->load->view('admin/vcetak_transaksi', $x);
    }

    function simpan_transaksi_bayar()
    {
        $no_faktur  = $this->input->post('no_faktur');
        $total_bayar = str_replace(',', '', $this->input->post('total_bayar'));

        $x['data'] = $this->m_transaksi->simpan_transaksi_bayar($no_faktur, $total_bayar);
        $this->load->view('pesan/vcetak_struk', $x);
    }

    // public function pesanan()
    // {
    //     $data = array(
    //         "kode_menu" => $_POST["kode_menu"],
    //         "nama_menu" => $_POST["nama_menu"],
    //         "harga_menu" => $_POST["harga_menu"],
    //     );

    //     echo json_encode($data);

    //     $this->cart->insert($data); //return rowid
    //     foreach ($this->cart->contents() as $items) {
    //         echo '
    //         <tr>
    //         <td>' . $items["kode_menu"] . '</td>
    //         <td>' . $items["nama_menu"] . '</td>
    //         <td>' . $items["harga_menu"] . '</td>
    //         <td>' . $items["qty"] . '</td>
    //         <td>' . $items["rowid"] . '</td>
    //         <td>' . $items["subtotal"] . '</td>
    //     </tr>
    //         ';
    //     }
    //     //echo $this->view();
    // }

    // public function view()
    // {
    //     $output = '';
    //     $output .= '
    //         <table>

    //     ';

    //     $count = 0;
    //     foreach ($this->cart->contents() as $items) {
    //         $count++;
    //         $output .= '
    //             <tr>
    //                 <td>
    //                     <p class="mr-2">' . $items["nama_menu"] . '</p>
    //                 </td>
    //                 <td>
    //                     <ul class="pagination">
    //                         <li class="page-item"><button class="page-link" onclick="handleQtyMin("itemval")"><i class="fas fa-minus"></i></li>
    //                         <li class="page-item"><input type="text" class="qty" id="qtyy" name="qty" value="' . $items["qty"] . '"></li>
    //                         <li class="page-item"><button class="page-link" onclick="handleQtyPlus("itemval")"><i class="fas fa-plus"></i></li>
    //                     </ul>
    //                 </td>
    //                 <td>
    //                     <p class="ml-2">Rp<span id="itemval">' . $items["subtotal"] . '</span></p>
    //                 </td>
    //                 <td>
    //                     <ul class="pagination">
    //                         <li class="page-item"><button type="submit" name="remove" id="' . $items["rowid"] . '" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></li>
    //                     </ul>
    //                 </td>
    //             </tr>
    //         ';
    //     }

    //     $output .= '
    //             <tr>
    //                 <td> Total </td>
    //                 <td>' . $this->cart->total() . '</td>
    //             </tr>
    //             </table>
    //         ';

    //     if ($count == 0) {
    //         $output = '<p>empty</p>';
    //     }

    //     return $output;
    // }

    public function tambah_pesanan()
    {
    }
}
