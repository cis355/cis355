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
    $con = mysqli_connect('localhost', 'gpcorser', 'forget', 'gpcorser')  
        or throwException("could not connect<br />"); 
} catch (Exception $e){ 
    echo " *** not connected *** <br />"; 
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

throw new Exception('exceptThis!');
echo "Not Executed<br />"; 
mysqli_close($con);


// $con = mysqli_connect('localhost', 'gpcorser', 'forget', 'gpcorser')  
    // or throwException("could not connect<br />"); 
         
// mysqli_close($con); 

// ----REGULAR EXPRESSION -------
echo " *** Begin REGEX *** <br /><br />";

function phpreg ($pattern, $check) {
	if (preg_match($pattern, $check) ) {
	echo 'Match Found!<br />';
	}else {echo 'Not found.'}
}

$pattern = '/ran/';
$check = 'Sue ran to the store';
phpreg($pattern, $check);
$pattern = '/^ran$';
phpreg($pattern, $check);
$check = 'ran';
phpreg($pattern, $check);
$pattern = '/[a-m]/';
phpreg($patern, $check);
$check='(989)998-8989';
$pattern='/(\(\d{3}\))\d{3}-\d{4}/';
phpreg($patern, $check);



// ----- set cookie ----- 

$name = "Username"; 
$value = "Ricardo"; 
$expiryTime = time()+60*60*24; 

echo "hello"; 

if( !isset($_COOKIE["Username"]) ) { 
    //no valid cookie found 
    setcookie($name, $value, $expiryTime); 
    echo "cookie was set"; 
} 
else { 
    echo "The value retrieved from the cookie is:"; 
    echo $_COOKIE["Username"]; 
} 
?>