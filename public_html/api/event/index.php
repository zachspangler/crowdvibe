<?ph
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Crowdvibe\{
	Event
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
	$pdo = connectionToEncryptedMySQL("/etc/apache2/capstone-mysql/ddctwitter.ini");

	//determine which HTTP method was used
	$method = array_key_exists ("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$eventId = filter_input(INPUT_GET, "eventId",
		FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventProfileId = filter_input(INPUT_GET, "eventProfileId",
		FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventAttendeeLimit = filter_input(INPUT_GET, "eventAttendeeLimit",
		FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventDetail = filter_input(INPUT_GET, "eventDetail",
		FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventEndDateTime = filter_input(INPUT_GET, "eventEndDateTime",
		FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventImage = filter_input(INPUT_GET, "eventImage",
		FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventLat = filter_input(INPUT_GET, "eventLat",
		FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventLong = filter_input(INPUT_GET, "eventLong",
	FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventName = filter_input(INPUT_GET, "eventName",
		FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventPrice = filter_input(INPUT_GET, "eventPrice",
		FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventStartDateTime = filter_input(INPUT_GET, "eventStartDateTime",
		FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);


}