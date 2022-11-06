<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rates extends Admin_Controller 
{

	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Rates';
		$this->load->model('model_rates');
		$this->load->model('model_category');
	}

	public function index()
	{

		if(!in_array('viewRates', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$rates_data = $this->model_rates->getRateData();

		$result = array();
		foreach ($rates_data as $k => $v) {
			$result[$k]['rate_info'] = $v;
			$category_data = $this->model_category->getCategoryData($v['vechile_cat_id']);
			$result[$k]['cat_info'] = $category_data;
		}


		$this->data['rates_data'] = $result;


		$this->render_template('rates/index', $this->data);
	}

	public function create()
	{
		if(!in_array('createRates', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->form_validation->set_rules('rate_name', 'Rate Name', 'required');
		$this->form_validation->set_rules('category_name', 'Category', 'required');
		$this->form_validation->set_rules('type', 'Type', 'required');
		$this->form_validation->set_rules('rate', 'Rate', 'required|integer');
		$this->form_validation->set_rules('rate_status', 'Status', 'required');

        if ($this->form_validation->run() == TRUE) {
            // true case
        	$data = array(
        		'rate_name' => $this->input->post('rate_name'),
        		'vechile_cat_id' => $this->input->post('category_name'),
        		'type' => $this->input->post('type'),
        		'rate' => $this->input->post('rate'),
        		'active' => $this->input->post('rate_status')
        	);

        	$create = $this->model_rates->create($data);
        	if($create == true) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('rates/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('rates/create', 'refresh');
        	}
        }
        else {

        	$category_data = $this->model_category->getActiveCategoryData();
        	$this->data['category_data'] = $category_data;

        	$this->render_template('rates/create', $this->data);	
        }
		
	}

	public function edit($id = null)
	{
		if(!in_array('updateRates', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if($id) {
			$this->form_validation->set_rules('rate_name', 'Rate Name', 'required');
			$this->form_validation->set_rules('category_name', 'Category', 'required');
			$this->form_validation->set_rules('type', 'Type', 'required');
			$this->form_validation->set_rules('rate', 'Rate', 'required|integer');
			$this->form_validation->set_rules('rate_status', 'Status', 'required');

	        if ($this->form_validation->run() == TRUE) {
	            // true case
	        	$data = array(
	        		'rate_name' => $this->input->post('rate_name'),
	        		'vechile_cat_id' => $this->input->post('category_name'),
	        		'type' => $this->input->post('type'),
	        		'rate' => $this->input->post('rate'),
	        		'active' => $this->input->post('rate_status')
	        	);

	        	$update = $this->model_rates->edit($data, $id);
	        	if($update == true) {
	        		$this->session->set_flashdata('success', 'Successfully updated');
	        		redirect('rates/', 'refresh');
	        	}
	        	else {
	        		$this->session->set_flashdata('errors', 'Error occurred!!');
	        		redirect('rates/edit/'.$id, 'refresh');
	        	}
	        }
	        else {
	            // false case
	            $category_data = $this->model_category->getCategoryData();
				$rate_data = $this->model_rates->getRateData($id);
				$this->data['category_data'] = $category_data;
				$this->data['rate_data'] = $rate_data;
				$this->render_template('rates/edit', $this->data);	
	        }

			
		}
		
	}

	public function delete($id = null)
	{

		if(!in_array('deleteRates', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		
		if($id) {
			if($this->input->post('confirm')) {

				// $check = $this->model_groups->existInUserGroup($id);
				// if($check == true) {
				// 	$this->session->set_flashdata('error', 'Group exists in the users');
	   //      		redirect('category/', 'refresh');
				// }
				// else {
					$delete = $this->model_rates->delete($id);
					if($delete == true) {
		        		$this->session->set_flashdata('success', 'Successfully removed');
		        		redirect('rates/', 'refresh');
		        	}
		        	else {
		        		$this->session->set_flashdata('error', 'Error occurred!!');
		        		redirect('rates/delete/'.$id, 'refresh');
		        	}
				// }	
			}	
			else {
				$this->data['id'] = $id;
				$this->render_template('rates/delete', $this->data);	
			}	
		}
		
	}
}