<?php
	
	require ('program01/database.php');
	class Customer{
	private static $id;
    private static $name;
    private static $email;
    private static $mobile;
    
	
	 public function displayRecords () {
		echo'{';//begin the object
		echo '"customers":';
		echo '[';
		
        $pdo = Database::connect();
        $sql = 'SELECT * FROM customers ORDER BY id DESC';
		$str = "";
        foreach ($pdo->query($sql) as $row ) {
            $str .= '{';
            $str .= '"id":"'. $row['id'] . '", ';
            $str .= '"name":"'. $row['name'] . '", ';
            $str .= '"email":"'. $row['email'] . '", ';
            $str .= '"mobile":"'. $row['mobile'] . '"';
			$str .='},';

        }
        $str = substr($str, 0, -1);
		echo $str;

        Database::disconnect();
		echo']';
		echo'}';
    }
}
	$cust = new Customer;
	$cust->displayRecords();
	show_source(__FILE__);
?>