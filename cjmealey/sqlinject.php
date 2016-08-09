<?php
/*
function throwException($message = null, $code = null){
	throw new Exception($message,$code);
}

try {
	$con = mysqli_connect('localhost', 'cjmealey', 'forget', 'cjmealey');
		or throwException("could not connect<br />");
} catch (Exception $e) {
	echo " *** not connected *** <br />";
} finally {
	echo "finally<br/>";
}

mysqli_close($con);
*/

function my_exception_handler($exception) {
	$msg = "<p>Exception number " . $exception->getCode();
	$msg .= $exception->getMessage() . " occurred on line ";
	$msg .= $exception->getLine() . " and in the file ";
	$msg .= $exception->getFile() . "</p>";
}	
set_exception_handler('my_exception_handler');


$name = $_POST['name']; // field allows SQL injection 
$name2 = $_POST['name2']; // field protects against it 
require ('crud/database.php'); 
$pdo = Database::connect(); 
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

$sql = "INSERT INTO customers (name) VALUES ('$name')"; 
$q = $pdo->prepare($sql); 
$q->execute(); 

$sql = "INSERT INTO customers (name) VALUES (?)"; 
$q = $pdo->prepare($sql); 
$q->execute(array($name2)); 

Database::disconnect(); 

// ------------------------------------------- HACKSTRING ---------------------------------------------+

/*
INSERT INTO customers (name) VALUES ('$name 

Zippydee'); INSERT INTO customers (name) VALUES ('HackMaster3000    <--- EDIT THIS STRING

')
*/

// +---------------------------------------------------------------------------------------------------+

error_reporting(E_ALL);
ini_set('display_errors', '1');
try {
	$file=fopen("welcome.txt", "r");
}
catch (Exception $e){
	throw $e;
}

if (isset($name)) echo "name is set <br />"; 
else echo "name is not set <br />"; 
if (isset($name2)) echo "name2 is set <br />"; 
else echo "name2 is not set <br />"; 
if (isset($name3)) echo "name3 is set <br />"; 
else echo "name3 is not set <br />"; 

if (empty($name)) echo "name is empty <br />"; 
else echo "name is not empty <br />"; 
if (empty($name2)) echo "name2 is empty <br />"; 
else echo "name2 is not empty <br />"; 
if (empty($name3)) echo "name3 is empty <br />"; 
else echo "name3 is not empty <br />"; 

$con = mysqli_connect('localhost', 'cjmealey', '564667', 'cjmealey');
$error = mysqli_connect_error();
if ($error!=NULL) echo "not connected <br />";
else echo "connected <br />";

show_source(__FILE__);
?>


