<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Parking extends Admin_Controller 
{

	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Parking';
		$this->load->model('model_parking');
		$this->load->model('model_category');
		$this->load->model('model_slots');
		$this->load->model('model_rates');
		$this->load->model('model_company');
	}

	public function index()
	{

		if(!in_array('viewParking', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$parking_data = $this->model_parking->getParkingData();
	
		$result = array();
		foreach ($parking_data as $k => $v) {
			$result[$k]['parking'] = $v;
			$category_data = $this->model_category->getCategoryData($v['vechile_cat_id']);
			$slot_data = $this->model_slots->getSlotData($v['slot_id']);
			$rate_data = $this->model_rates->getRateData($v['rate_id']);

			$result[$k]['category'] = $category_data;
			$result[$k]['slot'] = $slot_data;
			$result[$k]['rate'] = $rate_data;
		}

		$this->data['company_currency'] = $this->company_currency();
		$this->data['parking_data'] = $result;
		$this->render_template('parking/index', $this->data);
	}


	public function create()
	{
		if(!in_array('createParking', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->form_validation->set_rules('parking_slot', 'Slot', 'required');
		$this->form_validation->set_rules('vehicle_cat', 'Category', 'required');
		$this->form_validation->set_rules('vehicle_rate', 'Rate', 'required');

        if ($this->form_validation->run() == TRUE) {
            // true case

        	$parking_code = strtoupper('pa-'.substr(md5(uniqid(mt_rand(), true)), 0, 6));

        	$data = array(
        		'parking_code' => $parking_code,
        		'vechile_cat_id' => $this->input->post('vehicle_cat'),
        		'rate_id' => $this->input->post('vehicle_rate'),
        		'slot_id' => $this->input->post('parking_slot'),
        		'in_time' => strtotime('now'),
        		'paid_status' => 0
        	);

        	$create = $this->model_parking->create($data);
        	if($create == true) {

        		// now unavailable the slot
        		$slot_data = array(
        			'availability_status' => 2
        		);

        		$update_slot = $this->model_slots->updateSlotAvailability($slot_data, $this->input->post('parking_slot'));

        		if($create == true && $update_slot == true) {
        			$this->session->set_flashdata('success', 'Successfully created');
		    		redirect('parking/', 'refresh');	
        		}
        		else {
        			$this->session->set_flashdata('errors', 'Error occurred!!');
	        		redirect('parking/create', 'refresh');
        		}
        		
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('parking/create', 'refresh');
        	}
        }
        else {
        	$vehicle_cat = $this->model_category->getActiveCategoryData();
        	
        	$this->data['vehicle_cat'] = $vehicle_cat;

        	$slots = $this->model_slots->getAvailableSlotData();
        	$this->data['slot_data'] = $slots;

			$this->render_template('parking/create', $this->data);
		}
	}

	public function edit($id = null)
	{
		if(!in_array('updateParking', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if($id) {
			$this->form_validation->set_rules('parking_slot', 'Slot', 'required');
			$this->form_validation->set_rules('vehicle_cat', 'Category', 'required');
			$this->form_validation->set_rules('vehicle_rate', 'Rate', 'required');

			if ($this->form_validation->run() == TRUE) {
            // true case
	        	$save_parking_data = $this->model_parking->getParkingData($id);
	        	$before_slot_id = $save_parking_data['slot_id'];

	        	// update the slot data
	        	$update_slot = array(
	        		'availability_status' => 1
	        	);
	        	$this->model_slots->updateSlotAvailability($update_slot, $before_slot_id);

	        	$data = array(
	        		'vechile_cat_id' => $this->input->post('vehicle_cat'),
	        		'rate_id' => $this->input->post('vehicle_rate'),
	        		'slot_id' => $this->input->post('parking_slot'),
	        	);

	        	$update_parking_data = $this->model_parking->edit($data, $id);
	        	if($update_parking_data == true) {

	        		// now unavailable the slot
	        		$slot_data = array(
	        			'availability_status' => 2
	        		);

	        		$update_slot = $this->model_slots->updateSlotAvailability($slot_data, $this->input->post('parking_slot'));

	        		if($update_parking_data == true && $update_slot == true) {
	        			$this->session->set_flashdata('success', 'Successfully created');
			    		redirect('parking/', 'refresh');	
	        		}
	        		else {
	        			$this->session->set_flashdata('errors', 'Error occurred!!');
		        		redirect('parking/create', 'refresh');
	        		}
	        		
	        	}
	        	else {
	        		$this->session->set_flashdata('errors', 'Error occurred!!');
	        		redirect('parking/create', 'refresh');
	        	}
	        }
			else {
				$vehicle_cat = $this->model_category->getCategoryData();
	        	$this->data['vehicle_cat'] = $vehicle_cat;

	        	$slots = $this->model_slots->getAvailableSlotData();
	        	$this->data['slot_data'] = $slots;

	        	$save_parking_data = $this->model_parking->getParkingData($id);
	        	$this->data['save_parking_data'] = $save_parking_data;

	        	// used parking slot info
	        	$get_used_slot = $this->model_slots->getSlotData($save_parking_data['slot_id']);

	        	$get_used_rate = $this->model_rates->getCategoryRate($save_parking_data['vechile_cat_id']);

	        	$this->data['slot_data'][] = $get_used_slot;
	        	$this->data['get_used_rate_data'] = $get_used_rate;

	        	// echo "<pre>";
	        	// print_r($save_parking_data);
	        	// die;
	        	

				$this->render_template('parking/edit', $this->data);	
			}				
		}
		
	}

	public function delete($id = null)
	{
		if(!in_array('deleteParking', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if($id) {
			if($this->input->post('confirm')) {

				$delete = $this->model_parking->delete($id);
				if($delete == true) {
	        		$this->session->set_flashdata('success', 'Successfully removed');
	        		redirect('parking/', 'refresh');
	        	}
	        	else {
	        		$this->session->set_flashdata('error', 'Error occurred!!');
	        		redirect('parking/delete/'.$id, 'refresh');
	        	}	
			}	
			else {
				$this->data['id'] = $id;
				$this->render_template('parking/delete', $this->data);	
			}	
			
			
		}	
	}

	public function printInvoice($id)
	{
		if(!in_array('viewParking', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if($id) {
			$parking_data = $this->model_parking->getParkingData($id);
			$company_info = $this->model_company->getCompanyData(1);

			// get the vehicle type 
			$vehicle_category = $this->model_category->getCategoryData($parking_data['vechile_cat_id']);

			$check_in_date = date("Y-m-d", $parking_data['in_time']);
			$check_in = date("h:i a", $parking_data['in_time']);

			$html = '<html>
				<head>
				 	<title>Print</title>
				 	<style>
				 	.main-content {
					    text-align: center;
					    width: 100%;
					}

					table.table {
					    width: 50%;
					    margin: 0 auto;
					    text-align: left;
					}
				 	</style>
				</head>
				<body>
					<div class="main-content">
						<div class="company-info">
							<div class="company-name"><p>'.$company_info['name'].'</p></div>
							<div class="company-address"><p>'.$company_info['address'].'</p></div>
							<div class="parking-slip"><h2>Parking Slip</h2></div>
						</div>
						<div class="parking-info">
							<table class="table">
								<tr>
									<td>Date: '.$check_in_date.'</td>
									<td>Time: '.$check_in.'</td>
								</tr>
								<tr>
									<td>Vehicle type: '.ucwords($vehicle_category['name']).' </td>
								</tr>
								<tr>
									<td>Parking no: '.$parking_data['parking_code'].' </td>
								</tr>
							</table>

							<p> For you own convenience, please do not loose the slip. </p>
						</div>
						<div class="parking-message">
							'.$company_info['message'].'
						</div>
					</div>					
				</body>
			</html>
			';

			echo $html;
		}
	}

	public function updatepayment() 
	{
		if(!in_array('updateParking', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$id = $this->input->post('parking_id');
		if($id) {
			// getting the parking data 
			$updatePayment = $this->model_parking->updatePayment($id, $this->input->post('payment_status'));
			if($updatePayment == true) {
    			$this->session->set_flashdata('success', 'Successfully updated');
	    		redirect('parking/', 'refresh');	
    		}
    		else {
    			$this->session->set_flashdata('payment_error', 'Error occurred!!');
        		redirect('parking/edit/'.$id, 'refresh');
    		}
		}
	}

	public function getCategoryRate($id) 
	{
		if($id) {
			$rate_data = $this->model_rates->getCategoryRate($id);
			$html = '';
			foreach ($rate_data as $k => $v) {
				$html .= '<option value="'.$v['id'].'">'.$v['rate_name'].'</option>';
			}
			
			echo json_encode($html);
		}
	}

}