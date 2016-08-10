<?php
/* *******************************************************************
 filename     : artworks.php  
 author       : Adam Henderson  
 username     : arhender 
 course       : cis355  
 section      : 11-MW  
 semester     : Summer 2016  
 description  :  This file contains the class the class to handle displaying area of processing
				 and displaying the table of artworks which currently exist in the database.
 
Process:
1. N/A

Current File:
http://csis.svsu.edu/~arhender/cis355/arhender/Program2/artworks.php

Links to class, database file, and UML Class diagram:
1.http://csis.svsu.edu/~arhender/cis355/arhender/Program2/artworks.php
2.http://csis.svsu.edu/~arhender/cis355/arhender/Program2/database.php
3.http://csis.svsu.edu/~arhender/cis355/arhender/Program2/artworkUMLdiagram.JPG
*********************************************************************  */
show_source(__FILE__);
require 'database.php';

class artwork
{
	
	private static $id; #private class variables
	private static $title;
	private static $artist;
	private static $style;

	
/*************************************************************		
FUNCTION: __construct
Parameters   :  $title- first name      			 Type: string
				$artist- email  		 			 Type: string
				$style- phone number 		 Type: string
				
purpose       : The purpose of this function is to be parametrized
				constructor.
				
output        : An object of type artwork 
precondition  : none, an object can be instantiated at any time.
postcondition : The object is as-is. 
****************************************************************/

	function __construct($title=null, $artist=null, $style=null) 
	{ 
	
		$this->id= 0;  #set all of the variables
        $this->title = $title; 
        $this->artist = $artist; 
        $this->style = $style;
		
         
    } 
	
/*************************************************************		
FUNCTION: setid
Parameters   :  $tuid- table id      			 Type: string
				
				
purpose       : The purpose of this function is to set the object
				id.
				
output        : object id is set
precondition  : object must be instantiated first.
postcondition : none, id can be set as many times without reprucussion. 
****************************************************************/
	public function setid($tuid)
	{
		$this->id = $tuid; #set the id of the function
		
	}
	
	/*************************************************************		
FUNCTION: setitle
Parameters   :  $title- title      			 Type: string
				
				
purpose       : The purpose of this function is to set the object
				title.
				
output        : object title is set
precondition  : object must be instantiated first.
postcondition : none, title can be set as many times without reprucussion. 
****************************************************************/
	
	public function settitle($title)
	{
		$this->title = $title; #set the id of the function
		
	}
	
/*************************************************************		
FUNCTION: setartist
Parameters   :  $artist- artist    			 Type: string
				
				
purpose       : The purpose of this function is to set the object
				artist.
				
output        : object artist is set
precondition  : object must be instantiated first.
postcondition : none, title can be set as many times without reprucussion. 
****************************************************************/
	public function setartist($artist)
	{
		$this->artist = $artist; #set the id of the function
		
	}
	
	
/*************************************************************		
FUNCTION: setstyle
Parameters   :  $style- style   			 Type: string
				
				
purpose       : The purpose of this function is to set the object
				artist.
				
output        : object style is set
precondition  : object must be instantiated first.
postcondition : none, style can be set as many times without reprucussion. 
****************************************************************/
	public function setstyle($style)
	{
		$this->style = $style; #set the id of the function
		
	}

	/*************************************************************		
FUNCTION: getid
Parameters   :  none
				
				
purpose       : The purpose of this function is to return the object
				id.
				
output        : object id is returned
precondition  : object must be instantiated first.
postcondition : id is an integer. 
****************************************************************/
	public function getid()
	{
		
	return $this->id;	#return object id
	}
	
/*************************************************************		
FUNCTION: gettitle
Parameters   :  none
				
				
purpose       : The purpose of this function is to return the object
				title.
				
output        : object title is returned
precondition  : object must be instantiated first.
postcondition : title is a string. 
****************************************************************/

	public function gettitle()
	{
		
		return $this->title; #return name
	
	}
		
/*************************************************************		
FUNCTION: getartist
Parameters   :  none
				
				
purpose       : The purpose of this function is to return the object
				artist.
				
output        : object title is returned
precondition  : object must be instantiated first.
postcondition : title is a string. 
****************************************************************/
	public function getartist()
	{
		
	return $this->artist; #return 
		
	}
	
/*************************************************************		
FUNCTION: getstyle
Parameters   :  none
				
				
purpose       : The purpose of this function is to return the object
				style.
				
output        : object style is returned
precondition  : object must be instantiated first.
postcondition : style is a string. 
****************************************************************/
	
	public function getstyle()
	{
		
		
		return $this->style; #return 
		
	}

/*************************************************************		
FUNCTION: displayrecords
Parameters   :  none
				
				
purpose       : The purpose of this function is to display artworks
				records in a table format
				
output        : html to show the table
precondition  : object must be instantiated first.
postcondition : page must be reloaded to show changes in database. 
****************************************************************/
	
	public function displayrecords()
	{
		
		
		$conn = database::connect(); #connect to the database
				
		        $stmt = $conn->prepare("SELECT * From artworks");#prepare the statement
				
				$result = $stmt->execute();#execute and bind the result
				$stmt->bind_result($tuid,$title,$artist,$style);
				
				    
				
				while($stmt->fetch())#while there are still records
				{
					
					echo '<tr>'; #for each record output and format
							   	echo '<td>'. $title . '</td>';
							   	echo '<td>'. $artist . '</td>';
							   	echo '<td>'. $style . '</td>';
							   	echo '<td width=250>';
							   	echo '<a class="btn btn-primary" href="read.php?id='.
								  $tuid.'">Read</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-success" 
								   href="update.php?id='.$tuid.'">Update</a>'; #place the id in the $_get array
							   	echo '&nbsp;';                                      #for processing use
							   	echo '<a class="btn btn-danger" 
								   href="delete.php?id='.$tuid.'">Delete</a>';
							   	echo '</td>';
							   	echo '</tr>';
					
					
					
					
				}
				
				
				$conn->close();#close the connection
		
					 
					  
						   		
					   
					   
	}
	
/*************************************************************		
FUNCTION: create
Parameters   :  none
				
				
purpose       : The purpose of this function is to insert
				a record into artworks
				
output        : a new database records
precondition  : object must be instantiated first, artworks database exists
postcondition : only inserts, and cannot be empty. 
****************************************************************/	
	public function create()
	{
		
				$conn = database::connect();
				// prepare and bind
				$stmt = $conn->prepare("INSERT INTO artworks (title, artist, style) VALUES (?, ?, ?)");
				$stmt->bind_param("sss", $title, $artist, $style);

				$title = $this->title;
				$artist = $this->artist;
				$style = $this->style;
				$stmt->execute();

				$stmt->close();
				$conn->close();
				
	}

/*************************************************************		
FUNCTION: read
Parameters   :  none
				
				
purpose       : The purpose of this function is to set the class variables to
				read a record from artworks
				
output        : a new database records
precondition  : object must be instantiated first, artworks database exists, id must be set
postcondition : only sets objects, to output must use the . 
****************************************************************/
	
	
	public function read()
	{
		        $conn = database::connect(); #connect
				
		        $stmt = $conn->prepare("SELECT * From artworks where id=?");
				$stmt->bind_param("i", $this->id);
				
				$result = $stmt->execute();
				$stmt->bind_result($tuid,$title,$artist,$style);
				
				    
				
				while($stmt->fetch())#while there is still records to fetch
				{
					
					$this->id = $tuid;
					$this->title = $title;
					$this->artist = $artist;
					$this->style = $style; 
					
				}
				
				
				$conn->close();
              
				
				/*
                $conn = database::connect();
				
				$sql = "SELECT * From artworks where id=" . $this->getid();
				$result = $conn->query($sql);
				$resultarray = $result->fetch_assoc();
				
				$conn->close();
				
				$this->title = $resultarray['title'];
				$this->artist = $resultarray['artist'];
				$this->style = $resultarray['style
				
				*/
		
	}
	
	
/*************************************************************		
FUNCTION: update
Parameters   :  none
				
				
purpose       : The purpose of this function is to set the class variables to update
				a record in artworks
				
output        : none
precondition  : object must be instantiated first, artworks database exists, record exists, id must be set
postcondition : object in database is updated. 
****************************************************************/
	public function update()
	{
		        $conn = database::connect();
				// prepare and bind
				$stmt = $conn->prepare("UPDATE artworks SET title=?, artist=?, style=? where id = ?");
				$stmt->bind_param("sssi",$title ,$artist, $style, $id);
                
				
				$title = $this->title;
				$artist= $this->artist;#set class update values to class items
				$style= $this->style;
				$id = $this->id;
				$stmt->execute();

				$stmt->close();
				$conn->close();
			
	}

/*************************************************************		
FUNCTION: delete
Parameters   :  none
				
				
purpose       : The purpose of this function is to set the class variables to delete
				a record in artworks
				
output        : none
precondition  : object must be instantiated first, artworks database exists, record exists, id must be set
postcondition : object in database is removed. 
****************************************************************/	
	public function delete()
	{
		
		
		        $conn = database::connect();
				// prepare and bind
				$stmt = $conn->prepare("DELETE FROM artworks where id = ?");
				$stmt->bind_param("i", $id);

				$id = $this->id;
				$stmt->execute();

				$stmt->close();
				$conn->close();
				
		
		
	}

	
/*************************************************************		
FUNCTION: showindex
Parameters   :  none
				
				
purpose       : The purpose of this function is to display the index page
				
output        : main index page, navigation buttons, table showing all records in artworks
precondition  : object must be instantiated first
postcondition : index page is shown. 
****************************************************************/	
public function showindex()
{
#display html
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
    			<h3>Object-Oriented Artwork CRUD Grid</h3>
    		</div>
			<div class='row'>
				<p>
					<a href='create.php' class='btn btn-success'>Create</a>
				</p>
				
				<table class='table table-striped table-bordered'>
		              <thead>
		                <tr>
		                  <th>Title</th>
		                  <th>Artist</th>
		                  <th>Style</th>
		                  <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>";
		             
					 self::displayrecords();
				     echo " </tbody>
	            </table>
    </div> <!-- /container -->
  </body>
</html>";
		
	
	}

/*************************************************************		
FUNCTION: showcreate
Parameters   :  none
				
				
purpose       : The purpose of this function is to display the create page
				
output        : create page, navigation buttons
precondition  : object must be instantiated first
postcondition : create page is shown. 
****************************************************************/	

	
	public function showcreate(){
		
		#display html
		echo "<html lang='en'>
<head>
    <meta charset='utf-8'>
    <link   href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' rel='stylesheet'>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
</head>

<body>
    <div class='container'>
    
    			<div class='span10 offset1'>
    				<div class='row'>
		    			<h3>Create an Artwork</h3>
		    		</div>
    		        <form class='form-horizontal' action='create.php' method='post'>";
					 
					
  					 echo "<div class='control-group";
				  
					 echo !empty($titleError)?'error':'';
					 echo "'>";
					 
					 echo "<label class='control-label'>Title</label>";
					 echo  "<div class='controls'>";
					 echo  "<input name='title' type='text' placeholder='Title' value='";
					 echo !empty($title)?$title:'';
					 echo "'>";
				 
				 
					 if (empty($titleError)){
					      		echo "<span class='help-inline'>" . $titleError ."</span>";
					 }
					 
					 echo "<div class='control-group";
				  
					 echo !empty($titleError)?'error':'';
					 echo "'>";
					 
					 echo "<label class='control-label'>Artist</label>";
					 echo  "<div class='controls'>";
					 echo  "<input name='artist' type='text' placeholder='Artist' value='";
					 echo !empty($artist)?$artist:'';
					 echo "'>";
				 
				 
					 if (empty($artistError)){
					      		echo "<span class='help-inline'>" . $artistError ."</span>";
					 }
					 
					 
					 echo "<div class='control-group";
				  
					 echo !empty($artistError)?'error':'';
					 echo "'>";
					 
					 echo "<label class='control-label'>Style</label>";
					 echo  "<div class='controls'>";
					 echo  "<input name='style' type='text' placeholder='Style' value='";
					 echo !empty($style)?$style:'';
					 echo "'>";
				 
				 
					 if (empty($styleError)){
					      		echo "<span class='help-inline'>" . $styleError ."</span>";
					 }
							
					  echo"  </div>";
					 
					 
					
					     
			  
					 
					   echo "
				    
					<div class='form-actions'>
						  <button type='submit' class='btn btn-success'>Create</button>
						  <a class='btn' href='index.php'>Back</a>
						</div>
					
					</form>
					
				</div>
				
    </div> <!-- /container -->
  </body>
</html>";
	
		
	}


/*************************************************************		
FUNCTION: showread
Parameters   :  none
				
				
purpose       : The purpose of this function is to display the read page
				
output        : read page, navigation buttons
precondition  : object must be instantiated first
postcondition : read page page is shown. 
****************************************************************/		
	public function showread(){
		#display html
	$title = $This->title;
	$artist = $This->artist;
	$style = $This->style;
	
echo "<html lang='en'>
<head>
    <meta charset='utf-8'>
    <link   href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' rel='stylesheet'>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
</head>

<body>
    <div class='container'>
    
    			<div class='span10 offset1'>
    				<div class='row'>
		    			<h3>Read an Artwork</h3>
		    		</div>
		    		
	    			<div class='form-horizontal' >
					  <div class='control-group'>
					    <label class='control-label'>Title:  </label>";
						 echo self::gettitle();
					     echo "</div>";
					
					echo "<div class='form-horizontal'><div class='control-group'>
				         <label class='control-label'>Artist:</label>";
						 echo self::getartist();
					     echo "</div>";
						 
					echo "<div class='form-horizontal' >
					  <div class='control-group'>
					    <label class='control-label'>Style:  </label>";
						 echo self::getstyle();
					     echo "</div>";
						 
					
					echo   "</div>
					    <div class='form-actions'>
						  <a class='btn' href='index.php'>Back</a>
					   </div>

					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>";
		
		
	}


/*************************************************************		
FUNCTION: showupdate
Parameters   :  none
				
				
purpose       : The purpose of this function is to display the update page
				
output        : update page, navigation buttons
precondition  : object must be instantiated first
postcondition : update page is shown,update needs to occur only on valid data. 
****************************************************************/		

	
	public function showupdate(){
#display html
			echo "<html lang='en'>
<head>
    <meta charset='utf-8'>
    <link   href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' rel='stylesheet'>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
</head>

<body>
    <div class='container'>
    
    			<div class='span10 offset1'>
    				<div class='row'>
		    			<h3>Create an Artwork</h3>
		    		</div>
    		        <form class='form-horizontal' action='update.php?id=" . self::getid() . "' method='post'>";
					 
			
  					 echo "<div class='control-group";
				  
					 echo !empty($titleError)?'error':'';
					 echo "'>";
					 
					 echo "<label class='control-label'>Title</label>";
					 echo  "<div class='controls'>";
					 echo  "<input name='title' type='text' placeholder='Title' value='" . self::gettitle() . "'>";
				 
				 
					 if (empty($titleError)){
					      		echo "<span class='help-inline'>" . $titleError ."</span>";
					 }
					 
					 echo "<div class='control-group";
				  
					 echo !empty($titleError)?'error':'';
					 echo "'>";
					 
					 echo "<label class='control-label'>Artist</label>";
					 echo  "<div class='controls'>";
					 echo  "<input name='artist' type='text' placeholder='Artist' value='";
					 echo self::getartist();
					 echo "'>";
				 
				 
					 if (empty($artistError)){
					      		echo "<span class='help-inline'>" . $artistError ."</span>";
					 }
					 
					 
					 echo "<div class='control-group";
				  
					 echo !empty($artistError)?'error':'';
					 echo "'>";
					 
					 echo "<label class='control-label'>Style</label>";
					 echo  "<div class='controls'>";
					 echo  "<input name='style' type='text' placeholder='Style' value='";
					 echo self::getstyle();
					 echo "'>";
				 
				 
					 if (empty($styleError)){
					      		echo "<span class='help-inline'>" . $styleError ."</span>";
					 }
							
					  echo"  </div>";
					 
					 
					
					     
			  
					 
					   echo "
				    
					<div class='form-actions'>
						  <button type='submit' class='btn btn-success'>Update</button>
						  <a class='btn' href='index.php'>Back</a>
						</div>
					
					</form>
					
				</div>
				
    </div> <!-- /container -->
  </body>
</html>";
		
		
	}

/*************************************************************		
FUNCTION: showdelete
Parameters   :  none
				
				
purpose       : The purpose of this function is to display the delete page
				
output        : delete page, navigation buttons
precondition  : object must be instantiated first
postcondition : delete page page is shown. 
****************************************************************/			
	public function showdelete(){
		#display html
echo "		<head>
    <meta charset='utf-8'>
    <link   href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' rel='stylesheet'>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
</head>

<body>
    <div class='container'>
    
    			<div class='span10 offset1'>
    				<div class='row'>
		    			<h3>Delete an Artwork</h3>
		    		</div>
		    		
	    			<form class='form-horizontal' action='delete.php' method='post'>
	    			  <input type='hidden' name='id' value='" . $this->id ."' />";
					echo "
					  <p class='alert alert-error'>Are you sure to delete ?</p>
					  <div class='form-actions'>
						  <button type='submit' class='btn btn-danger'>Yes</button>
						  <a class='btn btn-warning' href='index.php'>No</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>";
		
		
	}
	
	
	
	

}



?>

