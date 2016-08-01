<html>
<body>
<form method="post" enctype="multipart/form-data">
  <table width="350" border="0" 
    cellpadding="1" cellspacing="1" class="box">
	<tr><td>Select a File</td></tr>
	<tr><td>
	<input type="hidden" name="MAX_FILE_SIZE" value="16000000">
	<input name="userfile" type="file" id="userfile">
	</td></tr>
	<tr><td width="80">
	<input name="upload" type="submit" class="box" id="upload" 
	  value=" Upload ">
	</td></tr>
  </table>
</form>

</body>
</html>
<?php
	/*
	echo $_FILES["file1"]["name"] . "<br />";
	echo $_FILES["file1"]["type"] . "<br />";
	echo $_FILES["file1"]["tmp_file"] . "<br />";
	echo $_FILES["file1"]["error"] . "<br />";
	echo $_FILES["file1"]["size"] . "<br />";
	*/
	
ini_set('file-uploads',true);
if(isset($_POST['upload']) && $_FILES['userfile']['size']>0)
{
  $fileName = $_FILES['userfile']['name'];
  $tmpName  = $_FILES['userfile']['tmp_name'];
  $fileSize = $_FILES['userfile']['size'];
  $fileType = $_FILES['userfile']['type'];
  $fileType = (get_magic_quotes_gpc()==0 
    ? mysql_real_escape_string($_FILES['userfile']['type'])
    : mysql_real_escape_string(stripslashes ($_FILES['userfile'])));
  $fp       = fopen($tmpName, 'r');
  $content  = fread($fp, filesize($tmpName));
  $content  = addslashes($content);
  echo "filename: " . $fileName . "<br />";
  echo "filesize: " . $fileSize . "<br />";
  echo "filetype: " . $fileType . "<br />";
  fclose($fp);
   if (! get_magic_quotes_gpc() )
   {
     $fileName = addslashes($fileName);
   }
  $con = mysql_connect('localhost','kcbenson','Kelsi42B') 
    or die(mysql_error());
  $db  = mysql_select_db('kcbenson',$con);
  if($db)
  {
    $query = "INSERT INTO uploadTest (name, size, type, content) ".
	  "VALUES ('$fileName', '$fileSize', '$fileType', '$content')";
	mysql_query($query) or die('Error... query failed!');
	mysql_close();
	echo "<br />File $fileName uploaded successfully <br />";
  }
  else
  {
    echo "file upload failed: " . mysql_error();
  }
}

?>