<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->data['page_title'] = 'Company';
		$this->load->model('model_company');
	}

	public function index() 
	{
        if(!in_array('updateCompany', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$company_id = 1;

		$this->form_validation->set_rules('company_name', 'Category name', 'required');
        $this->form_validation->set_rules('address', 'Status', 'required');
		$this->form_validation->set_rules('currency', 'Currency', 'required');

        if ($this->form_validation->run() == TRUE) {
            // true case
        	$data = array(
        		'name' => $this->input->post('company_name'),
        		'address' => $this->input->post('address'),
                'message' => trim($this->input->post('message')),
        		'currency' => $this->input->post('currency')
        	);

        	$update = $this->model_company->edit($data, $company_id);
        	if($update == true) {
        		$this->session->set_flashdata('success', 'Successfully updated');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        	}

        	redirect('company/', 'refresh');
        }
        else {
			$company_data = $this->model_company->getCompanyData($company_id);
            $this->data['currency_symbols'] = $this->currency();
			$this->data['company_data'] = $company_data;
			$this->render_template('company/index', $this->data);
		}

	}

}