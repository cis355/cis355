<?php
  //get contents of svsu courses api
  $url = 'http://api.svsu.edu/courses?prefix=CIS&term=16/FA';
  $json = file_get_contents($url);
  //var_dump($json);
  $obj = json_decode($json);
  //var_dump($obj);
  foreach($obj->courses as $course){
    echo $course->prefix;
    echo $course->courseNumber . " ";
    echo $course->title;
    echo ' (' . $course->meetingTimes[0]->instructor . ')';
    foreach($course->meetingTimes as $mt){
      echo $mt->days . ':';
      echo $mt->building . $mt->room;
      
    }//end foreach meeting
    echo '<br/>';
  }//end foreach
  
  show_source(__FILE__);
?>