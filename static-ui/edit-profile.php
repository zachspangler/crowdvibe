<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	</head>
	<body>
		<div class="card bg-dark mb-3" style="max-width: 20rem">
			<img class="card-img-top" src="http://www.talktocanada.com/wp-content/uploads/2014/02/Fotolia_34730819_S-660x346.jpg" alt="Card image cap">
			<div class="card-block">
				<form>
					<div class="form-group">
						<label for="exampleInputFile">Change Profile Picture</label>
						<input type="file" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
					</div>
					<div class="form-group">
						<input type="email" class="form-control" id="changeUsername" aria-describedby="emailHelp" placeholder="Username">
					</div>
					<div class="form-group">
						<input type="email" class="form-control" id="changeFirstName" aria-describedby="emailHelp" placeholder="First Name">
					</div>
					<div class="form-group">
						<input type="email" class="form-control" id="changeLastName" aria-describedby="emailHelp" placeholder="Last Name">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" id="changePassword" placeholder="Password">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" id="confirmChangePassword" placeholder="Confirm Password">
					</div>
					<div class="form-group">
						<label for="exampleTextarea">Bio</label>
						<textarea class="form-control" id="ChangeBio" rows="3"></textarea>
					</div>

					<button type="submit" class="btn btn-dark">Submit</button>
				</form>
			</div>
		</div>
	</body>
</html>