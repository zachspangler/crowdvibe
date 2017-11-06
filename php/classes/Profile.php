<?php
namespace Edu\Cnm\CrowdVibe;
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;
/**
 * CrowdVibe User Profile
 *
 * This is the user profile information stored for a CrowdVibe user. This entity is a top level entity that holds the keys to the other entities in our capstone.
 *
 * @author Zach Spangler <zspangler@gmail.com> and Dylan McDonald <dmcdonald21@cnm.edu>
 * @version 4.0.0
 **/

class Profile implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for this Profile; this is the primary key
	 * @var Uuid $profileId
	 **/
	private $profileId;
	/**
	/**
	 * token handed out to verify that the profile is valid and not malicious.
	 * @var $profileActivationToken
	 **/
	private $profileActivationToken;
	/**
	 * bio allows the user to describe themselves so other users can know more about the people attending.
	 * @var string $profileBio
	 **/
	private $profileBio;
	/**
	 * email for this Profile; this is a unique index
	 * @var string $profileEmail
	 **/
	private $profileEmail;
	/**
	 * first name for the this Profile; this is a unique index
	 * @var string $profileFirstName
	 **/
	private $profileFirstName;
	/**
	 * hash for profile password
	 * @var $profileHash
	 **/
	private $profileHash;
	/**
	 * image associated with the Profile, only one image is allowed
	 * @var string $profileImage
	 **/
	private $profileImage;
	/**
	 * last name for the this Profile; this is a unique index
	 * @var string $profileFirstName
	 **/
	private $profileLastName;
	/**
	 * salt for profile password
	 *
	 * @var $profileSalt
	 */
	private $profileSalt;
	/**
	 * user name for the this Profile; this is a unique index
	 * @var string $profileUserName
	 **/
	private $profileUserName;
	/**
	 * constructor for this Profile
	 *
	 * @param string|Uuid $newProfileId id of this Profile or null if a new Profile
	 * @param string $newProfileActivationToken activation token to safe guard against malicious accounts
	 * @param string $newProfileBio string containing bio of the profile
	 * @param string $newProfileEmail string containing email
	 * @param string $newProfileFirstName string first name of the user
	 * @param string $newProfileHash string containing password hash
	 * @param string $newProfileImage string containing the location of the image
	 * @param string $newProfileLastName string last name of the user
	 * @param string $newProfileSalt string containing password salt
	 * @param string $newProfileLastName string user name designated by the user
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if a data type violates a data hint
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/