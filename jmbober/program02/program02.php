<?php
/* *******************************************************************
* filename : program02.php
* author : Jenny Bober
* username : jmbober
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : This program is a basic CRUD application for creating
multiple choice questions in a database. 
*
* Structure:
*
* Class AnswerOptions
*   -displayCreateScreen()
*   -insertRecord()
*   -displayReadScreen()
*   -displayUpdateScreen()
*   -updateRecord()
*   -deleteRecord()
*   -displayListScreen()
*   
*
* precondition : database.php must exist in the same directory, and
*                answerOptions table must exist
* postcondition: Web page displays the table along with options to create,
*                read, update and delete
*
* Code adapted from professor Corser
* ******************************************************************* 
*/

include "database.php";
class AnswerOptions{
  
  function displayCreateScreen(){
     /*********************************************************** 
     *PURPOSE: displays a screen for users to enter information
     *INPUT: question, option1, option2, option3
     *PRE: N/A
     *OUTPUT: html form
     *POST: variables are stored in $_POST and $_POST['choice']=create
     **********************************************************/
    
    echo '<form action = "program02.php" method="post">';
    echo 'Question <input name="question" placeholder="What is the capital of North Dakota?" type = "text" /> <br/>';
    echo 'Option 1 <input name="option1" placeholder="Lansing" type = "text" /> <br/>';
    echo 'Option 2 <input name="option2" placeholder="Bismark" type = "text" /> <br/>';
    echo 'Option 3 <input name="option3" placeholder="Albany" type = "text" /> <br/>';
    echo '<input name="choice" value="create" type = "hidden" />';
    echo '<input name="submit" type="submit" />';
    echo '</form>';
  }//end displayCreateScreen
  
  function insertRecord($question, $op1, $op2, $op3){
    /*********************************************************** 
     *PURPOSE: Inserts information from create form into database
     *INPUT: question, option1, option2, option3
     *PRE: answerOptions table exists with proper fields and can be accessed from database.php
     *OUTPUT: N/A
     *POST: record is created in database table
     **********************************************************/
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO answerOptions (question, option1, option2, option3) values(?, ?, ?, ?)";
    $q = $pdo->prepare($sql);
    $q->execute(array($question, $op1, $op2, $op3));
    Database::disconnect();
    header("Location: program02.php");
  }//end insertRecord
  
  function displayReadScreen(){
     /*********************************************************** 
     *PURPOSE: Allows user to read details of a record 
     *INPUT: $_GET['id']
     *PRE: answerOptions table exists with proper fields and can be accessed from database.php
     *OUTPUT: html form
     *POST: variables appear in a readable format on the page
     **********************************************************/
    $id = $_GET['id'];
    $pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM answerOptions where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
    
    echo '<div class="container">';
    echo '<div class="span10 offset1">';
    echo '<div class="row">';
		echo '<h3>Question information</h3>';
		echo '</div>';
		echo '<div class="form-horizontal" >';
		echo '<div class="control-group">';
		echo '<label class="control-label">Question ID = </label>';
		echo $data['id'];
		echo '<br/><label class="control-label">Question: </label>';
		echo $data['question'];
		echo '<br/><label class="control-label">A) </label>';
		echo $data['option1'];
		echo '<br/><label class="control-label">B) </label>';
		echo $data['option2'];
    echo '<br/><label class="control-label">C) </label>';
		echo $data['option3'];    
		echo '<br/> <a class="btn" href="program02.php">Back</a>';
		echo '</div> </div>	</div> </div>';
    
  }
  
  function displayUpdateScreen($id, $question, $option1, $option2, $option3){
     /*********************************************************** 
     *PURPOSE: Displays the update form for one record
     *INPUT: $id, $question, $option1, $option2, $option3
     *PRE: variables have existing values
     *OUTPUT: $id, $question, $option1, $option2, $option3
     *POST: variables are stored in $_POST and $_POST['choice'] = update
     **********************************************************/
    
    echo '<h3>Update a question</h3>';
		echo '<form action = "program02.php" method="post">';
    echo '<input name="id" value="'. $id .'" type="hidden" />';
		echo 'Question: <input name="question" type="text" value="'. $question .'"><br/>';
		echo 'Option 1: <input name="option1" type="text" value=" '. $option1 .'"><br/>';
		echo 'Option 2: <input name="option2" type="text" value=" '. $option2 .'"><br/>';
		echo 'Option 3: <input name="option3" type="text" value=" '. $option3 .'"><br/>';
    echo '<input name="choice" value="update" type="hidden" />';
		echo '<input name="submit" type="submit" />';
    echo '<a class="btn" href="program02.php">Back</a>';
    echo '</form>';
    
  }
  
  function updateRecord($id, $question, $op1, $op2, $op3){
     /*********************************************************** 
     *PURPOSE: To update a record in the database table
     *INPUT: $id, $question, $op1, $op2, $op3
     *PRE: variables have existing values
     *OUTPUT: N/A
     *POST: Record is updated
     **********************************************************/
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE answerOptions set question = ?, option1 = ?, option2 = ?, option3 = ? WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($question, $op1, $op2, $op3, $id));
    Database::disconnect();
    header("Location: program02.php"); 

  } 
  
  function deleteRecord($id) { 
   /*********************************************************** 
     *PURPOSE: To delete a record in the database table
     *INPUT: $id
     *PRE: $id has value
     *OUTPUT: N/A
     *POST: Record is deleted
     **********************************************************/
    $pdo = Database::connect(); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    $sql = "DELETE FROM answerOptions WHERE id = ?"; 
    $q = $pdo->prepare($sql); 
    $q->execute(array($id)); 
    Database::disconnect(); 
    header("Location: program02.php"); 
  } 
  
  function displayListScreen(){
     /*********************************************************** 
     *PURPOSE: Main menu screen; shows table and has buttons to create, read, update and delete
     *INPUT: N/A
     *PRE: N/A
     *OUTPUT: N/A
     *POST: If a button is pressed, displays appropriate screen; otherwise displays table of records
     **********************************************************/
    echo '<head>';
    echo '<meta charset="utf-8">';
    echo '<link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">';
    echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>';
    echo '</head>';
    echo '<body> <div class="container"> <div class="row"> <h3>Questions List</h3> </div> <div class="row">';
    echo '<p>';
    echo '<a href="program02.php?choice=create" class="btn btn-success">Create</a>   ';
    echo '</p>';
    echo '<table class="table table-striped table-bordered">';
    echo '<thead> <tr>';
		echo '<th>Question</th>';
		echo '<th>Option 1</th>';
		echo '<th>Option 2</th>';
		echo '<th>Option 3</th>';
		echo '</tr> </thead> <tbody>';
		
		$pdo = Database::connect();
		$sql = 'SELECT * FROM answerOptions ORDER BY id DESC';
    foreach ($pdo->query($sql) as $row) {
      echo '<tr>';
      echo '<td>'. $row['question'] . '</td>';
      echo '<td>'. $row['option1'] . '</td>';
      echo '<td>'. $row['option2'] . '</td>';
      echo '<td>'. $row['option3'] . '</td>';
      
      echo '<td width=250>';
      echo '<a class="btn" href="program02.php?choice=read&id='.
       $row['id'].'">Read</a>';
      echo '&nbsp;';
      echo '<a class="btn btn-success" href="program02.php?choice=update&id='.$row['id'].'&question='.$row['question'].'&option1='.$row['option1'].'&option2='.$row['option2'].'&option3='.$row['option3'].'">Update</a>';
      echo '&nbsp;';
      echo '<a class="btn btn-danger" 
       href="program02.php?choice=delete&id='.$row['id'].'">Delete</a>';
      echo '</td>';
      echo '</tr>';
		}
    Database::disconnect();
					  
		echo '</tbody> </table>';
		echo '</div>';
    echo '</div>';
    
    echo '<a href="http://csis.svsu.edu/~jmbober/cis355/jmbober/program02/UMLdiagram.jpg">UML Diagram</a></br>'; 
    echo '</body>';
    
  }//end displayListScreen
  
  
  
}//end class

//create the object
$obj = new AnswerOptions();

//The following handles all possible scenarios upon loading the page
if (empty($_POST) && empty($_GET)) $obj->displayListScreen(); 
else if ($_GET['choice'] == 'create') $obj->displayCreateScreen(); 
else if (!empty($_POST) && $_POST['choice'] == 'create') $obj->insertRecord($_POST['question'], $_POST['option1'], $_POST['option2'], $_POST['option3']);
else if ($_GET['choice'] == 'read') $obj->displayReadScreen();
else if ($_GET['choice'] == 'update') $obj->displayUpdateScreen($_GET['id'], $_GET['question'], $_GET['option1'], $_GET['option2'], $_GET['option3']);
else if (!empty($_POST) && $_POST['choice'] == 'update') $obj->updateRecord($_POST['id'], $_POST['question'], $_POST['option1'], $_POST['option2'], $_POST['option3']);
else if ($_GET['choice'] == 'delete') $obj->deleteRecord($_GET['id']);



 show_source(__FILE__); 
?>