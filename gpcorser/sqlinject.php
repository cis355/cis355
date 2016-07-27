<?php
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

/* hackstring is middle line below
INSERT INTO customers (name) VALUES ('$name
Zippydee'); INSERT INTO customers (name) VALUES ('George
')
*/

function my_exception_handler ($exception) {
    $msg = "<p>Exception number ". $exception->getCode();
	$msg .= $exception->getMessage() . "occurred on line " ;
	$msg .= $exception->getLine() . " and in the file ";
	$msg .= $exception->getFile() . "</p>";
}

set_exception_handler('my_exception_handler');

error_reporting(E_ALL);
ini_set('display_errors','1'); 
try {
    $file=fopen("welcome.txt","r"); // warning
} catch (Exception $e) {
    echo "hello!";
    throw $e;
}
throw new Exception ("Zippy did not appear");
// if( 2 / 0 ) echo "batsh crazy";

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

$con = mysqli_connect('localhost', 'gpcorser', 'forget', 'gpcorser');

$error = mysqli_connect_error();
if ($error != NULL) echo "not connected";
else echo "connected";



show_source(__FILE__);




















?>