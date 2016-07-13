<?php
$filename1 = "test1.php";
$username1 = "Jimmy Joe";
$value1 = 23;

$filename2 = "test2.php";
$username2 = "Billy Bob";
$value2 = 32;

echo "<select>";
echo "<option value='$value1'>$username1 ($filename1)</option>";
echo '<option value="' . $value2 . '">' . $username2 . ' (' . $filename2 . ')</option>';
echo "</select>";
echo "<br /><br /><br />";

$product = "box";
$weight = 1.23456789;

printf("The %s is %.2f pounds.", $product, $weight);
echo "<br /><br /><br />";

$fahrenheit = 100;
$celsius = F2C($fahrenheit);
echo $celsius . "<br />";
echo $fahrenheit . "<br />";

function F2C(&$fahrenheit) {
	$celsius = ($fahrenheit - 32) / 1.8;
	$fahrenheit = 0;
	return $celsius;
}

?>
