<?php
//const EARLIEST_DATE = 'January 1 1200';
//class Artist {
//
//	public static $artistCount = 0;
//	public $firstName;
//	public $lastName;
//	private $birthDate;
//	public $birthCity;
//	public $deathDate;
//	
//	function __construct($firstName, $lastName, $city, $birth = EARLIEST_DATE, $death=null) {
//		$this->firstName = $firstName;
//		$this->lastName = $lastName;
//		$this->birthCity = $city;
//		$this->birthDate = $birth;
//		$this->deathDate = $death;
//		self::$artistCount++;
//	}
//	public function __toString() {
//		return $this->firstName . "  " . $this->lastName . " , (" . $this->birthCity . " , " . $this->birthDate . " - " . $this->deathDate . ") one of " .  self::$artistCount . "artists. <br />";
//	}
//	
//	public function getEarliestAllowedDate() {
//		return date_create(EARLIEST_DATE);
//	}
//	
//	public function getBirthDate() {
//		return $this->birthDate;
//	}
//	
//	public function setBirthDate($birthdate) {
//		$date =date_create($birthdate);
//		if (! $date) {
//			$this->birthDate = $this->getEarliestAllowedDate();
//		}
//		else {
//			if ($date < $this->getEarliestAllowedDate() ) {
//				$date = $this->getEarliestAllowedDate();
//			}
//		$this->birthDate = $birthdate;
//		}
//	}
//	
//	public function outputAsTable() {
//		$table = "<table>";
//		$table .= "<tr><th colspan='2'>";
//		$table .= $this->firstName . " " . $this->lastName;
//		$table .= "</th></tr>";
//		$table .= "<tr><td>Birth:</td>";
//		$table .= "<td>" . $this->birthDate;
//		$table .= "(" . $this->birthCity . ")</td></tr>";
//		$table .= "<tr><td>Death:</td>";
//		$table .= "<td>" . $this->deathDate . "</td></tr>";
//		$table .= "</table>";
//		return $table;
//	}
//}
//
//class Painter extends Artist {
//	public $favoritePaint;
//	
//}
///*
//$picasso = new Artist();
//$picasso -> firstName = "Pablo";
//$picasso -> lastName = "Picasso";
//$picasso -> birthCity = "Malaga";
//$picasso -> birthDate = "October 25 1881";
//$picasso -> deathDate = "April 8 1973";
//*/
//$picasso = new Artist("Pablo", "Picasso", "Malaga", "October 25 1881", "April 8 1973");
//#$dali = new Artist();
//$dali = new Artist("Salvador", "Dali", "Figures", "May 11 1904", "Jan 23 1989");
//echo $picasso;
//echo $dali;
//$colin = new Painter("Colin", "Mealey", "Saginaw");
//echo $colin->outputAsTable();
//echo $picasso->outputAsTable();
//$colin->setBirthDate("January 2 1200");
//echo $colin->outputAsTable();
//$colin->$favoritePaint = "acrylic";
//
//echo $colin->$favoritePaint();


abstract class Animal {
	protected $name;
	
	abstract function vocalize ();
	abstract function run();
}

class Dog extends Animal implements Eat {
	//private $name;
	function vocalize () {
	echo $this->name . "says Bow wow <br \>";
	}
	function run() {
		echo $this->name . "goes zoom <br \>";
	}
	function eat() {
		echo $this->name . " eats some food <br />";
	}	
	public function getName() {
		return $this->name;
	}
	public function setName($name) {
		$this->name = name;
	}
	function __construct($n) {
		return $this->name;
	}
}

class Elephant extends Animal implements Eat{
	//private $name;
	function vocalize () {
		echo $this->name . "say Trumpet <br \>";
	}
	function run() {
		echo $this->name . "go Boom...boom... <br \>";
	}
	function eat() {
		echo $this->name . " eats some peanuts <br />";
	}
	public function getName() {
		return $this->name;
	}
	public function setName($name) {
		$this->name = name;
	}
	function __construct($n) {
		return $this->name;
	}
}

interface Eat {
	public function eat ();
}

$fido = new Dog("Fido");
$spot = new Dog("Spot");
$dumbo = new Elephant("Dumbo");
$babar = new Elephant("Babar");
$fido->vocalize();
$fido->run();
$spot->vocalize();
$spot->run();
$dumbo->vocalize();
$dumbo->run();
$babar->vocalize();
$babar->run();



?>