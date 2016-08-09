<!-- 
filename  : program02.php
author    : Erika McLean
date      : 2016-08-08
email     : elmclean@svsu.edu
course    : CIS-355
link      : csis.svsu.edu/~elmclean/cis355/elmclean/program02/program02.php
backup    : github.com/cis355/cis355
purpose   : This file serves as a menu template for the course, 
            CIS-355: Server Side Web Development, 
            at Saginaw Valley State University (SVSU)
copyright : GNU General Public License (http://www.gnu.org/licenses/)
            This program is free software: you can redistribute it and/or modify
            it under the terms of the GNU General Public License as published by
            the Free Software Foundation, either version 3 of the License, or
            (at your option) any later version.
            This program is distributed in the hope that it will be useful,
            but WITHOUT ANY WARRANTY; without even the implied warranty of
            MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.   
program structure : 
    php: start session, check POST for create or update button call
    class Visits: private variables, public functions
    main: new Visits class object and call to member functions
    php get: check GET for read, update, or delete call
    final: show php source function
-->

<?php 
    session_start();  // create session 
    require ("database.php");  // database connection file

    // if POST has data
    if (!empty($_POST)) {
        if (array_key_exists('create', $_POST)) {  // insert a new record
            // keep track post values
            $park_id = $_POST['parkInput'];
            $tourist_id = $_POST['touristInput'];
            $visit_date = $_POST['dateInput'];

            // insert data, error checking done in HTML
            $connection = mysqli_connect('localhost','elmclean','604577','elmclean');
            $sql = "INSERT INTO visits (park_id,tourist_id,visit_date)VALUES('$park_id','$tourist_id','$visit_date')";
            mysqli_query($connection, $sql);  // run query
            mysqli_close($connection);  // close connection

            header("Location: program02.php");  // redirect
        } else {  // update existing record
            // keep track post values
            $park_id = $_POST['parkInput'];
            $tourist_id = $_POST['touristInput'];
            $visit_date = $_POST['dateInput'];

            // convert to integer values
            $park = intval($park_id);
            $tourist = intval($tourist_id);

            // insert data, error checking done in HTML
            $connection = mysqli_connect('localhost','elmclean','604577','elmclean');
            $sql = "UPDATE visits SET visit_date = '".$visit_date."' WHERE park_id = $park AND tourist_id = $tourist";   
            mysqli_query($connection, $sql);  // run query
            mysqli_close($connection);  // close connection

            header("Location: program02.php");  // redirect
        }
    } 
    
    /**
     *  Visit class creates an instance of a park tourist visit
     */
    class Visit {  
        // create static fields 
        private static $park_id;  
        private static $tourist_id;  
        private static $visit_date;  
        
        /**
         * Include header links and UML diagram
         */
        public function includeCSS() {
            echo '<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">';
            echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>';
            echo '<br />';
            echo '<div class="container col-md-4"><a href="http://csis.svsu.edu/~elmclean/cis355/elmclean/program02/McLean_Program02Diagram.png" name="create" type="submit" class="btn btn-primary">UML Diagram</a></div>';
            echo '<br /><br />';
        }

        /**
         * Display all records in table format
         */
        public function displayRecords() {
            $connection = mysqli_connect('localhost','elmclean','604577','elmclean'); 
            $sql = 'SELECT * FROM visits ORDER BY visit_date'; 
            echo '<div class="container col-xs-12">
                <div class="col-xs-6">
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
            // loop through all table records
            foreach ($connection->query($sql) as $row) { 
                echo '<tr>'; 
                echo '<td>'. $row['park_id'] . '</td>'; 
                echo '<td>'. $row['tourist_id'] . '</td>'; 
                echo '<td>'. $row['visit_date'] . '</td>';
                echo '<td class="text-center"><a class="btn btn-primary" href="program02.php?button=read&park_id='.$row['park_id'].'&tourist_id='. $row['tourist_id'].'">Read</a></td>'; 
                echo '<td class="text-center"><a class="btn btn-warning" href="program02.php?button=update&park_id='.$row['park_id'].'&tourist_id='. $row['tourist_id'].'">Update</a></td>';
                echo '<td class="text-center"><a class="btn btn-danger" href="program02.php?button=delete&park_id='.$row['park_id'].'&tourist_id='. $row['tourist_id'].'">Delete</i></a></td>';
            } 

            echo '</tbody></table></div></div>'; 
            mysqli_close($connection);  // close connection
        }  
        
        /**
         * Display the create new record form
         */
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
        
        /**
         * Display the update existing record form
         */
        function displayUpdateForm($park_id, $tourist_id){
            // convert to integer values
            $park = intval($park_id);
            $tourist = intval($tourist_id);

            $connection = mysqli_connect('localhost','elmclean','604577','elmclean');
            $sql = "SELECT * FROM visits WHERE park_id = $park AND tourist_id = $tourist";
            $result = mysqli_query($connection, $sql);  // run query
            $record = $result->fetch_assoc();  // get row columns

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

            mysqli_close($connection);  // close connection
        } 
        
        /**
         * Delete an existing table record
         *
         * @return header("Location: program02.php");
         */
        function deleteRecord($park_id, $tourist_id) { 
            // convert to integer values
            $park = intval($park_id);
            $tourist = intval($tourist_id);

            $connection = mysqli_connect('localhost','elmclean','604577','elmclean'); 
            $sql = "DELETE FROM visits WHERE park_id = $park AND tourist_id = $tourist"; 
            mysqli_query($connection, $sql);  // run query
            mysqli_close($connection);  // close connection

            header("Location: program02.php");  // redirect
        } 
        
        /**
         * Display an existing table record
         *
         * @return header("Location: program02.php");
         */
        function readRecord($park_id, $tourist_id) { 
            // convert to integer values
            $park = intval($park_id);
            $tourist = intval($tourist_id);
 
            $connection = mysqli_connect('localhost','elmclean','604577','elmclean');
            $sql = "SELECT * FROM visits WHERE park_id = $park AND tourist_id = $tourist";
            $result = mysqli_query($connection, $sql);  // run query
            $record = $result->fetch_assoc();  // get row columns

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

            mysqli_close($connection);  // close connection
            header("Location: program02.php");  // redirect
        } 
    } 
     
    $visit = new Visit;  // create new Visit object
    $visit->includeCSS();  // call to includeCSS() function
    $visit->displayCreateForm();  // call to displayCreateForm() function
    $visit->displayRecords();  // call to displayRecords() function
    echo "<br />";  
    
    // if record update button clicked, displayUpdateForm()
    if ($_GET['button'] == 'update') { 
        $park_id = $_GET['park_id'];
        $tourist_id = $_GET['tourist_id'];

        $visit->displayUpdateForm($park_id, $tourist_id);
    } 
    
    // if record delete button clicked, deleteRecord()
    if ($_GET['button'] == 'delete') { 
        $park_id = $_GET['park_id'];
        $tourist_id = $_GET['tourist_id'];

        $visit->deleteRecord($park_id, $tourist_id); 
    } 
    
    // if record read button clicked, readRecord()
    if ($_GET['button'] == 'read') { 
        $park_id = $_GET['park_id'];
        $tourist_id = $_GET['tourist_id'];

        $visit->readRecord($park_id, $park_id);
    }

    show_source(__FILE__);
?> 