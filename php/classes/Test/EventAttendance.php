<?php
namespace Edu\Cnm\DataDesign\Test;

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

class EventAttendanceTest extends DataDesignTest {
	/**
	 * Profile that created the Event; this is for foreign key relations
	 * @var EventAttendance Attendance
	 **/
	protected $EventAtendance = null;
}