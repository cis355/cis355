<?php

  class Artist {
    public $firstName;
    public $lastName;
    public $birthDate;
    public $birthCity;
    public $deathDate;
    
    function __construct($firstName, $lastName, $city, $birth, $death=null){
      $this->firstName = $firstName;
      $this->lastName = $lastName;
      $this->birthCity = $city;
      $this->birthDate = $birth;
      $this->deathDate = $death;
    }
    
    public function __toString(){
      return $this->firstName . " " . $this->lastName . " " . $this->birthdate . " " . $this->birthCity . " " . $this->deathDate;
    }
  }
  
  //$picasso = new Artist();
  //$dali = new Artist();
  //$picasso->firstName = "Pablo";
  //$picasso->lastName = "Picasso";
  //$picasso->birthCity = "Malaga";
  //$picasso->birthDate = "October 25 1881";
  //$picasso->deathDate = "April 8 1973";
  
  $picasso = new Artist("Pablo","Picasso","Malaga","Oct 25, 1881", "Apr 8,1973");
  $dali = new Artist("Salvador","Dali","Figures","May 11, 1904", "Jan 23, 1989");
  
  echo $dali;

?>