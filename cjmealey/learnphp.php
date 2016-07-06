<html>
	<head>
		<title>Information From Client</title>
	</head>
	<body>
		<?php
		
		if(!empty ($_POST["ftemp"])) {
			echo $_POST["ftemp"] . " F = " . (($_POST["ftemp"] - 32 ) / 1.8) . " C" ; 
		}
		if(!empty ($_POST["ctemp"])) {
			echo $_POST["ctemp"] . " C = " . (($_POST["ctemp"] * 1.8) + 32 ) . " F" ; 
		}
		
		$b = 50;
		$c = &$b;
		$b += 5;
		echo "<br />" . $c;
		$c += 5;
		echo "<br />" . $b;
		/* 
		MULTI
		LINE
		COMMENT
		*/
		// single line comment method no.1
		# single line method no.2
		
		echo "<p>This is the data from the form...</p>";
		date_default_timezone_set('UTC');
		echo date("h:i:s:u a, l F jS Y e");
		# used post method, so must output variables created in post
		echo "<br />" . $_POST["username"] ;
		echo "<br />" . $_POST["streetaddress"] ;
		echo "<br />" . $_POST["cityaddress"] ;
		
		echo "<br />";
		$username = $_POST["username"] ; 
		extract($_POST);
		define ("PI", 3.1416);
		$a = "hey there";
		echo "<br />$username<br />$streetaddress<br />$cityaddress" . PI;
		
		$states = Array("Alabama", "Alaska", "Arizona", "Arkansas");
		print_r ($states);
		
		// FOR LOOP
			echo "<br /><br />Traditional For Loop: ";
			for($i = 0; $i<sizeof($states); $i++){
				echo "<br />" . $states[$i];
			}
			echo "<br />";
		// END FOR LOOP
		
		//FOREACH METHOD
			echo "<br /><br />Foreach method: ";
			foreach ($states as $state) {
				echo "<br />" . $state;
			}
			echo "<br />";
		// END FOREACH METHOD
		
		$states2 = Array
			(
				"AL" => "Alabama",
				"AK" => "Alaska", 
				"AZ" => "Arizona", 
				"AR" => "Arkansas"
			);
		echo ("<br />");
		print_r ($states2);
		
		$states3 = Array
			(
				"AL" => Array("Montgomery", "Selma", "Birmingham"),
				"AK" => Array("Juneau", "Nome", "Fairbanks"),
				"AZ" => Array("Phoenix", "Tempe"),
				"AR" => Array("Little Rock")
			);
		echo ("<br />");
		print_r ($states3);
		
		echo "<br /><br />ATTEMPT TO PRINT: ";
		foreach ($states3 as $key => $valuearray) {
			echo "<br/>" . $key . ":";
			for($i=0;$i<sizeof($valuearray);$i++){
				echo "<br />&nbsp;&nbsp;" . $valuearray[$i];
			}
		}
		echo "<br />";
			
			
		# show_source(__FILE__);
		
		?>
	</body>
</html>
