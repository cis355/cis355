<html>
	<head>
	</head>
	<body>
		<form method="POST">
			<table>
				<tr>
					<td>Fehrenhite: </td>
					<td><input type="number" name="feh" size="30"/></td>
				</tr>
				<tr>
					<td>Submit: </td>
					<td><button type="submit" name="submit" size="30">Submit</button></td>
				</tr>
			</table>
			<?php
				if(isset($_POST['feh'])){
					echo "<br/> " . (($_POST['feh'] - 32) * 5/9);
				}
			?>
		</form>
	</body>
</html>