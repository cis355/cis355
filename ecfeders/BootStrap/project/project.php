<?php
/* *******************************************************************  
* filename     : project.php  
* author       : Erik Federspiel & Start Bootstrap & Star Tutorial
*  				 https://startbootstrap.com/template-overviews/simple-sidebar/
				 https://www.startutorial.com/
* username     : ecfeders  
* course       : cs355  
* section      : 11-MW  
* semester : Summer 2016  
*  
* description  : This program is a crud program with an associative array.
*   			 You can create, read,update, and delete in a database with these
*   			 tables.  I use sql queries to display the right information in each table
*     			 when an item is created, deleted, or updated.
 *  
 * processing   : The program steps are as follows.   
 *          1. display main table 
 *          2. wait for button click
 *          3. after button click go to correct form 
 *          4. based on button click do operations  
 
 * output       : table with correct information
 *  
 * precondition : css documents and php files in same directory/databaseProject.php
 * postcondition: actions based on button clicks
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

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
				    <!-- Title -->
                    <h2>
                        Food Safety
                    </h2>
                </li>
				<!-- List for options -->
                <li>
                    <a href="loginProject.php">Login</a>
                </li>
                <li>
                    <a href="logoutProject.php">Logout</a>
                </li>
                <li>
                    <a href="createSheet.php">Create</a>
                </li>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

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
										<th>Business</th>
										<th>Worker</th>
										<th>Date</th>
										<th>Action</th>
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
									$sql = 'SELECT businesses.name AS busName, workers.name As workerName, 
										sheet.dateMod As date, sheet.id As ID, workers.buss_id As bus_id FROM sheet INNER JOIN workers ON workers.id = sheet.worker_id
												INNER JOIN businesses ON businesses.id = sheet.buss_id';
									# iterates through every record return by the select statment above
									foreach ($pdo->query($sql) as $row) {
										if($employeeBussinessID == $row['bus_id']){
												echo '<tr>';
												echo '<td>'. $row['busName'] . '</td>';
												echo '<td>'. $row['workerName'] . '</td>';
												echo '<td>'. $row['date'] . '</td>';
												echo '<td width="250">';
												echo '<a class="btn" href="readProject.php?id='.
												$row['ID'].'">Read</a>';
												echo '&nbsp;';
												echo '<a class="btn btn-success" 
												href="updateProject.php?id='.$row['ID'].'">Update</a>';
												echo '&nbsp;';
												echo '<a class="btn btn-danger" 
												href="deleteProject.php?id='.$row['ID'].'">Delete</a>';
												echo '</td>';
												echo '</tr>';
										}
									}
									Database::disconnect();
									?>
									</tbody>
								<table>
							</div>
						</div> <!-- /container -->
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
