<?php
	echo '<a href="webservice.php">WebService</a><br /><br />';
	
	// get contents of svsu courses api
	$url = 'http://api.svsu.edu/courses?prefix=CIS&term=16/FA';
	$json = file_get_contents($url);
	//var_dump($json);
	$obj = json_decode($json);
	//var_dump($obj);
	
	echo '<html><body><table>';
	echo '<tr>
		<td>Department</td>
		<td>Course Number</td>
		<td>Course</td>
		<td>Instructor</td>
		<td>Meeting Location</td></tr>';
	
	foreach ($obj->courses as $course) {
		echo '<tr>
			<td>' . $course->prefix . '</td>' .
			'<td>' . $course->courseNumber . '</td>' .
			'<td>' . $course->title . '</td>' .
			'<td>' . $course->meetingTimes[0]->instructor . '</td>';
		foreach ($course->meetingTimes as $meeting) {
			echo '<td>' . $meeting->building . ' ' . 
				$meeting->room . '</td></tr>'; 
		}
	}
	echo '</table></body></html><br /><br /><br />';
	
	echo '<html><body><h2>Yahoo Weather</h2><table>';
	$url = 'https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%20in%20(select%20woeid%20from%20geo.places(1)%20where%20text%3D%22nome%2C%20ak%22)&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys';
	$json = file_get_contents($url);
	$obj = json_decode($json);
	
	echo '<tr>
		<td>Date</td>
		<td>High</td>
		<td>Low</td></tr>';
	
	foreach ($obj->query->results->channel->item->forecast as $f) {
		echo '<tr>
			<td>' . $f->date . '</td>' . 
			'<td>' . $f->high . '</td>' . 
			'<td>' . $f->low . '</td></tr>'; 
	}
	echo '</table></body></html><br /><br /><br />';

	show_source(__FILE__);
?>