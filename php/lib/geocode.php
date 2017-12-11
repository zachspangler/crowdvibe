<?php

namespace Edu\Cnm\CrowdVibe;
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

/**
 * function to get latitude and longitude by address
 *
 * @param string $address profile address
 * @throws \InvalidArgumentException if $address is not a string or insecure
 *
 */
function getLatLongByAddress ($address) : \stdClass {
	if(empty($address) === true) {
		throw(new \InvalidArgumentException("address content is empty or insecure"));
	}
	$address = filter_var($address, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	$url = 'https://maps.googleapis.com/maps/api/geocode/json';
	$config = readConfig("/etc/apache2/capstone-mysql/crowdvibe.ini");
	$api = $config["google"];

	$json = file_get_contents($url . '?address=' . urlencode($address) . '&key=' . $api);
	$jsonObject = json_decode($json);
	$lat = $jsonObject->results[0]->geometry->location->lat;
	$long = $jsonObject->results[0]->geometry->location->lng;
	$reply = new stdClass();
	$reply->lat = $lat;
	$reply->long = $long;

	return $reply;
}



/**
 * function to get address by latitude and longitude
 *
 * @param float $lat event address
 * @param float $long event address
 * @throws \InvalidArgumentException if $lat or $long is not a float or insecure
 *
 */
function getAddressByLatLong($lat, $long) : \stdClass {
	if(empty($lat)or empty($long) === true) {
		throw(new \InvalidArgumentException("address content is empty or insecure"));
	}
	//$lat = filter_var($lat, FILTER_SANITIZE_NUMBER_FLOAT);
	//$long = filter_var($long, FILTER_SANITIZE_NUMBER_FLOAT);


	$url = 'https://maps.googleapis.com/maps/api/geocode/json';
	$config = readConfig("/etc/apache2/capstone-mysql/crowdvibe.ini");
	$api = $config["google"];
	var_dump($api);

	$json = file_get_contents($url . '?latlng=' . $lat . "," . $long  . '&key=' . $api);
	$jsonObject = json_decode($json);
	$address = $jsonObject->results[0]->formatted_address;
	$reply = new \stdClass();
	$reply->formatted_address = $address;


	return $reply;
}
$fuckOff = getAddressByLatLong(35.085883,
$long = -106.649854);

var_dump($fuckOff);

