<html>
  <head>
    <title>Information from Client</title>
  </head>
  <body>
    <?php 
    
      if(!empty($_POST["fahrenheit"])) {
        echo $_POST["fahrenheit"] . "F = " . (($_POST[ "fahrenheit"] - 32) / 1.8) . "C";        
      }
      
      $b = 50;
      $c = &$b;
      $b += 5;
      echo "<br/>" . $b . $c;
      
      echo "<p>This is the data from the form...</p>";
      date_default_timezone_set('UTC');
      echo date("h:i:s:u a, l F jS Y e");
      echo "<br/>" . $_POST["username"];
      echo "<br/>" . $_POST["streetaddress"];
      echo "<br/>" . $_POST["cityaddress"];
      echo "<br/>";
      print_r($_POST);
      
      $username = $_POST["username"];
      extract($_POST);
      $a = "hey there";
      
      define ("PI",3.1416);
      
      echo "<br/>$username<br/>$streetaddress<br/>$cityaddress" . PI;
      
      echo "<br/><br/><br/><br/>";
      
      $states = Array("Alabama","Alaska","Arizona","Arkansas");
      print_r($states);
      
      foreach ($states as $state) {
        echo "<br/>" . $state;
      }
      
      echo "<br/><br/>";
      
      $states2 = Array(
        "AL" => "Alabama",
        "AK" => "Alaska",
        "AZ" => "Arizona",
        "AR" => "Arkansas"
       );
       
       print_r($states2);
       
       foreach ($states2 as $key => $state) {
         echo "<br/>" . $key . " " . $state;
       }
       
       echo "<br/><br/>";
       $states3 = Array(
        "AL" => Array("Montgomery","Selma","Birmingham"),
        "AK" => Array("Juneau","Nome","Fairbanks"),
        "AZ" => Array("Phoenix","Tempe"),
        "AR" => Array("Little Rock")
       );
       print_r($states3);
       foreach ($states3 as $key => $value) {
         echo "<br/>" . $key . ":";
         foreach ($value as $city) {
           echo "<br/>&nbsp&nbsp" . $city;
         }
       }
      
      
      echo "<br/><br/>";
      show_source(__FILE__);
    ?>
  </body>
</html>