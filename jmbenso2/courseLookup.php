<?php

// Get contents of SVSU courses API
$url = 'http://api.svsu.edu/courses?prefix=CIS&term=16/FA';
$json = file_get_contents($url);

//var_dump($json);
$obj = json_decode($json);

foreach ($obj->courses as $course) {
	echo $course->prefix;
	echo '-';
	echo $course->courseNumber;
	echo ', ';
	echo $course->title;
	echo ' (';
	echo $course->instructors[0]->name;
	echo ')';
	foreach ($course->meetingTimes as $meeting) {
		echo ' [';
		echo $meeting->days . ': ';
		echo $meeting->building . '-';
		echo $meeting->room;
		echo '] ';
	}
	echo '<br />';
} // End foreach

show_source(__FILE__);

?>