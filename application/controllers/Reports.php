<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends Admin_Controller 
{

	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Report';
		$this->load->model('model_report');
	}

	public function index()
	{

		$today_year = date('Y');

		if($this->input->post('select_year')) {
			$today_year = $this->input->post('select_year');
		}

		$parking_data = $this->model_report->getParkingData($today_year);
		$this->data['report_years'] = $this->model_report->getParkingYear();
		

		$final_parking_data = array();
		foreach ($parking_data as $k => $v) {
			
			if(count($v) > 1) {
				$total_amount_earned = array();
				foreach ($v as $k2 => $v2) {
					if($v2) {
						$total_amount_earned[] = $v2['earned_amount'];
						
					}
				}
				$final_parking_data[$k] = array_sum($total_amount_earned);	
			}
			else {
				$final_parking_data[$k] = 0;	
			}
			
		}
		
		$this->data['selected_year'] = $today_year;
		$this->data['company_currency'] = $this->company_currency();
		$this->data['parking_data'] = $final_parking_data;

		$this->render_template('reports/index', $this->data);
	}

}