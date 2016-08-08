<?php
/* *******************************************************************
* filename : parks.php
* author : Terry Lewis
* username : tjlewis2
* course : cis355
* section : 01
* semester : Summer 2016
*
* description : This us a crud program that
* allows that user to perform crud opertations
* on a list of parks
*
* input : rows from the database
* processing : database
* 2. display the create new record button
* output : read, update, and delete
*
* *******************************************************************
*/
class parks {
		public $id;
		public $name;
		public $state;
		public $city;

public function showParks () {
	$connect = mysqli_connect('localhost','tjlewis2','547247','tjlewis2');	
	
	$sql = 'SELECT * FROM parks';
	
	echo '<table>
		<thead>
		    <tr>
		        <th>Park</th>
		        <th>Name</th>
		        <th>State</th>
		        <th>City</th>
		    </tr>
		</thead>
		<tbody>';
		
	foreach ($connect->query($sql) as $row) {
		echo '<tr>';
		echo '<td>'. $row['id'] . '</td>';
		echo '<td>'. $row['name'] . '</td>';
		echo '<td>'. $row['state'] . '</td>';
		echo '<td>'. $row['city'] . '</td>';
		echo '<td width="600">';
		   	
		echo '<a class="btn btn-danger" href="parks.php? id=' . $row['id'] . '">Delete Park</a>';
		echo '</td>';
		echo '</tr>';
	}
		
	echo '</tbody></table>';
	mysqli_close($connect);
	}


public function showCreateButton() {
		echo '<a href="parks.php?status=create" class="btn btn-success create">Create a park</a>';
	}


function displayCreateScreen () { 
		echo '<div class="container">';
			echo '<div class="span10 offset1">';
			echo '<div class="row">';
			echo '<h2>Create or Update a park</h2>';
			echo '<p> To update park, enter an id from the list above and update the name,state,
					  and city values and then click the update button.</p>';
			echo '<p> To create a park, enter values and click create button.</p>';
			
		echo '</div>';
		
		echo '<form class="form-horizontal" action="parks.php" method="post">';
		

			echo '<div class="control-group <label class=" control-label ">id</label>';
				echo '<div class="controls ">';
				echo '<input name="parkid" type="text " placeholder="id" >';
				echo '</div>';
			echo '</div>';
		
			echo '<div class="control-group ">';
			echo '<label class="control-label ">Name</label>';
				echo '<div class="controls ">';
				echo '<input name="name" type="text " placeholder="name"/>';
				echo '</div>';
			echo '</div>';
			
			echo '<div class="control-group">';
			echo '<label class=" control-label">State</label>';
			echo '<div class="controls ">';
				echo '<input name="state" type="state" placeholder="State" >';
				echo '</div>';
			echo '</div>';
			
			echo '<div class="control-group ">';
			echo '<label class="control-label ">City</label>';
			echo '<div class="controls ">';
				echo'<input name="city" type="city " placeholder="City"/>';
				echo '</div>';
			echo '</div>';
			
			echo '<div class="form-actions ">'; 
				echo '<button type="submit " class="btn btn-success" name="create">Create</button>';
			echo '</div>';
		
			echo '<div class="form-actions ">'; 
				echo '<button type="submit " class="btn btn-success" name="update">Update</button>';
			echo '</div>';
			
		echo '</form>';
		echo '</div></div>';


} 

public function insert($id,$name,$state,$city) {
	$connect = mysqli_connect('localhost','tjlewis2','547247','tjlewis2');
	$sql = "INSERT INTO parks (id,name,state,city) values ($id, '$name', '$state', '$city')";
	$connect->query($sql);
	mysqli_close($connect);
	header("Location: parks.php");
}

public function update($id,$name,$state,$city) {
	$connect = mysqli_connect('localhost','tjlewis2','547247','tjlewis2');
	$sql = "UPDATE parks SET name = '$name', state = '$state', city = '$city' WHERE id = '$id'";
	$connect->query($sql);
	mysqli_close($connect);
	header("Location: parks.php");
}

public function delete($id){
	$connect = mysqli_connect('localhost','tjlewis2','547247','tjlewis2');
	$sql = "DELETE FROM parks WHERE id = $id";
	$connect->query($sql);
	mysqli_close($connect);
	header("Location: parks.php");
}

}
$obj = new parks;

$obj->showParks();
$obj->displayCreateScreen();

if(isset($_POST['create']))
{
	
	$id= $_POST['parkid'];
	$name = $_POST['name'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$obj->insert($id,$name,$state,$city);
}

if(isset($_POST['update']))
{
	
	$id= $_POST['parkid'];
	$name = $_POST['name'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$obj->update($id,$name,$state,$city);
}

if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
		$obj->delete($id);
	}

//***UML DIAGRAM****	
//https://svsu0-my.sharepoint.com/personal/tjlewis2_svsu_edu/_layouts/15/guestaccess.aspx?guestaccesstoken=QyCOEqAePAdzjpEWj75Aogld%2f8fdzzNDt6A5flPY7s0%3d&docid=0b5ce26745201483084bac7f771607ac9&rev=1
show_source(__FILE__);

?>
