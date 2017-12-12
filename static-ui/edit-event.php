<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<!--Bootstrap added-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
		<!--jQuery added -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<!--CSS-->
		<style>
			.text-box{
				margin-right: 6px;
			}
			.border-warning{
				margin: fill;
				color: #FFA500;
			}
			.btn{
				color: #FFA500;
			}
			.col-form-label{
				margin-right: 5rem;
			}
		</style>
	<body>
		<div class="card text-white border-warning bg-dark mb-3" style="width: 30rem;">
			<img class="card-img-top" src="http://michaelolivier.co.za/wp-content/uploads/2012/11/Stellenbosch-Wine-Festival-People-41.jpg" alt="Card image cap">
			<div class="form-group">
				<label for="exampleInputFile">Change Event Photo</label>
				<input type="file" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
			</div>

			<div class="form-group row">
				<label for="example-text-input" class="col-2 col-form-label">Event</label>
				<div class="col-10">
					<input class="form-control" type="text" value="Meet up at the wine festival" id="example-text-input">
				</div>
			</div>
			<div class="form-group">
				<label for="exampleTextarea">Event Description</label>
				<textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
			</div>
			<div class="form-group row">
				<label for="example-attending-input" class="col-2 col-form-label">Viber Limit</label>
				<div class="col-10">
					<input class="form-control" type="email" value="150" id="example-email-input">
				</div>
			</div>

			<div class="form-group">
				<label for="start-time" class="col-form-label">Start Time:</label>
				<input type="datetime-local" class="text-box form-control" id="start-time">
			</div>
			<div class="form-group">
				<label for="end-time" class="col-form-label">End Time:</label>
				<input type="datetime-local" class="form-control" id="end-time">
			</div>
			<div class="form-group row">
				<label for="example-password-input" class="col-2 col-form-label">Spot</label>
				<div class="col-10">
					<input class="form-control" type="tel" value=" 3122 Central Ave SE, Albuquerque, NM 87106" id="example-password-input">
				</div>
			</div>
			<div class="form-group row">
				<label for="example-number-input" class="col-2 col-form-label">Price?</label>
				<div class="col-10">
					<input class="form-control" type="number" value="10$" id="example-number-input">
					<div>
						<button type="submit" class="btn btn-dark">Finish</button>
						</div>
					</div>
				</div>
			</div>
	</body>
</html>