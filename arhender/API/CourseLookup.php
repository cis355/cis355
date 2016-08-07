<?php
//get contents of svsu courses api
$url = 'http://api.svsu.edu/courses?prefix=CIS&term=16/FA';

$json = file_get_contents($url);

var_dump($json);

$obj = json_decode($json);

//var_dump($obj);

foreach ($obj->courses as $course){
	
	
	echo $course->prefix . " " . $course->courseNumber . ": " . $course->title . '<br/>';
	echo $course->meetingTimes[0]->instructor . " <br/>" ;
	foreach ($course->meetingTimes as $meetings){
		echo $meetings->building . "-" . $meetings->room . "<br/>" ;
		
	}
	echo '<br/>';
	
	
}


show_source(__File__);




?>