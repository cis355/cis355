
<?php 
/* *******************************************************************
* filename : program02.php
* author : Samuel Bromund
* username : sbbromun
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : This program is a object oriented CRUD application using mysqlli

* input : ten integers in an input file
* processing : The program steps are as follows.
* 1. initialize 10x10 2d array
* 2. populate 10x10 2d array with random integers
* 3. print array
* 4. print sum of array elements
* 5. print sum of column with index [3]
* 6. print index number of row with largest sum
* output : printed 10x10 array of random integers and sum
*
* precondition : an input file must exist in the same directory as
* the directory in which the program executes
* postcondition: information printed to the screen,
* as listed in processing items 3 through 6, above.
* *******************************************************************
*/
session_start(); 

class Responses { 
	//Private Data members
    private static $id; 
    private static $questionID; 
    private static $responseID; 
    private static $correctResponse; 
    
	
    public function displayRecords ()
    //Function prints out table and buttons read, update, and delete.
	/* *******************************************************************
	* input : N/A
	* processing : The program steps are as follows.
	* 1. Define database parameters
	* 2. connect to database
	* 3. print table of database records
	* 4. print buttons for further processing
	* output : none
	*
	* precondition : none
	* postcondition: none
	* *******************************************************************
	*/	{ 
		define('DBHOST', 'localhost'); 
		define('DBNAME', 'sbbromun'); 
		define('DBUSER', 'sbbromun'); 
		define('DBPASS', '592880'); 
		
		$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);  
        $sql = 'SELECT * FROM responses ORDER BY id DESC'; 
		$result = mysqli_query($connection, $sql);		//echo table out.
        echo '<table class="table table-striped table-bordered"> 
                <thead> 
                <tr> 
                  <th>ID</th> 
                  <th>Question Number</th> 
                  <th>Response Number</th> 
                  <th>Correct Response</th> 
                </tr> 
              </thead> 
              <tbody>'; 
			  
		if($result = mysqli_query($connection, $sql)) {
			while($row = mysqli_fetch_assoc($result)){
				echo '<tr>';
				echo '<td>' . $row['id'] . '</td>' ; 
				echo '<td>' . $row['questionID'] . '</td>';
				echo '<td>' . $row['responseID'] . '</td>';
				if ($row['correctResponse'] == 0) {
					echo '<td> False </td>';
				}else{
					echo '<td> True </td>';
				}
				echo '<td width=250>'; 
				echo '<a class="btn" href="read.php?id='. $row['id'].'">Read</a>  ';
				echo '<a class="btn" href="update.php?id=' . $row['id'].'">Update  </a>  ';
				echo '<a class="btn" href="delete.php?id=' . $row['id'].'">Delete  </a>  ';
				
				echo '&nbsp;'; 
				echo '</td>'; 
				echo '</tr>'; 
	
			}
		}
        echo '</tbody></table>'; 

    } 
 

	
	function displayCreateScreen () { 
	    //Function prints out area for adding new record
	/* *******************************************************************
	* input : N/A
	* processing : Prints out html for form adding new record
	* output : none
	*
	* precondition : none
	* postcondition: none
	* *******************************************************************
	*/
		echo ' <div class="container"> 
		<div class="span10 offset1"> <div class="row"> 
		<h3>Create a response</h3> </div><form class="form-horizontal" action="program02.php" method="post">  
		<input name="create" value="create" type="hidden"> 
		<div class="control-group <label class="control-label">Question Number</label> <div class="controls"> 
		<input name="questionID" type="text" > </div></div><div class="control-group"> 
		<label class="control-label">Response Number</label> <div class="controls"> 
		<input name="responseID" type="text"/> </div></div>
		<div class="control-group"> <label class="control-label">Correct Response</label> 
		<div class="controls"> <input name="correctResponse" type="text" placeholder="0 for false, 1 for true"/> 
		</div></div><div class="form-actions"> 
		<button type="submit" class="btn btn-success">Create</button> 
		</div></form></div></div> 
		';
		echo '<img src="Untitled Diagram.png">';//This just shows the uml diagram.
    } 
	
	function createRecord($questionID, $responseID, $correctResponse) {
	//Function connects to database and adds record
	/* *******************************************************************
	* input : text from create fields.
	* processing : The program steps are as follows.
	* 1. Connect to database
	* 2. execute SQL
	* 3. reset the page
	* output : none
	*
	* precondition : none
	* postcondition: New record added to table.
	* *******************************************************************
	*/
		define('DBHOST', 'localhost'); 
		define('DBNAME', 'sbbromun'); 
		define('DBUSER', 'sbbromun'); 
		define('DBPASS', '592880'); 
		
		$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);  
        $sql = "INSERT INTO responses (questionID,responseID,correctResponse) VALUES ($questionID, $responseID, $correctResponse)"; 
		$connection->query($sql);	
		header("Location: program02.php"); 
	}
	

}
//new instance of Response
$response1 = new Responses; 
//Using hidden field to see if we need to create a new record
if(!empty($_POST['create'])) { 
    $questionID = $_POST['questionID']; 
    $responseID = $_POST['responseID']; 
    $correctResponse = $_POST['correctResponse']; 
    $response1->createRecord($questionID, $responseID, $correctResponse); 
} 
echo "Object-oriented CRUD application <br />";
$response1->displayRecords(); 
$response1->displayCreateScreen();


 show_source(__FILE__);


?>