<?php

class M_pegawai extends CI_Model
{
	protected $_table = 'user';

	public function lihat()
	{
		$query = "SELECT user.*, user_role.role FROM user JOIN user_role ON user.role_id = user_role.id";
		return $this->db->query($query)->result();
		// return $query->result() mengembalikan bentuknya objek
	}

	public function lihatKasir()
	{
		$query = $this->db->get_where($this->_table, ['role_id' => 3]);
		return $query->result();
	}

	public function jumlah()
	{
		$query = $this->db->get($this->_table);
		return $query->num_rows();
	}

	public function lihat_id($id)
	{
		$query = $this->db->get_where($this->_table, ['id' => $id]);
		return $query->row();
	}

	public function lihat_username($username_pengguna)
	{
		$query = $this->db->get_where($this->_table, ['username_pengguna' => $username_pengguna]);
		return $query->row();
	}

	public function tambah($data)
	{
		return $this->db->insert($this->_table, $data);
	}

	public function ubah($data, $id)
	{
		$query = $this->db->set($data);
		$query = $this->db->where(['id' => $id]);
		$query = $this->db->update($this->_table);
		return $query;
	}

	public function hapus($id)
	{
		return $this->db->delete($this->_table, ['id' => $id]);
	}
}
