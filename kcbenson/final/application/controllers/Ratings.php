<?php
/* *******************************************************************
* filename : Ratings.php
* author : Kelsi Benson
* username : kcbenson
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : This program creates a display of theme park
* ratings by reading in data from a SQL database and 
* formatting it with CodeIgniter grocery_crud based code.
* The purpose of this program is to demonstrate
* a CRUD application with real world value.
*
* input : database records
* processing : The program steps are as follows.
* 1. connect to database
* 2. read in specified fields
* 3. output data based upon the view
* output : formatted database table with create, read
* update and delete functionality.
*
* precondition : the database.php file must exist
* and have proper connection information
* postcondition: information printed to the screen,
* *******************************************************************
*/

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ratings extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('grocery_CRUD');
	}

	public function _example_output($output = null)
	{
		$this->load->view('example.php',$output);
	}

	public function offices()
	{
		$output = $this->grocery_crud->render();
		$this->_example_output($output);
	}

	public function index()
	{
		//$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	public function display()
	{
			$crud = new grocery_CRUD();
			$crud->set_subject('Ratings');
			$crud->set_table('parkRatings')->columns('rideID','customerID','rating','justification');
			$crud->display_as('rideID','Ride')->display_as('customerID','Rider')->display_as('rating','Rating')->display_as('justification','Review');
			$crud->fields('rideID','customerID','rating','justification');
			$crud->required_fields('rideID','customerID','rating');
			$crud->set_relation('rideID','parkRides','{rideName}');
			$crud->set_relation('customerID','parkCustomers','{name}');
			$output = $crud->render();
			$this->_example_output($output);
	}
}