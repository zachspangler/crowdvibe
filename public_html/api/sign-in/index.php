<?php
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Crowdvibe\Profile;

/**
 * api for handling sign-in
 *
 * @author Zach Spangler
 */

// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	// start session
	if(session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
	// grab MySQL statement
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/crowbvibe.ini");

	// determine which HTTP method is being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// if method is POST, handle the sign in logic
	if($method === "POST") {
		// make sure XSRF token is valid
		verifyXsrf();
		// process the request content and decode the json object into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		// check to make sure the password and email field is not empty
		if(empty($requestObject->profileEmail) === true) {
			throw(new \InvalidArgumentException("Incorrect email address", 401));
		} else {
			$profileEmail = filter_var($requestObject->profileEmail, FILTER_SANITIZE_EMAIL);
		}
		if(empty($requestObject->profilePassword) === true) {
			throw(new \InvalidArgumentException("Must enter a password", 401));
		} else {
			$profilePassword = $requestObject->profilePassword;
		}
