<html>
<!-- comment -->
	<head>
		<title>Information from Client</title>
	</head>
	<body>
		<?php
			
			if(!empty($_POST["fahrenheit"])) {
				$celsius = (($_POST["fahrenheit"] - 32) / 1.8 );
				echo $_POST["fahrenheit"] . " Fahrenheit = " . round($celsius, 2) . " Celsius.";
			}
			
			/* Multi
			line
			comment */
			//single line comment
			# php single line comment
			
			echo "<p>This is the data from the form....</p>";
			date_default_timezone_set('UTC');
			echo date("h:i:s:u a, l F jS Y e");
			echo "<br />" . $_POST["username"] ;
			echo "<br />" . $_POST["streetAddress"] ;
			echo "<br />" . $_POST["cityAddress"] ;
			
			echo "<br /><br />";
			print_r($_POST);
			$username = $_POST["username"] ;
			extract($_POST);
			define("PI",3.1416);
			
			$a = "hey there";
			
			echo "<br />$a<br/>$username<br />$streetAddress<br />$cityAddress" . PI; 
			echo "<br />$a<br/>";
			echo "<br /><br /><br /><br />";
			
			$states = Array("Alabama", "Alaska", "Arizona", "Arkansas");
			print_r($states);
			
			echo "<br />";
			
			for($i=0; $i<sizeof($states); $i++) {
				echo "<br />" . $states[$i];
			}
			
			echo "<br />";
			
			foreach ($states as $state) {
				echo "<br />" . $state;
			}
			
			echo "<br /><br />";
			
			$states2 = Array(
				"AL" => "Alabama", 
				"AK" => "Alaska", 
				"AZ" => "Arizona", 
				"AR" => "Arkansas"
			);
			print_r($states2);
			
			echo "<br />";
			
			foreach ($states2 as $key => $value) {
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
			
			echo "<br />";
			
			foreach ($states3 as $key => $value) {
				echo "<br />" . $key;
				for($i=0; $i<sizeof($value); $i++) {
					echo " " . $value[$i] . ",";
				}
			}
			
			echo "<br /><br /><br /><br />";
			show_source(__FILE__);
		?>
	</body>
</html>