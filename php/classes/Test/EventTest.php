<?php
namespace Edu\Cnm\CrowdVibe\Test;

use Edu\Cnm\CrowdVibe\{Profile, Event};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the Event class
 *
 * This is a complete PHPUnit test of the Event class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Event
 * @author Luther <lmckeiver@cnm.edu>
 **/
class EventTest extends CrowdVibeTest {
    /**
     * Profile that created the Event; this is for foreign key relations
     * @var Profile profile
     **/
    protected $profile;


    /**
     * valid profile hash to create the profile object to own the test
     * @var $VALID_HASH
     **/
    protected $VALID_PROFILE_HASH;

    /**
     * valid salt to use to create the profile object to own the test
     * @var string $VALID_SALT
     **/
    protected $VALID_PROFILE_SALT;

    /**
     * detail of the Event
     * @var string $VALID_EVENTDETAIL
     **/
    protected $VALID_EVENTDETAIL = "PHPUnit test passing";

    /**
     * content of the updated Event
     * @var string $VALID_EVENTDETAIL2
     **/
    protected $VALID_EVENTDETAIL2 = "PHPUnit test still passing";

    /**
     * location of event latitude
     * @var float $VALID_EVENTLAT
     **/
    protected $VALID_EVENTLAT;

    /**
     * location of event longitude
     * @var float $VALID_EVENTLONG
     **/
    protected $VALID_EVENTLONG;

    /**
     * price of the event
     * @var float $VALID_EVENTPRICE
     **/
    protected $VALID_EVENTPRICE;

    /**
     * the start of the event
     * @var /DateTime $VALID_EVENTSTARTDATETIME
     **/
    protected $VALID_EVENTSTARTDATETIME;

    /**
     * the end of the event
     * @var /DateTime $VALID_EVENTENDDATETIME
     **/
    protected $VALID_EVENTENDDATETIME;

    /**
     * the amount of attendees that can attend an event
     * @var float $VALID_EVENTATTENDEELIMIT
     **/
    protected $VALID_EVENTATTENDEELIMIT;

    /**
     * this is the image for an event
     * @var null $VALID_EVENTIMAGE
     **/
    protected $VALID_EVENTIMAGE;

    /**
     * this is the name of the event
     * @var string $VALID_EVENTNAME
     **/
    protected $VALID_EVENTNAME;

    /**
     * create dependant object before running each test
     **/
    public final function setUp() : void {
        //run the default setUp() method first
        parent::setUp();
        $password ="Idkwhatimdoing";
        $this->VALID_PROFILE_SALT = bin2hex(random_bytes(32));
        $this->VALID_PROFILE_HASH = hash_pbkdf2("sha512", $password, $this->VALID_PROFILE_SALT, 262144);

        //create and insert a Profile to own test Event
        $this->profile = new Profile(generateUuidV4(), null,"hey im cool", "wow@email.com","JeeWilikers",$this->VALID_PROFILE_HASH,"https://www.google.com/search?q=image&rlz=1C5CHFA_enUS729US729&source=lnms&tbm=isch&sa=X&ved=0ahUKEwjGiIeN3rzXAhXmqFQKHbCfAyAQ_AUICigB&biw=1440&bih=723#imgrc=9rzb-Rok9-rBiM","Coolio",$this->VALID_PROFILE_SALT,"WowIamtehbest101");
        $this->profile->insert($this->getPDO());


        //calculate the date (just use the time the unit test was setup...)
        $this->VALID_EVENTSTARTDATETIME = new \DateTime();
        $this->VALID_EVENTENDDATETIME = new \DateTime();

        //format the eventstartdatetime to use for testing
        $this->VALID_EVENTSTARTDATETIME = new \DateTime();
        $this->VALID_EVENTSTARTDATETIME->sub(new \DateInterval("P10D"));

        //format the eventenddatetime to use for testing
        $this->VALID_EVENTENDDATETIME = new  \DateTime();
        $this->VALID_EVENTENDDATETIME->add(new \DateInterval("P10D"));
    }

    /**
     * test inserting a valid Event and verify that the actual mySQL data matches
     **/
    public function testInsertValidEvent() : void {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("event");

        // create a new Event and insert to into mySQL
        $eventId = generateUuidV4();
        $event = new Event ($eventId, $this->profile->getProfileId(), $this->VALID_EVENTDETAIL, $this->VALID_EVENTATTENDEELIMIT, $this->VALID_EVENTSTARTDATETIME, $this->VALID_EVENTLAT, $this->VALID_EVENTLONG, $this->VALID_EVENTENDDATETIME,);
            $event->insert($this->getPDO());

        //grab the data from mySQL and enforce the fields match our expectations
        $pdoEvent = Event::getEventByEventId($this->getPDO(), $event->getEventId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
        $this->assertEquals($pdoEvent->getEventId(), $eventId);
        $this->assertEquals($pdoEvent->getEventProfileId(),$this->profile->getProfileId());
        $this->assertEquals($pdoEvent->getEventAttendeeLimit(), $this->VALID_EVENTATTENDEELIMIT);
        // format the date too seconds since the beginning of time to avoid round off error
        $this->assertEquals($pdoEvent->getEventEndDateTime()->getTimestamp(),$this->VALID_EVENTENDDATETIME);
        $this->assertEquals($pdoEvent->getEventDetail(), $this->VALID_EVENTDETAIL);
        $this->assertEquals($pdoEvent->getEventImage(), $this->VALID_EVENTIMAGE);
        $this->assertEquals($pdoEvent->getEventLat(), $this->VALID_EVENTLAT);
        $this->assertEquals($pdoEvent->getEventLong(), $this->VALID_EVENTLONG);
        $this->assertEquals($pdoEvent->getEventName(), $this->VALID_EVENTNAME);
        $this->assertEquals($pdoEvent->getEventPrice(), $this->VALID_EVENTPRICE);
        // format the date too seconds since the beginning of time to avoid round off error
        $this->assertEquals($pdoEvent->getEventStartDateTime()->getTimestamp(), $this->VALID_EVENTSTARTDATETIME->getTimestamp());
    }

    /**
     * test creating a Event and then deleting it
     **/
    public function testDeleteValidEvent() : void {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("event");

        // create a new Event and insert into mySQL
        $eventId = generateUuidV4();
            $event = new Event($eventId, $this->profile->getProfileId(), $this->VALID_EVENTATTENDEELIMIT, $this->VALID_EVENTDETAIL, $this->VALID_EVENTENDDATETIME, $this->VALID_EVENTIMAGE, $this->VALID_EVENTLAT, $this->VALID_EVENTLONG, $this->VALID_EVENTNAME, $this->VALID_EVENTPRICE, $this->VALID_EVENTSTARTDATETIME);
            $event->insert($this->getPDO());


        // delete the Event from mySQL
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
        $event->delete($this->getPDO());

        //grab the data from mySQQL and enforce the Event does not exist
        $pdoEvent = Event::getEventByEventId($this->getPDO(), $event->getEventId());
        $this->assertNull($pdoEvent);
        $this->assertEquals($numRows, $this->getConnection()->getRowCount("event"));
    }

    /**
     * test grabbing a Event that does not exist
     **/
    public function testGetInvalidEventbyEventId() : void {
        // grab a profile id that exceeds the maximum allowable profile id
        $event = Event::getEventByEventId($this->getPDO(), generateUuidV4());
        $this->assertNull($event);
    }

    /**
     * test inserting a Event and regrabbing it from mySQL
     **/
    public function testGetValidEventsByEventProfileId() {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("event");

    // create a new Event and insert to mySQL
        $eventId = generateUuidV4();
        $event = new Event($eventId, $this->profile->getProfileId(), $this->VALID_EVENTATTENDEELIMIT, $this->VALID_EVENTDETAIL, $this->VALID_EVENTENDDATETIME, $this->VALID_EVENTIMAGE, $this->VALID_EVENTLAT, $this->VALID_EVENTLONG, $this->VALID_EVENTNAME, $this->VALID_EVENTPRICE, $this->VALID_EVENTSTARTDATETIME);
        $event->insert($this->getPDO());

        //grab the data from mySQL and enforce the fields match our expectations
        $results = Event::getEventByEventProfileId($this->getPDO(), $event->getEventProfileId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
        $this->assertCount(1, $results);
        $this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CrowdVibe\\Event", $results);

        // grab the result from the array and validate it
        $pdoEvent = $results[0];

        $this->assertEquals($pdoEvent->getEventId(), $eventId);
        $this->assertEquals($pdoEvent->getEventProfileId(),$this->profile->getProfileId());
        $this->assertEquals($pdoEvent->getEventAttendeeLimit(), $this->VALID_EVENTATTENDEELIMIT);
        // format the date to seconds since the beginning of time to avoid round off error
        $this->assertEquals($pdoEvent->getEventEndDateTime()->getTimestamp(),$this->VALID_EVENTENDDATETIME);
        $this->assertEquals($pdoEvent->getEventDetail(), $this->VALID_EVENTDETAIL);
        $this->assertEquals($pdoEvent->getEventImage(), $this->VALID_EVENTIMAGE);
        $this->assertEquals($pdoEvent->getEventLat(), $this->VALID_EVENTLAT);
        $this->assertEquals($pdoEvent->getEventLong(), $this->VALID_EVENTLONG);
        $this->assertEquals($pdoEvent->getEventName(), $this->VALID_EVENTNAME);
        $this->assertEquals($pdoEvent->getEventPrice(), $this->VALID_EVENTPRICE);
        // format the date to seconds since the beginning of time to avoid round off error
        $this->assertEquals($pdoEvent->getEventStartDateTime()->getTimestamp(), $this->VALID_EVENTSTARTDATETIME->getTimestamp());
    }

    /**
     * test grabbing a event from by event name
     **/
    public function testGetValidEventByEventName (): void {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("event");
        // create a new Event and insert it into mySQL
        $eventId = generateUuidV4();
        $event = new Event($eventId, $this->profile->getProfileId(), $this->VALID_EVENTATTENDEELIMIT, $this->VALID_EVENTDETAIL, $this->VALID_EVENTENDDATETIME, $this->VALID_EVENTIMAGE, $this->VALID_EVENTLAT, $this->VALID_EVENTLONG, $this->VALID_EVENTNAME, $this->VALID_EVENTPRICE, $this->VALID_EVENTSTARTDATETIME);
        $event->insert($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $results = Event::getEventByEventName($this->getPDO(), $event->getEventName());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
        $this->assertCount(1, $results);

        // enforce no other objects are bleeding into the test
        $this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CrowdVibe\\Event", $results);


        // grab the result from the array and validate it
        $pdoEvent = $results[0];
        $this->assertEquals($pdoEvent->getEventId(), $eventId);
        $this->assertEquals($pdoEvent->getEventProfileId(), $this->profile->getProfileId());
        $this->assertEquals($pdoEvent->getEventDetail(), $this->VALID_EVENTDETAIL);
        //format the date too seconds since the beginning of time to avoid round off error
        $this->assertEquals($pdoEvent->getEventStartDateTime()->getTimestamp(), $this->VALID_EVENTSTARTDATETIME->getTimestamp());
    }
    /**
     * test grabbing a Event by a name that does not exist
     **/
    public function testGetInvalidEventName (): void {
        // grab an name that does not exist
        $event = Event::getEventByEventName($this->getPDO(), "omgmynameisLuther");
        $this->assertNull($event);
    }
	//TODO write valid test method for update. write valid and invalid test method for getEventByEventStartDate.
	/**
	 * test grabbing a Event by Event Start Date Time
	 **/
	public function testGetValidEventByEventStartDateTime (): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("event");
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->profile->getProfileId(), $this->VALID_EVENTATTENDEELIMIT, $this->VALID_EVENTDETAIL, $this->VALID_EVENTENDDATETIME, $this->VALID_EVENTIMAGE, $this->VALID_EVENTLAT, $this->VALID_EVENTLONG, $this->VALID_EVENTNAME, $this->VALID_EVENTPRICE, $this->VALID_EVENTSTARTDATETIME);
		$event->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expecations
		$results = Event::getEventByEventStartDateTime($this->getPDO(), $event->getEventStartDateTime());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CrowdVibe\\Event", $results);

		// grab the result from the array and validate it
		$pdoEvent = $results[0];
		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($pdoEvent->getEventProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoEvent->getEventDetail(), $this->VALID_EVENTDETAIL);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventStartDateTime()->getTimestamp(), $this->VALID_EVENTSTARTDATETIME->getTimestamp());

		/**
		 * test grabbing a invalid event with eventStartDateTime
		 **/
		public function testGetInvalidEventByEventStartDateTime (): void {
			$event = Event::getEventByEventStartDateTime($this->getPDO();
		}




	}
}

