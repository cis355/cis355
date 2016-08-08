<?php 
    session_start();  
    require ("database.php");  
    var_dump($_POST);
    if (!empty($_POST)) {
        if (array_key_exists('create', $_POST)) {  // insert a new record
            // keep track post values
            $park_id = $_POST['parkInput'];
            $tourist_id = $_POST['touristInput'];
            $visit_date = $_POST['dateInput'];

            // insert data, error checking done in HTML
            $connection = mysqli_connect('localhost','elmclean','604577','elmclean');
            $sql = "INSERT INTO visits (park_id,tourist_id,visit_date) VALUES('$park_id','$tourist_id','$visit_date')";
            mysqli_query($connection, $sql);
            mysqli_close($connection);

            header("Location: program02.php");
        } else if(array_key_exists('update', $_POST)){  // update existing record
            // keep track post values
            $park_id = $_POST['parkInput'];
            $tourist_id = $_POST['touristInput'];
            $visit_date = $_POST['dateInput'];

            var_dump($visit_date);

            // insert data, error checking done in HTML
            $connection = mysqli_connect('localhost','elmclean','604577','elmclean');
            $sql = "UPDATE visits SET visit_date = $visit_date WHERE park_id = $park_id AND tourist_id = $tourist_id";
            mysqli_query($connection, $sql);
            mysqli_close($connection);

            header("Location: program02.php");
        }
    } 
     
    class Visit {  
        // create static fields 
        private static $park_id;  
        private static $tourist_id;  
        private static $visit_date;  
        
        public function includeCSS() {
            echo '<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">';
            echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>';
        }

        // show records in table format 
        public function displayRecords() {
            $connection = mysqli_connect('localhost','elmclean','604577','elmclean'); 
            $sql = 'SELECT * FROM visits ORDER BY park_id'; 
            echo '<div class="container col-xs-12">
                <table class="table table-striped">  
                <caption>Park Visits</caption>
                    <thead>  
                        <tr>  
                            <th>Park #</th>  
                            <th>Tourist #</th>  
                            <th>Visit Date</th>
                            <th></th>
                            <th></th>
                            <th></th> 
                        </tr>  
                    </thead>  
                  <tbody>';

            foreach ($connection->query($sql) as $row) { 
                echo '<tr>'; 
                echo '<td>'. $row['park_id'] . '</td>'; 
                echo '<td>'. $row['tourist_id'] . '</td>'; 
                echo '<td>'. $row['visit_date'] . '</td>';
                echo '<td class="text-center"><a class="btn btn-primary" href="program02.php?button=read&park_id='.$row['park_id'].'&tourist_id='. $row['tourist_id'].'">Read</a></td>'; 
                echo '<td class="text-center"><a class="btn btn-warning" href="program02.php?button=update&park_id='.$row['park_id'].'&tourist_id='. $row['tourist_id'].'">Update</a></td>';
                echo '<td class="text-center"><a class="btn btn-danger" href="program02.php?button=delete&park_id='.$row['park_id'].'&tourist_id='. $row['tourist_id'].'">Delete</i></a></td>';
            } 

            echo '</tbody></table></div>'; 
            mysqli_close($connection); 
        }  
         
        function displayCreateForm() {
            echo '<div class="container col-xs-12">
                    <div class="row">
                    <form class="form-horizontal col-xs-6" action="program02.php" method="post">
                        <legend>Create a Record</legend>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="parkInput">Park ID: </label>  
                            <div class="col-md-4">
                                <input id="parkInput" name="parkInput" type="number" min="1" max="10" class="form-control input-md" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="touristInput">Tourist ID:</label>  
                            <div class="col-md-4">
                                <input id="touristInput" name="touristInput" type="number" min="1" max="10" class="form-control input-md" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="dateInput">Visit Date:</label>  
                            <div class="col-md-4">
                                <input id="dateInput" name="dateInput" type="date" class="form-control input-md" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">
                                <button name="create" type="submit" class="btn btn-success">Create</button>
                            </div>
                        </div>
                    </form>
                    </div>
                  </div>'; 
        } 
         
        function displayUpdateForm($park_id, $tourist_id){
            $park = intval($park_id);
            $tourist = intval($tourist_id);

            $connection = mysqli_connect('localhost','elmclean','604577','elmclean');
            $sql = "SELECT * FROM visits WHERE park_id = $park AND tourist_id = $tourist";
            $result = mysqli_query($connection, $sql); 
            $record = $result->fetch_assoc();

            echo '<div class="container col-xs-12">
                    <div class="row">
                    <form class="form-horizontal col-xs-6" action="program02.php" method="post">
                        <legend>Update a Record</legend>
                        <div class="form-group">
                            <input type="hidden" name="parkInput" value="'.$record["park_id"].'">
                            <input type="hidden" name="touristInput" value="'.$record["tourist_id"].'">
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="dateInput">Visit Date:</label>  
                            <div class="col-md-4">
                                <input id="dateInput" name="dateInput" type="date" class="form-control input-md" value="'.$record["visit_date"].'" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">
                                <button name="update" type="submit" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </form>
                    </div>
                  </div>';

            mysqli_close($connection); 
        } 
         
        function deleteRecord($park_id, $tourist_id) { 
            // delete function
            $connection = mysqli_connect('localhost','elmclean','604577','elmclean'); 
            $sql = "DELETE FROM visits WHERE park_id = $park_id AND tourist_id = $tourist_id"; 
            mysqli_query($connection, $sql);
            mysqli_close($connection);

            header("Location: program02.php"); 
        } 
         
        function readRecord($park_id, $tourist_id) { 
            // display one record
            $park = intval($park_id);
            $tourist = intval($tourist_id);
 
            $connection = mysqli_connect('localhost','elmclean','604577','elmclean');
            $sql = "SELECT * FROM visits WHERE park_id = $park AND tourist_id = $tourist";
            $result = mysqli_query($connection, $sql); 
            $record = $result->fetch_assoc();

            echo '<div class="container col-xs-12">
                <table class="table table-striped">  
                <caption>Read Record</caption>
                    <thead>  
                        <tr>  
                            <th>Park #</th>  
                            <th>Tourist #</th>  
                            <th>Visit Date</th>
                        </tr>  
                    </thead>  
                  <tbody>';
            echo '<tr>'; 
            echo '<td>'. $record['park_id'] . '</td>'; 
            echo '<td>'. $record['tourist_id'] . '</td>'; 
            echo '<td>'. $record['visit_date'] . '</td>';
            echo '</tbody></table></div>'; 
            mysqli_close($connection); 

            header("Location: program02.php");
        } 
    } 
     
    $visit = new Visit;   
    $visit->includeCSS();   
    $visit->displayCreateForm();  
    $visit->displayRecords();  
    echo "<br />";  
     
    if ($_GET['button'] == 'update') { 
        $park_id = $_GET['park_id'];
        $tourist_id = $_GET['tourist_id'];

        $visit->displayUpdateForm($park_id, $tourist_id);
    } 
     
    if ($_GET['button'] == 'delete') { 
        $park_id = $_GET['park_id'];
        $tourist_id = $_GET['tourist_id'];

        $visit->deleteRecord($park_id, $tourist_id); 
    } 
     
    if ($_GET['button'] == 'read') { 
        $park_id = $_GET['park_id'];
        $tourist_id = $_GET['tourist_id'];

        $visit->readRecord($park_id, $park_id);
    }

    show_source(__FILE__);
?> 