 <html>
	<head>
		<title>Information from Client!</title>
		<style>
			#container
			{
				width:100%;
				height:100%;
				padding-top: 10%;
				background-color: #99ccff;
				
			}
			.main
			{
				width: 50%;
				height: 35%;
				background-color: #e6f2ff;
				border-radius: 25px;
				position: absolute;
				right: 25%;
			}
			.space
			{
				height:25%;
			}
			.sending
			{
				margin-left: 35%;
				margin-top: 5%;
			}
			.center
			{
				text-align: center;
			}
			
		</style>
	</head>
	
	<body>
	<div id="container">
		<div class="main">
		
		</br>
			<div>
				<form action="learnPhp.php" method="POST" >
					
					<table class="sending">
				
						<tr class="center">
							<td>
								<?php 
								echo $_POST["facts"];
								?>
							</td>
						</tr>
						<tr class="center">
							<td><input type="text" name="facts" size="30"/></td>
						</tr>
						<tr class="center">
						
							<td><input type="submit" value="Next"/></td>
						</tr>
					</table>
				</form>	
			</div>
		</div>
	</div>
	</body>
 
 </html>