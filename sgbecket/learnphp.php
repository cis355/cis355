 <html> 
<!-- This is a comment --> 
<head> 
    <title>Information from Client</title> 
</head> 
<body> 
<?php 

if(!empty($_POST["farhenheit"])) { 
    echo $_POST["farhenheit"] . "F = " . (($_POST["farhenheit"] - 32 ) / 1.8) . "C"; 
} 

$b =50;
$c = &$b;
$b += 5;
echo "<br>" . $c;
$c += 5;

echo "br>" . $b;
/* 
Multi 
line 
comment  
*/ 
// single line comment 
# single line comment 

echo "<p>This is the data from the form...</p>"; 
date_default_timezone_set('UTC'); 
echo date("h:i:s:u a, l F jS Y e"); 
echo "This is a quotation mark \" These word are in quotes 'hello world'"; 
echo "<br />" . $_POST["username"] ; 
echo "<br />" . $_POST["streetaddress"] ; 
echo "<br />" . $_POST["cityaddress"] ; 

echo "<br /><br />"; 
print_r($_POST); 
$username = $_POST["username"] ; 
extract($_POST); 
define ("PI",3.1416); 
$a = "hey there"; 
echo "<br />$a<br />$username<br />$streetaddress<br />$cityaddress " . PI  . "<br>"; 

$states = Array("Alabama", "Alaska", "Arizona", "Arkansas");
print_r($states);

for($i=0; $i<sizeof($states); $i++){
	echo "<br>" . $states[$i];
}

foreach($states as $state){
	echo "<br>" . $state;

}
$states2 = Array(
"AL" =>"Alabama",
 "AK" => "Alaska", 
"AZ" => "Arizona", 
 "AR" =>"Arkansas");


echo"<br>";
print_r($states2);

foreach ($states2 as $key => $value) {
	echo "<br>" . $key . " " . $value;
}
echo "<br> <br> <br>";
$states3 = Array(
"AL" => Array("Montgomery", "Selma", "Birmingham"),
"AK" => Array("Jeneau", "Nome", "Fairbanks"), 
"AZ" => Array("Phoenix", "Tempe"), 
"AR" =>Array("Little Rock"));

print_r($states3);

foreach($states3 as $key => $value){
	echo "<br>" . $key. ":" ;
	for($i=0; $i<sizeof($value); $i++){
		echo "<br> &nbsp &nbsp &nbsp &nbsp" . $value[$i];
}
}
?> 

</body> 
</html> 