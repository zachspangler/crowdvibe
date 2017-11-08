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
    public final function setUp() :void {
        // run the default setUP() method first
        parent::setUp();
        $password = "abc123";
        $this->VALID_PROFILE_SALT = bin2hex (random_bytes(32));
        $this->VALID_PROFILE_HASH = hash_pbkdf2("sha512", $password, $this->VALID_PROFILE_SALT, 262144);


        // create and insert a Profile to own the test Event
        $this->profile = new Profile(generateUuidV4(),null, "Wow very nice computer skills","woww@mail.com","Jee", $this->VALID_PROFILE_HASH, null,"Willikers", $this->VALID_PROFILE_SALT,"JeeWilikersImcool"
            );
    }
}




