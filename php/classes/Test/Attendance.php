<?php
namespace Edu\Cnm\CrowdVibe;
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use JsonSerializable;
use Ramsey\Uuid\Uuid;
/**
 * Created by PhpStorm.
 * User: Chris Owens
 * Date: 11/7/2017
 * Time: 16:42
 */

class attendance implements JsonSerializable{
use ValidateUuid;
/**
 * id for the amount of people attending.
 */
protected $attendanceId;
/**
 * Id for attendance to a particular event
 */
protected $attendanceEventId;
/**
 * Id that relates the amount of people attending to a profile
 */
protected $attendanceProfileId;
/**
 * how to keep track of which users attend the event
 */
protected  $attendanceCheckIn;
/**
 * records how many people are attending
 */
protected $attendanceNumberAttending;
}