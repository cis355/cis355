<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
			<link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
				<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
			</head>

			<body>
				<div class="container">

					<div class="span10 offset1">
						<div class="row">
							<h3>Donation</h3>
						</div>

						<form class="form-horizontal" action="create.php" method="post">
							<div class="control-group">
								<label class="control-label">Item: </label>
								<div class="controls">
									<input name="wishItem" type="text"  placeholder="Item" value="" readonly>
											<span class="help-inline"></span>

										</div>
									</div>
									<div class="control-group">
											<label class="control-label">Quantity: </label>
											<div class="controls">
												<input name="qty" type="text" placeholder="Quantity" value="">
													
														<span class="help-inline"></span>

													</div>
												</div>
												<div class="control-group ">
													<label class="control-label">Comment: </label>
													<div class="controls">
														<textArea name="comments" type="text" value=""></textArea>
															<span class="help-inline"></span>

														</div>
													</div>
													<div class="form-actions">
														<button type="submit" class="btn btn-success">Donate</button>
														<a class="btn btn-info" href="se_donations.php">Back</a>
													</div>
												</form>
											</div>       
										</div> <!-- /container -->
									</body>
								</html>