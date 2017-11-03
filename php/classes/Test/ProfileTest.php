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
	 * @var profileId
	 **/
	protected $profileId = null;

	/**
	 * Profile Activation Token is a the way an account is confirmed
	 * @var profileActivationToken
	 **/
	protected $profileActivationToken = null;

	/**
	 * Profile Bio is the text description for the user
	 * @var string profileBio
	 **/
	protected $profileBio = null;

	/**
	 * Profile Email is the email associated with the profile
	 * @var string profileEmail
	 **/
	protected $profileEmail = null;

	/**
	 * Profile Fist Name is the first name of the user
	 * @var string profileFirstName
	 **/
	protected $profileFirstName = null;

	/**
	 * Profile Hash is used for the profile password
	 * @var profileHash
	 **/
	protected $profileHash = null;

	/**
	 * Profile Image is image the profile will use
	 * @var string profileImage
	 **/
	protected $profileImage = null;

	/**
	 * Profile Last Name is the last name of the user
	 * @var string profileLastName
	 **/
	protected $profileLastName = null;

	/**
	 * Profile Salt is used for the profile password
	 * @var profileSalt
	 **/
	protected $profileSalt = null;

	/**
	 * Profile User Name is used as the screen name for profile
	 * @var string profileUserName
	 **/
	protected $profileUserName = null;
}
