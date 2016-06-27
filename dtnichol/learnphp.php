<html>

<head>
	<title>Information from Client</title>
<head>
<body>

<?php

if(!empty($_POST["fahrenheit"])){
	echo $_POST["fahrenheit"] . "F = " . (($_POST["fahrenheit"] - 32) / 1.8) . "C";
	

	
}

// reference variable
$b = 50;
$c = &$b;
$b += 5;
echo "<br />" . $c;

#single line comment
//single line comment
/*multi line
comments
*/

echo "<p>This is the data from the form...</p>";
date_default_timezone_set('UTC');
echo date("h:i:s:u a, l F jS Y e");
echo "<br />" . $_POST["username"];
echo "<br />" . $_POST["streetaddress"];
echo "<br />" . $_POST["cityaddress"];

echo "<br ?><br />";
print_r($_POST);
$username = $_POST["username"];
extract($_POST);
define ("PI",3.1416);


$a = "hey there";
echo "<br />$a<br />$username<br />$streetaddress<br />$cityaddress " . PI;

echo "<br /><br /><br /><br />";

$states = Array("Alabama", "Alaska", "Arizona", "Arkansas");
print_r ($states);

for($i=0; $i<sizeof($states); $i++){
	echo "<br />" . $states[$i];
}

foreach ($states as $state) {
	echo "<br />" . $state;
	
}

echo "<br /><br />";
foreach ($states as $key => $value) {
	echo "<br />" . $key . " " . $value;
	
}



echo "<br /><br />";
$states2 = Array(
	"AL" => "Alabama", 
	"AK" => "Alaska", 
	"AZ" => "Arizona", 
	"AR" => "Arkansas"
);
print_r ($states2);

echo "<br /><br />"; 
foreach ($states2 as $key => $value) { 
    echo "<br />" . $key . " " . $value; 
} 
echo "<br /><br />"; 
$states3 = Array( 
    "AL" => Array("Montgomery","Selma","Birmingham"), 
    "AK" => Array("Juneau","Nome","Fairbanks"), 
    "AZ" => Array("Phoenix","Tempe","Scottsdale","Flagstaff"), 
    "AR" => Array("Little Rock") 
); 
print_r($states3); 

//print element of 2D array
 foreach ($states3 as $key => $valuearray){
	 echo "<br />" . $key . ":";
	 
	 for($i=0; $i<sizeof($valuearray); $i++){
		 echo "<br />&nbsp;&nbsp;&nbsp;" . $valuearray[$i];
	 }
	 
 }


echo "<br /><br /><br /><br />";

show_source(__FILE__);
?>

</body>
</html>