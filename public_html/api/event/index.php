<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/php/lib/geocode.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\CrowdVibe\ {
	Event,
	// we only use Profile for testing purposes
	Profile, Rating, JsonObjectStorage
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
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/crowdvibe.ini");

	// mock a logged on user by forcing the session. This is only for testing purposes and should not be in the live code

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventProfileId = filter_input(INPUT_GET, "eventProfileId", FILTER_VALIDATE_INT);
	$eventAttendeeLimit = filter_input(INPUT_GET, "eventAttendeeLimit", FILTER_VALIDATE_INT);
	$eventDetail = filter_input(INPUT_GET, "eventDetail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventEndDateTime = filter_input(INPUT_GET, "eventEndDateTime", FILTER_VALIDATE_INT);
	$eventImage = filter_input(INPUT_GET, "eventImage", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventLat = filter_input(INPUT_GET, "eventLat", FILTER_VALIDATE_FLOAT);
	$eventLong = filter_input(INPUT_GET, "eventLong", FILTER_VALIDATE_FLOAT);
	$eventName = filter_input(INPUT_GET, "eventName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventPrice = filter_input(INPUT_GET, "eventPrice", FILTER_VALIDATE_FLOAT);
	$eventStartDateTime = filter_input(INPUT_GET, "eventStartDateTime", FILTER_VALIDATE_INT);


	if(empty($eventStartDateTime) === false && empty($eventEndDateTime) === false) {
		$eventEndDateTime= date("Y-m-d H:i:s", $eventEndDateTime/1000);
		$eventStartDateTime= date("Y-m-d H:i:s", $eventStartDateTime/1000);
	}

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
				$reply->data = $events;
			}
		} else if(empty($eventStartDateTime && $eventEndDateTime) === false) {
			$events = Event::getEventByEventStartDateTime($pdo, $eventStartDateTime,  $eventEndDateTime);

			if($events !== null) {
				$storage = new JsonObjectStorage();
				foreach($events as $event) {
					$eventAvg = Rating::getRatingByEventId($pdo, $event->getEventId);
					$storage->attach($event, $eventAvg);
				}
				$reply->data=$storage;
			} else {
				$address = getAddressByLatLong(35.085883, -106.649854);
				$reply->data = $address;
			}


		}

		//* latlong *\\
	} else if($method === "PUT" || $method === "POST") {

		//enforce the user is signed in and only trying to edit their own profile
		if(empty($_SESSION["profile"]) === true) {
			throw(new \InvalidArgumentException("you must be logged in to post events", 401));
		}

		verifyXsrf();

		//$requestContent = file_get_contents("php://input");
		//$requestObject = json_decode($requestContent);
		$requestContent = file_get_contents("php://input");
		// Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestObject = json_decode($requestContent);
		// This Line Then decodes the JSON package and stores that result in $requestObject


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
			throw (new \InvalidArgumentException("No event start date", 405));
			} else {
				$requestObject->eventStartDateTime = date("Y-m-d H:i:s.u");
				}

		// make sure event Price is available (required field)
		if(empty($requestObject->eventPrice) === true) {
			throw (new InvalidArgumentException("Invalid Price", 405));
		}

		// make sure event Image is available (optional field)
		if (empty($requestObject->eventImage) === true) {
			throw (new InvalidArgumentException("No image available", 405));
		}

		$point = getLatLongByAddress($requestObject->eventAddress);

		//perform the actual put or post
		if($method === "PUT") {

			//retrieve the method to update
			$event = Event::getEventByEventId($pdo, $id);
			if($event === null) {
				throw (new RuntimeException("Event does not exist.", 404));
			}

			// enforce the end user has a Jwt token
			//validateJwtHeader();

			$secondsEnd = $requestObject->eventEndDateTime;
			$formattedEndDate= date("Y-m-d H:i:s", $secondsEnd/1000);

			$secondsStart = $requestObject->eventStartDateTime;
			$formattedStartDate= date("Y-m-d H:i:s", $secondsStart/1000);

			//enforce the user is signed in and only trying to edit their own event
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $event->getEventProfileId()->toString()) {
				throw(new \InvalidArgumentException("You are not allowed to edit this event", 403));
			}

			// update all attributes
			//$event->setEventStartDateTime($requestObject->eventStartDateTime);
			$event->setEventAttendeeLimit($requestObject->eventAttendeeLimit);
			$event->setEventDetail($requestObject->eventDetail);
			$event->setEventEndDateTime($formattedEndDate);
			$event->setEventImage($requestObject->eventImage);
			$event->setEventLat($point->lat);
			$event->setEventLong($point->long);
			$event->setEventName($requestObject->eventName);
			$event->setEventPrice($requestObject->eventPrice);
			$event->setEventStartDateTime($formattedStartDate);
			$event->update($pdo);

			// update reply
			$reply->message = "Event updated OK";
		} else if ($method === "POST") {
			 //enforce that the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to post events", 403));
			}
			//enforce the end user has a JWT token
			//validateJwtHeader();

			$secondsEnd = $requestObject->eventEndDateTime;
			$formattedEndDate= date("Y-m-d H:i:s", $secondsEnd/1000);

			$secondsStart = $requestObject->eventStartDateTime;
			$formattedStartDate= date("Y-m-d H:i:s", $secondsStart/1000);

			// create a new Event an insert it into the database
			$event = new Event(generateUuidV4(), $_SESSION["profile"]->getProfileId(), $requestObject->eventAttendeeLimit, $requestObject->eventDetail, $formattedEndDate, $requestObject->eventImage, $point->lat, $point->long, $requestObject->eventName, $requestObject->eventPrice, $formattedStartDate);
			$event->insert($pdo);

			// update reply
			$reply->message="Event created OK";
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



