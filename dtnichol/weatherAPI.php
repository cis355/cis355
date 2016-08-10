<?php
//get contents of yahoo weather api
$url ='https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%20in%20(select%20woeid%20from%20geo.places(1)%20where%20text%3D%22nome%2C%20ak%22)&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys';
$json = file_get_contents($url);
//var_dump($json);
$obj = json_decode($json);
var_dump($obj);

foreach($obj->query->results->channel->item->forecast as $f){
	echo $f->code . " " ;
	echo $f->date . " " ;
	echo $f->day . " " ;
	echo $f->high . " " ;
	echo $f->low . " " ;
	echo $f->text;
	echo '<br />';
}
//foreach ($obj->courses as $course){
//	echo '<tr>';
//	echo $course->prefix . " - ";
//	echo $course->courseNumber . " ";
//	echo $course->title;
//	echo ' (' . $course->meetingTimes[0]->instructor . ') ';
//	foreach ($course->meetingTimes as $meeting){
//		echo $meeting->days . ':';
//		echo $meeting->building . ' - ' . $meeting->room . ' ';
//	}// end for each
//	echo '<br />';
//}//end for each

show_source(__FILE__);
?>