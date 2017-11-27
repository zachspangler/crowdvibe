<?php
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";

use Edu\Cnm\Crowdvibe\{
	Event,
	// we only use Profile for testing purposes
	Profile
};

/**
 * api for the Event class
 *
 * @author {Luther Mckeiver} <lmckeiver@cnm.edu>
 * @coauthor Derek Mauldlin <derek.e.mauldin@gmail.com
 **/


// verify the session, start if not active
if(session_status() !==PHP_SESSION_ACTIVE) {
	session_start();
}
// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	// grab the mySQL connection
	$pdo = connectionToEncryptedMySQL("/etc/apache2/capstone-mysql/crowdvibe.ini");

	// mock a logged on user by forcing the session. This is only for testing purposes and should not be in the live code

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventProfileId = filter_input(INPUT_GET, "eventProfileId", FILTER_VALIDATE_INT);
	$eventAttendeeLimit = filter_input(INPUT_GET, "eventAttendeeLimit", FILTER_VALIDATE_INT);
	$eventImage = filter_input(INPUT_GET, "eventImage", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventLat = filter_input(INPUT_GET, "eventLat", FILTER_VALIDATE_FLOAT);
	$eventLong = filter_input(INPUT_GET, "eventLong", FILTER_VALIDATE_FLOAT);
	$eventName = filter_input(INPUT_GET, "eventName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventPrice = filter_input(INPUT_GET, "eventPrice", FILTER_VALIDATE_FLOAT);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 402));
	}

	// handle GET request - if id is present, that event is returned, otherwise all events are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific event or all events and update it
		if(empty($id) === false) {
			$event = Event::getEventByEventId($pdo, $id);
			if($event !== null) {
				$reply->data = $event;
			}

		} else if(empty($eventProfileId) === false) {

			// if the user is logged in and grabs all the events based on users logged on
			$event = Event::getEventByEventProfileId($pdo, $_SESSION["profile"]->getProfileId())->toArray();
			if($event !== null) {
				$reply->data = $event;
			}
		} else if(empty($eventName) === false) {

			// grabs the event by event Name
			$events = Event::getEventByEventName($pdo, $eventName)->toArray();
			if($events !== null) {
				$reply->data->$events;
			}
		} else if(empty($eventStartDateTime) === false) {
			$events = Event::getEventByEventStartDateTime($pdo, \DateTime, \DateTime);
		} else {
			$events = Event::getAllEvents($pdo)->toArray();
			if($events === null) {
				echo "shit didn't work";
			}
			if($events !== null) {
				$reply->data = $events;
			}
		}

	} else if($method === "PUT" || $method === "POST") {

		//enforce the user is signed in and only trying to edit their own profile
		if(empty($_SESSION["profile"]) === true) {
			throw(new \InvalidArgumentException("you must be logged in to post events", 401));
		}

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure event detail is available (required field)
		if(empty($requestObject->eventDetail) === true) {
			throw (new \InvalidArgumentException("No detail listed for event.", 405));
		}

		//make sure event name is available (required field)
		if(empty($requestObject->eventName) === true) {
			throw (new \InvalidArgumentException("No name listed for the event", 405));
		}

		// make sure there is a valid date for event (required field)
		if(empty($requestObject->eventStartDateTime) === true) {
			$requestObject->eventStartDateTime = date("Y-m-d H:i:s.u");
		}

		// make sure event Lat is available (required field)
		// TODO: finish this
		if(empty($requestObject->eventLat) === true) {
			throw (new InvalidArgumentException("Invalid Latitude", 405));
		}

		// make sure event Long is available (required field)
		if(empty($requestObject->eventLong) === true) {
			throw (new InvalidArgumentException("Invalid Longitude", 405));
		}

		//perform the actual put or post
		if($method === "PUT") {

			//retrieve the method to update
			$event = Event::getEventByEventId($pdo, $id);
			if($event === null) {
				throw (new RuntimeException("Event does not exist.", 404));
			}

			// enforce the end user has a Jwt token
			// validateJwtHeader();

			//enforce the user is signed in and only trying to edit their own event
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $event->getEventProfileId()->toString()) {
				throw(new \InvalidArgumentException("You are not allowed to edit this event", 403));
			}

			// update all attributes
			//$event->setEventStartDateTime($requestObject->eventStartDateTime);
			$event->setEventDetail($requestObject->eventDetail);
			$event->update($pdo);

			// update reply
			$reply->message = "Event updated OK";
		} else if ($method === "POST") {
			// enforce that the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to post events", 403));
			}
			//enforce the end user has a JWT token
			validateJwtHeader();

			// create a new Event an insert it into the database
			// TODO: come back and finish this as well.
			$event = new Event(generateUuidV4(), $_SESSION["profile"]->getProfileId(), $requestObject->eventAttendeeLimit, $requestObject->eventDetail, $requestObject->eventEndDateTime, $requestObject->eventImage, $requestObject->eventLat, $requestObject->eventLong, $requestObject->eventName, $requestObject->eventPrice, $requestObject->eventStartDateTime);
			$event->insert($pdo);

			// update reply
			$reply->message="Event updated OK";

			}

	} else if($method === "DELETE") {

		// enforce that the end user has a XSRF token
		verifyXsrf();

		// retrieve the event to be deleted
		$event = Event::getEventByEventId($pdo, $id);
		if($event === null) {
			throw (new RuntimeException("Event does not exist.", 404));
		}

		//enforce the end user has a JWT token
		//validateJwtHeader();

		//enforce the user is signed in and only trying to edit their own tweet
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $event->getEventProfileId()->toString()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this event", 403));
		}


		// delete event
		$event->delete($pdo);
		// update reply
		$reply->message = "Event deleted OK";
	} else {
		throw (new InvalidArgumentException("Invalid HTTP Method request", 418));
	}
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

// encode and return reply to front end caller
echo json_encode($reply);



