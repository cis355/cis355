<?php
/*
const EARLIEST_DATE = 'January 1 1200';
class Artist {
	
	public static $artistCount = 0;
	public $firstName;
	public $lastName;
	public $birthDate;
	public $birthCity;
	public $deathDate;
	
	function __construct($firstName, $lastName, $city, $birth=EARLIEST_DATE, $death=null) {
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->birthCity = $city;
		$this->birthDate = $birth;
		$this->deathDate = $death;
		self::$artistCount++;
	}
	
	public function __toString() {
		return $this->firstName . " " . $this->lastName . " (" . $this->birthcity . ", " . $this->birthDate . " -" . $this->deathDate . " )<br />";
	}
	
	public function outputAsTable() {
		$table = "<table>";
		$table .= "<tr><th colspan='2'>";
		$table .= $this->firstName . " " . $this->lastName;
		$table .= "</th></tr>";
		$table .= "<tr><td>Birth:</td>";
		$table .= "<td>" . $this->birthDate;
		$table .= " (" . $this->birthCity . ")</td></tr>";
		$table .= "<tr><td style='color:red'>Death:</td>";
		$table .= "<td>" . $this->deathDate . "</td></tr>";
		$table .= "</table>";
		return $table;
		
	function __construct($firstName, $lastName, $city, $birth,
		$death=null) {
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->birthCity = $city;
		$this->birthDate = $birth;
		$this->deathDate = $death;
		self::$artistCount++;
 }
		
		
 }
	
}


$picasso->firstName = "Pablo";
$picasso->lastName = "Picasso";
$picasso->birthCity = "Malaga";
$picasso->birthDate = "October 25 1881";
$picasso->deathDate = "April 8 1973";


$dali = new Artist("Salvador","Dali","Figures","May 11 1904",
 "Jan 23 1989");

$picasso = new Artist("Pablo","Picasso","Malaga","Oct 25 1881",
 "Apr 8 1973");
 
$colin = new Artist("Colin","Mealey","Saginaw");
 
echo $colin; 
echo $picasso;
echo $dali;
echo "<br />";
echo $colin->outputAsTable(); 
*/

abstract class Animal {
	
	abstract function vocalize ();
	abstract function run ();
	
	public function getName() {
		return $this->name
	}
	
}
 
class Dog extends Animal {
	
	private $name;
	
	function vocalize() {
		echo "Bow wow";
	}
	
	function run() {
		echo "Zoom";
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function setName($n) {
		$this->name = $n;
	}
	
	function__construct ($n) {
		setName($n);
	}
}


 
class Elephant extends Animal {
	function vocalize() {
		echo "Trumpet";
	}
	
	function run() {
		echo "Boom... Boom...";
	}
}

$fido = new Dog ("Fido");
$fido->vocalize();
$fido->run();
 
?>