<?php
$name = 1;
$name2 = 2;

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
var_dump($error);
mysqli_close($con);

echo "hello <br />";

// perform error checking on database connection using try/catch/finally
function throwException($message = null,$code = null) {
	throw new Exception($message,$code);
}

try {
	$con = mysqli_connect('localhost','kcbenson','123nope','kcbenson')
	or throwException("could not connect<br />");
} catch (Exception $e) {
	echo " ** not connected **<br />";
	//echo $e->getMessage();
} finally {
	echo "finally<br />";
}
mysqli_close($con);
// perform error checking on database using exception handler

echo "start exception handler code <br />";

function exception_handler($exception) {
	echo "Uncaught exception: " , $exception->getMessage(), "<br />";
}

set_exception_handler('exception_handler');

//throw new Exception('exceptThis');
echo "Not Executed<br />"; //will not execute if exception is thrown
//$con = mysqli_connect('localhost','kcbenson','123nope','kcbenson')
	//or throwException("could not connect<br />");
	
mysqli_close($con);

//regular expressions

/*$pattern = '/ran/';
$check = 'Sue ran to the store';
if (preg_match($pattern, $check)) {
	echo 'Match found.';
}*/
$pattern = '^\D?(\d{3})\D?\D?(\d{3})\D?(\d{4})$';
$check = '1112223333';
if (preg_match($pattern, $check)) {
	echo 'Match found.';
}

//CCCOOOOOKKKIEEEESSSSS rofl
$varname = "Username";
$value = "Cookie Monster";
$expiryTime = time()+60*60*24;

echo "Cookies mixed.<br />";

unset($_COOKIE["Username"]);
 
if(!isset($_COOKIE["Username"])) {
	//no valid cookie found
	setcookie($varname, $value, $expiryTime);
	echo "Cookie is baking.";
} 
else {
	echo "The cookie is baked for you, ";
	echo $_COOKIE["Username"];
}



?>