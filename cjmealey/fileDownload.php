<?php
/*
	echo $_FILES["file1"]["name"]. "<br/>";
	echo $_FILES["file1"]["type"]. "<br/>";
	echo $_FILES["file1"]["tmp_file"]. "<br/>";
	echo $_FILES["file1"]["error"]. "<br/>";
	echo $_FILES["file1"]["size"]. "<br/>";
*/

	foreach ($_FILES as $fileKey => $fileArray) {
		if ($fileArray["error"] != UPLOAD_ERR_OK) { // error
		echo "Error: " . $fileKey . " has error" . $fileArray["error"]
		. "<br>";
	}
	else { // no error
	echo $fileKey . "Uploaded successfully ";
	}
}

mysql_connect("localhost","cjmealey","564667");
mysql_select_db("cjmealey");
// if first time calling this php file, use first pic
// else use value entered from form
$id = 1; 
if(isset($_POST['img_id'])) $id = $_POST['img_id'];
// ----- display list of files available by id -----
$query = "SELECT id, name, size, type 
  FROM cjmealey_up02";
$result  = mysql_query ($query);

//display row
while ($row = mysql_fetch_assoc($result)) 
{
  echo "<p>" . $row['id'] . ' ' . $row['name'] . 
    ' ' . $row['size'] . ' ' . $row['type'] . "</p>";
}
echo "<form method='post' action='fileDownload.php' >";
echo "<input name='img_id' type='text'>";
echo "<input type='submit' value='Submit'>";
echo "</form>";
$query = "SELECT name, size, content, type 
  FROM cjmealey_up02 WHERE id=$id";
$result  = mysql_query ($query);
$name    = mysql_result($result, 0, "name");
$size    = mysql_result($result, 0, "size");
$type    = mysql_result($result, 0, "type");
$content = mysql_result($result, 0, "content");
// Header( "Content-type: $type");
// print $content;
echo "<img height='auto' width='50%'
  src='data:image/jpeg;base64," 
  . base64_encode($content) . "'>";

?>