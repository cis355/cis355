<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller {

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

		$crud->set_subject('Order');
		$crud->set_table('orders');
		$crud->display_as('orderId','Orders Id')->
		display_as('customerId','Customer Id')->
		display_as('item','Items');
		$crud->set_relation('customerId', 'customers', '{name} - {id} - {status}');
		
		$crud->fields('orderId','customerId','items');
		$crud->required_fields('orderId','customerId','items');
		
		$output = $crud->render();

		$this->_example_output($output);
	}


}