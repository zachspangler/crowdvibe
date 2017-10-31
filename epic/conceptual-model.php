<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>CrowdVibe | Conceptual Model</title>
	</head>
	<body>
		<h1>Conceptual Model</h1>
		<h6>Author: Zach Spangler</h6>
		<h4>PROFILE</h4>
		<ul>
			<li>profileId (primary key)</li>
			<li>profileActivationToken</li>
			<li>profileBio</li>
			<li>profileEmail</li>
			<li>profileFirstName</li>
			<li>profileHash</li>
			<li>profileImage</li>
			<li>profileLastName</li>
			<li>profileSalt</li>
			<li>profileUserName</li>
		</ul>
		<h4>EVENT</h4>
		<ul>
			<li>eventId (primary key)</li>
			<li>eventProfileId (foreign key) - host of event </li>
			<li>eventAttendeeLimit</li>
			<li>eventCategory</li>
			<li>eventDateTime</li>
			<li>eventDetail</li>
			<li>eventDuration</li>
			<li>eventImage</li>
			<li>eventLat</li>
			<li>eventLocation</li>
			<li>eventLong</li>
			<li>eventName</li>
			<li>eventPrice</li>
		</ul>
		<h4>RATING</h4>
		<ul>
			<li>ratingId (primary key)</li>
			<li>ratingEventId (foreign key) - event that was attended </li>
			<li>ratingRateeProfileId (foreign key) - For the person receiving the rating</li>
			<li>ratingRaterProfileId (foreign key) - For the person giving the rating</li>
			<li>ratingEventScore</li>
			<li>ratingSocialScore</li>
			<li>ratingType - is this a rating for a person or an event</li>
		</ul>
		<h4>EVENT ATTENDANCE</h4>
		<ul>
			<li>attendanceID (primary key)</li>
			<li>attendanceEventId (foreign key)</li>
			<li>attendanceProfileId (foreign key)</li>
			<li>attendanceCheckIn</li>
			<li>attendanceNumberAttending</li>
		</ul>
	</body>
</html>