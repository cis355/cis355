<!--/* *******************************************************************
* filename : program2.php
* author : Derek Nichols
* username : dtnichol
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : This program has one database table called Bands and this code allows 
*				you to create, read, update, and delete those bands.
*
* input : ten integers in an input file
* processing : The program steps are as follows.
* 		1. initialize 10x10 2d array
* 		2. populate 10x10 2d array with random integers
* 		3. print array
* 		4. print sum of array elements
* 		5. print sum of column with index [3]
* 		6. print index number of row with largest sum
* output : printed 10x10 array of random integers and sum
*
* precondition : an input file must exist in the same directory as
* 				 the directory in which the program executes
* postcondition: information printed to the screen,
* 				 as listed in processing items 3 through 6, above.
* *******************************************************************
*/-->

<?php
define ('DBHOST', 'localhost');
define ('DBNAME', 'dtnichol');
define ('DBUSER', 'dtnichol');
define ('DBPASS', '99DT44Nichols');
class Band {
	
	private static $id;
	private static $name;
	private static $homeTown;
	private static $genre;



 


	
		public function displayRecords () {
		$con = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
		$sql = 'SELECT * FROM Bands ORDER BY id DESC';
		
		echo '<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Name</th>
		                  <th>Home Town</th>
		                  <th>Genre</th>
		                  <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>';
		
		
		
		   foreach ($con->query($sql) as $row) {
						echo '<tr>';
						echo '<td>'. $row['name'] . '</td>';
						echo '<td>'. $row['homeTown'] . '</td>';
						echo '<td>'. $row['Genre'] . '</td>';
						echo '<td width=350>';
						echo '<a class="btn" href="program2.php?status=readBand&id='.$row['id'] . '">Read</a>';
						echo '&nbsp;';
						
						echo '<a class="btn btn-success" 
						href="program2.php?status=updateBand&id='.$row['id'].'">Update</a>';
						echo '&nbsp;';
						echo '<a class="btn btn-danger" 
						href="program2.php?status=deleteBand&id='.$row['id'] .'">Delete</a>';
						
						echo '&nbsp;';
						
						echo '</tr>';
					   }
					   echo '</tbody></table>';
					   
					  mysqli_close($con);
		
	}
	
	//print_r($displayRecords);
	
	
	
	function displayCreateScreen(){
		echo '<div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Create a Customer</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="program2.php" method="post">
						<input name="create" value="create" type="hidden"/>
					
					  <div class="control-group ">
					    <label class="control-label">Band Name</label>
					    <div class="controls">
					      	<input name="name" type="text"  placeholder="Name" ">
					      	
					    </div>
					  </div>
					  
					  <div class="control-group ">
					    <label class="control-label">Home Town</label>
					    <div class="controls">
					      	<input name="homeTown" type="text" placeholder="Home Town" ">
					      	
					    </div>
					  </div>
					  <div class="control-group ">
					    <label class="control-label">Genre</label>
					    <div class="controls">
					      	<input name="Genre" type="text"  placeholder="Genre" ">
					      	
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="program2.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
		';
		
	}
	
	function createRecord($name, $homeTown, $genre){
		
			$con =  mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
			//$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO `Bands` (name,homeTown,Genre) VALUES('$name', '$homeTown', '$genre')";
			//print_r($sql); 
			
			
			$q = $con->prepare($sql);
			
			//$q =bind_param('sss', $_POST['name'], $_POST['homeTown'], $_POST['Genre']);
			$q->execute();
			
			//print_r($q);
			mysqli_close($con);
			//echo "got to here";
			//exit();
			header("Location: program2.php");
	}
	
	function readRecord($name, $homeTown, $genre){
		$id = $_GET['id'];
		$con =  mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
			//$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM `Bands` WHERE id = $id";
			$q = $con->query($sql);
			
			$row = $q->fetch_assoc();
			
		echo '<div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Read a Customer</h3>
		    		</div>
		    		<input type="hidden"
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Name:</label>
						     	' .  $row['name'] . '
					  </div>
					  <div class="control-group">
					    <label class="control-label">Home Town:</label>
						     	' .  $row['homeTown'] . '
					  </div>
					  <div class="control-group">
					    <label class="control-label">Genre:</label>
						     	' .  $row['Genre'] . '
					  </div>
					    <div class="form-actions">
						  <a class="btn" href="program2.php">Back</a>
					   </div>
    
					</div>
				</div>
				
    </div> <!-- /container -->';
	mysqli_close($con);
	}
	
	function readBand() {
		$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: program2.php");
	} else {
		$con =  mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
		$sql = 'SELECT * FROM Bands WHERE id = ?';
		
		mysqli_close($con);
	}
	}
	
	function deleteBand($name,$homeTown,$genre){
		
		$id = $_GET['id'];
		
		$con = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
		
		$sql = "DELETE FROM `Bands` WHERE id = $id";
		$q = $con->query($sql);
		//$q->execute();
		mysqli_close($con);
		header("Location: program2.php");
	}
	
	function displayUpdateScreen($name,$homeTown,$genre){
		
		$id = $_GET['id'];
		
		$con = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
		
		$sql = "SELECT * FROM Bands where id = '$id'";
		
		$q = $con->query($sql);
		
		
		
		$data = $q->fetch_assoc();
		//var_dump($data);
		//echo "got to here";
		//exit();
		$name = $data['name'];
		
		$homeTown = $data['homeTown'];
		
		$genre = $data['Genre'];
		mysqli_close($con);
		
	 echo '<div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Update a Customer</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="program2.php?id= ' . $id .'" method="post">
					<input name="update" value="update" type="hidden"/>
					  <div class="control-group ">
					    <label class="control-label">Name</label>
					    <div class="controls">
					      	<input name="name" type="text"  placeholder="Name" value="'. $name .'">
					      	
					    </div>
					  </div>
					  <div class="control-group ">
					    <label class="control-label">Home Town</label>
					    <div class="controls">
					      	<input name="homeTown" type="text" placeholder="Home Town" value="'. $homeTown .'">
					      	
					    </div>
					  </div>
					  <div class="control-group ">
					    <label class="control-label">Genre</label>
					    <div class="controls">
					      	<input name="Genre" type="text"  placeholder="Genre" value="'. $genre .'">
					      	
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="program2.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->';
	}
	
	
	function updateBand($name,$homeTown,$genre){
			
		if(!empty($_GET['id'])){
			
			$id = $_GET['id'];
			
			$con = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
			
			$sql = "UPDATE Bands  SET name = '$name', homeTown = '$homeTown', Genre = '$genre' WHERE id = '$id'";
			
			$con->query($sql);
			
			
			
			mysqli_close($con);
			
			header("Location: program2.php");
		
		}
		
	}
	
	
	
	
	
}
$band1 = new Band;
echo '<a class="btn" href="program2UML.png">UML Class Diagram</a>';

if(!empty($_POST['create'])) {
	$name = $_POST['name'];
	$homeTown = $_POST['homeTown'];
	$genre = $_POST['Genre'];
	$band1->createRecord($name,$homeTown,$genre);
	
} 

if ($_GET['status'] == readBand) {$band1->readRecord();
}
if ($_GET['status'] == deleteBand) {
	$band1->deleteBand();
	
}

if($_GET['status'] == updateBand) {
	
	$band1->displayUpdateScreen();
}

if(!empty($_POST['update'])) {
	$name = $_POST['name'];
	$homeTown = $_POST['homeTown'];
	$genre = $_POST['Genre'];
	$band1->updateBand($name,$homeTown,$genre);
	
} 



$band1->displayCreateScreen();

$band1->displayRecords();


echo "<br />";
//print_r($_SESSION);


	
show_source(__FILE__);	
	










?>