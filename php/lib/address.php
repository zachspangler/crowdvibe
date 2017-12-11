<?php

/**
 * function to get latitude and longitude by address
 *
 * @param string $address profile address
 * @throws \InvalidArgumentException if $address is not a string or insecure
 *
 */
function getAddressByLatLong($lat, $long) : \stdClass {
    if(empty($lat)or empty($long) === true) {
        throw(new \InvalidArgumentException("address content is empty or insecure"));
    }
    $lat = filter_var($lat, FILTER_SANITIZE_NUMBER_FLOAT);
    $long = filter_var($long, FILTER_SANITIZE_NUMBER_FLOAT);

    $url = 'https://maps.googleapis.com/maps/api/geocode/json';
    $config = readConfig("/etc/apache2/capstone-mysql/crowdvibe.ini");
    $api = $config["google"];

    $json = file_get_contents($url . '?latlng=' . $lat . "," . $long  . '&key=' . $api);
    $jsonObject = json_decode($json);
    $address = $jsonObject->results[0]->formatted_address;
    $reply = new stdClass();
    $reply->formatted_address = $address;

    return $reply;
}

