<?php 

class Dashboard extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Dashboard';
			
		$this->load->model('model_slots');
		$this->load->model('model_users');
		$this->load->model('model_parking');
	}

	public function index()
	{
		$this->data['total_slots'] = $this->model_slots->countTotalSlots();
		$this->data['total_users'] = $this->model_users->countTotalUsers();
		$this->data['total_parking'] = $this->model_parking->countTotalParking();

		$user_id = $this->session->userdata('id');
		$is_admin = ($user_id == 1) ? true :false;

		$this->data['is_admin'] = $is_admin;
 
		$this->render_template('dashboard', $this->data);
	}
}