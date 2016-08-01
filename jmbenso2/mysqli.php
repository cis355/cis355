<?php 

define('DBHOST', 'localhost'); 
define('DBNAME', 'jmbenso2'); 
define('DBUSER', 'jmbenso2'); 
define('DBPASS', '540550'); 

$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME); 
// mysqli_connect_error returns string description of the last 
// connect error 
$error = mysqli_connect_error(); 
if ($error != null) { 
    $output = "<p>Unable to connect to database<p>" . $error; 
    exit($output); 
} else { 
    echo "<p>connected!</p>"; 
} 

show_source(__FILE__); 
?>