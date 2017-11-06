<?php
/**
 * Created by PhpStorm.
 * User: zacharyspangler
 * Date: 11/3/17
 * Time: 9:33 AM
 */

namespace Edu\Cnm\CrowdVibe\Test;

use Edu\Cnm\CrowdVibe\{Profile};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the Profile class
 *
 * This is a complete PHPUnit test of the Profile class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Profile
 * @author Zach Spangler<zspangler@gmail.com> and Dylan McDonald <dmcdonald21@cnm.edu>
 **/

class Profile extends CrowdVibe {
	/**
	 * Profile Id is the unique identifier for a profile; this is a primary key relations
	 * @var Uuid $VALID_PROFILE_ID
	 **/
	protected $VALID_PROFILE_ID = "PHPUnit test passing";

	/**
	 * Profile Activation Token is a the way an account is confirmed
	 * @var $VALID_PROFILE_ACTIVATION_TOKEN
	 **/
	protected $VALID_PROFILE_ACTIVATION_TOKEN = "PHPUnit test passing";

	/**
	 * Profile Bio is the text description for the user
	 * @var string $VALID_PROFILE_BIO
	 **/
	protected $VALID_PROFILE_BIO = "PHPUnit test passing";

	/**
	 * Profile Email is the email associated with the profile
	 * @var string $VALID_PROFILE_EMAIL
	 **/
	protected $VALID_PROFILE_EMAIL = "PHPUnit test passing";

	/**
	 * Profile Fist Name is the first name of the user
	 * @var string $VALID_PROFILE_FIRST_NAME
	 **/
	protected $VALID_PROFILE_FIRST_NAME = "PHPUnit test passing";

	/**
	 * Profile Hash is used for the profile password
	 * @var $VALID_PROFILE_HASH
	 **/
	protected $VALID_PROFILE_HASH;

	/**
	 * Profile Image is image the profile will use
	 * @var string $VALID_PROFILE_IMAGE
	 **/
	protected $VALID_PROFILE_IMAGE = "PHPUnit test passing";

	/**
	 * Profile Last Name is the last name of the user
	 * @var string $VALID_PROFILE_LAST_NAME
	 **/
	protected $VALID_PROFILE_LAST_NAME = "PHPUnit test passing";

	/**
	 * Profile Salt is used for the profile password
	 * @var $VALID_PROFILE_SALT
	 **/
	protected $VALID_PROFILE_SALT;

	/**
	 * Profile User Name is used as the screen name for profile
	 * @var string $VALID_PROFILE_PROFILE_USERNAME
	 **/
	protected $VALID_PROFILE_PROFILE_USERNAME = "PHPUnit test passing";

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp()  : void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_PROFILE_SALT = bin2hex(random_bytes(32));
		$this->VALID_PROFILE_HASH = hash_pbkdf2("sha512", $password, $this->VALID_PROFILE_SALT, 262144);

		// create and insert a Profile
		$this->profile = new Profile(generateUuidV4(), null,"My name is Tester. I love kitty food and puppies.", "test@phpunit.de","Tester",$this->VALID_PROFILE_HASH,"sample_woman", "McTester", $this->VALID_PROFILE_SALT,"test123");
		$this->profile->insert($this->getPDO());
}
