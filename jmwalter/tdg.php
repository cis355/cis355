<?php
require 'crud/database.php';
class Customer {
	private static $id;
	private static $name;
	private static $email;
	private static $mobile;

	
	public function insertFred () {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO customers (name,email,mobile) values(?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array("Fred","fred@fred.com","123-fred"));
		Database::disconnect();
	}
	
}
?>