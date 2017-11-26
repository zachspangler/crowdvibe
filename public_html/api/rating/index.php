<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Crowdvibe\{
	Rating,
	// we only use the profile, event, and event attendance class for testing purposes
	Profile, Event, EventAttendance
};

/**
 * api for Rating class
 *
 * @author {} <mcdav3636@gmail.com>
 **/

//verify the session, start if not active
if(session_start() !==PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
		//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/ddctwitter.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$ratingId = filter_input(INPUT_GET, "ratingId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$ratingEventAttendanceId = filter_input(INPUT_GET, "ratingEventAttendacnceId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$ratingRateeProfileId = filter_input( INPUT_GET, "ratingRateeProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$ratingRaterProfileId = filter_input(INPUT_GET, "ratingRaterProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$ratingScore = filter_input(INPUT_GET, "ratingScore", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is calid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($ratingId) === true)){
		throw(new InvalidArgumentException("ratingId cannot be empty or negative", 405));
	}

}