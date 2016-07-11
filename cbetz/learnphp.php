<html>

<head>
	<title>Information from Client</title>
</head>
<body>

<?php
/*
Multi
Line
Comment
*/
// single line comment
# single line comment

echo "<p>This is the data from the form...</p>";
date_default_timezone_set('UTC');
echo date("h:i:s:u a, l F js Y e");
echo "<br />" . $_POST["username"] ;
echo "<br />" . $_POST["streetaddress"] ;
echo "<br />" . $_POST["cityaddress"] ;

echo "<br /><br />";
print_r($_POST);
$username = $_POST["username"] ;
extract($_POST);

define ("PI",3.1416);
echo "<br />";
$a = "hey there";
echo "<br />$a<br />$username<br />$streetaddress<br />$cityaddress " . PI;


echo "<br /><br /><br /><br />";

$states = Array("Alabama","Alaska","Arizona","Arkansas");
print_r($states);


foreach ($states as $state) {
	echo "<br />" . $state;
}

$states2 = Array(
	"AL" => "Alabama",
	"AK" => "Alaska",
	"AZ" => "Arizona",
	"AR" => "Arkansas");
echo "<br /><br /><br /><br />";	
print_r($states2);

foreach ($states as $key => $value) {
	echo "<br />" . $key . " " . $value;
}

echo "<br /><br />";

$states3 = Array(
	"AL" => Array("Montgomery","Selme","Birmingham"),
	"AK" => Array("Juneau","Nome", "Fairbanks"),
	"AZ" => Array("Phoenix","Tempe"),
	"AR" => Array("Little Rock")
);
print_r($states3);

echo "<br /><br />";

foreach ($states3 as $key => $valuearray) {
	echo "<br />" . $key . ":";
	for($i=0; $i<sizeof($valuearray); $i++) {
		echo "<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $valuearray[$i];
	}
}



show_source(_FILE_);
?>
</body>


</html>