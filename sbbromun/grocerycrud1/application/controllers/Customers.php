<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customers extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
	}

	public function show_output($output = null)
	{
		$this->load->view('example.php',$output);
	}

	public function index()
	{
		//$this->show_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	public function customers()
	{
			$crud = new grocery_CRUD();
			$crud->set_subject('Customer');
			$crud->set_table('customers')
			->columns('name','status','image');
			$crud->display_as('name','Customer Name')
			->display_as('status','Customer Status')
			->display_as('image','Customer Image');	
			$crud->fields('name','status','image');
			$crud->required_fields('name','status');
			$crud->set_field_upload('image','assets/uploads/files');
			$output = $crud->render();
			$this->show_output($output);
	}
	public function orders()
	{
			$crud = new grocery_CRUD();
			$crud->set_subject('Order');
			$crud->set_table('orders')
			->columns('item','customer_id');
			$crud->display_as('item','Item Name')
			->display_as('customer_id','Customer Name');	
			$crud->fields('item','customer_id');
			$crud->required_fields('item','customer_id');
			$crud->set_relation('customer_id','customers','{name} - {id} - {status}');
			$output = $crud->render();
			$this->show_output($output);
	}
}










