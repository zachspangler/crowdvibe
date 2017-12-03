<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="ie=edge"/>
		<meta name="viewport" content="width = device-width, initial-scale = 1, shrink-to-fit = no"/>
		<meta name="author" content="Chris, Luther, Matt, Zach"/>
		<meta name="description"
				content="CrowdVibe, is a social platform allowing people to connect through near live event posting."/>

		<!-- Bootstrap CSS -->

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
				integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb"
				crossorigin="anonymous"/>

		<!-- Font Awesome Link -->

		<script src="https://use.fontawesome.com/46c6e23a21.js"></script>
		<link rel="stylesheet" href="font-awesome-animation.min.css">

		<!-- CrowdVibe CSS -->
		<link rel="stylesheet" href="./styles.css">

<!--		<script src="./styles.css"></script>-->


		<!-- jQuery, Popper.js, Bootstrap JS -->

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"
				  integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
				  crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"
				  integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
				  crossorigin="anonymous"></script>

		<!-- jQuery Form, Additional Methods, Validate -->

		<script type="text/javascript"
				  src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
		<script type="text/javascript"
				  src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
		<script type="text/javascript"
				  src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js"></script>

		<!-- CrowdVibe Javascript -->

		<!--Google Fonts -->

		<!-- CrowdVibe Favicon -->

		<!-- Global site tag (gtag.js) - Google Analytics -->


		<title>CrowdVibe</title>
	</head>
	<body>
		<header>
			<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
				<a class="navbar-brand" href="#">Crowd<i class="fa fa-wifi text-danger" aria-hidden="true"></i>ibe</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
						  aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse ml-auto" id="navbarSupportedContent">
					<form class="form-inline my-2 my-lg-0">
						<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
						<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
					</form>
					<ul class="navbar-nav ml-auto">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
								data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img
									class="rounded-circle m-0"
									src="https://dl.dropboxusercontent.com/s/s05h8qapt3p00kn/face.jpg?dl=0" height="50" width="50">
							</a>
							<div class="dropdown-menu mr-auto" aria-labelledby="navbarDropdown">
								<a class="dropdown-item mr-auto" href="#">Profile</a>
								<a class="dropdown-item mr-auto" href="#">Create An Event</a>
								<a class="dropdown-item mr-auto" href="#">Signout</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>
		</header>
		<main class="rating-event">
			<div class="container">
				<div class="row">
					<div class="col-md-6 align-content-center mt-2">
						<div class="card event bg-dark text-white">
							<h3 class="text-center"><i class="fa fa-wifi text-danger" aria-hidden="true"></i>ibing now</h3>
							<img class="card-img-top" src="https://dl.dropboxusercontent.com/s/9ojadnxp8n2b7oq/bar.jpg?dl=0"
								  alt="Card image cap" height="400">
							<div class="card-body text-center bg-dark text-white">
								<img class="rounded-circle"
									  src="https://dl.dropboxusercontent.com/s/s05h8qapt3p00kn/face.jpg?dl=0"
									  height="100" width="100">
								<p class="card-text">
									<small class="text-muted">Hosted By: Zach</small>
								</p>
								<div class="text-center">
									<i class="fa fa-thermometer-three-quarters fa-2x m-2 text-warning" aria-hidden="true"></i>
								</div>
								<h4 class="card-title">Happy Hour</h4>
								<div class="text-center">
									<i class="fa fa-thermometer-full fa-2x m-2 text-danger" aria-hidden="true"></i>
								</div>
								<p class="card-text">Some co-workers are getting together for a drink, we would love to meet
									some new people in town.</p>
								<p class="card-text my-1">
									<small class="text-muted">@:</small>
									D Rinkers Pub
								</p>
								<p class="card-text my-1">363 Palmer Ave Ne</p>
								<p class="card-text my-1">Fun Town</p>
								<p class="card-text my-1">89933</p>
								<p class="card-text my-1">
									<small class="text-muted">Starts:</small>
									6:00pm
								</p>
								<p class="card-text my-1">
									<small class="text-muted">Ends:</small>
									2:00am
								</p>
								<p class="card-text my-1">
									<small class="text-muted">Price:</small>
									Free
								</p>
								<p class="card-text my-1">
									<small class="text-muted">Attending:</small>
									57
								</p>
								<div class="dropdown">
									<button class="btn btn-secondary dropdown-toggle"
											  type="button" id="dropdownMenu1" data-toggle="dropdown"
											  aria-haspopup="true" aria-expanded="false">
										Rate It!
									</button>
									<div class="dropdown-menu" aria-labelledby="dropdownMenu1">
										<a class="dropdown-item" href="#!">
											<div class="lines">
												<i class="fa fa-thermometer-empty fa-2x text-secondary" aria-hidden="true"></i>
												<i class="fa fa-thermometer-quarter fa-2x text-primary" aria-hidden="true"></i>
												<i class="fa fa-thermometer-half fa-2x text-success" aria-hidden="true"></i>
												<i class="fa fa-thermometer-three-quarters fa-2x text-warning" aria-hidden="true"></i>
												<i class="fa fa-thermometer-full fa-2x text-danger" aria-hidden="true"></i>
											</div>
										</a>
									</div>
								</div>
							</div>
							<a href="#">
								<div class="card-footer">
									<small class="text-muted align-content-center"><i class="fa fa-users" aria-hidden="true"></i>
										Attend Event
									</small>
								</div>
							</a>
						</div>
					</div>

					<div class="col-md-6">
						<div class="container">
							<div class="row">
								<div class="col-md-12 mt-2">
									<h3 class="bg-transparent text-white text-center">Who Attended</h3>
									<div class="container mb-2">
										<div class="row">
											<div class="col-md-6">
													<div class="card border-0">
														<div class="top-picture">
															<img class="card-img-top rounded-circle" src="./image/look-lady.jpg" alt="Card image cap" height="200">
														</div>
														<div class="card-body bg-dark text-white">
															<h6 class="card-title">Allison Mopsqueezer</h6>
															<p class="card-subtitle mb-2 text-muted">Rating</p>
															<div class="text-center">
																<i class="fa fa-thermometer-three-quarters fa-2x m-4 text-warning" aria-hidden="true"></i>
															</div>
																<button class="btn btn-secondary dropdown-toggle"
																		  type="button" id="dropdownMenu1" data-toggle="dropdown"
																		  aria-haspopup="true" aria-expanded="false">
																	Rate Me
																</button>
																<div class="dropdown-menu" aria-labelledby="dropdownMenu1">
																	<a class="dropdown-item" href="#!">
																		<div class="lines">
																			<i class="fa fa-thermometer-empty fa-2x text-secondary" aria-hidden="true"></i>
																			<i class="fa fa-thermometer-quarter fa-2x text-primary" aria-hidden="true"></i>
																			<i class="fa fa-thermometer-half fa-2x text-success" aria-hidden="true"></i>
																			<i class="fa fa-thermometer-three-quarters fa-2x text-warning" aria-hidden="true"></i>
																			<i class="fa fa-thermometer-full fa-2x text-danger" aria-hidden="true"></i>
																		</div>
																	</a>
																</div>
														</div>
													</div>
											</div>
											<div class="col-md-6">
												<div class="card border-0">
													<img class="card-img-top rounded-circle bg-transparent" src="./image/look-lady.jpg" alt="Card image cap" height="200">
													<div class="card-body bg-dark text-white">
														<h6 class="card-title">Allison Mopsqueezer</h6>
														<p class="card-subtitle mb-2 text-muted">Rating</p>
														<div class="text-center">
															<i class="fa fa-thermometer-quarter fa-2x m-4 text-success" aria-hidden="true"></i>
														</div>
														<button class="btn btn-secondary dropdown-toggle"
																  type="button" id="dropdownMenu1" data-toggle="dropdown"
																  aria-haspopup="true" aria-expanded="false">
															Rate Me
														</button>
														<div class="dropdown-menu" aria-labelledby="dropdownMenu1">
															<a class="dropdown-item" href="#!">
																<div class="lines">
																	<i class="fa fa-thermometer-empty fa-2x text-secondary" aria-hidden="true"></i>
																	<i class="fa fa-thermometer-quarter fa-2x text-primary" aria-hidden="true"></i>
																	<i class="fa fa-thermometer-half fa-2x text-success" aria-hidden="true"></i>
																	<i class="fa fa-thermometer-three-quarters fa-2x text-warning" aria-hidden="true"></i>
																	<i class="fa fa-thermometer-full fa-2x text-danger" aria-hidden="true"></i>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="container mb-2">
										<div class="row">
											<div class="col-md-6">
												<div class="card border-0">
													<img class="card-img-top rounded-circle bg-transparent" src="./image/look-lady.jpg" alt="Card image cap" height="200">
													<div class="card-body bg-dark text-white">
														<h6 class="card-title">Allison Mopsqueezer</h6>
														<p class="card-subtitle mb-2 text-muted">Rating</p>
														<div class="text-center">
															<i class="fa fa-thermometer-quarter fa-2x m-4 text-success" aria-hidden="true"></i>
														</div>
														<button class="btn btn-secondary dropdown-toggle"
																  type="button" id="dropdownMenu1" data-toggle="dropdown"
																  aria-haspopup="true" aria-expanded="false">
															Rate Me
														</button>
														<div class="dropdown-menu" aria-labelledby="dropdownMenu1">
															<a class="dropdown-item" href="#!">
																<div class="lines">
																	<i class="fa fa-thermometer-empty fa-2x text-secondary" aria-hidden="true"></i>
																	<i class="fa fa-thermometer-quarter fa-2x text-primary" aria-hidden="true"></i>
																	<i class="fa fa-thermometer-half fa-2x text-success" aria-hidden="true"></i>
																	<i class="fa fa-thermometer-three-quarters fa-2x text-warning" aria-hidden="true"></i>
																	<i class="fa fa-thermometer-full fa-2x text-danger" aria-hidden="true"></i>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="card border-0">
													<img class="card-img-top rounded-circle bg-transparent" src="./image/look-lady.jpg" alt="Card image cap" height="200">
													<div class="card-body bg-dark text-white">
														<h6 class="card-title">Allison Mopsqueezer</h6>
														<p class="card-subtitle mb-2 text-muted">Rating</p>
														<div class="text-center">
															<i class="fa fa-thermometer-quarter fa-2x m-4 text-success" aria-hidden="true"></i>
														</div>
														<button class="btn btn-secondary dropdown-toggle"
																  type="button" id="dropdownMenu1" data-toggle="dropdown"
																  aria-haspopup="true" aria-expanded="false">
															Rate Me
														</button>
														<div class="dropdown-menu" aria-labelledby="dropdownMenu1">
															<a class="dropdown-item" href="#!">
																<div class="lines">
																	<i class="fa fa-thermometer-empty fa-2x text-secondary" aria-hidden="true"></i>
																	<i class="fa fa-thermometer-quarter fa-2x text-primary" aria-hidden="true"></i>
																	<i class="fa fa-thermometer-half fa-2x text-success" aria-hidden="true"></i>
																	<i class="fa fa-thermometer-three-quarters fa-2x text-warning" aria-hidden="true"></i>
																	<i class="fa fa-thermometer-full fa-2x text-danger" aria-hidden="true"></i>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="container mb-2">
										<div class="row">
											<div class="col-md-6">
												<div class="card border-0">
													<img class="card-img-top rounded-circle bg-transparent" src="./image/look-lady.jpg" alt="Card image cap" height="200">
													<div class="card-body bg-dark text-white">
														<h6 class="card-title">Allison Mopsqueezer</h6>
														<p class="card-subtitle mb-2 text-muted">Rating</p>
														<div class="text-center">
															<i class="fa fa-thermometer-quarter fa-2x m-4 text-success" aria-hidden="true"></i>
														</div>
														<button class="btn btn-secondary dropdown-toggle"
																  type="button" id="dropdownMenu1" data-toggle="dropdown"
																  aria-haspopup="true" aria-expanded="false">
															Rate Me
														</button>
														<div class="dropdown-menu" aria-labelledby="dropdownMenu1">
															<a class="dropdown-item" href="#!">
																<div class="lines">
																	<i class="fa fa-thermometer-empty fa-2x text-secondary" aria-hidden="true"></i>
																	<i class="fa fa-thermometer-quarter fa-2x text-primary" aria-hidden="true"></i>
																	<i class="fa fa-thermometer-half fa-2x text-success" aria-hidden="true"></i>
																	<i class="fa fa-thermometer-three-quarters fa-2x text-warning" aria-hidden="true"></i>
																	<i class="fa fa-thermometer-full fa-2x text-danger" aria-hidden="true"></i>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="card border-0">
													<img class="card-img-top rounded-circle bg-transparent" src="./image/look-lady.jpg" alt="Card image cap" height="200">
													<div class="card-body bg-dark text-white">
														<h6 class="card-title">Allison Mopsqueezer</h6>
														<p class="card-subtitle mb-2 text-muted">Rating</p>
														<div class="text-center">
															<i class="fa fa-thermometer-quarter fa-2x m-4 text-success" aria-hidden="true"></i>
														</div>
														<button class="btn btn-secondary dropdown-toggle"
																  type="button" id="dropdownMenu1" data-toggle="dropdown"
																  aria-haspopup="true" aria-expanded="false">
															Rate Me
														</button>
														<div class="dropdown-menu" aria-labelledby="dropdownMenu1">
															<a class="dropdown-item" href="#!">
																<div class="lines">
																	<i class="fa fa-thermometer-empty fa-2x text-secondary" aria-hidden="true"></i>
																	<i class="fa fa-thermometer-quarter fa-2x text-primary" aria-hidden="true"></i>
																	<i class="fa fa-thermometer-half fa-2x text-success" aria-hidden="true"></i>
																	<i class="fa fa-thermometer-three-quarters fa-2x text-warning" aria-hidden="true"></i>
																	<i class="fa fa-thermometer-full fa-2x text-danger" aria-hidden="true"></i>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>