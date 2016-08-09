<?php
$filename1 = "test.php";
$username1 = "Aaron Warner"
$value1 = 23;

$filename2 = "test2.php";
$username2 = "Juliette Ferrars"
$value2 = 32;


echo "<select>";
echo "<option value = '$value1'> $username1 ($filename1) </option>";
echo '<option value="' . $value2 . '">' . $username2 . ' (' . $filename2 . ')</option>';
echo "</select>"; 
echo "<br /> <br /> <br />";

$product = "box";
$weight = 1.23456789;

printf("The %s is %.2f pounds", $product, $weight);

echo "<br /> <br /> <br />";

echo "this program " . $filename . "worked \n";
echo "this program $filename worked, too \n";

echo "<br /> <br /> <br />";

$fahrenheit = -40;
$celsius = F2C($fahrenheit);
echo $celsius . "<br />";

function F2C($fahrenheit) {
	return ($fahrenheit - 32) / 1.8;
}

?>