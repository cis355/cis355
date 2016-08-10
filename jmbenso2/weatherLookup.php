<?php

// Get contents of weather json
$url = 'https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%20in%20(select%20woeid%20from%20geo.places(1)%20where%20text%3D%22nome%2C%20ak%22)&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys';
$json = file_get_contents($url);

$obj = json_decode($json);

//Get temperature units
$tempUnit = $obj->query->results->channel->units->temperature;

echo $obj->query->results->channel->title . '<br />';
echo 'Current: <br />';
echo $obj->query->results->channel->item->condition->date . '<br />';
echo $obj->query->results->channel->item->condition->temp . ' ';
echo $tempUnit .'<br />';
echo $obj->query->results->channel->item->condition->text .'<br />';
echo '<br />';
echo 'Forecast: <br /><br />';
foreach($obj->query->results->channel->item->forecast as $day) {
	echo '----' . $day->day .', '. $day->date .'----<br />';
	echo 'High: ' . $day->high . ' ' . $tempUnit . '<br />';
	echo 'Low: ' . $day->low . ' ' . $tempUnit . '<br />';
	echo 'Condition: ' . $day->text . '<br />';
	echo '<br />';
}

show_source(__FILE__);

?>