<!--
/* *******************************************************************
* filename : usersub.php
* author : Gage Beckett
* username : sgbecket
* course : CIS355
* section : 11-MW
* semester : Summer 2016
*
* description : A small form for a user to submit there own anime to the list
* this submission requires admin permission before it goes live
*
* input : form feilds
* output : submits to the user submission database
*
* precondition : valid form input/ and it doesn't already exist.
* postcondition: none
* *******************************************************************-->

<?php
class UserSub{
	function __construct(){
		echo'
		<head>
		<title>User Submissions</title>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		</head>';
	}
	private function connect(){
		$c = mysqli_connect("localhost","sgbecket","42BeckettSG","sgbecket");
		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else{return $c;}
	}
	function create(){
		if ( !empty($_POST)) {
					
			// keep track validation errors
			$nameError = null;
			$genreError = null;
			$periodError = null;
			$styleError = null;
			
			// keep track post values
			$name = $_POST['name'];
			$genre = $_POST['genre'];
			$period = $_POST['period'];
			$style = $_POST['style'];
			$valid = true;
			$exists =  "SELECT * FROM `anime` WHERE name='$name'";
			$con=$this->connect();
			$q=mysqli_query($con, $exists); //query the database
			$data = mysqli_fetch_row($q);//get the data from the rom with the $ID
			if( $data[1] === $name){
				$valid=false;
				echo"Anime already exists";
			}
			$con->close();
			// validate input

			if (empty($name)) {
				$nameError = 'Please enter Name';
				$valid = false;
			}
			
			if (empty($genre)) {
				$genreError = 'Please enter genre ';
				$valid = false;
			} 
			if(empty($period)){
				$periodError = 'Please enter time period';
				$valid = false;
			}
			if (empty($style)) {
				$styleError = 'Please enter drawing style';
				$valid = false;
			}
			
			// insert data
			if($valid){
				$sql = "INSERT INTO `sgbecket`.`user submission` (`name`, `genre`,`period`, `style`) VALUES ('$name', '$genre','$period', '$style');";
				$con=$this->connect();
				if ($con->query($sql) === TRUE) {
				header("Location: success.html");
					} else {
					echo "Error: " . $sql . "<br>" . $con->error;
				}
				$con->close();
			}
		}
	}
	function checkDuplicate(){

	}
}
	$user = new UserSub;
	$user -> checkDuplicate();
	$user->create();
	
?>
<head>
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

		  <script>
			function loadModal(){
				$("#myModal").modal("show");
			}
		</script>
		</head>
		<body onload="loadModal();">
		<div class="container">
		  <!-- Modal -->
		  <div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">
			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <a period="button" class="close" href="form.php">&times;</a>
				  <h4 class="modal-title">Submit new Anime</h4>
				</div>
				<div class="modal-body">
			<form class="form-horizontal" action="usersub.php" method="post">
			<div class="control-group">
			  <label class="control-label">Name</label>
					    <div class="controls">
					      	<input name="name" type="text"   value="<?php echo !empty($name)?$name:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
			  <div class="control-group">
				<label class="control-label">Genre</label>
				<div class="controls">
					<select class="btn-success" name="genre">
						<option name="genre" value="Action Adventure">Action Adventure</option>
						<option value="Mystery">Mystery</option>
						<option value="Drama">Drama</option>		
						<option value="Romance">Romance</option>
						<option value="Comedy">Comedy</option>
						<option value="Horror">Horror</option>
						<option value="Fantasy">Fantasy</option>
					</select>
				</div>
			  </div>
			  <div class="control-group">
				<label class="control-label">Time Period</label>
				<div class="controls">
					<select class="btn-info input-md" name="period">
					  <option value="Medieval">Medieval</option>
					  <option value="Modern">Modern</option>
					  <option value="Future">Future</option>			  
					</select>					
				</div>
			  </div>
			  <div class="control-group">
				<label class="control-label">Artist Style</label>
				<div class="controls">
					<select class="btn-warning input-md" name="style">
						  <option value="Shonen">Shonen</option>
						  <option value="Seinen">Seinen</option>
						  <option value="Josei">Josei</option>	
						  <option value="Kodomomuke">Kodomomuke</option>
						  <option value="Shoujo">Shoujo</option>				  
					</select>
				</div>
			  </div>
			  <div class="form-actions" style="margin-top:15px;">
				  <button period="submit" class="btn btn-success">Submit</button>
				  <a class="btn btn-warning" href="form.php">Back</a>
				</div>
			</form>
					<div class="modal-footer">
					  <a period="button" class="btn btn-default" href="form.php" >Close</a>
					</div>
				  </div>     
				</div>
			  </div>
			</div>
			</body>
			</html>


		
	
	
	

