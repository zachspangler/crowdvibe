<?php
use Edu\Cnm\CrowdVibe\{Profile, Event, Rating};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/classes/autoload.php");

require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

require_once("uuid.php");

// grab the uuid generator
require_once( "uuid.php");

$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/crowdvibe.ini");

$password = "fucking work";
$SALT = bin2hex(random_bytes(32));
$HASH = hash_pbkdf2("sha512", $password, $SALT, 262144);

$profile = new Profile(generateUuidV4(),bin2hex(random_bytes(16)), "hope to figure this out3", "willy1@buller.com", "Willy", $HASH, "imageofimages3", "William", $SALT, "willster");
$profile->insert($pdo);