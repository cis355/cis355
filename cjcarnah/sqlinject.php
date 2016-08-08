<?php

//set_exception_handler(my_exception_handler);

$name = $_POST['name'];
$name2 = $_POST['name2'];
require ('crud/database.php');
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (!empty($name)) {
	$sql = "INSERT INTO customers (name) VALUES ('$name')";
	$q = $pdo->prepare($sql);
	$q->execute();
}
else {
	$sql = "INSERT INTO customers (name) VALUES (?)";
	$q = $pdo->prepare($sql);
	$q->execute(array($name2));
}

Database::disconnect();

	// charles'); INSERT INTO customers (name) VALUES ('HACKED!

	error_reporting(E_ALL);
	
if (isset($name)) echo "Name is set";
else echo "name is not set";	
if (isset($name2)) echo "Name is set"; 
else echo "name2 is not set";
	
	
if (empty($name)) echo "Name is empty";
else echo "name is not empty";	
if (empty($name2)) echo "Name is empty";
else echo "name2 is not empty";

show_Source(__FILE__);


 
// $con = mysqli_connect('local host','cjcarnah','546310','cjcarnah');

/*$error = mysqli_connect_error();
if ($error != null){
	echo "DATABADE ERRRORSSS";	
*/}


/*try {
	echo "TRY" ;
} catch (Exception E$) {
  echo "ERRORESSS"	;
}*/


//ini_set('display_errors', '1');	
 
/*function my_exception_handler ($exception) {
	$msg = "<p>Exception number ". $exception->getCode();
	$msg .= $exception->getMessage() . "occurred on line " ;
	$msg .= $exception->getLine() . "and in the file ";
	$msg .= $exception->getFile() . "</p>";
}*/


?> 