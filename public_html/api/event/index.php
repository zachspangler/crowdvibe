<?php
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

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
	$method = array_key_exists ("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$id = filter_input(INPUT_GET, "id",FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
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
if ($method === "GET") {
	//set XSRF cookie
	setXsrfCookie();
	}
}


