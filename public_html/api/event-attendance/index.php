<?php
require_once dirname(__DIR__,3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\CrowdVibe\EventAttendance;
/**
 * API for event-attendance
 *
 * @author Christian Owens <cowens17@cnm.edu>
 */
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
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$eventAttendanceId = filter_input(INPUT_GET, "eventAttendanceId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventAttendanceEventId = filter_input(INPUT_GET, "eventAttendanceEventId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventAttendanceProfileId = filter_input(INPUT_GET, "eventAttendanceProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventAttendanceCheckIn = filter_input(INPUT_GET, "eventAttendanceCheckIn", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventAttendanceNumberAttending = filter_input(INPUT_GET, "eventAttendanceNumberAttending",FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "GET" || $method === "PUT") && (empty($eventAttendanceId) === true || $eventAttendanceId < 0)){
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
// handle GET request - if eventAttendanceId is present, that the event attendance is returned, otherwise all event attendances are returned
		if($method === "GET") {
			//set XSRF cookie
			setXsrfCookie();

			//get a specific events attendance
			if(empty($eventAttendanceId) === false) {
				$eventAttendanceId = EventAttendance::getEventAttendanceByEventAttendanceId($pdo, $eventAttendanceId);
				if($eventAttendanceId !== null) {
					$reply->data = $eventAttendanceId;
				}
			} else if(empty($eventAttendanceProfileId) === false) {
				$eventAttendanceId = EventAttendance::getEventAttendanceByEventAttendanceProfileId($pdo, $eventAttendanceProfileId);
				if($eventAttendanceProfileId !== null) {
					$reply->data = $eventAttendanceProfileId;
				}
			} else if(empty($eventAttendanceEventId) === false) {
				$eventAttendanceEventId = EventAttendance::getEventAttendanceByEventAttendanceEventId($pdo, $eventAttendanceEventId);
				if($eventAttendanceEventId !== null) {
					$reply->data = $eventAttendanceEventId;
				}
			}
		} else if($method === "PUT" || $method === "POST") {

			//enforce that the user has an XSRF token
			verifyXsrf();

			$requestContent = file_get_contents("php://input");
			// Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
			$requestObject = json_decode($requestContent);
			// This Line Then decodes the JSON package and stores that result in $requestObject

			//  make sure eventAttendanceProfileId is available
			if(empty($requestObject->eventAttendanceProfileId) === true) {
				throw(new \InvalidArgumentException ("No Profile ID.", 405));
			}
			//make sure eventAttendanceCheckIn is available (required field)
			if(empty($requestObject->eventAttendanceCheckIn) === true) {
				throw(new \InvalidArgumentException ("No check in for this event.", 405));
			}
			//make sure eventAttendanceNumberAttending is available (required field)
			if(empty($requestObject->eventAttendanceNumberAttending) === true) {
				throw(new \InvalidArgumentException ("No number attending for this event.", 405));
			}

else if($method === "POST") {

				// enforce the user is signed in
				if(empty($_SESSION["profile"]) === true) {
					throw(new \InvalidArgumentException("you must be logged in to host events", 403));
				}

				// create new event and insert into the database
				$eventAttendanceId = new \Edu\Cnm\CrowdVibe\Event(generateUuidV4(), $_SESSION["profile"]->getProfileId(), $requestObject->eventAttendanceNumberAttending, null);
				$eventAttendanceId->insert ($pdo);

				// update reply
				$reply->message = "Event created OK";
			}

		} else if($method === "DELETE") {

			//enforce that the end user has a XSRF token.
			verifyXsrf();

			// retrieve the event to be deleted
			$eventAttendanceId = EventAttendance::getEventAttendanceByEventAttendanceId($pdo, $eventAttendanceId);
			if($eventAttendanceId === null) {
				throw(new RuntimeException("Event does not exist", 404));
			}

			//enforce the user is signed in and only trying to edit their own event
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $eventAttendanceProfileId->getEventAttendanceProfileId()) {
				throw(new \InvalidArgumentException("You are not allowed to delete this event", 403));
			}

			// delete event
			$eventAttendanceId->delete($pdo);
			// update reply
			$reply->message = "Event deleted OK";
		} else {
			throw (new InvalidArgumentException("Invalid HTTP method request"));
		}
// update the $reply->status $reply->message
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
