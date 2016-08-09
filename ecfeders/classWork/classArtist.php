<?php
	class Artist{
		public $firstName;
		public $lastName;
		public $birthDate;
		public $birthCity;
		public $deathDate;
	}
	function __construct($firstName, $lastName, $birthDate, $birthCity, $deathDate = null){
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->birthDate = $birthDate;
		$this->birthCity = $birthCity;
		$this->deathDate = $deathDate;
	}
	$picaso = new Artist("Pablo","Picaso","October 25 1881","Malaga","April 8 1973");
	$dali = new Artist("Salvador","Dali","May 11 1904", "Figures", "January 23 1983");

	public function outputAsTable(){
		$table = "<table>";
		$table .= "<tr><th colspan='2'>";
		$table .= $this->firstName . " " . $this->lastName;
		$table .= "</th></tr>";
		$table .= "<tr><td>Birth:</td>";
		$table .= "<td>" . $this->birthDate;
		$table .= " (" . $this->birthCity . ")</td></tr>";
		$table .= "<tr><td>Death:</td>";
		$table .= "<td>" . $this->deathDate . "</td></tr>";
		$table .= "</table>";
		return $table;
	}
	
	echo $picaso->outputAsTable();
	
?>