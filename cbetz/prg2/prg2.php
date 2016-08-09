<?php 
    class Questions { 
        //Member Data 
        private static $id; 
        private static $question; 
        private static $category; 
        private static $difficulty; 
        
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
	
	// This function display the create new person button, it has a link to the create.php link for creation
	    // of a new user.
	    function displayCreateButton() {
	    	
	    	echo "<a href='create.php' class='btn btn-success'>Create a New Question!!</a><br />";
	    	
	    } 
	    
	    // This function shows the read button to the right of each person.
	    // This has a link to the read.php file where it shows the contents of the person.
	    function readButton () { 
         
            echo "<a href='read.php' class='btn btn-success'></a><br />"; 
         
        } 
	    
	    // This function shows the update button to the right of each person.
	    // This has a link to the update.php where it shows the create screen but with the original
	    // contents from the user you choose and lets you change anything and update.
	    function updateButton() {
	    	
	    	echo "<a href='update.php' class='btn btn-success'></a><br />"; 
	    }
	    
	    // This function shows the delete button to the right of each person.
	    // This has a link to the delete.php where it asks if you are sure about deleting.
	    // Depending on whcih you choose if will delete the record or take you back.
	    function deleteButton() {
	    	
	    	echo "<a href='delete.php' class='btn btn-success'></a><br />"; 
	    }
}

// Create a new instance of class Customer
$cust1 = new Questions; 
echo "BETZ PROGRAM 2";
echo "<br />";
echo "<br />";
// Display the create new person button
$cust1->displayCreateButton();
echo "<br />";
// display the record in your customer table
$cust1->displayRecords(); 

echo "<br />";
echo "<br />";
         
     

    show_source (__FILE__); 

?>