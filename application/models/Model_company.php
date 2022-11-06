<?php 

class Model_company extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getCompanyData($id)
	{
		if($id) {
			$sql = "SELECT * FROM company WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();	
		}
	}

	public function edit($data, $id)
	{
		$this->db->where('id', $id);
		$update = $this->db->update('company', $data);
		return ($update == true) ? true: false;
	}
}