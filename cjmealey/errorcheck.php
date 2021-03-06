<?php 

// ----- set error reporting for testing phase of development ----- 

// error_reporting(E_ALL); 
// ini_set('display_errors','1');  

// ----- Compare isset() with empty() ---- 

$name = -1; 
$name2 = 2; 

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

$name4 = 4; 
if (isset($name4)) echo "name4 is set <br />"; 
else echo "name4 is not set <br />"; 
unset($name4); 
if (isset($name4)) echo "name4 is set <br />"; 
else echo "name4 is not set <br />"; 







// ----- perform error checking on database connection ----- 

$con = mysqli_connect('localhost', 'gpcorser', 'forget', 'gpcorser'); // wrong password 

$error = mysqli_connect_error(); 
if ($error != NULL) echo "not connected<br />"; 
else echo "connected<br />"; 

mysqli_close($con); 

echo "hello <br />"; 








// ----- perform error checking on database connection using try/catch/finally ----- 

function throwException($message = null,$code = null) { 
    throw new Exception($message,$code); 
} 

try { 
    $con = mysqli_connect('localhost', 'gpcorser', 'forgot', 'gpcorser')  
        or throwException("could not connect<br />"); 
} catch (Exception $e){ 
    echo " *** not connected *** <br />"; 
    echo $e->getMessage(); 
    var_dump($e); 
} finally { 
    echo "finally<br />"; 
} 

mysqli_close($con); 







// ----- perform error checking on database connection using exception handler ----- 

echo "start exception handler code <br />";  

function exception_handler($exception) { 
  echo "Uncaught exception: " , $exception->getMessage(), "<br />"; 
} 

set_exception_handler('exception_handler'); 









//throw new Exception('exceptThis!'); 
echo "Not Executed<br /><br /><br />"; // will not execute if exception is thrown 

mysqli_close($con); 










// ----- regular experessions ----- 

echo " *** BEGIN REGEX *** <br /><br />"; 

function phpreg ($pattern, $check) { 
    if ( preg_match($pattern, $check) ) { echo 'Match found!  ' . $pattern . " " . $check ."<br />"; }  
    else { echo "Match not found!  " . $pattern. " " . $check . "<br />";} 
} 

$pattern = '/ran/'; // substring 
$check = 'Sue ran to the store';  
phpreg($pattern, $check); // match 
$pattern = '/^ran$/';  
phpreg($pattern, $check); // not a match 
$check = 'ran';  
phpreg($pattern, $check); 
$pattern = '/[a-m]/'; 
phpreg($pattern, $check); 
$check = 'rqn'; 
phpreg($pattern, $check); 
$pattern = '/^[0-9]$/'; 
$pattern = '/\d{2}/';
$check = '33'; 
phpreg($pattern, $check);

$check = '989 559-8989';
$pattern = '/((\(\d{3}\) ?)|(\d{3}-))?\d{3}-\d{4}/';
phpreg($pattern, $check);


echo "<br/><br/><br/><br/>";







// COOKIE STUFF 

$varname = "Username";
$value = "Ricardo";
$expiryTime = time()+60*60*24;


if(!isset($_COOKIE["Username"])) {
	//Valid cookie found
	setcookie($varname, $value, $expiryTime);
	echo "cookie was set";	
}
else{
	echo "The value retrieved from the cookie list<br>";
	echo "Welcome Back, " . $_COOKIE["Username"] . "!";
}





?>