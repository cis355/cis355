

<html>
	<head>
		<title>Info from client</title>
	</head>
	<body>
		<?php
			//$username = $_POST['username'];
			//$streetaddress = $_POST['streetaddress'];
			//$cityaddress = $_POST['cityaddress'];
			extract($_POST);
			echo("<p>This is the data from the form</p>");
			date_default_timezone_set('UTC');
			echo date("h:i:s:u a, l F jS Y e");
			echo("<p>Hello ".$username." In: ".$streetaddress." City: ".$cityaddress."</p>");
			
			$states = Array("Alabama","Alaska","Arizons","Arkansas");
			echo "<br/><br/>";
			foreach($states as $state)
				echo($state . "<br/>");
				
			$states2 = Array(
				"AL" => "Alabama",
				"AK" => "Alaska",
				"AZ" => "Arizons",
				"AR" => "Arkansas"
			);

			echo "<br/><br/>";
			
			foreach($states2 as $short => $state)
				echo($short . " -> " .$state . "<br/>");
				
			echo "<br/><br/>";
			
			$states3 = Array(
				"AL" => Array("CityAL1","CityAL2","CityAL3"),
				"AK" => Array("CityAK1","CityAK2","CityAK3"),
				"AZ" => Array("CityAZ1","CityAZ2","CityAZ3"),
				"AR" => Array("CityAR1","CityAR2","CityAR3")
			);
			echo "<br/><br/>";
			foreach($states3 as $short => $state)
			{
				foreach($state as $city)
					echo($short . " " . $city . "<br/>");
			}
		?>
	</body>
</html>