<?php
$filename1 = "test1.php";
$username1 = "Jimmy Joe";
$value1 = 23;

$filename2 = "test2.php";
$username2 = "Billy Bob";
$value2 = 32;

echo "<select>";
echo "<option value='$value'>$username1 ($filename1)</option>";
echo '<option value="'.$value2 . '">' . $username2 . '(' . $filename2 . ')</option>';

echo "</select> <br>";

$product = "box";
$weight = 1.23456789;

printf("The %s is %.2f pounds", $product, $weight);

$fahrenheit = -0;
$celsius = f2c($fahrenheit);

echo "<br>" . $celsius . "<br>";


function f2c($fahrenheit){
		return ($fahrenheit - 32) / 1.8;
}

?>

