<?php
namespace Edu\Cnm\CrowbVibe\Test;
use Edu\Cnm\CrowbVibe\{Profile, Event, EventAttendance};
use Edu\Cnm\CrowdVibe\Test\CrowdVibeTest;

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");
/**
 * Full PHPUnit test for the Event Attendance class
 *
 * This is a complete PHPUnit test of the Like class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @author
 **/
class EventAttendanceTest extends CrowdVibeTest {
	/**
	 * Profile that attended the event; this is for foreign key relations
	 * @var  Profile $profile
	 **/
	protected $profile;
	/**
	 * Event is being attended; this is for foreign key relations
	 * @var  Event $event
	 **/
	protected $event;
	/**
	 * Attendance Check In is a int used as a boolean to show whether or not the user attended the event
	 * @var  $VALID_CHECK_IN
	 **/
	protected $VALID_CHECK_IN = 1;
	/**
	 * valid hash to use
	 * @var $VALID_HASH
	 */
	protected $VALID_HASH;
	/**
	 * valid number of attending this is the total number of people who are planning on attending
	 * @var $VALID_NUMBER_ATTENDING
	 */
	protected $VALID_NUMBER_ATTENDING = 2;
	/**
	 * valid salt to use to create the profile object to own the test
	 * @var string $VALID_SALT
	 */
	protected $VALID_SALT;
	/**
	 * valid activationToken to create the profile object to own the test
	 * @var string $VALID_ACTIVATION
	 */
	protected $VALID_ACTIVATION_TOKEN;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp(): void {
		// run the default setUp() method first
		parent::setUp();
		// create a salt and hash for the mocked profile
		$password = "abc123";
		$this->VALID_SALT = bin2hex(random_bytes(32));
		$this->VALID_HASH = hash_pbkdf2("sha512", $password, $this->VALID_SALT, 262144);
		$this->VALID_ACTIVATION_TOKEN = bin2hex(random_bytes(16));
		// create and insert the mocked profile
		$this->profile = new Profile(generateUuidV4(), $this->VALID_ACTIVATION_TOKEN, "For score and seven years ago", "thisis@life.com", "Donald", $this->VALID_HASH, "https://upload.wikimedia.org/", "Knuth", $this->VALID_SALT, "mustreadtaocp");
		$this->profile->insert($this->getPDO());
		// create the and insert the mocked event
		$this->event = new Event(generateUuidV4(), $profile->getProfileId(), 20, "19/11/2016 14:00:00", "Celebrate the birth of mayan time", null, "35.113281", "-106.621216", "End of the World - Mayan Style", "0.00", "19/11/2016 12:00:00");
		$this->event->insert($this->getPDO());
	}
	/**
	 * test inserting a valid Event Attendance and verify that the actual mySQL data matches
	 **/
	public function testInsertValidEventAttendance(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("eventAttendance");
		// create a new Event Attendance and insert to into mySQL
		$eventAttendance = new EventAttendance(generateUuidV4(), $profile->getProfileId(), $event->getEventId(), $this->VALID_CHECK_IN, $this->VALID_NUMBER_ATTENDING);
		$eventAttendance->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoEventAttendance = EventAttendance::getEventAttendanceByEventId($this->getPDO(), $profile->getProfileId(), $event->getEventId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("eventAttendance"));
		$this->assertEquals($pdoEventAttendance->getEventAttendanceEventId(), $event->getEventId());
		$this->assertEquals($pdoEventAttendance->getEventAttendanceProfileId(), $profile->getProfileId());
		$this->assertEquals($pdoEventAttendance->getEventAttendanceCheckIn(), $this->VALID_CHECK_IN);
		$this->assertEquals($pdoEventAttendance->getEventAttendanceNumberAttending(), $this->VALID_NUMBER_ATTENDING);
	}
	/**
	 * test creating a Event Attendance and then deleting it
	 **/
	public function testDeleteValidEventAttendance() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("eventAttendance");
		// create a new Event Attendance and insert to into mySQL
		$eventAttendance = new EventAttendance(generateUuidV4(), $event->getEventId(), $profile->getProfileId(), $this->VALID_CHECK_IN, $this->VALID_NUMBER_ATTENDING);
		$eventAttendance->insert($this->getPDO());
		// delete the Event Attendance from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("eventAttendance"));
		$eventAttendance->delete($this->getPDO());
		// grab the data from mySQL and enforce the Event Attendance does not exist
		$pdoEventAttendance = EventAttendance::getEventAttendanceByEventId($this->getPDO(), generateUuidV4(), $event->getEventId(), $profile->getProfileId(), $this->VALID_CHECK_IN, $this->VALID_NUMBER_ATTENDING);
		$this->assertNull($pdoEventAttendance);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("eventAttendance"));
	}
	/**
	 * test inserting a Event Attendance and regrabbing it from mySQL
	 **/
	public function testGetValidEventAttendanceByProfileId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("eventAttendance");
		// create a new Event Attendance and insert to into mySQL
		$eventAttendance = new EventAttendance(generateUuidV4(), $event->getEventId(), $profile->getProfileId(), $this->VALID_CHECK_IN, $this->VALID_NUMBER_ATTENDING);
		$eventAttendance->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoEventAttendance = EventAttendance::getEventAttendanceByProfileId($this->getPDO(), $event->getEventId(), $profile->getProfileId(), $this->VALID_CHECK_IN, $this->VALID_NUMBER_ATTENDING);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("eventAttendance"));
		$this->assertEquals($pdoEventAttendance->getEventAttendanceEventId(), $event->getEventId());
		$this->assertEquals($pdoEventAttendance->getEventAttendanceProfileId(), $profile->getProfileId());
		$this->assertEquals($pdoEventAttendance->getEventAttendanceCheckIn(), $this->VALID_CHECK_IN);
		$this->assertEquals($pdoEventAttendance->getEventAttendanceNumberAttending(), $this->VALID_NUMBER_ATTENDING);
	}
	/**
	 * test grabbing event attendance by event attendance Id
	 **/
	public function testGetValidEventAttendanceByEventAttendanceId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("eventAttendance");
		// create a new Event Attendance and insert to into mySQL
		$eventAttendance = new EventAttendance(generateUuidV4(), $event->getEventId(), $profile->getProfileId(), $this->VALID_CHECK_IN, $this->VALID_NUMBER_ATTENDING);
		$eventAttendance->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = EventAttendance::getEventAttendanceByEventAttendanceId($this->getPDO(), $eventAttendance->getEventAttendanceId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("eventAttendance"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CrowdVibe\\EventAttendance", $results);
		// grab the result from the array and validate it
		$pdoEventAttendance = $results[0];
		$this->assertEquals($pdoEventAttendance->getEventAttendanceEventId(), $event->getEventId());
		$this->assertEquals($pdoEventAttendance->getEventAttendanceProfileId(), $profile->getProfileId());
		$this->assertEquals($pdoEventAttendance->getEventAttendanceCheckIn(), $this->VALID_CHECK_IN);
		$this->assertEquals($pdoEventAttendance->getEventAttendanceNumberAttending(), $this->VALID_NUMBER_ATTENDING);
	}
	/**
	 * test grabbing event attendance by event Id
	 **/
	public function testGetValidEventAttendanceByEventAttendanceEventId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("eventAttendance");
		// create a new Event Attendance and insert to into mySQL
		$eventAttendance = new EventAttendance(generateUuidV4(), $event->getEventId(), $profile->getProfileId(), $this->VALID_CHECK_IN, $this->VALID_NUMBER_ATTENDING);
		$eventAttendance->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = EventAttendance::getEventAttendanceByEventAttendanceEventId($this->getPDO(), $eventAttendance->getEventAttendanceEventId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("eventAttendance"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CrowdVibe\\EventAttendance", $results);
		// grab the result from the array and validate it
		$pdoEventAttendance = $results[0];
		$this->assertEquals($pdoEventAttendance->getEventAttendanceEventId(), $event->getEventId());
		$this->assertEquals($pdoEventAttendance->getEventAttendanceProfileId(), $profile->getProfileId());
		$this->assertEquals($pdoEventAttendance->getEventAttendanceCheckIn(), $this->VALID_CHECK_IN);
		$this->assertEquals($pdoEventAttendance->getEventAttendanceNumberAttending(), $this->VALID_NUMBER_ATTENDING);
	}
	/**
	 * test grabbing event attendance by profile Id
	 **/
	public function testGetValidEventAttendanceByEventAttendanceProfileId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("eventAttendance");
		// create a new Event Attendance and insert to into mySQL
		$eventAttendance = new EventAttendance(generateUuidV4(), $event->getEventId(), $profile->getProfileId(), $this->VALID_CHECK_IN, $this->VALID_NUMBER_ATTENDING);
		$eventAttendance->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = EventAttendance::getEventAttendanceByEventAttendanceProfileId($this->getPDO(), $eventAttendance->getEventAttendanceProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("eventAttendance"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CrowdVibe\\EventAttendance", $results);
		// grab the result from the array and validate it
		$pdoEventAttendance = $results[0];
		$this->assertEquals($pdoEventAttendance->getEventAttendanceEventId(), $event->getEventId());
		$this->assertEquals($pdoEventAttendance->getEventAttendanceProfileId(), $profile->getProfileId());
		$this->assertEquals($pdoEventAttendance->getEventAttendanceCheckIn(), $this->VALID_CHECK_IN);
		$this->assertEquals($pdoEventAttendance->getEventAttendanceNumberAttending(), $this->VALID_NUMBER_ATTENDING);
	}
}
