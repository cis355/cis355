<html>
<head>
    <title>Steam Thing</title>
</head>
<body>

<?php

# include connection data and functions
require 'database.php';

$submittedID = $_POST["idToFind"];
$_POST['originalID'] = $submittedID;
echo $submittedID;
$gamesURL = 'http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=226D6A33C502B0FB5AF1C013F8452A23&steamid=' . $submittedID . '&format=json';
$gamesObj = json_decode(file_get_contents($gamesURL), true);
print_r($gamesObj['response']['games']);

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "INSERT INTO steam_user_games (steam_id, game_id) values(?, ?)";
			
foreach ($gamesObj['response']['games'] as $game) {
	echo $game['appid'];
	echo "<br>";
	$q = $pdo->prepare($sql);
	$q->execute(array($submittedID, $game['appid']));
	
}
Database::disconnect();
//header("Location: se_index.php");

$url = 'http://api.steampowered.com/ISteamUser/GetFriendList/v0001/?key=226D6A33C502B0FB5AF1C013F8452A23&steamid=' . $submittedID . '&relationship=friend';
echo $url;
$obj = json_decode(file_get_contents($url), true);

//print_r($obj['friendslist']['friends']);

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