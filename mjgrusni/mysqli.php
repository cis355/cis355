<?php 

define('DBHOST', 'localhost'); 
define('DBNAME', 'mjgrusni'); 
define('DBUSER', 'mjgrusni'); 
define('DBPASS', '582117'); 

$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME); 
// mysqli_connect_error returns string description of the last 
// connect error 
$error = mysqli_connect_error(); 
if ($error != null) { 
    $output = "<p>Unable to connect to database<p>" . $error; 
    // Outputs a message and terminates the current script 
    exit($output); 
} else { 
    echo "<p>connected!</p>"; 
} 

$sql = "SELECT * FROM `customers` ORDER BY name";

$result = mysqli_query($connection, $sql);
var_dump ($result);

// run the query
if ($result = mysqli_query($connection, $sql)) {
// fetch a record from result set into an associative array
	while($row = mysqli_fetch_assoc($result)){
		// the keys match the field names from the table
		echo $row['id'] . " - " . $row['name'] . " - " . $row['email'] ;
		echo "<br/>";
	}
}

//insert
$sql_insert = "INSERT INTO `customers` (name, email) VALUES ('Frank', 'a@b.com')";
$connection->query($sql_insert);




show_source(__FILE__); 
?>