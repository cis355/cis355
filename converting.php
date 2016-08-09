<html>
<!-- This is a comment -->
<!-- php syntax checker for code errors -->

<head>
	<title>Information from Client</title>
</head>
<body>
<?php

#if(!empty($_POST["farhenheit"]))
#	echo $_POST["farhenheit"] . "F = " . (($_POST["farhenheit"] -32) / 1.8) . "C";
#	 $temp = ($_POST[farhenheit] - 32) * 5/9;
	

echo "<p>This is the data from the form...</p>";

#echo "<br />" . $_POST["username"];
#echo "<br />" . $_POST["streetaddress"];
#echo "<br />" . $_POST["city"];

echo "<br /><br />";
print_r($_POST);
$username = $_POST["username"];
extract($_POST);

$a = "hey there";

/* echo "<br /><br />";
$states = Array(
	"AL" => "Alabama", 
	"AK" => "Alaska", 
	"AZ" => "Arizona",
	"AR" =>"Arkansas"
);
print_r($states);
echo "<br /><br />";

$states2 = Array(
	"AL" => "Alabama", 
	"AK" => "Alaska", 
	"AZ" => "Arizona",
	"AR" =>"Arkansas"
);

foreach($states3 as $key => $value) {
	echo "<br />" . $key . " " . $value;
}
echo "<br /><br />";

$states3 = Array(
	"AL" => Array("Montgomery", "Selma", "Birmingham"),
	"AK" => Array("Juneau", "Nome", "Fairbanks"), 
	"AZ" => Array("Phoenix", "Tempe"),
	"AR" =>"Arkansas"

	foreach($states3 as $key => $value) {
		foreach($states3 as $key => $value) {
	echo "<br />" . $key . " " . $value;
}
	echo "<br />" . $key . " " . $value;
}
 */
#echo <br />$a<br />$username<br /> $temp<br />$streetaddress<br />$cityaddress";
?>
</body>
</html>
