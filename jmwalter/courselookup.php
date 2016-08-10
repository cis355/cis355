<?php
//josh walters 
//api extra credit
$url = 'http://api.svsu.edu/courses'; 
$json = file_get_contents($url);
$obj = json_decode($json);

foreach ($obj->courses as $course)
{
    echo $course->prefix . '-'; 
    echo $course->courseNumber . ' '; 
    echo $course->title; 
    echo ' (' . $course->meetingTimes[0]->instructor . ') '; 
    foreach ($course->meetingTimes as $meeting) { 
        echo $meeting->days . ':'; 
        echo $meeting->building . '-' . $meeting->room . ' '; 
    } 
    echo '<br />'; 

}

//weather api stuff 
$url = 'https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%20in%20(select%20woeid%20from%20geo.places(1)%20where%20text%3D%22nome%2C%20ak%22)&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys';
$json = file_get_contents($url); 
$obj = json_decode($json); 
var_dump($obj); 

foreach ($obj->query->results->channel->item->forecast as $f) { 
    echo $f->date. ' ' . $f->high . ' ' . $f->low . '<br />'; 
} 
show_source(__FILE__);
?>