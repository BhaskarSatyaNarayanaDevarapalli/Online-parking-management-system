<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends Admin_Controller 
{

	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Category';
		$this->load->model('model_category');	
	}

	public function index()
	{
		if(!in_array('viewCategory', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$category_data = $this->model_category->getCategoryData();
		$this->data['category_data'] = $category_data;
		$this->render_template('category/index', $this->data);
	}

	public function create()
	{
		if(!in_array('createCategory', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->form_validation->set_rules('category_name', 'Category name', 'required');
		$this->form_validation->set_rules('category_active', 'Status', 'required');

        if ($this->form_validation->run() == TRUE) {
            // true case
        	$data = array(
        		'name' => $this->input->post('category_name'),
        		'active' => $this->input->post('category_active')
        	);

        	$create = $this->model_category->create($data);
        	if($create == true) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('category/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('category/create', 'refresh');
        	}
        }
        else {
        	$this->render_template('category/create', $this->data);	
        }
		
	}

	public function edit($id = null)
	{
		if(!in_array('updateCategory', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if($id) {
			$this->form_validation->set_rules('category_name', 'Category name', 'required');
			$this->form_validation->set_rules('category_active', 'Status', 'required');

	        if ($this->form_validation->run() == TRUE) {
	            // true case
	        	$data = array(
	        		'name' => $this->input->post('category_name'),
	        		'active' => $this->input->post('category_active')
	        	);

	        	$update = $this->model_category->edit($data, $id);
	        	if($update == true) {
	        		$this->session->set_flashdata('success', 'Successfully updated');
	        		redirect('category/', 'refresh');
	        	}
	        	else {
	        		$this->session->set_flashdata('errors', 'Error occurred!!');
	        		redirect('category/edit/'.$id, 'refresh');
	        	}
	        }
	        else {
	            // false case
	            $category_data = $this->model_category->getCategoryData($id);
				$this->data['category_data'] = $category_data;
				$this->render_template('category/edit', $this->data);	
	        }

			
		}
		
	}

	public function delete($id = null)
	{
		if(!in_array('deleteCategory', $this->permission)) {
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
					$delete = $this->model_category->delete($id);
					if($delete == true) {
		        		$this->session->set_flashdata('success', 'Successfully removed');
		        		redirect('category/', 'refresh');
		        	}
		        	else {
		        		$this->session->set_flashdata('error', 'Error occurred!!');
		        		redirect('category/delete/'.$id, 'refresh');
		        	}
				// }	
			}	
			else {
				$this->data['id'] = $id;
				$this->render_template('category/delete', $this->data);	
			}	
		}
		
	}

}