<?php 

class Model_rates extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getRateData($id = null) 
	{
		if($id) {
			$sql = "SELECT * FROM rate WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM rate";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data = '')
	{
		$create = $this->db->insert('rate', $data);
		return ($create == true) ? true : false;
	}

	public function edit($data, $id)
	{
		$this->db->where('id', $id);
		$update = $this->db->update('rate', $data);
		return ($update == true) ? true : false;	
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete('rate');
		return ($delete == true) ? true : false;
	}

	public function getCategoryRate($id)
	{
	 	$sql = "SELECT * FROM rate WHERE vechile_cat_id = ? AND active = ?";
	 	$query = $this->db->query($sql, array($id, 1));
	 	return $query->result_array();
	}
}