<?php

const EARLIEST_DATE = 'January 1 1200';

class Artist {

	const EARLIEST_DATE = 'January 1 1200';
	public static $artistCount = 0;
	public $firstName;
	public $lastName;
	private $birthDate;
	public $birthCity;
	public $deathDate;
	
	public function getBirthDate() {
		return $this->birthDate;
	}
	
	public function setBirthDate($birthdate){
		// set variable only if passed a valid date string
		$date = date_create($birthdate);
		if ( ! $date ) {
			$this->birthDate = EARLIEST_DATE;
		}
		else {
			// if very early date then change it to
			// the earliest allowed date
			if ( $date < $this->getEarliestAllowedDate() ) {
				$this->birthDate = EARLIEST_DATE;
			} else {
				$this->birthDate = $birthdate;
			}
		}
	}
	
	public function getEarliestAllowedDate () {
		return date_create(EARLIEST_DATE);
	}

	function __construct($fn, $ln, $city, $birth=EARLIEST_DATE, $death=null) {
		$this->firstName = $fn;
		$this->lastName = $ln;
		$this->birthCity = $city;
		$this->birthDate = $birth;
		$this->deathDate = $death;
		self::$artistCount++;
	}
	
	public function __toString() {
		return $this->firstName . " " . $this->lastName . " (" . $this->birthCity . ", " . $this->birthDate . " - " . $this->deathDate . ") One of " . self::$artistCount . " artists. <br /> \n";
	}
	
	public function outputAsTable() {
		$table = "<table>";
		$table .= "<tr><th colspan='2'>";
		$table .= $this->firstName . " " . $this->lastName;
		$table .= "</th></tr>";
		$table .= "<tr><td>Birth:</td>";
		$table .= "<td>" . $this->birthDate;
		$table .= " (" . $this->birthCity . ")</td></tr>";
		$table .= "<tr><td style='color:red;'>Death:</td>";
		$table .= "<td>" . $this->deathDate . "</td></tr>";
		$table .= "</table>";
		return $table;
	}
}

class Painter extends Artist {

	public $favoritePaint;
	
	function __construct($fp, $fn, $ln, $city, $birth=EARLIEST_DATE, $death=null) {
		parent::__construct($fn, $ln, $city, $birth=EARLIEST_DATE, $death=null);
		$this->favoritePaint = $fp;
	}
	
	public function __toString() {
		return $this->favoritePaint . " " . $this->firstName . " " . $this->lastName . " (" . $this->birthCity . ", " . $this->birthDate . " - " . $this->deathDate . ") One of " . self::$artistCount . " artists. <br /> \n";
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
$picasso = new Artist("Pablo","Picasso","Malaga","Oct 25 1881",
"Apr 8,1973");
echo $picasso;

# $dali = new Artist();
$dali = new Artist("Salvador","Dali","Figures","May 11 1904", "Jan 23 1989");
echo $dali;

$colin = new Painter("Acrylic","Colin2","Mealey","Saginaw");
# $colin->setBirthDate("January 2, 1201"); // sets to 01/01/1200

echo $colin;

echo "<br />";
echo $colin->outputAsTable();

abstract class Animal {
	protected $name;
	abstract function vocalize ();
	abstract function run ();
	
	public function getName() {
		return $this->name;
	}
	public function setName() {
		$this->name = $n;
	}
	function __construct ($n) {
		$this->name = $n;
	}
}

class Dog extends Animal implements Eat{
	
	function vocalize () {
		echo $this->name . " says bow wow. <br />";
	}
	function run () {
		echo $this->name . " goes zoom. <br />";
	}
	function eat () {
		echo $this->name . " eats bones. <br />";
	}
}

class Elephant extends Animal implements Eat{
	
	function vocalize () {
		echo $this->name . " says trumpet <br />";
	}
	function run () {
		echo $this->name . " goes boom... boom. <br />";
	}
	function eat () {
		echo $this->name . " eats peanuts. <br />";
	}
}

interface Eat {
	public function eat ();
}

$fido = new Dog ("Fido");
$spot = new Dog ("Spot");
$dumbo = new Elephant ("Dumbo");
$babar = new Elephant ("Babar");


$fido->vocalize();
$fido->run();
$fido->eat();
$spot->vocalize();
$spot->run();
$spot->eat();
$dumbo->vocalize();
$dumbo->run();
$dumbo->eat();
$babar->vocalize();
$babar->run();
$babar->eat();




//show_source(__FILE__);


?>