<html>
<!-- This is a comment -->
<!-- php syntax checker for code errors -->

<head>
	<title>Information from Client</title>
</head>
<body>
<?php

/*
Multi
line
comment
*/

//single line comment
# single line comment

echo "<p>This is the data from the form...</p>";
date_default_timezone_set('UTC');
echo date("h:i:s:u a, l F js Y e");
echo "This is a quotation mark \" These word are in quotes
'hello world'";

echo "<br />" . $_POST["username"];
echo "<br />" . $_POST["streetaddress"];
echo "<br />" . $_POST["city"];

echo "<br /><br />";
print_r($_POST);
$username = $_POST["username"];
extract($_POST);
define("PI", 3.1.16);

$a - "hey there";

echo <br />$a<br />$username<br />$streetaddress<br />$cityaddress";
?>
</body>
</html>
