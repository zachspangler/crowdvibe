<?php

require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\CrowdVibe\ {
	Profile
};

/**
 * API for Profile
 *
 * @author Zach Spangler
 * @version 1.0
 */

// verify the session; if not active, start it
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	// grab the MySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/crowdvibe.ini");

	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
	$profileActivationToken = filter_input(INPUT_GET, "profileActivationToken", FILTER_SANITIZE_STRING);
	$profileBio = filter_input(INPUT_GET, "profileBio", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileFirstName = filter_input(INPUT_GET, "profileFirstName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileLastName = filter_input(INPUT_GET, "profileLastName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileUserName = filter_input(INPUT_GET, "profileUserName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
	if($method === "GET") {
		// set XSRF cookie
		setXsrfCookie();
		// gets a profile by cid
		if(empty($id) === false) {
			$profile = Profile::getProfileByProfileId($pdo, $id);
			// gets profile by profile id
			if($profile !== null) {
				$reply->data = $profile;
			}
		} else if(empty($profileEmail) === false) {
			$profile = Profile::getProfileByProfileEmail($pdo, $profileEmail);
			if($profile !== null) {
				$reply->data = $profile;
			}
		} else if(empty($profileUserName) === false) {
			$profile = Profile::getProfileByProfileUserName($pdo, $profileUserName);
			if($profile !== null) {
				$reply->data = $profile;
			}
		} else if(empty($profileUserName) === false) {
			$profile = Profile::getProfileByProfileName($pdo, $profileUserName);
			if($profile !== null) {
				$reply->data = $profile;
			}
		}
	} else if ($method === "PUT") {
		//enforce that the XSRF token is in the header
		verifyXsrf();

		//enforce the user is signed in and only trying and only trying to edit their profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $id) {
			throw(new \InvalidArgumentException("You are not allowed to access this profile", 403));
		}

		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//retrieve the profile to be updated
		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw(new \RuntimeException("Profile does not exist", 404));
		}

		//profile Bio
		if(empty($requestObject->profileBio) === true) {
			throw(new \InvalidArgumentException("No profile bio present", 405));
		}

		//profile Email
		if(empty($requestObject->profileEmail) === true) {
			throw(new \InvalidArgumentException("No profile email present", 405));
		}

		//profile First Name
		if(empty($requestObject->profileFirstName) === true) {
			throw(new \InvalidArgumentException("No first name present", 405));
		}

		//profile Last Name
		if(empty($requestObject->profileLastName) === true) {
			throw(new \InvalidArgumentException("No last name present", 405));
		}

		//profile UserName
		if(empty($requestObject->profileUserName) === true) {
			throw(new \InvalidArgumentException("No profile username present", 405));
		}

		$profile->setProfileBio($requestObject->profileBio);
		$profile->setProfileEmail($requestObject->profileEmail);
		$profile->setProfileFirstName($requestObject->profileFirstName);
		$profile->setProfileLastName($requestObject->profileLastName);
		$profile->setProfileUserName($requestObject->profileUserName);
		$profile->update($pdo);

		// update reply
		$reply->message = "Profile information updated";

	} else if ($method === "DELETE") {

		//Verify XRSF token
		verifyXsrf();

		//validateJwtHeader();
		$profile = Profile::getProfileByProfileId($pdo, $id);

		var_dump($profile);
		var_dump($_SESSION);

		if($profile === null) {
			throw (new \RuntimeException("Profile does not exist"));
		}
		//enforce the user is signed in and only trying to edit their own profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $profile->getProfileId()) {
			throw(new \InvalidArgumentException("You are not allowed to access this profile", 403));
		}
		//delete the profile from the database
		$profile->delete($pdo);
		$reply->message = "Profile Deleted";
	} else {
		throw (new \InvalidArgumentException(("Invalid HTTP request"), 400));
	}
} catch (\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);