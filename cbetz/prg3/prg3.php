<a href="http://imgur.com/VJmVLNq">Program 3 Diagram</a>
<?php
/* ******************************************************************* 
 filename     : prg3.php   
 author       : Chad Betz   
 course       : cis355     
 semester     : Summer 2016   
 description  : This file contains the class that returns the JSON object
				of the query and displays them in a table.
**********************************************************************/ 
require ("../crud/database.php"); 

//Question class
class Question { 

    private static $id; 
    private static $question; 
    private static $category; 
    private static $difficulty; 
    
	//PURPOSE: Outputs the JSON gathering of the questions table
	//INPUT  : None
	//PRE    : The variable id,question,category and difficulty are there
	//OUTPUT : str
	//POST   : This function displays the questions table by each object and whats inside each.
    public function outputJSON () { 
     
        echo '{'; // begin the object 
        echo '"questions":'; 
        echo '['; // begin the array 
     
        $pdo = Database::connect(); 
        $sql = 'SELECT * FROM questions ORDER BY id DESC'; 
         
        $str = ''; 
        foreach ($pdo->query($sql) as $row) { 
            $str .= '{'; 
            $str .=  '"id":"'. $row['id'] . '", '; 
            $str .=  '"question":"'. $row['question'] . '",'; 
            $str .=  '"category":"'. $row['category'] . '",'; 
            $str .=  '"difficulty":"'. $row['difficulty']. '"'; 
            $str .=  '},'; 
        } 
        $str = substr($str, 0, -1); // remove last comma 
        echo $str; 
         
        Database::disconnect(); 
        echo ']'; // close the array 
        echo '}'; // close the object 
		
    } 
	
	
} 
$quest = new Question; 
$json = $quest->outputJSON();

$obj = json_decode($json);
echo '<br /><br /><br />'; 

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
                <h3>Questions</h3> 
            </div> 
            <div class='row'> 
                 
                 
                <table class='table table-striped table-bordered'> 
                      <thead> 
                        <tr> 
                          <th>Question</th> 
                          <th>Category</th> 
                          <th>Difficulty</th> 
                        </tr> 
                      </thead> 
                      <tbody>"; 
                     $pdo = Database::connect();
					   $sql = 'SELECT * FROM questions ORDER BY id DESC';
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['question'] . '</td>';
							   	echo '<td>'. $row['category'] . '</td>';
							   	echo '<td>'. $row['difficulty'] . '</td>';
							   	echo '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
                     echo " </tbody> 
                </table>"; #close the table  


show_source(__FILE__); 
?>