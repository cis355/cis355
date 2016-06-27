<html>
<!-- COMMENTS -->
<head>
	<title>Information from Client</title>
</head>
<body>
	<?php
	if(!empty($_POST["farenheit"])) {
		$celsius = (($_POST['farenheit'] - 32) / 1.8) ;
		echo "F= " . $_POST['farenheit'] . "  C=$celsius ";
	}
	
	$b = 50;
	$c = &$b;
	$b +=5;
	echo "<br />" . $c;
	$c += 5;
	echo "<br />" . $b;

	echo "<p>This is the data from the form</p>";
	date_default_timezone_set('UTC');
	echo date("h:i:s:u a, l F js Y e");
	echo "<br />" . "This is a quotation mark \" These words are in quotes 'Hello World'";
	echo "<br />" . $_POST["username"] ;
	echo "<br />" . $_POST["streetaddress"] ;
	echo "<br />" . $_POST["cityaddress"] ;
	
	echo "<br />" ;
	print_r($_POST);
	$username = $_POST["username"] ;
	extract($_POST);
	define ("PI", 3.1415);
	
	$a = "hey there";
	echo "<br />$a<br />$username<br />$streetaddress<br />$cityaddress" . PI;
	
	echo "<br /><br />";
	
	$states = Array("Alabama","Alaska","Arizona","Arkansas");
	print_r ($states);
	echo "<br /><br />";
	for($i=0;$i<sizeof($states);$i++) {
	echo "<br />" . $states[$i];
	};
	echo "<br /><br />";

	foreach ($states as $state) {
		echo "<br />" . $state;
	};
	
	echo "<br /><br />";

	$states2 = Array(
	"AL" => "Alabama",
	"AK" => "Alaska",
	"AZ" => "Arizona",
	"AR" => "Arkansas");
	print_r ($states2);
	echo "<br /><br />";

	foreach ($states as $key => $value){
		echo "<br />" . $key . " " . $value;
	}
	echo "<br /><br />";
	$states3 = Array( 
    "AL" => Array("Montgomery","Selma","Birmingham"), 
    "AK" => Array("Juneau","Nome","Fairbanks"), 
    "AZ" => Array("Phoenix","Tempe"), 
    "AR" => Array("Little Rock") 
	); 
	print_r($states3); 
	echo "<br /><br /><br /><br />"; 
	foreach($states3 as $key => $valuearray){
		echo $key . ": ";
		foreach ($valuearray as $city){
			echo $city . ", ";
		};
	};
	show_source(__FILE__)
	?>
</body>
</html>