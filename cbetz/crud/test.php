<?php>

$fahrenheit = 212;
$celsius = F2C($fahrenheit);
echo $celsius . "<br />";

function ($fahrenheit) {
	return ($fahrenheit -32) / 1.8;
}


?>