<?php
class Artist {
	public static $artistCount = 0;
	public	$firstName;
	public	$lastName;
	public	$birthCity;
	public	$birthDate;
	public	$deathDate;

	function __construct($firstName, $lastName, $birthCity, $birthDate, $deathDate=null) {
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->birthCity = $birthCity;
		$this->birthDate = $birthDate;
		$this->deathDate = $deathDate;
		self::$artistCount++;
	}
	
	public function __toString() {
		return $this->firstName . " " . $this->lastName . ", " . $this->birthCity .
		", " . $this->birthDate . ", " . $this->deathDate . '</br>';
	}
	
	public function outputAsTable() {
		$table = "<table>";
		$table .= "<tr><th colspan='2'>";
		$table .= "<u>" . $this->firstName . " " . $this->lastName . "</u>";
		$table .= "</th></tr>";
		$table .= "<tr><td>Birth:</td>";
		$table .= "<td>" . $this->birthDate;
		$table .= " (" . $this->birthCity . ")</td></tr>";
		$table .= "<tr><td>Death:</td>";
		$table .= "<td>" . $this->deathDate . "</td></tr>";
		$table .= "</table></br>";
		return $table;
	}
}

/*
$picasso = new Artist();
$picasso->firstName = "Pablo";
$picasso->lastName = "Picasso";
$picasso->birthCity = "Malaga";
$picasso->birthDate = "October 25 1881";
$picasso->deathDate = "April 8 1973";
*/

#$dali = new Artist();
$picasso = new Artist("Pablo", "Picasso", "Malaga", "October 25, 1881", "April 8, 1973");
$dali = new Artist("Salvador", "Dali", "Figures", "May 11, 1904", "January 23, 1989");

echo $picasso->outputAsTable();
echo $dali->outputAsTable();

#--------------------------------------------------------------------------------
echo "------------------------------------ </br></br>";

#Forces you to use the contained functions.
abstract class Animal {
	
	protected $name;
	
	abstract function vocalize();
	abstract function run();
	}

#Implements part is unnecessary I believe.
class Dog extends Animal implements Eat {
	
	#private $name;
	
	function vocalize() {
		echo $this->name . " says bow wow. </br>";
	}
	
	function run() {
		echo $this->name . " runs fast. </br>";
	}
	
	function eat() {
		echo $this->name . " chews on a bone. </br>";
	}
	
	public function getName() {
	return $this->name;
	}
	
	function __construct ($name) {
		$this->name = $name;
	}
}

class Eliphant extends Animal implements Eat {
	#private $name;
	
	function vocalize() {
		echo $this->name . " makes a trumpet sound. </br>";
	}
	
	function run() {
		echo $this->name . " goes boom...boom... </br>";
	}
	
	function eat() {
		echo $this->name . " eats peanuts. </br>";
	}
	
	public function getName() {
	return $this->name;
	}
	
	function __construct ($name) {
		$this->name = $name;
	}
}

interface Eat {
	public function eat();
}


$fido = new Dog ("Fido");
$fido->vocalize();
$fido->run();
$fido->eat();

echo "</br>";

$topsy = new Eliphant ("Topsy");
$topsy->vocalize();
$topsy->run();
$topsy->eat();

?>