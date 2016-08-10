<?php

require('crud/database.php');

class Customer {
	
	private static $id;
	private static $name;
	private static $email;
	private static $mobile;
	
	public function outputJSON () {
		$str = '';
		$str .= '{';
		$str .= '"customers":';
		$str .= '['; // begin array
		
		$pdo = Database::connect();
		$sql = 'SELECT * FROM customers ORDER BY id DESC';
		
		foreach ($pdo->query($sql) as $row) {
			$str .= '{';
			$str .= '"id":"' . $row['id'] . '",';
			$str .= '"name":"' . $row['name'] . '",';
			$str .= '"email":"' . $row['email'] . '",';
			$str .= '"mobile":"' . $row['mobile'] .'"';
			$str .= '},';
		}
		$str = substr($str,0,-1); // remove last comma
		
		
		Database::disconnect();
		
		$str .= ']'; // end array
		$str .= '}';
		
		echo $str;
	}
	
}

$cust = new Customer();
$cust->outputJSON();
show_source(__FILE__);

?>