
<!-- -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-

filename  : program03.php
author    : Gage Beckett
date      : 2016-07-31
email     : sgbecket@svsu.edu
course    : CIS-355
link      : csis.svsu.edu/~gpcorser/cis355/sgbecket/program03/program03.php
backup    : github.com/cis355/cis355
purpose   : This file creates a functioning CRUD site from a class

copyright : GNU General Public License (http://www.gnu.org/licenses/)
			This program is free software: you can redistribute it and/or modify
			it under the terms of the GNU General Public License as published by
			the Free Software Foundation, either version 3 of the License, or
			(at your option) any later version.
			This program is distributed in the hope that it will be useful,
			but WITHOUT ANY WARRANTY; without even the implied warranty of
			MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.   
            
external code used in this file: 
			Code constructed with guidance from G. Corser  with the star tutorial
			
program structure : 
		require database.php
		create static variables
		displayRecords()
		output opening api format
		output table inside api format with
		output closing api format
		create new venue for api call
                
+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+- -->
<?php
	//open the database connection
	require ('database.php');
	class Venue{
	private static $id;				 //create static variable for info
    private static $name;           //create static variable for info
    private static $type;             //create static variable for info
    private static $location;        //create static variable for info
    
	
	 public function displayRecords () {									  //output opening api
		echo'{';//begin the object                                                //output opening api
		echo '"Venues":';                                                            //output opening api
		echo '[';                                                                         //output opening api
		                                                                                        
        $pdo = Database::connect();                                            
        $sql = 'SELECT * FROM venue ORDER BY id DESC';          
		$str = "";                                                                         
        foreach ($pdo->query($sql) as $row ) {                           //output the ap ibody
            $str .= '{';                                                                   //output the api body
            $str .= '"id":"'. $row['id'] . '", ';                                      //output the api body
            $str .= '"name":"'. $row['name'] . '", ';                           //output the api body
            $str .= '"type":"'. $row['type'] . '", ';                              //output the api body
            $str .= '"location":"'. $row['location'] . '"';                       //output the api body
			$str .='},';                                                                   //output the api body

        }
        $str = substr($str, 0, -1);
		echo $str;

        Database::disconnect();
		echo']';                                                                          //output the closing api tags 
		echo'}';                                                                          //output the closing api tags
    }
}
	$venue = new Venue;														 //create the new venue for output
	$venue->displayRecords();                                                  //create the new venue for output
	echo '<br><img src="http://csis.svsu.edu/~sgbecket/cis355/sgbecket/program03/UML" /><br>';
	show_source(__FILE__);                                                 //create the new venue for output
?>
