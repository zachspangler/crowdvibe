<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">

		<!--Bootstrap added-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

		<!--jQuery added -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<!--CSS-->
		 <style>
			 .btn{
				 color: #FFA500;
				 border-color: #FFA500;
			 }
			 .form-control{
				 position: center;
			 }
			 .form-control-file{
				 margin-top: 10px;
			 }
		 </style>
	</head>
	<body>
		<div class="btn card bg-dark border-4 border-warning mb-3" style="max-width: 20rem">
			<img class="card-img-top" src="http://davidsheff.com/wp-content/uploads/snoopdogg300.jpg" alt="Card image cap">
			<div class="card-block">
				<form>
					<div class="form-group">
						<input type="file" class="form-control-file" id="pictureInputFile" aria-describedby="fileHelp">
					</div>
					<div class="form-group">
						<label>Change Username</label>
						<input style="width: 18.3rem" class="form-control" id="changeUsername" aria-describedby="emailHelp" placeholder="Username">
					</div>
					<div class="form-group">
						<label>First Name</label>
						<input style="width: 18.3rem" class="form-control" id="changeFirstName" aria-describedby="emailHelp" placeholder="First Name">
					</div>
					<div class="form-group">
						<label>Last Name</label>
						<input style="width: 18.3rem" class="form-control" id="changeLastName" aria-describedby="emailHelp" placeholder="Last Name">
					</div>
					<div class="form-group">
						<label>Change Password</label>
						<input style="width: 18.3rem" class="form-control" id="changePassword" placeholder="Password">
					</div>
					<div class="form-group">
						<label>Confirm Password</label>
						<input style="width: 18.3rem" class="form-control" id="confirmChangePassword" placeholder="Confirm Password">
					</div>
					<div class="form-group">
						<label for="textarea">Bio</label>
						<textarea class="form-control" id="ChangeBio" rows="3"></textarea>
					</div>

					<button type="submit" class="btn btn-dark">Submit</button>
				</form>
			</div>
		</div>
	</body>
</html>