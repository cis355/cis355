<?php
require ("database.php");
class Customer
{
	private static $id;
	private static $name;
	private static $email;
	private static $mobile;

	function outputJSON() {

		echo' {'; // begin object
		echo' "customers":';
		echo' ['; //begin array

		$pdo = Database::connect();
		$sql = 'SELECT * FROM customers ORDER BY id DESC';

		$str = "";
		foreach ($pdo->query($sql) as $row) {
			
				$str .= '{';
				$str .= '"id":"' . $row['id'];
				$str .= '", "name":"' . $row['name'];
				$str .= '", "email":"' . $row['email']; 
				$str .= '", "mobile":"' . $row['mobile'] . '"';
				$str .= '},';
		}
		$str = substr($str, 0, -1); //remove comma
		echo $str;

		Database::disconnect();

		echo'] '; //end array
		echo'} '; // end object
	}

}

$cust=New Customer;
$cust->outputJSON();
echo "<br><br><br>";

show_source(__FILE__);

?>