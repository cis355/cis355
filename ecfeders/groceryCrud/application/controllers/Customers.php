<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customers extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
	}

	public function _example_output($output = null)
	{
		$this->load->view('example.php',$output);
	}

	public function index()
	{
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	public function display()
	{
		$crud = new grocery_CRUD();

		//$crud->set_theme('datatables');
		$crud->set_table('customers')->columns('name','status','image');
		
		$crud->display_as('name','Customer Name')->display_as('status','Customer Status')->display_as('image','Customer Image');
		$crud->set_subject('Customers');
		$crud->fields('name','status','image');
		$crud->required_fields('name','status');
		
		$crud->set_field_upload('image', 'assets/uploads/files');

		$output = $crud->render();

		$this->_example_output($output);
	}
	
	public function displayOrders()
	{
		$crud = new grocery_CRUD();

		//$crud->set_theme('datatables');
		$crud->set_table('orders')->columns('order_id','customer_id','item');
		
		$crud->display_as('order_id','Order ID')->display_as('customer_id','Customer ID')->display_as('item','Item');

		$crud->fields('customer_id','item');
		$crud->required_fields('customer_id','item');
		
		$crud->set_relation('customer_id','customers','{name} - {id} - {status}')

		$output = $crud->render();

		$this->_example_output($output);
	}
}