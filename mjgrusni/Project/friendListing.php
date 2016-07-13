<html>
<head>
    <title>Steam Thing</title>
</head>
<body>

<?php

$submittedID = $_POST["idToFind"];
$_POST['originalID'] = $submittedID;
echo $submittedID;
$url = 'http://api.steampowered.com/ISteamUser/GetFriendList/v0001/?key=226D6A33C502B0FB5AF1C013F8452A23&steamid=' . $submittedID . '&relationship=friend';
echo $url;
$obj = json_decode(file_get_contents($url), true);

print_r($obj['friendslist']['friends']);

foreach ($obj['friendslist']['friends'] as $friend) {
	
	$friendIDs = $friendIDs . $friend['steamid'] . ',';	
	
	//echo $friendIDs;
	//echo "<br>";
	
}
echo $friendIDs;
$friendListUrl = 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=226D6A33C502B0FB5AF1C013F8452A23&steamids=' . $friendIDs;
echo "<br>";
echo $friendListUrl;
echo "<br>";
$friendObj = json_decode(file_get_contents($friendListUrl), true);
echo '<form action="selectFriend.php" method="post">';
foreach ($friendObj['response']['players'] as $friendItem) {
	
	echo '<input type="submit" name="' . $friendItem['steamid'] . '" value="' . $friendItem['personaname'] . '">';
	
	echo $friendItem[personaname];
	echo "<br>";
	
}
echo '</form>'
?>

</body>
</html>