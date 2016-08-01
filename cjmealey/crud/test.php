<?php

$filename1 = "test1.php";
$username1 = "Jimmy Joe";
$value1 = 23;

$filename2 = "test2.php";
$username2 = "Billy Bob";
$value2 = 32;

echo "<select>";
echo "<option value='$value1'>$username1 ($filename1)</option>";
echo '<option value=' . $value2 . '>' . $username2 . ' (' . $filename2 . ')</option>';
echo "</select><br /><br /><br />";

$product = "box";
$weight = 1.2345689;
printf("This %s is %.2f pounds", $product, $weight);

echo "<br /><br /><br />";
$fahr = 32;
$cels = FtC($fahr);
echo $cels . "<br />";
echo $fahr . "<br />";

function FtC(&$fahr) {
	$cels = ($fahr - 32) / 1.8;
	$fahr = 0;
	return $cels;
}


?>

