<?php 
    require_once('course.php');
    $course = new course();
    
    $con = database::connect();
    
    //Request course Table
    $course->makeTable($con);
    
    //Builds Page
    $course->buildPage($con);
    
    
    //Checks to see if a command was selected
    if(isset($_GET['m'])){
        //Create course
        if($_GET['m'] == 'create'){
            $course->create($con,$_POST['name'],$_POST['instructor'],$_POST['major']);
        }
        //Update course
        if($_GET['m'] == 'update'){
            $course->update($con,$_POST['id'],$_POST['name'],$_POST['instructor'],$_POST['major']);
        }
        //Delete course
        if($_GET['m'] == 'delete'){
            //Delete request from Form
            if(isset($_POST['id'])){
                $course->delete_course($con,$_POST['id']);    
            }
            //Delete request from Read Table
            if(isset($_GET['id'])){
                $course->delete_course($con,$_GET['id']);   
            }
        }
    }
    
    echo '<br><br>';
    $course->showSource(); 
   
    show_source(__FILE__);
?> 