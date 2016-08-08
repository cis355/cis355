<?php 
class Artist {
	public static $artistCount = 0;
	public $firstName;
	public $lastName;
	private $birthDate;
	public $birthCity;
	public $deathDate;

	const EARLIES_DATE = "Nov 1 1000";
	
	function __construct($firstName, $lastName, $city, $birth, $death) {
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->birthCity = $city;
		$this->birthDate = $birth; 
		$this->deathDate = $death;
		self::$artistCount++;
	}
	
	public function getEarliestAllowedDate() {
		return date_create(self::EARLIEST_DATE);
	}
	
	public function getBirthDate() {
		return $this->birthDate;
	}
	
	public function __toString() {
		return $this->firstName . " " . $this->lastName . " (" . $this->birthCity . " " . $this->birthDate . " " . $this->deathDate . ") <br/> \n";
	}
	
	public function setBirthDate($birthdate){
		// set variable only if passed a valid date string
		$date = date_create($birthdate);
		if ( ! $date ) {
			$this->birthDate = $this->getEarliestAllowedDate();
		}
		else {
			// if very early date then change it to
			// the earliest allowed date
			if ( $date < $this->getEarliestAllowedDate ) {
				$date = $this->getEarliestAllowedDate;
			}
			$this->birthDate = $date;
		}
	}
	
public function outputAsTable() {
$table = "<table>";
$table .= "<tr><th colspan='2'>";
$table .= $this->firstName . " " . $this->lastName;
$table .= "</th></tr>";
$table .= "<tr><td>Birth:</td>";
$table .= "<td>" . $this->birthDate;
$table .= "(" . $this->birthCity . ")</td></tr>"; 
$table .= "<tr><td>Death:</td>";
$table .= "<td>" . $this->deathDate . "</td></tr>";
$table .= "</table>";
return $table;
}
	
}

$picasso = new Artist("Pablo","Picasso","Malaga","Oct 25,1881", "Apr 8 1973" );
$dali = new Artist("Salvador","Dali","Figures","May 11 1904", "Jan 23 1989" );
$colin = new Artist("Colin", "Dude", "Bay City", "Jan 2 1200", "July 14 2016");

echo $picasso;
echo $dali;

$colin->setBirthDate("nov 5, 1000"); 

echo $dali->outputAsTable();
echo $picasso->outputAsTable();
echo $colin->outputAsTable();

?>