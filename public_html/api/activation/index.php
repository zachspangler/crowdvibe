<?php
require_once dirname(__DIR__,3) . "/vendor/autoload.php";
require_once dirname(__DIR__,3) . "/php/classes/autoload.php";
require_once dirname(__DIR__,3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\Cnm\CrowdVibe\Profile;

/**
 * api for the Profile Activation class
 *
 * @author Zach Spangler <zaspangler@gmail.com>
 */

//verify the session status. start session if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/crowdvibe.ini");
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	//sanitize activation input
	$activation = filter_input(INPUT_GET, "activation", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	// handle GET request - if id is present, that activation is returned, otherwise all activations are returned
	if($method === "GET") {
		//make sure Profile Activation Token is a valid hash
		if(ctype_xdigit($activation) === false) {
			throw (new \InvalidArgumentException("Activation token is invalid.", 405));
		}
		//check that activation token is correct length
		if(strlen($activation) !== 32) {
			throw (new \InvalidArgumentException("Activation token is invalid length", 405));
		}
		//set XSRF Cookie
		setXsrfCookie();
		$profile = Profile::getProfileByProfileActivationToken($pdo, $activation);
		if(empty($profile) === true) {
			throw(new\InvalidArgumentException("No profile for Activation", 404));
		}
		//set activation token to null
		$profile->setProfileActivationToken(null);
		//update profile
		$profile->update($pdo);
		//update reply
		$reply->message = "Your account has been activated, start vibing!";
	}
	else {
		throw (new\Exception("Invalid HTTP method", 405));
	}
	header("Location: ../../");
	// update reply with exception information
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();

	echo json_encode($reply);
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

//header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);