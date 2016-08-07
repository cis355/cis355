<?php
mysql_connect("localhost","arhender","530612");
mysql_select_db("arhender");
// if first time calling this php file, use first pic
// else use value entered from form
$id = 1; 
if(isset($_POST['img_id'])) $id = $_POST['img_id'];
// ----- display list of files available by id -----
$query = "SELECT id, name, size, type 
  FROM arh_upload";
$result  = mysql_query ($query);
while ($row = mysql_fetch_assoc($result)) 
{
  echo "<p>" . $row['id'] . ' ' . $row['name'] . 
    ' ' . $row['size'] . ' ' . $row['type'] . "</p>";
}
echo "<form method='post' action='filedownload.php' >";
echo "<input name='img_id' type='text'>";
echo "<input type='submit' value='Submit'>";
echo "</form>";
$query = "SELECT name, size, content, type 
  FROM arh_upload WHERE id=$id";
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






