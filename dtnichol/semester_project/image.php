
<?php

//connect to database
mysql_connect("localhost","dtnichol","99DT44Nichols");
mysql_select_db("dtnichol");


// if first time calling this php file, use first pic
// else use value entered from form
$id = 1; 
if(isset($_POST['img_id'])) $id = $_POST['img_id'];
// ----- display list of files available by id -----
$query = "SELECT id, name, size, type 
  FROM images";
$result  = mysql_query ($query);

//display list
while ($row = mysql_fetch_assoc($result)) 
{
  echo "<p>" . $row['id'] . ' ' . $row['name'] . 
    ' ' . $row['size'] . ' ' . $row['type'] . "</p>";
}
echo "<form method='post' action='image.php' >";

echo "</form>";
$query = "SELECT name, size, content, type 
  FROM images WHERE id=$id";
$result  = mysql_query ($query);
$name    = mysql_result($result, 0, "name");
$size    = mysql_result($result, 0, "size");
$type    = mysql_result($result, 0, "type");
$content = mysql_result($result, 0, "content");
 Header( "Content-type: $type");
// print $content;
echo "<img height='20%' width='20%'
  src='data:image/jpeg;base64," 
  . base64_encode($content) . "'>";
?>
