<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends CI_Controller {

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
		//$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	public function display()
	{
		$crud = new grocery_CRUD();

		//$crud->set_theme('datatables');
		$crud->set_table('Orders')->columns('order_id','customer_id','item');
		
		$crud->display_as('order_id','Order ID')->display_as('customer_id','Customer ID')->display_as('item','Item');
		$crud->set_subject('Orders');
		$crud->fields('customer_id','item');
		$crud->required_fields('customer_id','item');
		
		$crud->set_relation('customer_id','customers','{name} - {id} - {status}')

		$output = $crud->render();

		$this->_example_output($output);
	}
}