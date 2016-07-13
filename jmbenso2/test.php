<?php 

function fToC($f) {
	$c = (($f-32) * 5/9);
	$f = 0;
	return $c;
	}

echo "<p>" . fToC(80) . "</p>";

$filename1 = "test.php";
$username1 = "Bob Costas";
$value1 = 23;

$filename2 = "test2.php";
$username2 = "Matt Lauer";
$value2 = 95;

echo "<select>";
echo "<option value='$value1'> $username1 ($filename1) </option>";
echo '<option value="' . $value2 . '"> ' . $username2 . '(' . $filename2 . ') </option>';
echo "</select>";

echo "this program " . $filename . "worked \n";
echo "this program $filename worked too \n";


?>