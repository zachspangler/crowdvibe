<?php
namespace Edu\Cnm\CrowdVibe\Test;

use Edu\Cnm\CrowdVibe\{Profile, Event, Rating};

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
	 * valid profile hash to create the profile object to own the test
	 * @var $VALID_HASH
	 */
	protected $VALID_RATER_HASH;

	/**
	 * valid salt to use to create the profile object to own the test
	 * @var string $VALID_SALT
	 */
	protected $VALID_RATER_SALT;

	/**
	 * Profile that created the Rating; this is for foreign key relation
	 * @var Profile $ratee
	 **/
	protected $ratee;

	/**
	 * valid profile hash to create the profile object to own the test
	 * @var $VALID_HASH
	 */
	protected $VALID_RATEE_HASH;

	/**
	 * valid salt to use to create the profile object to own the test
	 * @var string $VALID_SALT
	 */
	protected $VALID_RATEE_SALT;

	/**
	 * score of the Rating
	 * @var int $VALID_RATINGS_CORE
	 **/
	protected $VALID_RATING_SCORE = 3;


	//TODO: add event variable for testing
	/**
	 * type of the Rating- person or event
	 * @var string $VALID_RATING_TYPE
	 **/
	protected $VALID_RATING_TYPE = "PHPUnit test passing";




    /**
     * create dependent objects before running each test
     **/
    public final function setUp() : void {
        //run the default setUp() method first
        parent::setUp();
        $password = "abc123";
        $eventDate = new \DateTime();
        $this->VALID_RATEE_SALT = bin2hex(random_bytes(32));
        $this->VALID_RATEE_HASH = hash_pbkdf2("sha512", $password, $this->VALID_RATEE_SALT, 262144);
        ;
        //create and insert a Rater to own the test Rating
        $this->rater = new Profile(generateUuidV4(), "stringcheese", "i'm hugry", "breez@hometime.com", "Cheech", $this->VALID_RATER_HASH, null, "Maren", $this->VALID_RATER_SALT, "@sohigh");
        $this->rater->insert($this->getPDO());

        //create and insert a Ratee to own the test Rating
        $this->ratee = new Profile(generateUuidV4(),"cawabunga", "I like eggs", "getsome@me.com", "tommy", $this->VALID_RATEE_HASH, $this->VALID_RATEE_HASH, "chong", $this->VALID_RATEE_SALT,"@smoke");
        $this->ratee->insert($this->getPDO());

        //create and insert a Event to own the test Rating
        $this->event = new Event(generateUuidV4(), null, $eventDate, "fun fun fun", null, "35.084319", "-106.619781", "chris' 10th bithday", null, )


    }
}