<?php 

define('DBHOST', 'localhost'); 
define('DBNAME', 'sbbromun'); 
define('DBUSER', 'sbbromun'); 
define('DBPASS', '592880'); 

$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME); 
// mysqli_connect_error returns string description of the last 
// connect error 
$error = mysqli_connect_error(); 
if ($error != null) { 
    $output = "<p>Unable to connect to database<p>" . $error; 
    // Outputs a message and terminates the current script 
    exit($output); 
} else  {
	echo "<p>connected</p>";
}

$sql = "SELECT * FROM customers ORDER BY name";
$result = mysqli_query($connection, $sql);
var_dump ($result);
if($result = mysqli_query($connection, $sql)) {
	while($row = mysqli_fetch_assoc($result)){
	echo $row['id'] . " - " . $row['name'];
	echo "<br />";
	}
}

$sql = "INSERT INTO customers (name, email) VALUES ('Frank', 'Frank@frank.com')";
//$connection->query($sql);

?>