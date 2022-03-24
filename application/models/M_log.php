<?php
class M_log extends CI_Model
{

    public function get_all_log()
    {
        $result = $this->db->query("SELECT * FROM tbl_log ORDER BY pengunjung_tanggal DESC")->result();
        return $result;
    }
}
