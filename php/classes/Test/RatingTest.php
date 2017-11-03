<?php
namespace Edu\Cnm\DataDesign\Test;

use Edu\Cnm\DataDesign\{Profile, Event, Rating};

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

class RatingTest extends DataDesignTest {
    /**
     * Profile that created the Rating; this is for foreign key relations
     * @var Profile profile
     **/
    protected $profile = null;

    /**
     * valid profile hash to create the profile object to own the test
     * @var $VALID_HASH
     */
    protected $VALID_PROFILE_HASH;

    /**
     * valid salt to use to create the profile object to own the test
     * @var string $VALID_SALT
     */
    protected $VALID_PROFILE_SALT;

    /**
     * score of the Rating
     * @var string $VALID_RATINGSCORE
     **/
    protected $VALID_RATINGSCORE = "PHPUnit test passing";

    /**
     * content of the updated Tweet
     * @var string $VALID_RATINGSCORE2
     **/
    protected $VALID_RATINGSCORE2 = "PHPUnit test still passing";
}