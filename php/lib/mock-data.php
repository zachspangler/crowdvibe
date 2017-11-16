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

$password2 = "woo shit";
$SALT = bin2hex(random_bytes(32));
$HASH = hash_pbkdf2("sha512", $password, $SALT, 262144);

$profile2 = new Profile(generateUuidV4(),bin2hex(random_bytes(16)), "I'm a big nancy boy", "cantstopme@hotstuff.com", "Chauncy", $HASH, "afullmoon", "lostashell", $SALT, "thelovedoctor");
$profile2->insert($pdo);


$eventId = generateUuidV4();
$event = new Event($eventId, $profile->getProfileId(),100,"chris' 10th birthday", "2022-11-04 19:45:32.4426", "babiesfirstparty", 35.084319, -106.619781, "get my big boy pants", 10, "2022-11-04 16:45:32.4426");
$event->insert($pdo);

$eventId2 = generateUuidV4();
$event2 = new Event($eventId2, $profile->getProfileId(),2,"Dylans barn raising party!", "2022-11-22 23:45:32.4426", "Amish old folks", 46.084319, -146.619781, "build my venue", 1000000, "2022-11-22 06:45:32.4426");
$event2->insert($pdo);

$eventAttendanceId = generateUuidV4();
$eventAttendance = new EventAttendance($eventAttendanceId, $event->getEventId(), $profile->getProfileId(), 1, 2);
$eventAttendance->insert($pdo);

$eventAttendanceId1 = generateUuidV4();
$eventAttendance1 = new EventAttendance($eventAttendanceId1, $event->getEventId(), $profile->getProfileId(), 1, 2);
$eventAttendance1->insert($pdo);

$eventAttendanceId2 = generateUuidV4();
$eventAttendance2 = new EventAttendance($eventAttendanceId2, $event->getEventId(), $profile->getProfileId(), 1, 2);
$eventAttendance2->insert($pdo);

$eventAttendanceId3 = generateUuidV4();
$eventAttendance3 = new EventAttendance($eventAttendanceId3, $event->getEventId(), $profile->getProfileId(), 1, 2);
$eventAttendance3->insert($pdo);