<html>
	<head>
		<title>
			Information from Client
		</title>
	</head>
	<body>
		<!-- All PHP goes in here-->
		<?php
		
			/* comment*/
			// line comment
			# or this for line comment
			
			if (!empty($_POST["fahrenheit"])) {
				$fahrenheit = $_POST["fahrenheit"] ;
				$celsius = ($fahrenheit - 32) * (5/9) ;
				
			} ;
			
			echo "<p>This is the data from the form...</p>";
			date_default_timezone_set('UTC');
			echo date("h:i:s:u a, l F jS Y e");
			// use . to concatenate strings
			// $_POST is accessing variables posted by html form
			echo "<br />" . $_POST["username"];
			echo "<br />" . $_POST["streetaddress"];
			echo "<br />" . $_POST["cityaddress"];
			echo "<br /> Degrees Fahrenheit: " . $fahrenheit;
			echo "<br /> Degrees Celsius: " . $celsius ;
			echo "<br />";
			print_r($_POST);
			
			
			//Two ways to get variables from post into our variables:
			//Favorable way:
			$username = $_POST["username"] ;
			$streetaddress = $_POST["streetaddress"] ;
			$cityaddress = $_POST["cityaddress"] ;
			//Or the Easy way:
			//extract($_POST);
			
			define("PI",3.1415926);
			$a = "hello"; // Declare variables
			
			#echo "<br />$username<br />$streetaddress<br />$cityaddress";
			
			
			echo "<br /><br /><br /><br />" ;
			
			print_r ($states);
			$states2 = Array(
				"AL" => "Alabama",
				"AK" => "Alaska",
				"AZ" => "Arizona",
				"AR" => "Arkansas"
			) ;
			$states = Array("Alabama","Alaska","Arizona","Arkansas") ;
			for each ($states as $value) {
				echo "<br />" . $value ;
				
			};
			/*
			for each($states2 as $key => $value) {
				echo "<br />" . $key . " " . $value ;
			} ;
			
			for($i=0; $i<4; $i++) {
				echo "<br />" . $states[$i];
			} ;
			*/
		?>
	</body>
</html>