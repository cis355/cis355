<?php
$filename1 = "test.php";
$username1 = "John Doe";
$value1 = 23;

$filename2 = "test2.php";
$username2 = "billy bob";
$value2 = 32;

echo "<select>";
echo "<option value=" . $value1 . ">" . $username1. " (". $filename1 .") </option>";
echo "<option value=" . $value2 . ">" . $username2. " (". $filename2 .") </option>";

function printStuff() {
	
	echo "<p> i am a function call</p>";
	echo "<p> your wish has been granted</p>";
}


echo "</select>";
printStuff();



?>