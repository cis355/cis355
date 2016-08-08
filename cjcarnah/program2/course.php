<?php

require ("database.php");

class course {

    //private static $con = null;//database::connect();

    //Show Source Code
    public function showSource(){
        echo "course.php";
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
        echo "
        <html>
        <head>
            <title>CRUD</title>
        </head>
        <body>
        <h1><a href='index.php?pg=create'>Add Course</a> <br>
        <a href='index.php?pg=read'>Show Courses</a> <br>
        <a href='index.php?pg=update'>Change Course</a> <br>
        <a href='index.php?pg=delete'>Remove Course</a></h1>
        ";
    }
    
    //Creates footer
    public function showFooter(){
        echo "
        </body>
        </html>
        ";
    }
    
    //Make Table if it Doesn't Exist
    public function makeTable($con){
        //echo 'd';
        //$con = database::connect();
        //var_dump($con);
         //echo $con->server_version;
        $query = $con->query("Select 1 from courses LIMIT 1") or die("Can't fetch data");
    }
    
    //Create course
    public function create($con,$name,$instructor,$major){
        $sql = "INSERT INTO courses (name,instructor,major) values('$name','$instructor','$major')";
        mysqli_query($con,$sql);
    }
    
    //Update course
    public function update($con,$id,$name,$instructor,$major){
        $sql = "UPDATE courses SET name = '$name', instructor = '$instructor', major = '$major' WHERE id = '$id'";
        mysqli_query($con,$sql);
    }
    
    //Delete course
    public function delete_course($con,$id){
        $sql = "DELETE FROM courses WHERE id = '$id'";
        mysqli_query($con,$sql);
    }
    
    //Read course
    public function read_course($con,$id){
        $sql = "SELECT * FROM courses WHERE id = '$id'";
        $result = mysqli_query($con,$sql);
        //$result = $con->query($sql);
        return self::fetchAll($result);
    }
    
    //Create Form
    public function getCreateForm(){ 
        echo '
            <form method="POST" action="index.php?m=create">
                Name: <input name="name" type="text" /><br>
                instructor: <input name="instructor" type="text" /><br>
                Major: <input name="major" type="text" /><br>
                <input type="submit" value="Submit" /><br>
            </form>';
    }
    
    //class Update Form
    public function getclassUpdateForm($con){
        $class = self::read_course($con,$_GET['id']);
        echo '
            <form method="POST" action="index.php?m=update">
                Class ID: <input name="id" type="text" value="'.$class[0]['id'].'" readonly/><br>
                Name: <input name="name" type="text" value="'.$class[0]['name'] .'"/><br>
                instructor: <input name="instructor" type="text" value="'.$class[0]['instructor'].'"/><br>
                Major: <input name="major" type="text" value="'.$class[0]['major'].'"/><br>
                <input type="submit" value="Submit"/><br>
            </form>
        ';
    }
    
    //class Request Form
    public function getclassRequestForm(){
        echo '
            <form method="GET" action="index.php?pg=update">
                <input name="pg" value="update" type="hidden" />
                Class ID: <input name="id" type="text" /><br>
                <input type="submit" value="Submit">
            </form>
        ';
    }

    //Delete Form
    public function getDeleteForm(){
        echo '
            <form method="POST" action="index.php?m=delete">
                class ID: <input name="id" type="text" /><br>
                <input type="submit" value="Submit">
            </form>        
        ';
    }

    //Display Table of courses
    public function read($con){
        $sql = "SELECT * FROM courses ORDER BY id DESC";
        $query = self::fetchAll(mysqli_query($con,$sql));
        echo '<table>
               <thead>
               <tr>
                 <th>ID</th>
                 <th>Name</th>
                 <th>Instructor</th>
                 <th>Major</th>
                 <th>Command</th>
               </tr>
             </thead>
             <tbody>';
        foreach($query as $course){
            echo "<tr><td>".$course['id']."</td><td>".$course['name']."</td><td>".$course['instructor']."</td><td>".$course['major']."</td><td><a href='index.php?pg=update&id=".$course['id']."'>Update</a>  |  <a href='index.php?m=delete&id=".$course['id']."'>Delete</a>";
        }
        echo "</tbody></table>";
    }

    //Builds the Webpage
    public function buildPage($con){
        echo "<a href='Project2UML.jpg'>UML Diagram</a>";
        self::showHeader();
        if(isset($_GET['pg'])){
            if($_GET['pg'] == 'create'){
                self::getCreateForm();
            }elseif($_GET['pg'] == 'read'){
                self::read($con);
            }elseif($_GET['pg'] == 'update'){
                if(!isset($_GET['id'])){
                    self::getclassRequestForm();
                }else{
                    self::getclassUpdateForm($con);
                }
            }elseif($_GET['pg'] == 'delete'){
                self::getDeleteForm();
            }
        }
        self::showFooter();
    }
}
?>