<head>
	<title>Information from Client</title>
</head>
<body>

<?php

if(!empty($_POST["fahrenheit"])) {
	
}
echo $_POST["fahrenheit"] . "F = " . ((($_POST["fahrenheit"] - 32 ) * 5) / 9) . "C";
/*
Multi
Line
Comment

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
*/
show_source(_FILE_);

?>
</body>


</html>