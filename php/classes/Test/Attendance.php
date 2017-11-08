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
	/**
	 * constructor for this Comments
	 *
	 * @param Uuid $newAttendanceId id of this events or null if a new events
	 * @param Uuid $newAttendanceProfileId id of the Profile that created the event
	 * @param Uuid $newAttendanceEventId id of the Event people attend
	 * @param Uuid $newAttendanceCheckIn how people are going to notify their attendance
	 * @param string $newAttendanceNumberAttending string containing actual data on the amount of people
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
}