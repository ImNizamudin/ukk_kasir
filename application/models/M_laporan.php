<?php

class M_laporan extends CI_Model
{
    public function get_all_laporan()
    {
        $role_id = $this->session->userdata('role_id');
        $iduser   = $this->session->userdata('iduser');

        $hsl = $this->db->query("SELECT * FROM 
        data_menu a INNER JOIN tbl_det_jual b 
        ON a.kode_menu=b.kode_menu 
        INNER JOIN tbl_master_jual c 
        ON c.nofak_jual=b.nofak_jual 
        INNER JOIN user d 
        ON d.id=c.pengguna_id 
        ORDER BY c.nofak_jual, c.tgl_jual")->result();
        return $hsl;
    }

    public function pendapatan()
    {
        return $this->db->query("SELECT SUM(total_harga) AS pendapatan FROM tbl_master_jual")->row();
    }
}
