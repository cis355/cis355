<html>
<!-- comment-->
	<head>
		<title>Information from Client</title>
	</head>
	<body>
		<?php
			/*
			line
			line
			*/
			//comment--
			# comment--
			
			if(isset($_POST["farenheight"])) {
				$far = $_POST["farenheight"];
				echo round((($far - 32) / 1.8), 2);
			}
			
			echo "<p>This is the data from the form</p>";
			date_default_timezone_set('UTC');
			echo date("h:i:s:u a, l F jS Y e");
			echo "This is a quotation Mark \" These words are in quotes 'hello world'";
			echo "<br />" . $_POST["username"] . "<br />";
			echo "<br />" . $_POST["streetaddress"] . "<br />";
			echo "<br />" . $_POST["cityaddress"] . "<br />" ;
			
			echo "<br />";
			print_r($_POST);
			$username = $_POST["username"];
			extract($_POST);
			define("PI",3.1416);
			echo "<br />$a<br />$username <br />$streetaddress<br/ >$cityaddress" . PI;
			
			#show_source(__FILE__);
			
			echo "<br />";
			echo "<br />";
			echo "<br />";
			echo "<br />";
			
			$states = Array("Alabama","Alaska","Arizona","Arkansas","California");
			print_r($states);
			
			foreach ($states as $state) {
				echo "<br />" . $state;
			}
						
			$states2 = Array(
			"AL" => Array("Montgomary","Selma","Birminghim"),
			"AK" => Array("AK1","AK2","AK3"),
			"AZ" => Array("AZ1","AZ2","AZ3"),
			"AR" => Array("AR1","AR2","AR3"),
			);
			
			print_r ($states2);
			
			foreach ($states2 as $key => $valuearray) {
				echo "<br />" . $key; 
				foreach ($valuearray as $city){
					echo "<br />" . $city;
				}
			}
			
			for ($i=0; $i<4; $i++) {
				echo "<br />" . $states[$i]; 
			}
			
		?>
	</body>
</html>