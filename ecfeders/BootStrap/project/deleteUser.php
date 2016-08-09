<?php
/* *******************************************************************  
* filename     : deleteUser.php  
* author       : Erik Federspiel & Start Bootstrap & Star Tutorial
*  				 https://startbootstrap.com/template-overviews/simple-sidebar/
				 https://www.startutorial.com/
* username     : ecfeders  
* course       : CIS-355  
* section      : 11-MW  
* semester : Summer 2016  
*  
* description  : This displays users of a particular business and allows
				 only the admin to delete workers from the business.
 *  
 * processing   : The program steps are as follows.   
 *          1. display main table 
 *          2. wait for delete button click
 *          3. after button click go to correct form 
 *          4. based on button click do operations  
 
 * output       : table with correct information
 *  
 * precondition : css documents and php files in same directory/databaseProject.php
 * postcondition: shows a table of workers for an owner of a business
 * *******************************************************************   */ 
 ?>
 
<?php
	session_start();
	if(empty($_SESSION['name'])){
		header("Location: loginProject.php"); // redirect 
	}
	
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Food Safety</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
	
	 <link href="css/table.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
 <!-- Page Content -->
 <div id="page-content-wrapper">
     <div class="container-fluid">
         <div class="row">
             <div class="col-lg-12">
                 <div class="container">
					<div class="row">
						<h3>Food Safety</h3>
					</div>
					<div class="row">
						<table class="table table-striped table-bordered">
							<thead>
							<tr>
								<!-- Table Headers -->
								<th>ID</th>
								<th>Name</th>
								<th>Position</th>
								<th>Delete</th>
							</thead>
							<tbody>
							<?php  
							$employeeBussinessID = $_SESSION['buss-id'];
							# databse.php contains connection code including connect and disconnect
							# functions
							include 'databaseProject.php';
							# connecting to the database and assign object to variable
							$pdo = Database::connect();
							# assigning variable for the SELECT STATEMENT
							$sql = 'SELECT id, name, buss_id, position FROM workers ORDER BY id DESC';
							# iterates through every record return by the select statment above
							foreach ($pdo->query($sql) as $row) {
								if($employeeBussinessID == $row['buss_id']){
										echo '<tr>';
										echo '<td>'. $row['id'] . '</td>';
										echo '<td>'. $row['name'] . '</td>';
										echo '<td>'. $row['position'] . '</td>';
										echo '<td width="250">';
										echo '<a class="btn btn-danger" 
										href="deleteUserCommit.php?id='.$row['id'].'">Delete</a>';
										echo '</td>';
										echo '</tr>';
								}
							}
							Database::disconnect();
							?>
							 <a class="btn btn-info" href="project.php">Back</a>
							</tbody>
						<table>
					</div>
				</div> <!-- /container -->
             </div>
         </div>
     </div>
 </div>
 <!-- /#page-content-wrapper -->
</body>

</html>
   