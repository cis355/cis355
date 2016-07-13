<?php
	
	session_start();
	if (empty($_SESSION['name'])) header("Location: login.php");
	
	$filename1 = "test.php";
	$username1 = "Jimmy Joe";
	$value1 = 23;
	
	$filename2 = "test2.php";
	$username2 = "Billy Bob";
	$value2 = 32;
	
	# Jimmy Joe (test1.php)
	echo "<select>";
	echo "<option value='$value1'>$username1 ($filename1)</option>";
	echo '<option value=' . $value2 . '">' . $username2 . ' (' . $filename2 . ')</option>';
	echo "</select>";
	
	#echo "this program " . filename1 . "worked  \n";
	#echo "this program $filename2 worked, too  \n";
	
?>