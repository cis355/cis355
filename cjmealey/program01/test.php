<?php

define('DBHOST', 'localhost');
define('DBNAME', 'cjmealey');
define('DBUSER', 'cjmealey');
define('DBPASS', '564667');

$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
// mysqli_connect_error returns string description of the last
// connect error
$error = mysqli_connect_error();
if ($error != null) {
$output = "<p>Unable to connect to database<p>" . $error;
// Outputs a message and terminates the current script
exit($output);
}
else {
	echo "<p>Connected</p>";
}

$sql = "SELECT * FROM customers ORDER BY name";
// returns a mysqli_result object
$result = mysqli_query($connection, $sql);
// run the query
if ($result = mysqli_query($connection, $sql)) {
	// fetch a record from result set into an associative array
	while($row = mysqli_fetch_assoc($result))
	{
		// the keys match the field names from the table
		echo $row['id'] . " - " . $row['name'] . " - " . $row['email'];
		echo "<br/>";
	}
}

$sql = "INSERT INTO customers (name, email) VALUES ('Franken', 'frank@frank.com')";
$connection->query($sql);

show_source(__FILE__);

?>