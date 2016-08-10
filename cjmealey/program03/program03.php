<!-- ------------------------------------------------------------------------

   _____   __  __ ______          _      ________     __
  / ____| |  \/  |  ____|   /\   | |    |  ____\ \   / /
 | |      | \  / | |__     /  \  | |    | |__   \ \_/ / 
 | |      | |\/| |  __|   / /\ \ | |    |  __|   \   /  
 | |____ _| |  | | |____ / ____ \| |____| |____   | |   
  \_____(_)_|  |_|______/_/    \_\______|______|  |_|   
                                                        

filename  : program03.php
author    : Colin Mealey
date      : 2016-08-02
email     : cjmealey@svsu.edu
course    : CIS-355
link      : csis.svsu.edu/~gpcorser/cis355/cjmealey/program03.php
backup    : github.com/cis355/cis355
purpose   : This file outputs the contents of a database as a JSON object

copyright : GNU General Public License (http://www.gnu.org/licenses/)
			This program is free software: you can redistribute it and/or modify
			it under the terms of the GNU General Public License as published by
			the Free Software Foundation, either version 3 of the License, or
			(at your option) any later version.
			This program is distributed in the hope that it will be useful,
			but WITHOUT ANY WARRANTY; without even the implied warranty of
			MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.   
            
external code used in this file: 
			G. Corser's class demonstration of how to create an API
			
program structure : 
	database call
	class Athlete
		outputJSON
			print API
	class END
	declare new Athlete
	call output function
                
------------------------------------------------------------------------- -->
<?php

function outputUML(){
// Purpose: Display UML
// Input: UML image 
// Pre: UML uploaded online to embed
// Output: UML Image
// Post: UML is displayed

	echo'<br/><br/><br/><br/><br/>
	<h3>Here is the UML</h3><br>
	<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJEAAAB+CAYAAAAkyvN0AAADJnpUWHRteEdyYXBoTW9kZWwAAE1UWQ+rOg7+NZXmvlTsyyNL6UKhUAoUXo5YAoQtlLXw60+YjnRHJLE/f4ptjM2BVppvBmtwoIhpAL2Ug3Y80OqBogy0wbqODpTGHglM/8eIEtiOaCgOtIzxtR1BjSU24/Ph4OONN0n8Ick/7D9YlbquBj6IdTjuXmj+SHO7I/3yMu4HSsF6Das99BkkFdqvKEWPGmzRWOpIHCmeoY8kuV9yoizq4f+5obBxBv0AUfvLlz3+9/kxIIUj6n/EsizHtI+WI0Q/clw78KNyhPL93akDfcKlSGGU91GDwdfzzFJEy8kiyCpFquY8B0pmbvf79CGtWEJ+Qjevwr+44uei8hxHZ8IzvHmf6ONNkyuJ7bAJVDDghG/fqsEiFj5a+86MQA9v98eHfjhxaBDvlGrFMyXDJVvZdFHf11m3mUGmrmN2MqSARIOudqaUr9Dk9DCHbidHThAQ384ieCliPYcMtuWjDriacqjq8IIlc97jTuj1sL4YbnYmKIk9X9tor+Bahjy3CXn2pvQpb/RnyL84ENfNoLmBaOqbQiylfpmK3HRu3viZqVnSOnVLwNtYtlosxqrwzcjxRq1/EuKDPSdFSW9CRbR24N1mc8WfW0ajt/HlerYzhYvYzlwhroJcVhY98G56WrfA04fS/wrYyho0wXnb8IYG80hZNii3QQ23W+5aD8cj5Q0hJxqBVZBrDko3O1/7iigXV6qiMOisVUes0/r+zb0Jn093M203fdJ9mArbo6LiwDZOZRKniQpiHAwmo26GjpUMWeMwsTgH6UXt3SvATa2NviKNuI21dElnwWR1YjFZYs4aPAEaXn1NZ3NmYu0FnVoYvymP/AqydtBGSdo+Mrtsm9pX7vW90pROvzNcXjpS+bbmfmzd95DD957EFN9DBUZTVcWXps8HdDqTYuDwF/7iT9oo4QDSSchLSu/KHoMzZfvIviCqPy0YAoaTc+uKHUn3ZyGiUAkSGQyGuqyc0w8vxizwgMl3lWA289EipAjCaRYD0F8ZfwE0TGe5+jIkmKetONv7MOwL95D27wz88P9+D/TpL4ayyaUAABdCSURBVHhe7d0FkFs31wZg9UuZmblTZmZmZmZmZm4KaZsyMzNzyimnzIxpO2VMmZt/Hs2vzK1re732prG90kxms+t7dXWl1+ccHXg11MCBAweG3PIMNDADQwHRUEMN1UAX+dbuOANF2TMIRFkgdUco1PfOhE4GUX1zl+/6/xnIIMpQaHgGgOjBBx+M/Sy66KIhq7OGp7T7dZBB1P3WvMvfOIOoy6e0+3XYbUB08cUXh8033zwsuOCC4YEHHgjDDDNMXO3vv/8+PPfcc2GyySYLU0wxRbjlllvCaqutFl544YUw66yz/gMRv/76a5h33nnDdNNNF6666qrwv//9ryJiXnrppfDDDz+EeeaZZ9Cz2hVe3QJEf/75Z1hsscXCY489FtexCJD3338/gue0004LO+20U7j++uvD2muvXRFEc845Z5hqqqnCzTffXBVEW221VbjtttvCe++9F0YaaaR2xU98r24BojfeeCNMP/30gxbyqKOOCgcccED48ssvw9577x0uueSSMO6444YrrrgiDBgwIILI3wHgww8/DLvuumvYcMMNQ6kk+uOPP0Lv3r3D6aefHqaccsqwyy67hPXWWy9ce+218f9ffPFF2HnnncPRRx8dvv3223DooYeGCy+8MCy//PKhZ8+eYe65524LcHULEJ100klhjz32CHfeeWc45JBDwtdffx1eeeWV+HPZZZcNr732WlzMa665JkoXINL8vO666+L/X3311QiUpM6uvPLKQNpQk2uuuWZ4/vnnI+iouU8//TQ+T5tvvvmidFtkkUXi51tssUUEkvbmm2+GaaaZpuWB1PYgStLjxx9/jIt28sknRynTr1+/MP/884ekzs4777wIiqTOgIFUSbbU008/HWaaaaZBICJdqLUVV1wxXH755RE4M8wwQ1h55ZXDTTfdFHbfffcIyrfffjv6UFZdddXQq1evsOeee4Y+ffqE1VdfPUqwHXfcMYOo2WfA4jNuqasTTjgh3HPPPeGyyy6LQKKKLDJpkBa01CZKv5eC6PDDD48GdmlbeOGFo+FOnbmXKr3//vsHSbfi9SeeeGIEW6u3tpdE++23Xzj22GP/tU5AZYG/+uqrCKJSSQQ0c8011yDJVAoi9s2MM84Y1RN1SeJ98MEHYeihhw6zzz57BBFJ1L9//3DHHXeEddZZJz5j/fXXj2r0o48+CuOMM06YeuqpWx1D7W1Y275b0N9//z08/PDDYbTRRos2z4EHHhjOPPPMaCNNPvnk0ei2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" style="cursor:pointer;max-width:100%;" onclick="(function(img){if(img.wnd!=null&&!img.wnd.closed){img.wnd.focus();}else{var r=function(evt){if(evt.data=="ready"&&evt.source==img.wnd){img.wnd.postMe"sage(decodeURIComponent(img.getAttribute("src")),"*"");window.removeEventListener("message",r);}};window.addEventListener("message",r);img.wnd=window.open("https://www.draw.io/?client=1&lightbox=1&chrome=0&edit=_blank");}})(this);"/>';
	echo' <br><br>';
}


require ("database.php");
class Athlete
{
	private static $id;
	private static $name;
	private static $sport;
	private static $team;

	function outputJSON() {
	// Purpose: Print the database as a JSON object
	// Input: database called "athletes"
	// Pre: the database exists
	// Output: in site as JSON object
	// Post: all contents of "athletes" output as an API

		echo' {'; // begin object
		echo' "athletes":';
		echo' ['; //begin array

		$pdo = Database::connect();
		$sql = 'SELECT * FROM athletes ORDER BY id DESC';

		$str = "";
		foreach ($pdo->query($sql) as $row) {
			
				$str .= '{';
				$str .= '"id":"' . $row['id'];
				$str .= '", "name":"' . $row['name'];
				$str .= '", "sport":"' . $row['sport']; 
				$str .= '", "team":"' . $row['team'] . '"';
				$str .= '},';
		}
		$str = substr($str, 0, -1); //remove comma
		echo $str;

		Database::disconnect();

		echo'] '; //end array
		echo'} '; // end object
	}

}

//Implement JSON
$cust=New Athlete;
$cust->outputJSON();
outputUML();

show_source(__FILE__);

?>