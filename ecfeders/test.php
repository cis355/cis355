<?php
	$filename = "test.php";
	$username = "Jimmy Joe";
	$value = 23;
	
	$filename2 = "test2.php";
	$username2 = "Billy Bob";
	$value2 = 32;
	
	echo "<select>";
	echo "<option value = '$value'>$username ($filename)</option>";
	echo '<option value ="' . $value2 . '">' . $username2 . '(' . $filename2 . ') </option>';
	echo "</select>";
	echo "</br></br></br>"
	
	$fahrenheight = -40;
	$celsius = getCelsius($fahrenheight);
	echo $celsius . "</br>";
	
	function getCelsius(&$fahrenheight)
	{
		$celsius  = ($fahrenheight - 32) / 1.8;
		&$fahrenheight = 0;
		return $celsius;
	}
?>