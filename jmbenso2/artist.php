<?php 

/*
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

	// How to define a constructor
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
		// Produce HTML for table containing data
        $table = "<table>"; 
		#incremental concatenation
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

# Make subclasses using extends
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


$picasso = new Artist(); 
$picasso->firstName = "Pablo"; 
$picasso->lastName = "Picasso"; 
$picasso->birthCity = "Malaga"; 
$picasso->birthDate = "October 25 1881"; 
$picasso->deathDate = "April 8 1973"; 

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
*/

# Abstract class cannot be substantiated
#   Contains common members for subclasses

interface Eats {
	public function eat();
}

abstract class Animal {
	
	abstract function vocalize();
	abstract function eat();
	abstract function move();
	
}

class Dog extends Animal implements Eats {
	

	# Member data
	private $name;
	# Constructor
	function __construct($n) { 
        $this->name = $n;
	
	}
	
	
	#Member functions
	# Dog class must override abstract functions from abstract parent class
	function vocalize () {
		echo $this->name . " says 'Woof.'<br />";
	}
	function move () {
		echo $this->name . " gallops adorably. <br />";
	}
	function eat () {
		echo $this->name . " goes 'Om nom nom.' <br />";
	}
	
	public function getName() {
		return $this->name;
	}
	public function setName($newName) {
		# You have to use $this-> to select a single instance
		$this->name = $newName;
	}
	
}

class Elephant extends Animal implements Eats {
	# Member data
	private $name;
	# Constructor
	function __construct($n) { 
        $this->name = $n;
	
	}
	function vocalize () {
		echo $this->name . " says 'Bddzzzoowaaar!' <br />";
	}
	function move () {
		echo $this->name . " trundles about. <br />";
	}
	function eat () {
		echo $this->name . " goes 'Crunch crunch.' <br />";
	}
}

// Instantiate a coupla dogs
$pets = array (
	new Dog("Fido"),
	new Elephant("Bozo"),
	new Dog("Roger"),
	new Elephant("Walt"),
	new Elephant("Topsy")
);


// Make 'em all vocalize
foreach ($pets as $p) {
	$p->vocalize();
}

// Make 'em all move
foreach ($pets as $p) {
	$p->move();
}

// Make 'em all eat
foreach ($pets as $p) {
	$p->eat();
}
















show_source(__FILE__); 


?>