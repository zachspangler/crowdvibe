<?php
namespace Edu\Cnm\DataDesign\Test;

use Edu\Cnm\CrowdVibe\Test\CrowdVibeTest;
use Edu\Cnm\DataDesign\{Event, Attendance};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the EventAttendance class
 *
 * This is a complete PHPUnit test of the EventAttendance class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Rating
 * @author Chris Owens <cowens17@cnm.edu>
 **/

class EventAttendanceTest extends CrowdVibeTest {
	/**
	 * Event Attendance Id is the unique identifier for an Event; this is a primary key relations
	 * @var AttendanceId
	 **/
	protected $AttendanceId = null;
	/**
	 * Attendance Event id is how to relate a post to a specific event (foreign key)
	 * @var AttendanceEventId
	 */
	protected $AttendanceEventId = null;
	/**Attendance Profile Id is how the event is specific to one profile (foreign key)
	 * @var AttendanceProfileId
	 */
	Protected $AttendanceProfileId = null;
	/**
	 * Attendance Check In is how people will let people know they will attend an event
	 * @var
	 **/
	public $AttendanceCheckIn = null;
	/**
	 * Attendance Number Attending will tell the profile the amount of people present
	 */
	public $AttendanceNumberAttending = null;
	}
}