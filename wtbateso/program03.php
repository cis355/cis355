<!-- ------------------------------------------------------------------------
* filename : program03.php
* author : William Bateson
* username : wtbateso
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : this program displays "jobs" table and displays it in JSON
*
* input : taken from the "jobs" table
* processing : The program steps are as follows.
* 1. initialize session
* 2. create class
* 3. echo table to screen
* 4. show code
*
* output : jobs table
*
* precondition : check for database table
* postcondition: information printed to the screen

------------------------------------------------------------------------- -->
<?php 
	require ("crud/database.php"); 

	class Customer { 

		private static $id; 
		private static $name; 
		private static $email; 
		private static $mobile; 
		 
		public function outputJSON () { 
		 
			echo '{'; // begin the object 
			echo '"jobs":'; 
			echo '['; // begin the array 
		 
			$pdo = Database::connect(); 
			$sql = 'SELECT * FROM jobs ORDER BY id DESC'; 
			 
			$str = ''; 
			foreach ($pdo->query($sql) as $row) { 
				$str .= '{'; 
				$str .=  '"id":"'. $row['id'] . '", '; 
				$str .=  '"name":"'. $row['jobName'] . '",'; 
				$str .=  '"email":"'. $row['jobSalary'] . '",'; 
				$str .=  '"mobile":"'. $row['companyName']. '"';; 
				$str .=  '},'; 
			} 
			$str = substr($str, 0, -1); // remove last comma 
			echo $str; 
			 
			Database::disconnect(); 
			echo ']'; // close the array 
			echo '}'; // close the object 
		} 
		 
	} 

	$cust = new Customer; 
	$cust->outputJSON(); 
	echo '<br /><br /><br />'; 
	show_source(__FILE__); 



?>