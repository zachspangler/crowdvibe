<?php
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Crowdvibe\{
	EventAttendance
};
/**
 * API for EventAttendance
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
	$pdo = connectionToEncryptedMySQL("/etc/apache2/capstone-mysql/ddctwitter.ini");
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$eventAttendanceId = filter_input(INPUT_GET, "eventAttendanceId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventAttendanceEventId = filter_input(INPUT_GET, "eventAttendanceEventId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventAttendanceProfileId = filter_input(INPUT_GET, "eventAttendanceProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventAttendanceCheckIn = filter_input(INPUT_GET, "eventAttendanceCheckIn", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventAttendanceNumberAttending = filter_input(INPUT_GET, "eventAttendanceNumberAttending",FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "GET" || $method === "PUT") && (empty($id) === true || $eventAttendanceId < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}}