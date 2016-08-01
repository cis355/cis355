<?php
set_exception_handler('my_exception_handler');

$name = $_POST['name']; //field allows SQL injection
$name2 = $_POST['name2']; //field protects against SQL injection
require_once ('crud/database.php');
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if (!empty($name)) {
	$sql = "INSERT INTO customers (name) VALUES ('$name')";
	$q = $pdo->prepare($sql);
	$q->execute(array($name));
}
else {
	$sql = "INSERT INTO customers (name) VALUES (?)";
	$q = $pdo->prepare($sql);
	$q->execute(array($name2));
}


Database::disconnect();

/* hackstring
INSERT INTO customers (name) VALUES ('$name 
Junky'); DROP TABLE inject; INSERT INTO customers (name) VALUES ('Kelsi');
*/
//error_reporting(E_ALL);
//ini_set('display_errors','1');
try {
	$file=fopen("welcome.txt","r");
} catch (Exception $e) {
	throw $e;
}
if (2/0) echo "batsh crazy";


if (isset($name)) echo ("Name is set. <br />");
else echo ("Name is not set.<br />");
if (isset($name2)) echo ("Name 2 is set. <br />");
else echo ("Name 2 is not set.<br />");
if (isset($name3)) echo ("Name 3 is set. <br />");
else echo ("Name 3 is not set.<br />");

if (empty($name)) echo ("Name is empty. <br />");
else echo ("Name is not empty.<br />");
if (empty($name2)) echo ("Name 2 is empty. <br />");
else echo ("Name 2 is not empty.<br />");
if (empty($name3)) echo ("Name 3 is empty. <br />");
else echo ("Name 3 is not empty. <br /><br />");

$con = mysqli_connect('localhost','kcbenson','123nope','kcbenson');
$error = mysqli_connect_error();
if ($error != NULL)
	echo "Not connected.";
else echo "Connected.";

function my_exception_handler ($exception) {
	$msg = "<p>Exception number " . $exception->getCode();
	$msg .= $exception->getMessage() . " occured on line ";
	$msg .= $exception->getLine() . " and in the file ";
	$msg .= $excecption->getFile() . ".</p>";
}



show_source(__FILE__);
?>