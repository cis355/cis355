<?php
	echo '<a href="JSONXML.php">WebService</a><br /><br />';
	require ("crud/database.php");
	class Customer {
		
		private static $id;
		private static $name;
		private static $email;
		private static $mobile;
		
		public function outputJSON () { 
			
			echo'{'; //begin the object
			echo '"customers":';
			echo '['; //begin the array
			
			
			$pdo = Database::connect(); 
			$sql = 'SELECT * FROM customers ORDER BY id DESC'; 
			$str = '';
			foreach ($pdo->query($sql) as $row) { 
				$str.= '{'; 
				$str.= '"id":"'. $row['id'] . '",'; 
				$str.= '"name":"'. $row['name'] . '",'; 
				$str.= '"email":"'. $row['email'] . '",'; 
				$str.= '"mobile":"'. $row['mobile'] . '"'; 
				$str.= '},'; 
			}
			$str = substr($str, 0, -1); //remove last comma
			echo $str;
			Database::disconnect(); 
			echo ']'; //close the array
			echo '}'; //close the object
		} 
	}
$cust1 = new Customer;
$cust1->outputJSON();
echo '<br /><br /><br />';
show_source(__FILE__);
?>