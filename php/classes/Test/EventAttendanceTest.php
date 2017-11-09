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
 * @author Chris Owens
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
	protected $VALID_CHECK_IN;
	/**
	 * valid hash to use
	 * @var $VALID_HASH
	 */
	protected $VALID_HASH;
	/**
	 * valid number of attending this is the total number of people who are planning on attending
	 * @var $VALID_NUMBER_ATTENDING
	 */
	protected $VALID_NUMBER_ATTENDING;
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
	public final function setUp() : void {
		// run the default setUp() method first
		parent::setUp();
		// create a salt and hash for the mocked profile
		$password = "abc123";
		$this->VALID_SALT = bin2hex(random_bytes(32));
		$this->VALID_HASH = hash_pbkdf2("sha512", $password, $this->VALID_SALT, 262144);
		$this->VALID_ACTIVATION_TOKEN = bin2hex(random_bytes(16));
		// create and insert the mocked profile
		$this->profile = new Profile(generateUuidV4(), $this->VALID_ACTIVATION_TOKEN, "For score and seven years ago","thisis@life.com", "Donald",$this->VALID_HASH, "https://upload.wikimedia.org/", "Knuth", $this->VALID_SALT, "mustreadtaocp");
		$this->profile->insert($this->getPDO());
		// create the and insert the mocked event
		$this->event = new Event(generateUuidV4(), $this->profile->getProfileId(), 20, "19/11/2016 14:00:00","Celebrate the birth of mayan time"), null, "35.113281", "-106.621216", "End of the World - Mayan Style", "0.00", "19/11/2016 12:00:00";
		$this->event->insert($this->getPDO());
		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_LIKEDATE = new \DateTime();
	}

}
