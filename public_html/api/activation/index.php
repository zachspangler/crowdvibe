<?php
require_once dirname(__DIR__,3) . "/vendor/autoload.php";
require_once dirname(__DIR__,3) . "/php/classes/autoload.php";
require_once dirname(__DIR__,3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\Cnm\Crowdvibe\Profile;

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
