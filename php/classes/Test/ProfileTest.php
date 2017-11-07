<?php
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

class ProfileTest extends CrowdVibeTest {
	/**
	 * Profile Activation Token is a the way an account is confirmed, placeholder until account activation is created
	 * @var $VALID_PROFILE_ACTIVATION_TOKEN
	 **/
	protected $VALID_PROFILE_ACTIVATION_TOKEN;

	/**
	 * Profile Bio is the text description for the user
	 * @var string $VALID_PROFILE_BIO
	 **/
	protected $VALID_PROFILE_BIO = "PHPUnit test passing";

	/**
	 * Profile Email is the email associated with the profile
	 * @var string $VALID_PROFILE_EMAIL
	 **/
	protected $VALID_PROFILE_EMAIL1 = "test1@phpunit.de";

	/**
	 * Profile Email is the email associated with the profile
	 * @var string $VALID_PROFILE_EMAIL
	 **/
	protected $VALID_PROFILE_EMAIL2 = "test2@phpunit.de";

	/**
	 * Profile Fist Name is the first name of the user
	 * @var string $VALID_PROFILE_FIRST_NAME
	 **/
	protected $VALID_PROFILE_FIRST_NAME = "Ada";

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
	protected $VALID_PROFILE_LAST_NAME = "Lovelace";

	/**
	 * Profile Salt is used for the profile password
	 * @var $VALID_PROFILE_SALT
	 **/
	protected $VALID_PROFILE_SALT;

	/**
	 * Profile User Name is used as the screen name for profile
	 * @var string $VALID_PROFILE_USERNAME
	 **/
	protected $VALID_PROFILE_USERNAME = "PHPUnit test passing";

	/**
	 * run the default setup operation to create salt and hash.
	 */
	public final function setUp(): void {
		parent::setUp();
		//
		$password = "abc123";
		$this->VALID_SALT = bin2hex(random_bytes(32));
		$this->VALID_HASH = hash_pbkdf2("sha512", $password, $this->VALID_SALT, 262144);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));
	}

	/**
	 * test inserting a valid Profile and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProfile(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_BIO, $this->VALID_PROFILE_EMAIL1, $this->VALID_PROFILE_FIRST_NAME, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_IMAGE, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_SALT, $this->VALID_PROFILE_USERNAME);
		$profile->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileBio(), $this->VALID_PROFILE_BIO);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL1);
		$this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_PROFILE_FIRST_NAME);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileImage(), $this->VALID_PROFILE_IMAGE);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_PROFILE_LAST_NAME);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_PROFILE_SALT);
		$this->assertEquals($pdoProfile->getProfileUserName(), $this->VALID_PROFILE_USERNAME);
	}
	/**
	 * test inserting a Profile, editing it, and then updating it
	 **/
	public function testUpdateValidProfile() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");
		// create a new Profile and insert to into mySQL
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_BIO, $this->VALID_PROFILE_EMAIL1, $this->VALID_PROFILE_FIRST_NAME, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_IMAGE, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_SALT, $this->VALID_PROFILE_USERNAME);
		$profile->insert($this->getPDO());
		// edit the Profile and update it in mySQL
		$profile->setProfileEmail($this->VALID_PROFILE_EMAIL2);
		$profile->update($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileBio(), $this->VALID_PROFILE_BIO);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL2);
		$this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_PROFILE_FIRST_NAME);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileImage(), $this->VALID_PROFILE_IMAGE);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_PROFILE_LAST_NAME);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_PROFILE_SALT);
		$this->assertEquals($pdoProfile->getProfileUserName(), $this->VALID_PROFILE_USERNAME);
	}
	/**
	 * test creating a Profile and then deleting it
	 **/
	public function testDeleteValidProfile() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_BIO, $this->VALID_PROFILE_EMAIL1, $this->VALID_PROFILE_FIRST_NAME, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_IMAGE, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_SALT, $this->VALID_PROFILE_USERNAME);
		$profile->insert($this->getPDO());
		// delete the Profile from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$profile->delete($this->getPDO());
		// grab the data from mySQL and enforce the Profile does not exist
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertNull($pdoProfile);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("profile"));
	}
	/**
	 * test inserting a Profile and regrabbing it from mySQL
	 **/
	public function testGetValidProfileByProfileId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_BIO, $this->VALID_PROFILE_EMAIL1, $this->VALID_PROFILE_FIRST_NAME, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_IMAGE, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_SALT, $this->VALID_PROFILE_USERNAME);
		$profile->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileBio(), $this->VALID_PROFILE_BIO);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL1);
		$this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_PROFILE_FIRST_NAME);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileImage(), $this->VALID_PROFILE_IMAGE);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_PROFILE_LAST_NAME);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_PROFILE_SALT);
		$this->assertEquals($pdoProfile->getProfileUserName(), $this->VALID_PROFILE_USERNAME);
	}
	/**
	 * test grabbing a Profile that does not exist
	 **/
	public function testGetInvalidProfileByProfileId() : void {
		// grab a profile id that exceeds the maximum allowable profile id
		$fakeProfileId = generateUuidV4();
		$profile = Profile::getProfileByProfileId($this->getPDO(), $fakeProfileId );
		$this->assertNull($profile);
	}

}