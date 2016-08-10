<?php

echo "<a href='http://csis.svsu.edu/~cjmealey/cis355/cjmealey/webservice.php'>Web Service</a><br><br><br>";
// THIS IS LINK TO ACCESS THE COURSES API
$url = 'http://api.svsu.edu/courses?prefix=CIS&term=16/FA';
$json = file_get_contents($url);
$obj = json_decode($json);


foreach ($obj->courses as $course){
	echo '<strong>' . $course->prefix . ' ' . $course->courseNumber . ' ' . $course->title . ' (' . $course->meetingTimes[0]->instructor . ') </strong><br>';
	foreach ($course->meetingTimes as $meeting){
		echo $meeting->days . ' : ' . $meeting->building . ' ' . $meeting->room . ' : ' . $meeting->startTime . '-' . $meeting->endTime . '<br>';
	}
	echo '<br>';
}

// -- YAHOO WEATHER -- //
echo '<h4>NOW FOR THE WEATHER</h4>';
$url2 = 'https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%20in%20(select%20woeid%20from%20geo.places(1)%20where%20text%3D%22nome%2C%20ak%22)&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys';
$json2 = file_get_contents($url2);
$obj2 = json_decode($json2);
//var_dump($obj2->query->results->channel->item->forecast);
//echo $obj2->query->results->channel->item->forecast[0]->code;

foreach($obj2->query->results->channel->item->forecast as $f) {
	echo '<strong>' . $f->day . ', ' . $f->date . '</strong><br>' . 'High: ' . $f->high . '<br>Low: ' . $f->low . '<br>Will be ' . $f->text . '<br><br>';
}
show_source(__FILE__);

?>