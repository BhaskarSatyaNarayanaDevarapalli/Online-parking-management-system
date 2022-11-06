<?php 

class Model_parking extends CI_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_rates');
		$this->load->model('model_slots');
	}

	public function getParkingData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM parking WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM parking ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data = '')
	{
		$create = $this->db->insert('parking', $data);
		return ($create == true) ? true : false;
	}

	public function edit($data, $id)
	{
		$this->db->where('id', $id);
		$update = $this->db->update('parking', $data);
		return ($update == true) ? true : false;	
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete('parking');
		return ($delete == true) ? true : false;
	}	


	/*
	 update the payment information for the parking
	 gets the parking data from the id and 
	 caculate the difference time 
	 checks if the rate is based on the hourly or fixed rate
	*/
	public function updatePayment($id, $payment_status) 
	{
		if($id && $payment_status) {
			if($payment_status == 1) {
				// get the data of parking data
				$data = $this->getParkingData($id);
				
				$check_in_time = $data['in_time'];
				$rate_id = $data['rate_id'];
				$slot_id = $data['slot_id'];

				$checkout_time = strtotime('now');

				// calculates the time by hourly
				$total_time = ceil((abs($checkout_time - $check_in_time) / 60) / 60);


				$rate_data = $this->model_rates->getRateData($rate_id);

				$earned_amount = 0;
				if($rate_data['type'] == 2) {
					// means hourly
					$earned_amount = ((int) $rate_data['rate'] * (int) $total_time);					
				}
				else {
					$earned_amount = $rate_data['rate'];
				}

				$update_data = array(
					'out_time' => $checkout_time,
					'paid_status' => 1,
					'total_time' => $total_time,
					'earned_amount' => $earned_amount
				);

				$this->db->where('id', $id);
				$update_ops = $this->db->update('parking', $update_data);

				if($update_ops == true) {

					$slot_update_data = array(
						'availability_status' => 1
					); 
					$update_slot_ops = $this->model_slots->updateSlotAvailability($slot_update_data, $slot_id);
				}
				else {
					return false;
				}

				return ($update_ops == true && $update_slot_ops == true) ? true : false;

			} // /elseif
			else {
				$update_data = array(
					'out_time' => '',
					'paid_status' => 0,
					'earned_amount' => 0				
				);

				$this->db->where('id', $id);
				$update_data = $this->db->update('parking', $update_data);
				return ($update_data == true) ? true: false; 
				
			}
		} // /if
		return false;
	}

	public function countTotalParking()
	{
		$sql = "SELECT * FROM parking";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	

	
}