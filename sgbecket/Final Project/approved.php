<!--
/* *******************************************************************
* filename : approved.php
* author : Gage Beckett
* username : sgbecket
* course : CIS355
* section : 11-MW
* semester : Summer 2016
*
* description : code to run if the approved button is clicked that will submit from the
* usersub.php file
*
* input : autoruns the usersub.php variables that are passed
* output : submits to the anime database the values that are passed from the usersub
*
* precondition : usersub is filled out and valid
* postcondition: none
* *******************************************************************-->

<?php
class Approved{
	private function connect(){
			$c = mysqli_connect("localhost","sgbecket","42BeckettSG","sgbecket");
			if (mysqli_connect_errno())
			{
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
			else{return $c;}
	}
	function approve(){
		$name=$_GET['name'];
		$genre=$_GET['genre'];
		$period=$_GET['period'];
		$style=$_GET['style'];
		
		$sql = "INSERT INTO `sgbecket`.`anime` (`name`, `genre`,`period`, `style`) VALUES ('$name', '$genre','$period', '$style');";
		
		$con=$this->connect();
		$con->query($sql);

		$sql = "DELETE FROM `user submission` WHERE name = '$name'";
		$con->query($sql);
		$con->close();
		
		header("Location: anime.php");
	}
}
$approve = new Approved;
$approve->approve();
?>