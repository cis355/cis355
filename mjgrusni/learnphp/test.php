<?php

$filename1 = "test.php";
$username1 = "Jimmy Joe";
$value1 = 23;

$filename2 = "test2.php";
$username2 = "Billy Bob";
$value2 = 32;

echo "<select>";
echo "<option value='value1'>$username1 ($filename1)</option>";
echo '<option value="' .$value2 . '">' . $username2 . ' (' . $filename2 . ')</option>';
echo "</select>";

echo "<br /><br /><br />";

$product = "box";
$weight = 1.23456789;

printf("The %s is %.2f pounds\n", $product, $weight);

echo "<br /><br /><br />";

echo "thisprogram " . $filename . " worked \n";
echo "this program $filename worked too \n";
#SINGLE QUOTES DON'T WORK echo 'this program $filename worked too \n';
echo "<div margin='250'> \n";
echo '<div margin="250"> \n';

echo "<br /><br /><br />";

$fahrenheit = 212;
$celsius = toCelsius($fahrenheit);
echo $celsius . "<br />";
echo $fahrenheit . "<br />";

function toCelsius(&$fahrenheit){
	$celsius = ($fahrenheit - 32) / 1.8;
	$fahrenheit = 0;
	return $celsius;
}

?>