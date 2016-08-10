<?php
$name = $_POST['name']; //field allows sql injection
$name2 = $_POST['name2']; // field protects against it

require ('crud/database.php');
$pdo = Database::connect();

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = "INSERT INTO customers (name) VALUES ('$name')";
		$q = $pdo->prepare($sql);
		$q->execute(array($name));
		


	$sql = "INSERT INTO customers (name) VALUES (?)";
	$q = $pdo->prepare($sql);
	$q->execute(array($name2));
	


Database::disconnect();
/* hack string
INSERT INTO customers (name) VALUES ('$name
zippydee'); INSERT INTO customers (name) VALUES ('Derek
');	
	*/	
	
function my_exception_handler ($exception){
	
	$msg = "<p>Exception number " . $exception->getcode();
	$msg .= $exception->getMessage() . "occurred on line ";
	$msg .= $exception->getLine() . " and in the file ";
	$msg .= $exception->getFile() . "</p>";
	
}
set_exception_handler('my_exception_handler');

//error_reporting(E_ALL);
ini_set('display_errors', '1');
try {
$file=fopen("welcome.txt", "r");
} catch (Exception $e) {
	
	throw $e;
}
$variable = 2 / 0;
	
if (isset($name)) echo "Name is set <br />";
else echo "Name is not set <br />";

if (isset($name2)) echo "Name2 is set <br />";
else echo "Name2 is not set <br />";

if (isset($name3)) echo "Name3 is set <br />";
else echo "Name3 is not set <br />";

if (isset($name)) echo "Name is empty <br />";
else echo "Name is not empty <br />";

if (isset($name2)) echo "Name2 is empty <br />";
else echo "Name2 is not empty <br />";

if (isset($name3)) echo "Name3 is empty <br />";
else echo "Name3 is not empty <br />";

$con = mysqli_connect('localhost', 'dtnichol', '99DT44Nichols', 'dtnichol');
$error = mysqli_connect_error();
if ($error != NULL) echo "not connected";
else echo "connected";
mysqli_close($con);

function throwException($message = null,$code = null) {
	throw new Exception($message,$code);
}

try {
	
	$con = mysqli_connect('localhost', 'dtnichol', '99DT44Nichols', 'dtnichol')
		or throwException("could not connect<br />");
} catch (Exception $e) {
	echo "*** not connected ***";
	
} finally {
	echo "finally";
}

mysqli_close($con);






show_source(__FILE__);
?>