<?php
/* *******************************************************************
* filename : webService.php
* author : Jenny Bober
* username : jmbober
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : This program outputs the answerOptions table as a JSON object
*
* Structure:
*
* Class Question
* -private variables declared
* -function outputJSON()
*      -creates the JSON object
* -object instantiated 
*   
*
* precondition : database.php must exist, and answerOptions table must exist
* postcondition: Page displays JSON object
*
* Code adapted from professor Corser
* *******************************************************************/ 
require("crud/database.php");

class Question { 

    private static $id; 
    private static $question; 
    private static $option1; 
    private static $option2; 
    private static $option3;
    
     public function outputJSON () { 
     /*********************************************************** 
     *PURPOSE: output answerOptions contents as a JSON object
     *INPUT: N/A
     *PRE: answerOptions exists with proper fields
     *OUTPUT: N/A
     *POST: displays JSON object on screen
     **********************************************************/
     
      echo '{'; //begin object
      echo '"answerOptions":';
      echo '['; //begin array
      
      
      $pdo = Database::connect(); 
      $sql = 'SELECT * FROM answerOptions ORDER BY id DESC'; 
      
    
        $str = '';
        foreach ($pdo->query($sql) as $row) { 
            $str .= '{'; 
            $str .=  '"id":"'. $row['id'] . '", '; 
            $str .=  '"question":"'. $row['question']. '",'; 
            $str .=  '"option1":"'. $row['option1']. '",'; 
            $str .=  '"option2":"'. $row['option2']. '",';
            $str .=  '"option3":"'. $row['option3']. '"';
            $str .=  '},'; 
            }
            $str = substr($str, 0, -1);
            echo $str; 
         
        Database::disconnect(); 
        
        echo ']'; //close array
        echo '}'; //close object
    } 
}

$quest = new Question;
$quest->outputJSON();
echo '<br /><br /><br />'; 
echo '<a href="http://csis.svsu.edu/~jmbober/cis355/jmbober/prog3diagram.jpg">UML Diagram</a></br>';

show_source(__FILE__); 
?>