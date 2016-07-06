<head> 
    <title>Information from Client</title> 
</head> 
<body> 
	<?php 
		if(!empty($_POST["farhenheit"])) { 
			echo $_POST["farhenheit"] . "F = " . (($_POST["farhenheit"] - 32 ) / 1.8) . "C"; 
		} 
		
		$b = 50; 
		$c = &$b; 
		$b += 5; 
		echo "<br />" . $c; 
		$c += 5;
		echo "<br />" . $c; 
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
		echo "<br / >";
		echo "<br />UserName = " . $_POST["username"] ; 
		echo "<br /> Street Address = " . $_POST["streetaddress"] ; 
		echo "<br /> City = " . $_POST["cityaddress"] ; 
		echo "<br / ><br / >";

		define ("PI",3.1416); 
		$a = "hey there"; 
		echo "$a PI = " . PI; 
		echo "<br / ><br / >";
		
		$states = Array("Alabama","Alaska","Arizona","Michigan"); 
		print_r ($states); 
		
		echo "<br / ><br / >";
		
		$states2 = Array(
		"AL" => "Alabama",
		"AK" => "Alaska",
		"AZ" => "Arizona",
		"MI" => "Michigan"); 
		print_r ($states2); 
		
		echo "<br / >";
		
		foreach($states as $state) {
			echo "<br />" . "$state";
		}
		
		echo "<br / > <br / >";
		$states3 = Array( 
			"AL" => Array("Montgomery","Selma","Birmingham"), 
			"AK" => Array("Juneau","Nome","Fairbanks"), 
			"AZ" => Array("Phoenix","Tempe"), 
			"AR" => Array("Little Rock") 
		); 
		print_r($states3); 
		echo "<br / > <br / >";
		// print elements of 2d array  
		foreach ($states3 as $key => $valuearray) { 
		echo "<br />" . $key . ":"; 
		for($i=0; $i<sizeof($valuearray); $i++) { 
			echo "<br />&nbsp;&nbsp;&nbsp;" . $valuearray[$i]; 
		} 
} 
		echo "<br / > <br / >";
		
		foreach ($states2 as $key => $value) { 
			echo "<br />" . $key . " " . $value;
		} 
		
		echo "<br / > <br / >";
		
		show_source(__FILE__); 
	?> 

</body> 
</html> 