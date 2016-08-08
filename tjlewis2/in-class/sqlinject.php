<?php 

$name = $_POST['name']; //field allows SQL injection
$name2 = $_POST['name2']; //field protects against it

require('database.php');

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(!empty($name)){
	$sql = "INSERT INTO customers (name) VALUES('$name')";
	$q = $pdo->prepare($sql);
	$q->execute(array($name));
}
else{
	$sql = "INSERT INTO customers (name) VALUES(?)";
	$q = $pdo->prepare($sql);
	$q->execute(array($name2));
}

echo $name;
$q = $pdo->prepare($sql);
$q->execute(array($name));
Database::disconnect();

error_reporting(E_ALL);
init_set('display_errors',"1");
$file=fopen('welcome.txt',"r");

$variable = 2/ 0;

if(isset($name)) echo "Name is set <br/>";
else echo "name is not set <br/>";
if(isset($name2)) echo "name2 is set <br/>";
else echo "name2 is not set <br/>";
if(isset($name3)) echo "name3 is set <br/>";
else echo "name3 is not set <br/>";

if(empty($name)) echo "Name is empty <br/>";
else echo "name is not set <br/>";
if(empty($name2)) echo "name2 is empty <br/>";
else echo "name2 is not set <br/>";
if(empty($name3)) echo "name3 empty <br/>";
else echo "name3 is not set <br/>";
show_source(__FILE__);

functon my_exception_handler($exception){
	$msg = "<p>Exception number " . $exception->getCode();
	$msg .= $exception->getMessage() . "occured on line";
	$msg .= $exception->getLine() . "and in the file ";
	$msg .= $exception->getFile() . "</p>";
	}


	/*
hackstring INSERT INTO customers(name) VALUES ('$name ZippyDee'); 
DROP TABLE 
//ZippyDee');
//  DROP TABLE attemps
*/

?> 