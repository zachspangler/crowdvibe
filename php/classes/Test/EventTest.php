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
class EventTest extends CrowdVibeTest
{
    /**
     * Profile that created the Event; this is for foreign key relations
     * @var Profile profile
     **/
    protected $profile = null;


    /**
     * valid profile hash to create the profile object to own the test
     * @var $VALID_HASH
     **/
    protected $VALID_PROFILE_HASH;

    /**
     * vaild salt to use to create the profile object to own the test
     * @var string $VALID_SALT
     **/
    protected $VALID_PROFILE_SALT;

    /**
     * name of the event
     * @var string $VALID_EVENTNAME
     **/
    protected $VALID_EVENTNAME = "PHPUnit test passing";
    /**
     * content of the event
     * @var string $VALID_EVENTDETAIL
     **/
    protected $VALID_EVENTDETAIL = "PHPUnit test passing";

    /**
     * content of the updated Event
     * @var string $VALID_EVENTDETAIL2
     **/
    protected $VALID_EVENTDETAIL2 = "PHPUnit test still passing";

    /**
     * timestamp of the Event; this starts as null and is assigned later
     * @var \DateTime $VALID_EVENTDATE
     **/
    protected $VALID_EVENTDATE = null;

    /**
     * Valid timestamp to use as sunriseEventDate
     **/
    protected $VALID_SUNRISEDATE = null;

    /**
     * Valid timestamp to use as sunsetEventDate
     **/
    protected $VALID_SUNSETDATE = null;

    /**
     * create dependent objects before running each test
     **/
    public final function setUp(): void
    {
        // run the default setUP() method first
        parent::setUp();
        $password = "abc123";
        $this->VALID_PROFILE_SALT = bin2hex(random_bytes(32));
        $this->VALID_PROFILE_HASH = hash_pbkdf2("sha512", $password, $this->VALID_PROFILE_SALT, 262144);


        // create and insert a Profile to own the test Event
        $this->profile = new Profile(generateUuidV4(), null, "Wow very nice computer skills", "woww@mail.com", "Jee", $this->VALID_PROFILE_HASH, null, "Willikers", $this->VALID_PROFILE_SALT, "JeeWilikersImcool"
        );

        // calculate the date (just use the time the unit test was set up...)
        $this - $this->VALID_EVENTDATE = new \DateTime();

        //format the sunrise date to use for testing
        $this->VALID_SUNRISEDATE = new \DateTime();
        $this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));
    }

    /**
     * test inserting a valid Event and verify that the actual mySQL data matches
     **/
    public function testInsertValidEvent(): void
    {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("event");

        //create a new Event and insert into mySQL
        $eventId = generateUuidV4();
        $event = new Event($eventId, $this->profile->getProfileId(), $this->VALID_EVENTDETAIL, $this->VALID_EVENTDATE);
        $this->insert($this->getPDO());

        //edit the Event and update it in mySQL
        $event->setEventDetail($this->VALID_EVENTDETAIL2);
        $event->update($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $pdoEvent = Event::getEventByEventId($this->getPDO(), $event->getEventId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
        $this->assertEquals($pdoEvent->getEventProfileId(), $this->profile->getProfileId());
        $this->assertEquals($pdoEvent->getEventDetail(), $this->VALID_EVENTDETAIL2);
        //format the date too seconds since the beginning of time to avoid round off error
        $this->assertEquals($pdoEvent->getEventDate()->getTimestamp(), $this->VALID_EVENTDATE->getTimestamp());


    }
/**
 * test updating a Event that does not exist
 *
 * @exceptedException \PDOException
 **/
public function testUpdateInvalidEvent() : void {
    // create a Event with a non null event id and watch it fail
    $event = new Event(null, $this->profile->getProfileId(), $this->VALID_EVENTDETAIL, $this->VALID_EVENTDATE);
    $event->update($this->getPDO());
}
/**
 * test creating a Event and then deleting it
 **/
public function testDeleteValidEvent() : void {
    // count the number of rows and save it for later
    $numRows = $this->getConnection()->getRowCount("event");

    // create a new Event and insert to into mySQL
    $event = new Event(null, $this->profile->getProfileId(), $this->VALID_EVENTDETAIL, $this->VALID_EVENTDATE);
    $event->insert($this->getPDO());

    // delete the Event from mySQL
    $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
    $event->delete($this->getPDO());

    // grab the data from mySQL and enforce the Event does not exist
    $pdoEvent = Event::getEventByEventId($this->getPDO(), $event->getEventId());
    $this->assertNull($pdoEvent);
    $this->assertEquals($numRows, $this->getConnection()->getEventCount("event"));
}
/**
 * test deleting a Event that does not exist
 *
 * @expectedException \PD0Exception
 **/
public function testDeleteInvalidEvent() : void {
    // create a Event and try not to delete it without actually inserting it
    $event = new Event(null, $this->profile->getProfileId(), $this->VALID_EVENTDETAIL, $this->VALID_EVENTDATE);
    $event->delete($this->getPDO());

}
/**
 * test grabbing a Event that does not exist
 **/
public function testGetInvalidEventbyEventId() : void {
    // grab a profile id that exceeds the maximum allowable profile id
    $event = Event::getEventByEventId ($this->getPDO(), CrowdVibeTest::INVALID_KEY());
$this->assertNull($event);
}

/**
 * test inserting a Event and regrabbing it from mySQL
 **/
public function testGetValidEventByEventProfileId() {
    // count the number of rows and save it for later
    $numRows = $this->getConnection()->getRowCount("event");

    // create a new Event and insert to mySQL
    $event = new Event(null, $this->profile->getProfileId(), $this->VALID_EVENTDETAIL, $this->VALID_EVENTDATE);
    $event->insert($this->getPDO());

    // grab the data from mySQL and enforce the fields match our expectations
    $results = Event::getEventByEventProfileId($this->getPDO(), $event->getEventProfileId());
    $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
    $this->assertCount(1, $results);
    $this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CrowdVibe\\Event", $results);

    //grab the result from the array and validate it
    $pdoEvent =$results[0];
    $this->assertEquals($pdoEvent->getEventProfileId(), $this->profile->getProfileId());
}
/**
 * test grabbing a Event that does not exist
 **/
public function testGetInvalidEventByEventProfileId() : void {
    // grab a profile id that exceeds the maximum allowable profile id
    $event = Event::getEventByEventProfileId ($this->getPDO(), CrowdVibeTest::INVALID_KEY);
    $this->assertCount(0, $event);
}
/**
 * test grabbing a Event by event detail
 **/
public function testGetValidEventByEventContent() : void {
    // count the number of rows and save it for later
    $numRows = $this->getConnection()->getRowCount("event");

    // create a new Event and insert into mySQL
    $event = new Event(null, $this->profile->getProfileId(), $this->VALID_EVENTDETAIL, $this->VALID_EVENTDATE);
    $event->insert($this->getPDO());

    //enforce no other objects are bleeding into the test
    $this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CrowdVibe\\Event",$results);

    //grab the result from the array and validate it
    $pdoEvent = $results[0];
    $this->assertEquals($pdoEvent->getEventProfileId(), $this->profile->getProfileId());
    $this->assertEquals($pdoEvent->getEventDetail(), $this->VALID_EVENTDETAIL);
    //format the date too seconds since the beginning of time to avoid round off error
    $this->assertEquals($pdoEvent->getEventDate()->getTimestamp(), $this->VALID_EVENTDATE->getTimestamp());
}
/**
 * test grabbing a Event by detail that does not exist
 **/
public function testGetInvalidEventByEventContent () : void {
    // grab event by detail that does not exist
    $event = Event::getEventByEventDetail ($this->getPDO(), "I don't like loud chewing");
    $this->assertCount(0, $event);
}

/**
 * test grabbing a valid Event by sunset and sunrise date
 *
 */
public function testGetValidEventDateBySunDate() : void {
    //count the number of rows and save it for later
    $numRows = $this->getConnection()->getRowCount("event");


    // grab the event from the database and see if it matches expectations
    $results = Event::getEventByEventDate($this->getPDO(), $this->VALID_SUNRISEDATE, $this->VALID_SUNSETDATE);
    $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
    $this->assertCount(1, $results);


    //enforce that no other objects are bleeding into the test
    $this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CrowdVibe\\Event", $results);

    //use the first result to make sure that the inserted event meets expectations
    $pdoEvent = $results[0];
    $this->assertEquals($pdoEvent->getEventId(), $event->getEventId());
    $this->assertEquals($pdoEvent->getEventProfileId(), $event->getEventProfileId());
    $this->assertEquals($pdoEvent->getEventDetail(), $event->getEventDetail());
    $this->assertEquals($pdoEvent->getEventDate()->getTimestamp(), $this->VALID_EVENTDATE->getTimestamp());
}

/**
 *test grabbing all Events
 **/
public function testGetAllValidEvents() : void {
    // count the number of rows and save it for later
    $numRows = $this->getConnection()->getRowCount("event");


    //create a new Event and insert into mySQL
    $event = new Event(null, $this->profile->getProfileId(), $this->VALID_EVENTDETAIL, $this->VALID_EVENTDATE);
    $event->insert($this->getPDO());

    //grab the data from mySQL and enforce the fields match our expectations
    $results = Event::getAllEvents($this->getPDO());
    $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
    $this->assertCount(1, $results);
    $this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CrowdVibe\\Event", $results);
}
}


