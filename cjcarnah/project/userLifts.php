<?php
/* *******************************************************************
* filename : userLifts.php
* author : Charles Carnahan
* username : cjcarnah
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* This file contains a class handling all of the output and 
* queries from a personal trainer client routine keeping application.
*
* input : user input
*
* precondition : database with tables 'users', 'lifts', and 'userLifts' is used.
* *******************************************************************
*/

require ("database.php");

class userLift {

    //Show Source Code
    public function showSource(){
        echo "userLifts.php";
        show_source(__FILE__);
    }
    
    //Get Data
    public function fetchAll($result){
        //echo 'in fetch all';
        $array = array();
        while($row = $result->fetch_assoc()){
         //echo 'row';
            $array[] = $row;
        }
        
        return $array;
    }
    
    
    //Displays header
    public function showHeader(){
    echo '
<head>
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>';

    echo "
        <div class='jumbotron vertical-center'> <!-- 
                      ^--- Added class  -->
        <div class='container' vertical-center>
        <html>
        <head>
            <title>Client Routines</title>
        </head>
        <body>
        <h1><a href='index.php?pg=readUsers'>Clients</a>".str_repeat('&nbsp;', 5)."
        <a href='index.php?pg=readLifts'>Lift Library</a></h1><br>
        ";
    }
    
    //Creates footer
    public function showFooter(){
        echo "
        </div>
        </div>
        </body>
        </html>
        ";
    }
    
    //Make Table if it Doesn't Exist
    public function makeTable($con){

        $query = $con->query("Select * from users LIMIT 1") or die("Can't fetch data");
        $query = $con->query("Select * from lifts LIMIT 1") or die("Can't fetch data");
        
    }
    
    //Create user
    public function createUser($con,$name,$eMail,$age){
        $sql = "INSERT INTO users (name,eMail,age) values('$name','$eMail','$age')";
        mysqli_query($con,$sql);
    }
    
    //Create lift
    public function createLift($con,$name,$sets,$reps,$restTime){
        $sql = "INSERT INTO lifts (name,sets,reps,restTime) values('$name','$sets','$reps','$restTime')";
        mysqli_query($con,$sql);
    }
    
    //Create Userlift
    public function createUserLift($con, $liftId, $userId){
        $sql = "INSERT INTO userLifts (liftId,userId) values('$liftId','$userId')";
        mysqli_query($con,$sql);
    }
    
    //Update user
    public function updateUser($con,$id,$name,$eMail,$age){
        $sql = "UPDATE users SET name = '$name', eMail = '$eMail', age = '$age' WHERE id = '$id'";
        mysqli_query($con,$sql);
    }
    
    public function getUsernameFromId($con, $id){
        $sql = "SELECT users.name FROM users WHERE id = '$id'";
        $query = self::fetchAll(mysqli_query($con,$sql));

        return $query[0]['name'];
    }
    
    //Access user Routine
    public function userRoutine($con,$id){
        $uname = self::getUsernameFromId($con, $id);
        Echo "<h2>".$uname."'s Routine</h1>";
        echo "<a href='index.php?pg=addRoutineLifts&id=".$id."'>Add Lift to Routine</a><br><br>";
        $sql = "SELECT lifts.id, lifts.name, lifts.reps, lifts.sets, lifts.restTime, userLifts.days, userLifts.userId, userLifts.id as ulid
                FROM lifts, userLifts
                WHERE lifts.id = userLifts.liftId AND userLifts.userId = '$id'";
        $query = self::fetchAll(mysqli_query($con,$sql));
        echo '<table>
               <thead>
               <tr>
                 <th>Lift Name</th> 
                 <th>Sets</th>
                 <th>Reps</th>
                 <th>Command</th>
               </tr>    
             </thead>
             <tbody>';
        foreach($query as $lift){
            echo "<tr><td>".$lift['name'].str_repeat('&nbsp;', 5)."</td><td>".$lift['sets'].str_repeat('&nbsp;', 8)."</td><td>".$lift['reps'].str_repeat('&nbsp;', 8)."</td><td><a href='index.php?m=deleteUserLift&id=".$lift['ulid']."&userId=".$lift['userId']."'>Remove</a>";
        }
        echo "</tbody></table>";                
    }
    
    //Update Lift
    public function updateLift($con,$id,$name,$sets,$reps,$restTime){
        $sql = "UPDATE lifts SET name = '$name', reps = '$reps', sets = '$sets', restTime = '$restTime' WHERE id = '$id'";
        mysqli_query($con,$sql);
    }
    
    //Delete user
    public function deleteUser($con,$id){
        $sql = "DELETE FROM users WHERE id = '$id'";
        mysqli_query($con,$sql);
    }
    
        //Delete lift
    public function deleteLift($con,$id){
        $sql = "DELETE FROM lifts WHERE id = '$id'";
        mysqli_query($con,$sql);
    }
    
    //Delete user lift
    public function deleteUserLift($con,$id){
        $sql = "DELETE FROM userLifts WHERE id = '$id'";
        mysqli_query($con,$sql);
    }
    
    //Read user
    public function read_user($con,$id){
        $sql = "SELECT * FROM users WHERE id = '$id'";
        $result = mysqli_query($con,$sql);
        //$result = $con->query($sql);
        return self::fetchAll($result);
    }
    
    //Read lift
    public function read_lift($con,$id){
        $sql = "SELECT * FROM lifts WHERE id = '$id'";
        $result = mysqli_query($con,$sql);
        //$result = $con->query($sql);
        return self::fetchAll($result);
    }
    
    //Create User Form
    public function getCreateUserForm(){ 
        echo '
            <form method="POST" action="index.php?m=createUser">
                Name: <input name="name" type="text" /><br>
                E-Mail: <input name="eMail" type="text" /><br>
                Age: <input name="age" type="text" /><br>
                <input type="submit" value="Submit" /><br>
            </form>';
    }
    
    //Create Lift Form
    public function getCreateLiftForm(){
        echo '
            <form method="POST" action="index.php?m=createLift">
                Name: <input name="name" type="text" /><br>
                Sets: <input name="sets" type="text" /><br>
                Reps: <input name="reps" type="text" /><br>
                Rest Time: <input name="restTime" type="text" /><br>
                <input type="submit" value="Submit" /><br>
            </form>';
    }
        
    //user Update Form
    public function getUserUpdateForm($con){
        $user = self::read_user($con,$_GET['id']);
        echo '
            <form method="POST" action="index.php?m=updateUser">
                user ID: <input name="id" type="text" value="'.$user[0]['id'].'" readonly/><br>
                Name: <input name="name" type="text" value="'.$user[0]['name'] .'"/><br>
                E-Mail: <input name="eMail" type="text" value="'.$user[0]['eMail'].'"/><br>
                age: <input name="age" type="text" value="'.$user[0]['age'].'"/><br>
                <input type="submit" value="Submit"/><br>
            </form>
        ';
    }
    
    //lift Update Form
    public function getLiftUpdateForm($con){
        $lift = self::read_lift($con,$_GET['id']);
        echo '
            <form method="POST" action="index.php?m=updateLift">
                lift ID: <input name="id" type="text" value="'.$lift[0]['id'].'" readonly/><br>
                Name: <input name="name" type="text" value="'.$lift[0]['name'] .'"/><br>
                Sets: <input name="sets" type="text" value="'.$lift[0]['sets'].'"/><br>
                Reps: <input name="reps" type="text" value="'.$lift[0]['reps'].'"/><br>
                Rest Time(sec): <input name="restTime" type="text" value="'.$lift[0]['restTime'].'"/><br>
                <input type="submit" value="Submit"/><br>
            </form>
        ';
    }
    
    //user Request Form
    public function getuserRequestForm(){
        echo '
            <form method="GET" action="index.php?pg=updateUser">
                <input name="pg" value="update" type="hidden" />
                user ID: <input name="id" type="text" /><br>
                <input type="submit" value="Submit">
            </form>
        ';
    }
    
    //lift Request Form
    public function getliftRequestForm(){
        echo '
            <form method="GET" action="index.php?pg=updateLift">
                <input name="pg" value="update" type="hidden" />
                Lift ID: <input name="id" type="text" /><br>
                <input type="submit" value="Submit">
            </form>
        ';
    }

    //Delete Form
    public function getDeleteForm(){
        echo '
            <form method="POST" action="index.php?m=deleteLift">
                lift ID: <input name="id" type="text" /><br>
                <input type="submit" value="Submit">
            </form>        
        ';
    }
    
    //Create Lift Form
    public function getAddRoutineLiftsList($con, $id){
    $uname = self::getUsernameFromId($con, $id);
    echo '<h2>Adding for '. $uname.'</h2>';
    
        $sql = "SELECT * FROM lifts ORDER BY id DESC";
        $query = self::fetchAll(mysqli_query($con,$sql));
        echo '<table>
               <thead>
               <tr>
                 <th>Name</th>
                 <th>Sets</th>
                 <th>Reps</th>
                 <th>Command</th>
               </tr>
             </thead>
             <tbody>';
        foreach($query as $lift){
            echo "<tr><td>".$lift['name'].str_repeat('&nbsp;', 5)."</td><td>".$lift['sets'].str_repeat('&nbsp;', 8)."</td><td>".$lift['reps'].str_repeat('&nbsp;', 8)."</td><td><a href='index.php?pg=addLiftToRoutine&liftId=".$lift['id']."&userId=".$id."'>Add</a>";
        }
        echo "</tbody></table>";
    }

    //Display Table of users
    public function readUsers($con){
        $sql = "SELECT * FROM users ORDER BY id DESC";
        $query = self::fetchAll(mysqli_query($con,$sql));
        echo "<a href='index.php?pg=createUser'>Add User</a><br><br>";
        echo '<table>
               <thead>
               <tr>
                 <th>Name        </th>
                 <th>E-Mail        </th>
                 <th>Age         </th>
                 <th>Command       </th>
               </tr>
             </thead>
             <tbody>';
        foreach($query as $user){
            echo "<tr><td>".$user['name'].str_repeat('&nbsp;', 5)."</td><td>".$user['eMail'].str_repeat('&nbsp;', 5)."</td><td>".$user['age'].str_repeat('&nbsp;', 5)."  </td><td><a href='index.php?pg=updateUser&id=".$user['id']."'>Edit</a>  |  <a href='index.php?m=deleteUser&id=".$user['id']."'>Delete</a>  |  <a href='index.php?m=userRoutine&id=".$user['id']."'>Routine</a>";
        }
        echo "</tbody></table>";
    }

        //Display Table of lifts
    public function readLifts($con){
        $sql = "SELECT * FROM lifts ORDER BY id DESC";
        $query = self::fetchAll(mysqli_query($con,$sql));
        echo "<a href='index.php?pg=createLift'>Add Lift</a><br><br>";
        echo '<table>
               <thead>
               <tr>
                 <th>Name   </th>
                 <th>Sets   </th>
                 <th>Reps   </th>
                 <th>Command</th>
               </tr>
             </thead>
             <tbody>';
        foreach($query as $lift){
            //echo "<tr><td>".$lift['id']."</td><td>".$lift['name']."</td><td>".$lift['sets']."</td><td>".$lift['reps']."</td><td><a href='index.php?pg=updateLift&id=".$lift['id']."'>Update</a>  |  <a href='index.php?m=deleteLift&id=".$lift['id']."'>Delete</a>";
            echo "<tr><td>".$lift['name'].str_repeat('&nbsp;', 5)."</td><td>".$lift['sets'].str_repeat('&nbsp;', 8)."</td><td>".$lift['reps'].str_repeat('&nbsp;', 8)."</td><td><a href='index.php?pg=updateLift&id=".$lift['id']."'>Update</a>  |  <a href='index.php?m=deleteLift&id=".$lift['id']."'>Delete</a>";
        }
        echo "</tbody></table>";
    }

    //Builds the Webpage
    public function buildPage($con){
        self::showHeader();
        if(isset($_GET['pg'])){
            if($_GET['pg'] == 'createUser'){
                self::getCreateUserForm();
            }elseif($_GET['pg'] == 'createLift'){
                self::getCreateLiftForm();
            }elseif($_GET['pg'] == 'read'){
                self::read($con);
            }elseif($_GET['pg'] == 'readUsers'){
                self::readUsers($con);
            }elseif($_GET['pg'] == 'addLiftToRoutine'){
                self::createUserLift($con,$_GET['liftId'],$_GET['userId']);
                self::userRoutine($con,$_GET['userId']);
            }elseif($_GET['pg'] == 'addRoutineLifts'){
                self::getAddRoutineLiftsList($con, $_GET['id']);
            }elseif($_GET['pg'] == 'readLifts'){
                self::readLifts($con);
            }elseif($_GET['pg'] == 'updateUser'){
                if(!isset($_GET['id'])){
                    self::getuserRequestForm();
                }else{ 
                    self::getuserUpdateForm($con);
                }
            }elseif($_GET['pg'] == 'updateLift'){
                if(!isset($_GET['id'])){
                    self::getliftRequestForm();
                }else{ 
                    self::getLiftUpdateForm($con);
                }
            }elseif($_GET['pg'] == 'delete'){
                self::getDeleteForm();
            }
        }
    }
}
?>