<?php 
/* *******************************************************************
* filename : Rides.php
* author : Kelsi Benson
* username : kcbenson
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : This program creates a display of theme park
* rides by reading in data from a SQL database and 
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

class Rides extends CI_Controller {

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
	}

	public function display()
	{
			$crud = new grocery_CRUD();
			$crud->set_subject('Rides');
			$crud->set_table('parkRides')->columns('rideName','parkName','rideType');
			$crud->display_as('rideName','Ride')->display_as('parkName','Park')->display_as('rideType','Ride Type');
			$crud->fields('rideName','parkName','rideType');
			$crud->required_fields('rideName','parkName','rideType');
			$output = $crud->render();
			$this->_example_output($output);
	}
}