<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Let's Chill | Conceptual Model</title>
	</head>
	<body>
		<h3>PROFILE</h3>
		<ul>
			<li>profileId (primary key)</li>
			<li>profileActivationToken</li>
			<li>profileUserName</li>
			<li>profileEmail</li>
			<li>profileHash</li>
			<li>profileSalt</li>
			<li>profileBio</li>
			<li>profileImage</li>
		</ul>
		<h3>EVENT</h3>
		<ul>
			<li>eventId (primary key)</li>
			<li>eventName</li>
			<li>eventDetail</li>
			<li>eventLocation</li>
			<li>eventDateTime</li>
			<li>eventDuration</li>
			<li>eventImage</li>
			<li>eventProfileId (foreign key) - host of event </li>
		</ul>
		<h3>PROFILE RATING</h3>
		<ul>
			<li>ratingId (primary key)</li>
			<li>ratingProfileId (foreign key) - For the person giving the rating</li>
			<li>ratingProfileId (foreign key) - For the person receiving the rating</li>
			<li>ratingEventId (foreign key)</li>
			<li>ratingSocialScore</li>
			<li>ratingFlakeFactor</li>
		</ul>
		<h3>EVENT RATING</h3>
		<ul>
			<li>eventRatingId (primary key)</li>
			<li>ratingProfileId (foreign key) - For the person giving the rating</li>
			<li>ratingEventId (foreign key)</li>
			<li>ratingEventScore</li>
		</ul>
		<h3>EVENT RATING</h3>
		<ul>
			<li>eventRatingId (primary key)</li>
			<li>ratingProfileId (foreign key) - For the person giving the rating</li>
			<li>ratingEventId (foreign key)</li>
			<li>ratingEventScore</li>
		</ul>
	</body>
</html>