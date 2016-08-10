<?php
/* *******************************************************************
 filename     : webService.php  
 author       : Adam Henderson  
 username     : arhender 
 course       : cis355  
 section      : 11-MW  
 semester     : Summer 2016  
 description  : This file contains the class to export properly formatted Json and the code
				to display the contens of the json object in a table format.
 
Input: N/A
 
Process:
1. Instantiate Artwork object
2. call the outputJSON method and place into a variable
3. decode the json and place into an object
4. loop through the object to place the contents in a table format

Output: Table display all records in the Artworks table

UML: http://csis.svsu.edu/~arhender/cis355/arhender/Program3/ArtworksUML.JPG
*********************************************************************  */
require ("../Program1/database.php"); 

class Artwork { 

    private static $id;  #private attributes
    private static $title; 
    private static $artist; 
    private static $style; 
     
    public function outputJSON () { 
         $str = ''; 
       $str .= '{'; // begin the object 
       $str .= '"Artworks":'; 
       $str .= '['; // begin the array 
     
        $pdo = Database::connect(); 
        $sql = 'SELECT * FROM artworks ORDER BY id DESC'; 
         
    #select all from the Artworks database and place into a properly formatted JSON object
        foreach ($pdo->query($sql) as $row) { 
            $str .= '{'; 
            $str .=  '"id":"'. $row['id'] . '", '; 
            $str .=  '"title":"'. $row['title'] . '",'; 
            $str .=  '"artist":"'. $row['artist'] . '",'; 
            $str .=  '"style":"'. $row['style'] .'"'; 
            $str .=  '},'; 
        } 
		 Database::disconnect();
        $str = substr($str, 0, -1); // remove last comma 
        $str .= ']';
        $str .= '}';
          
      return $str;
    } 
     
} 

$art = new Artwork;  #instantiate a new Artwork Object
$json = $art->outputJSON(); #retrieve the JSON


$obj = json_decode($json); #decode the JSON and show it is valid

#echo out the table
echo " 
<html lang='en'>
<head>
	<!-- The head section does the following.
		1. Sets character set
		2. Includes Bootstrap
		-->
    <meta charset='utf-8'>
    <link   href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' rel='stylesheet'>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
</head>

<body>
	<!-- The body section does the following.
		1. Displays heading
		2. Displays a create 
		3. Displays rows of database records (from MySQL database)
		4. Displays tutorial button
		-->
    <div class='container'>
    		<div class='row'>
    			<h3>Artworks JSON call</h3>
    		</div>
			<div class='row'>
				
				
				<table class='table table-striped table-bordered'>
		              <thead>
		                <tr>
		                  <th>Title</th>
		                  <th>Artist</th>
		                  <th>Style</th>
		                </tr>
		              </thead>
		              <tbody>";
		             foreach ($obj->Artworks as $artwork){
	           #for each artworks object output the attribute of the JSON Object
			   #in a table format
	
	
	                           echo '<tr>'; #for each record output and format
							   	echo '<td>'. $artwork->title . '</td>';
							   	echo '<td>'. $artwork->artist . '</td>';
							   	echo '<td>'. $artwork->style . '</td>';
							   	echo '</tr>';
					
	
	
	
}
					 
				     echo " </tbody>
	            </table>"; #close the table 


show_source(__file__);


?>