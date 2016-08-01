<?php 
    class Questions { 
        //Member Data 
        private static $id; 
        private static $question; 
        private static $category; 
        private static $difficulty; 
        
        function create() {
		
		
		if ( !empty($_POST)) {
		// keep track validation errors
		$questionError = null;
		$categoryError = null;
		$difficultyError = null;
		
		// keep track post values
		$question = $_POST['question'];
		$category = $_POST['category'];
		$difficulty = $_POST['difficulty'];
		
		// validate input
		$valid = true;
		if (empty($question)) {
			$questionError = 'Please enter a question';
			$valid = false;
		}
		
		if (empty($category)) {
			$categoryError = 'Please enter category';
			$valid = false;
		} else if ( !filter_var($category,FILTER_VALIDATE_EMAIL) ) {
			$categoryError = 'Please enter a valid category';
			$valid = false;
		}
		
		if (empty($difficulty)) {
			$difficultyError = 'Please enter a difficulty';
			$valid = false;
		}
		
		// MYSQLI Connect Variables 
        $servername = "localhost"; 
        $username = "cbetz"; 
        $password = "547295"; 
        $dbname = "cbetz"; 
         
        // Create connection 
        $conn = new mysqli($servername, $username, $password, $dbname); 
        // Check connection 
        if ($conn->connect_error) { 
            die("Connection failed: " . $conn->connect_error); 
        }  
		// insert data
		if ($valid) {
			$sql = "INSERT INTO questions (question,category,difficulty) values(?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($question,$category,$difficulty));
			$conn->close();
			header("Location: prg2.php");
		}
	} # end if ( !empty($_POST))
		}
		
         
        public function displayRecords () {  
?>     
        <html lang="en"> 
        <head> 
            <!-- The head section does the following  
                1. Sets character set 
                2.Includes bootstrap!--> 
            <meta charset="utf-8"> 
            <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"> 
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
        </head> 
         
        <body> 
            <!-- The body section does the following  
                1. Displays Heading 
                2. Displays the create button 
                3. Displays rows of database records from MYSQL 
                4. Displays the tutorial button--> 
            <div class="container"> 
                    <div class="row"> 
                        <h3>Questions</h3> 
                    </div> 
                    <div class="row"> 
                        <p> 
                            <a href="create.php"  class="btn btn-success">Create</a> 
                        </p> 
                         
                        <!-- Table Titles !--> 
                        <table class="table table-striped table-bordered"> 
                            <thead> 
                                <tr> 
                                <th>Question</th> 
                                <th>Category</th> 
                                <th>Difficulty</th> 
                                <th>Action</th> 
                                </tr> 
                            </thead> 
                            <tbody> 
                            <?php 
                              // MYSQLI Connect Variables 
                                $servername = "localhost"; 
                                $username = "cbetz"; 
                                $password = "547295"; 
                                $dbname = "cbetz"; 
                                 
                                // Create connection 
                                $conn = new mysqli($servername, $username, $password, $dbname); 
                                // Check connection 
                                if ($conn->connect_error) { 
                                    die("Connection failed: " . $conn->connect_error); 
                                }  
                                //SQl Statment 
                                $sql = "SELECT * FROM questions"; 
                                $result = $conn->query($sql); 
                                 
                                if ($result->num_rows > 0) { 
                                     
                                    // output data of each row 
                                    while($row = $result->fetch_assoc()) { 
                                        echo '<tr>'; 
                                        echo '<td>'. $row['question'] . '</td>'; 
                                        echo '<td>'. $row['category'] . '</td>'; 
                                        echo '<td>'. $row['difficulty'] . '</td>'; 
                                        echo '<td width="250">';; 
                                        echo '<a class="btn btn-success" href="read.php?id='.$row['id'].'">Read</a>'; 
                                        echo '&nbsp;'; 
                                        echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';                                         
                                        echo '&nbsp;'; 
                                        echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>'; 
                                        echo '</td>'; 
                                        echo '</tr>'; 
                                    } 
                                } else { 
                                    echo "0 results"; 
                                } 
                                //Close connection 
                                $conn->close(); 
                            ?> 
                            </tbody> 
                        </table> 
                </div> 
            </div> <!-- /container --> 
        </body> 
        </html>
	 
<?php 		 
         
        } 
         
     
}  

    //Create instantiation and call fucntion 
    $cust1 = new Questions; 
    $cust1->displayRecords(); 
     
    show_source (__FILE__); 

?>