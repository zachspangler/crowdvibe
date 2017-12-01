<?php
namespace Edu\Cnm\CrowdVibe\Test;

namespace Edu\Cnm\CrowdVibe\Test;
use Edu\Cnm\CrowdVibe\{
    Profile, Event, EventAttendance, Rating
};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the Rating class
 *
 * This is a complete PHPUnit test of the Rating class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Rating
 * @author Matthew David <mcdav3636@gmail.com>
 **/

class RatingTest extends crowdvibeTest {

	/**
	 * Profile that created the Rating; this is for foreign key relation
	 * @var Profile $rater
	 **/
	protected $rater;


	/**
	 * Profile that receives the Rating; this is for foreign key relation
	 * @var Profile $ratee
	 **/
	protected $ratee;

    /**
     * Event that receives the Rating; this is a foreign key relation
     *@var Event $event
     **/
    protected $event;

    /**
     * EventAttendance that connects the Rating; this is a foreign key relation
     *@var EventAttendance $eventAttendance
     **/
    protected $eventAttendance;

	/**
	 * score of the Rating
	 * @var int $VALID_RATINGS_SCORE
	 **/
	protected $VALID_RATING_SCORE = 3;

    /**
     * score of the Rating
     * @var int $VALID_RATINGS_SCORE2
     **/
    protected $VALID_RATING_SCORE2 = 5;



    /**
     * create dependent objects before running each test
     **/
    public final function setUp() : void {
        //run the default setUp() method first
        parent::setUp();
        $password = "abc123";

        $eventEndDateTime = new \DateTime();
        $eventEndDateTime->add(new \DateInterval("P10D"));

        $eventStartDateTime = new \DateTime();
        $eventStartDateTime->sub(new \ DateInterval("P10D"));

        $profileActivationToken = bin2hex(random_bytes(16));

        $SALT = bin2hex(random_bytes(32));
        $HASH = hash_pbkdf2("sha512", $password, $SALT, 262144);

        //create and insert a Rater to own the test Rating
        $this->rater = new Profile(generateUuidV4(), $profileActivationToken, "i'm hugry", "breez@hometime.com", "Cheech", $HASH, "big time", "Maren", $SALT, "@sohigh");
        $this->rater->insert($this->getPDO());

        //create and insert a Ratee to be receive Rating
        $this->ratee = new Profile(generateUuidV4(),$profileActivationToken, "I like eggs", "getsome@me.com", "tommy", $HASH, "little time", "chong", $SALT,"@smoke");
        $this->ratee->insert($this->getPDO());

        //create and insert a Event to own the test Rating
        $this->event = new Event(generateUuidV4(), $this->rater->getProfileId(), 50, "howdy", $eventEndDateTime, "lets do it","35.084319", "-106.619781", "big boy pants!", 5, $eventStartDateTime);

        $this->event->insert($this->getPDO());

        //create and insert event attendance to be able to rate
        $this->eventAttendance = new eventAttendance(generateUuidV4(), $this->event->getEventId(),$this->rater->getProfileId(), "2", "15");
        $this->eventAttendance->insert($this->getPDO());

    }

    /**
     * test inserting a valid Rating and verify that the actual mySQL data matches
     **/
    public function testInsertValidRating() : void {
        //count number of rows and save for later
        $numRows = $this->getConnection()->getRowCount("rating");

        //create a new Rating and insert into mySQL
		  $ratingId = generateUuidV4();
        $rating = new Rating($ratingId,$this->eventAttendance->getEventAttendanceId(), $this->ratee->getProfileId(), $this->rater->getProfileId(),$this->VALID_RATING_SCORE);
        $rating->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations

        $pdoRating = Rating::getRatingByRatingId($this->getPDO(), $ratingId);
        $this->assertEquals($numRows + 1,$this->getConnection()->getRowCount("rating"));
        $this->assertEquals($pdoRating->getRatingId(),$ratingId);
        $this->assertEquals($pdoRating->getRatingEventAttendanceId(), $this->eventAttendance->getEventAttendanceId());
        $this->assertEquals($pdoRating->getRatingRateeProfileId(),$rating->getRatingRateeProfileId());
        $this->assertEquals($pdoRating->getRatingRaterProfileId(),$rating->getRatingRaterProfileId());
        $this->assertEquals($pdoRating->getRatingScore(), $this->VALID_RATING_SCORE);
    }

    /**
     * test inserting a Rating, edit it, and then updating it
     **/
    public function testUpdateValidRating() : void {
        //count number of rows and save for later
        $numRows = $this->getConnection()->getRowCount("rating");

        //create a new Rating and insert into mySQL
        $rating = new Rating(generateUuidV4(),$this->eventAttendance->getEventAttendanceId(), $this->ratee->getProfileId(), $this->rater->getProfileId(),$this->VALID_RATING_SCORE2);
        $rating->insert($this->getPDO());

        //edit the Rating and update it in mySQL
        $rating->setRatingScore($this->VALID_RATING_SCORE);
        $rating->update($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations

        $pdoRating= Rating::getRatingByRatingId($this->getPDO(), $rating->getRatingId());
        $this->assertEquals($numRows + 1,$this->getConnection()->getRowCount("rating"));
        $this->assertEquals($pdoRating->getRatingId(),$rating-> getRatingId());
        $this->assertEquals($pdoRating->getRatingEventAttendanceId(), $this->eventAttendance->getEventAttendanceId());
        $this->assertEquals($pdoRating->getRatingRateeProfileId(),$rating->getRatingRateeProfileId());
        $this->assertEquals($pdoRating->getRatingRaterProfileId(),$rating->getRatingRaterProfileId());
        $this->assertEquals($pdoRating->getRatingScore(), $this->VALID_RATING_SCORE);
    }

    /**
     * test creating a Rating and then deleting it
     **/
    public function testDeleteValidRating() : void {
        //count number of rows and save for later
        $numRows = $this->getConnection()->getRowCount("rating");

        //create a new Rating and insert into mySQL
        $rating = new Rating(generateUuidV4(),$this->eventAttendance->getEventAttendanceId(), $this->ratee->getProfileId(), $this->rater->getProfileId(),$this->VALID_RATING_SCORE);
        $rating->insert($this->getPDO());

        //delete the Rating from mySQL
        $this->assertEquals($numRows + 1,$this->getConnection()->getRowCount("rating"));
        $rating->delete($this->getPDO());

        // grab the data from mySQL and enforce the Rating does not exist
        $pdoRating = rating::getRatingByRatingId($this->getPDO(), $rating->getRatingId());
        $this->assertNull($pdoRating);
        $this->assertEquals($numRows,$this->getConnection()->getRowCount("rating"));
    }

    /**
     * test inserting a Rating and regrab it from mySQL
     **/
    public function testGetValidEventAttendanceId() {
        //count number of rows and save for later
        $numRows = $this->getConnection()->getRowCount("rating");

        //create a new Rating and insert into mySQL
        $ratingId = generateUuidV4();
        $rating = new Rating($ratingId, $this->eventAttendance->getEventAttendanceId(), $this->ratee->getProfileId(), $this->rater->getProfileId(), $this->VALID_RATING_SCORE);
        $rating->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $results = Rating::getRatingByRatingEventAttendanceId($this->getPDO(), $rating->getRatingEventAttendanceId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("rating"));
        $this->assertCount(1, $results);
        $this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CrowdVibe\\Rating", $results);


        //grab the results from the array and validate it
        $pdoRating = $results[0];

        $this->assertEquals($pdoRating->getRatingId(), $ratingId);
        $this->assertEquals($pdoRating->getRatingEventAttendanceId(), $rating->getRatingEventAttendanceId());
        $this->assertEquals($pdoRating->getRatingRateeProfileId(), $rating->getRatingRateeProfileId());
        $this->assertEquals($pdoRating->getRatingRaterProfileId(), $rating->getRatingRaterProfileId());
        $this->assertEquals($pdoRating->getRatingScore(), $this->VALID_RATING_SCORE);
    }

    /**
     * test grabbing a Rating that does not exist
     **/
    public function testGetInvalidRatingByEventAttendanceId() : void {
        // grab a profile id that exceeds the maximum allowable profile id
        $rating = Rating::getRatingByRatingEventAttendanceId($this->getPDO(), generateUuidV4());
        $this->assertCount(0, $rating);
    }


    /**
     * test inserting a Rating and regrabbing it from mySQL
     **/
    public function testGetValidRaterProfileId() : void {
        //count number of rows and save for later
        $numRows = $this->getConnection()->getRowCount("rating");

        //create a new Rating and insert into mySQL
		  $ratingId = generateUuidV4();
        $rating = new Rating($ratingId, $this->eventAttendance->getEventAttendanceId(), $this->ratee->getProfileId(), $this->rater->getProfileId(), $this->VALID_RATING_SCORE);
        $rating->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $results = Rating::getRatingByRatingRaterProfileId($this->getPDO(), $this->rater->getProfileId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("rating"));
        $this->assertCount(1, $results);
        $this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CrowdVibe\\Rating", $results);


        //grab the results from the array and validate it
        $pdoRating = $results[0];

        $this->assertEquals($pdoRating->getRatingId(), $rating->getRatingId());
        $this->assertEquals($pdoRating->getRatingEventAttendanceId(), $this->eventAttendance->getEventAttendanceId());
        $this->assertEquals($pdoRating->getRatingRateeProfileId(), $this->ratee->getProfileId());
        $this->assertEquals($pdoRating->getRatingRaterProfileId(), $this->rater->getProfileId());
        $this->assertEquals($pdoRating->getRatingScore(), $this->VALID_RATING_SCORE);
    }

    /**
     * test grabbing a Rating that does not exist
     **/
    public function testGetInvalidRatingByRaterProfileId() : void {
        // grab a profile id that exceeds the maximum allowable profile id
        $rating = Rating::getRatingByRatingRaterProfileId($this->getPDO(), generateUuidV4());
        $this->assertCount(0, $rating);
    }

    /**
	  * test get valid profile and event average
	  **/
    public function testGetValidProfileAndEventRatingAverage() : void{
    	// count number of rows and save for later
		 $numRows = $this->getConnection()->getRowCount("rating");

		 $password = "fucking work";
		 $SALT = bin2hex(random_bytes(32));
		 $HASH = hash_pbkdf2("sha512", $password, $SALT, 262144);


		 $profile = new Profile(generateUuidV4(),bin2hex(random_bytes(16)), "hope to figure this out3", "willy1@buller.com", "Willy", $HASH, "imageofimages3", "William", $SALT, "willster");
		 $profile->insert($this->getPDO());

		 $password2 = "woo shit";
		 $SALT = bin2hex(random_bytes(32));
		 $HASH = hash_pbkdf2("sha512", $password, $SALT, 262144);

		 $profile2 = new Profile(generateUuidV4(),bin2hex(random_bytes(16)), "I'm a big nancy boy", "cantstopme@hotstuff.com", "Chauncy", $HASH, "afullmoon", "lostashell", $SALT, "thelovedoctor");
		 $profile2->insert($this->getPDO());


		 $eventId = generateUuidV4();
		 $event = new Event($eventId, $profile->getProfileId(),100,"chris' 10th birthday", "2022-11-04 19:45:32.4426", "babiesfirstparty", 35.084319, -106.619781, "get my big boy pants", 10, "2022-11-04 16:45:32.4426");
		 $event->insert($this->getPDO());

		 $eventId2 = generateUuidV4();
		 $event2 = new Event($eventId2, $profile->getProfileId(),2,"Dylans barn raising party!", "2022-11-22 23:45:32.4426", "Amish old folks", 46.084319, -146.619781, "build my venue", 1, "2022-11-22 06:45:32.4426");
		 $event2->insert($this->getPDO());

		 $eventAttendanceId = generateUuidV4();
		 $eventAttendance = new EventAttendance($eventAttendanceId, $event->getEventId(),$profile->getProfileId(), true, 2);
		 $eventAttendance->insert($this->getPDO());

		 $eventAttendanceId1 = generateUuidV4();
		 $eventAttendance1 = new EventAttendance($eventAttendanceId1, $event->getEventId(),$profile2->getProfileId(),  true, 1);
		 $eventAttendance1->insert($this->getPDO());

		 $eventAttendanceId2 = generateUuidV4();
		 $eventAttendance2 = new EventAttendance($eventAttendanceId2, $event->getEventId(),$profile->getProfileId(),  true, 5);
		 $eventAttendance2->insert($this->getPDO());

		 $eventAttendanceId3 = generateUuidV4();
		 $eventAttendance3 = new EventAttendance($eventAttendanceId3, $event->getEventId(),$profile2->getProfileId(), true, 3);
		 $eventAttendance3->insert($this->getPDO());

		 $ratingId= generateUuidV4();
		 $rating = new Rating($ratingId, $eventAttendance->getEventAttendanceEventId(),$profile->getProfileId(), $profile2->getProfileId(),4);
		 $rating->insert($this->getPDO());

		 $ratingId1= generateUuidV4();
		 $rating1 = new Rating($ratingId1, $eventAttendance->getEventAttendanceEventId(),$profile->getProfileId(), $profile2->getProfileId(),2);
		 $rating1->insert($this->getPDO());

		 $ratingId2= generateUuidV4();
		 $rating2 = new Rating($ratingId2, $eventAttendance->getEventAttendanceEventId(),$profile2->getProfileId(), $profile->getProfileId(), 1);
		 $rating2->insert($this->getPDO());

		 $ratingId3= generateUuidV4();
		 $rating3 = new Rating($ratingId3, $eventAttendance3->getEventAttendanceEventId(), $profile2->getProfileId(), $profile->getProfileId(), 5);
		 $rating3->insert($this->getPDO());

			 // grab the data from mySQL and enforce the fields match our expectations
		 $rateeAvg = Rating::getRatingByProfileId($this->getPDO(), $profile->getProfileId());

		 $this->assertEquals($rateeAvg,3, null, 6);

		 // grab the ata from mySQL and enforce the fields match our expectations
		 $eventAvg = Rating::getRatingByEventId($this->getPDO(), $event->getEventId());

		 $this->assertEquals($eventAvg, 3, null, 6);

	 }
}