<?php

namespace Edu\Cnm\CrowdVibe;
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * CrowdVibe User Profile
 *
 * This is the user profile information stored for a CrowdVibe user. This entity is a top level entity that holds the keys to the other entities in our capstone.
 *
 * @author Zach Spangler <zaspangler@gmail.com> and Dylan McDonald <dmcdonald21@cnm.edu>
 * @version 1.0.0
 **/
class Profile implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for this Profile; this is the primary key
	 * @var Uuid $profileId
	 **/
	private $profileId;
	/**
	 * /**
	 * token handed out to verify that the profile is valid and not malicious.
	 * @var string $profileActivationToken
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
	 * @var string $profileHash
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
	 * @var string $profileSalt
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
	 * @param string $newProfileUserName string user name designated by the user
	 * @param string $newProfileName string which is the combination of first name and last name
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if a data type violates a data hint
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newProfileId, ?string $newProfileActivationToken, string $newProfileBio, string $newProfileEmail, string $newProfileFirstName, string $newProfileHash, string $newProfileImage, string $newProfileLastName, string $newProfileSalt, string $newProfileUserName) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileActivationToken($newProfileActivationToken);
			$this->setProfileBio($newProfileBio);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileFirstName($newProfileFirstName);
			$this->setProfileHash($newProfileHash);
			$this->setProfileImage($newProfileImage);
			$this->setProfileLastName($newProfileLastName);
			$this->setProfileSalt($newProfileSalt);
			$this->setProfileUserName($newProfileUserName);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			//determine what exception type was thrown
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for profile id
	 *
	 * @return Uuid value of profile id (or null if new Profile)
	 **/
	public function getProfileId(): Uuid {
		return ($this->profileId);
	}

	/**
	 * mutator method for profile id
	 *
	 * @param  Uuid| string $newProfileId value of new profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if the profile Id is not
	 **/
	public function setProfileId($newProfileId): void {
		try {
			$uuid = self::validateUuid($newProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->profileId = $uuid;
	}

	/**
	 * accessor method for account activation token
	 *
	 * @return string value of the activation token
	 */
	public function getProfileActivationToken(): ?string {
		return ($this->profileActivationToken);
	}

	/**
	 * mutator method for account activation token
	 *
	 * @param string $newProfileActivationToken
	 * @throws \InvalidArgumentException  if the token is not a string or insecure
	 * @throws \RangeException if the token is not exactly 32 characters
	 * @throws \TypeError if the activation token is not a string
	 */
	public function setProfileActivationToken(?string $newProfileActivationToken): void {
		if($newProfileActivationToken === null) {
			$this->profileActivationToken = null;
			return;
		}
		$newProfileActivationToken = strtolower(trim($newProfileActivationToken));
		if(ctype_xdigit($newProfileActivationToken) === false) {
			throw(new\RangeException("user activation is not valid"));
		}
		//make sure user activation token is only 32 characters
		if(strlen($newProfileActivationToken) !== 32) {
			throw(new\RangeException("user activation token has to be 32"));
		}
		$this->profileActivationToken = $newProfileActivationToken;
	}

	/**
	 * accessor method for profile bio
	 *
	 * @return string value of at profile bio
	 **/
	public function getProfileBio(): string {
		return ($this->profileBio);
	}

	/**
	 * mutator method for profile bio
	 *
	 * @param string $newProfileBio new value of profile bio
	 * @throws \InvalidArgumentException if $newProfileBio is not a string or insecure
	 * @throws \RangeException if $newProfileBio is > 255 characters
	 * @throws \TypeError if $newProfileBio is not a string
	 **/
	public function setProfileBio(string $newProfileBio): void {
		// verify the profile bio is secure
		$newProfileBio = trim($newProfileBio);
		$newProfileBio = filter_var($newProfileBio, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileBio) === true) {
			throw(new \InvalidArgumentException("profile bio is empty or insecure"));
		}
		// verify the profile bio will fit in the database
		if(strlen($newProfileBio) > 255) {
			throw(new \RangeException("profile bio is too large"));
		}
		// store the profile bio
		$this->profileBio = $newProfileBio;
	}

	/**
	 * accessor method for email
	 *
	 * @return string value of email
	 **/
	public function getProfileEmail(): string {
		return $this->profileEmail;
	}

	/**
	 * mutator method for email
	 *
	 * @param string $newProfileEmail new value of email
	 * @throws \InvalidArgumentException if $newEmail is not a valid email or insecure
	 * @throws \RangeException if $newEmail is > 128 characters
	 * @throws \TypeError if $newEmail is not a string
	 **/
	public function setProfileEmail(string $newProfileEmail): void {
		// verify the email is secure
		$newProfileEmail = trim($newProfileEmail);
		$newProfileEmail = filter_var($newProfileEmail, FILTER_SANITIZE_EMAIL);
		if(empty($newProfileEmail) === true) {
			throw(new \InvalidArgumentException("profile email is empty or insecure"));
		}
		// verify the email will fit in the database
		if(strlen($newProfileEmail) > 128) {
			throw(new \RangeException("profile email is too large"));
		}
		// store the email
		$this->profileEmail = $newProfileEmail;
	}

	/**
	 * accessor method for profile first name
	 *
	 * @return string value of at profile first name
	 **/
	public function getProfileFirstName(): string {
		return ($this->profileFirstName);
	}

	/**
	 * mutator method for profile first name
	 *
	 * @param string $newProfileFirstName new value of profile first name
	 * @throws \InvalidArgumentException if $newProfileFirstName is not a string or insecure
	 * @throws \RangeException if $newProfileFirstName is > 32 characters
	 * @throws \TypeError if $newProfileFirstName is not a string
	 **/
	public function setProfileFirstName(string $newProfileFirstName): void {
		// verify the profile first name is secure
		$newProfileFirstName = trim($newProfileFirstName);
		$newProfileFirstName = filter_var($newProfileFirstName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileFirstName) === true) {
			throw(new \InvalidArgumentException("profile first name is empty or insecure"));
		}
		// verify the profile first name will fit in the database
		if(strlen($newProfileFirstName) > 32) {
			throw(new \RangeException("profile first name is too large"));
		}
		// store the profile first name
		$this->profileFirstName = $newProfileFirstName;
	}

	/**
	 * accessor method for profileHash
	 *
	 * @return string value of hash
	 */
	public function getProfileHash(): string {
		return $this->profileHash;
	}

	/**
	 * mutator method for profile hash password
	 *
	 * @param string $newProfileHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 128 characters
	 * @throws \TypeError if profile hash is not a string
	 */
	public function setProfileHash(string $newProfileHash): void {
		//enforce that the hash is properly formatted
		$newProfileHash = trim($newProfileHash);
		$newProfileHash = strtolower($newProfileHash);
		if(empty($newProfileHash) === true) {
			throw(new \InvalidArgumentException("profile password hash empty or insecure"));
		}
		//enforce that the hash is a string representation of a hexadecimal
		if(!ctype_xdigit($newProfileHash)) {
			throw(new \InvalidArgumentException("profile password hash is empty or insecure"));
		}
		//enforce that the hash is exactly 128 characters.
		if(strlen($newProfileHash) !== 128) {
			throw(new \RangeException("profile hash must be 128 characters"));
		}
		//store the hash
		$this->profileHash = $newProfileHash;
	}

	/**
	 * accessor method for profile image
	 *
	 * @return string value of at profile image
	 **/
	public function getProfileImage(): string {
		return ($this->profileImage);
	}

	/**
	 * mutator method for profile image
	 *
	 * @param string $newProfileImage new value of profile image
	 * @throws \InvalidArgumentException if $newProfileImage is not a string or insecure
	 * @throws \RangeException if $newProfileImage is > 255 characters
	 * @throws \TypeError if $newProfileImage is not a string
	 **/
	public function setProfileImage(string $newProfileImage): void {
		// verify the profile image is secure
		$newProfileImage = trim($newProfileImage);
		$newProfileImage = filter_var($newProfileImage, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileImage) === true) {
			throw(new \InvalidArgumentException("profile image is empty or insecure"));
		}
		// verify the profile image will fit in the database
		if(strlen($newProfileImage) > 255) {
			throw(new \RangeException("profile image is too large"));
		}
		// store the profile image
		$this->profileImage = $newProfileImage;
	}

	/**
	 * accessor method for profile last name
	 *
	 * @return string value of at profile last name
	 **/
	public function getProfileLastName(): string {
		return ($this->profileLastName);
	}

	/**
	 * mutator method for profile last name
	 *
	 * @param string $newProfileLastName new value of profile last name
	 * @throws \InvalidArgumentException if $newProfileLastName is not a string or insecure
	 * @throws \RangeException if $newProfileLastName is > 32 characters
	 * @throws \TypeError if $newProfileLastName is not a string
	 **/
	public function setProfileLastName(string $newProfileLastName): void {
		// verify the profile first name is secure
		$newProfileLastName = trim($newProfileLastName);
		$newProfileLastName = filter_var($newProfileLastName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileLastName) === true) {
			throw(new \InvalidArgumentException("profile last name is empty or insecure"));
		}
		// verify the profile last name will fit in the database
		if(strlen($newProfileLastName) > 32) {
			throw(new \RangeException("profile last name is too large"));
		}
		// store the profile first name
		$this->profileLastName = $newProfileLastName;
	}

	/**
	 *accessor method for profile salt
	 *
	 * @return string representation of the salt hexadecimal
	 */
	public function getProfileSalt(): string {
		return $this->profileSalt;
	}

	/**
	 * mutator method for profile salt
	 *
	 * @param string $newProfileSalt
	 * @throws \InvalidArgumentException if the salt is not secure
	 * @throws \RangeException if the salt is not 64 characters
	 * @throws \TypeError if the profile salt is not a string
	 */
	public function setProfileSalt(string $newProfileSalt): void {
		//enforce that the salt is properly formatted
		$newProfileSalt = trim($newProfileSalt);
		$newProfileSalt = strtolower($newProfileSalt);
		//enforce that the salt is a string representation of a hexadecimal
		if(!ctype_xdigit($newProfileSalt)) {
			throw(new \InvalidArgumentException("profile password hash is empty or insecure"));
		}
		//enforce that the salt is exactly 64 characters.
		if(strlen($newProfileSalt) !== 64) {
			throw(new \RangeException("profile salt must be 128 characters"));
		}
		//store the hash
		$this->profileSalt = $newProfileSalt;
	}

	/**
	 * accessor method for profile user name
	 *
	 * @return string value of at profile user name
	 **/
	public function getProfileUserName(): string {
		return ($this->profileUserName);
	}

	/**
	 * mutator method for profile user name
	 *
	 * @param string $newProfileUserName new value of profile user name
	 * @throws \InvalidArgumentException if $newProfileUserName is not a string or insecure
	 * @throws \RangeException if $newProfileUserName is > 32 characters
	 * @throws \TypeError if $newProfileUserName is not a string
	 **/
	public function setProfileUserName(string $newProfileUserName): void {
		// verify the profile user name is secure
		$newProfileUserName = trim($newProfileUserName);
		$newProfileUserName = filter_var($newProfileUserName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileUserName) === true) {
			throw(new \InvalidArgumentException("profile last name is empty or insecure"));
		}
		// verify the profile user name will fit in the database
		if(strlen($newProfileUserName) > 32) {
			throw(new \RangeException("profile last name is too large"));
		}
		// store the profile user name
		$this->profileUserName = $newProfileUserName;
	}

	/**
	 * inserts this Profile into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {
		// create query template
		$query = "INSERT INTO profile(profileId, profileActivationToken, profileBio, profileEmail, profileFirstName, profileHash, profileImage, profileLastName, profileSalt, profileUserName) VALUES (:profileId, :profileActivationToken, :profileBio, :profileEmail, :profileFirstName, :profileHash, :profileImage, :profileLastName, :profileSalt, :profileUserName)";
		$statement = $pdo->prepare($query);
		$parameters = ["profileId" => $this->profileId->getBytes(), "profileActivationToken" => $this->profileActivationToken, "profileBio" => $this->profileBio, "profileEmail" => $this->profileEmail, "profileFirstName" => $this->profileFirstName, "profileHash" => $this->profileHash, "profileImage" => $this->profileImage, "profileLastName" => $this->profileLastName, "profileSalt" => $this->profileSalt, "profileUserName" => $this->profileUserName];
		$statement->execute($parameters);
	}

	/**
	 * deletes this Profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {
		// create query template
		$query = "DELETE FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["profileId" => $this->profileId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * updates this Profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public function update(\PDO $pdo): void {
		// create query template
		$query = "UPDATE profile SET profileId = :profileId, profileActivationToken = :profileActivationToken, profileBio = :profileBio, profileEmail = :profileEmail, profileFirstName = :profileFirstName, profileHash = :profileHash, profileImage = :profileImage, profileLastName= :profileLastName, profileSalt = :profileSalt, profileUserName = :profileUserName WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["profileId" => $this->profileId->getBytes(), "profileActivationToken" => $this->profileActivationToken, "profileBio" => $this->profileBio, "profileEmail" => $this->profileEmail, "profileFirstName" => $this->profileFirstName, "profileHash" => $this->profileHash, "profileImage" => $this->profileImage, "profileLastName" => $this->profileLastName, "profileSalt" => $this->profileSalt, "profileUserName" => $this->profileUserName];
		$statement->execute($parameters);
	}

	/**
	 * gets the Profile by profile id
	 *
	 * @param \PDO $pdo $pdo PDO connection object
	 * @param string $profileId profile Id to search for
	 * @return Profile|null Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getProfileByProfileId(\PDO $pdo, string $profileId):?Profile {
		// sanitize the profile id before searching
		try {
			$profileId = self::validateUuid($profileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT profileId, profileActivationToken, profileBio, profileEmail, profileFirstName, profileHash, profileImage, profileLastName, profileSalt, profileUserName FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		// bind the profile id to the place holder in the template
		$parameters = ["profileId" => $profileId->getBytes()];
		$statement->execute($parameters);
		// grab the Profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileBio"], $row["profileEmail"], $row["profileFirstName"], $row["profileHash"], $row["profileImage"], $row["profileLastName"], $row["profileSalt"], $row["profileUserName"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}

	/**
	 * gets the Profile by email
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileEmail email to search for
	 * @return Profile|null Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileEmail(\PDO $pdo, string $profileEmail): ?Profile {
		// sanitize the email before searching
		$profileEmail = trim($profileEmail);
		$profileEmail = filter_var($profileEmail, FILTER_VALIDATE_EMAIL);
		if(empty($profileEmail) === true) {
			throw(new \PDOException("not a valid email"));
		}
		// create query template
		$query = "SELECT profileId, profileActivationToken, profileBio, profileEmail, profileFirstName, profileHash, profileImage, profileLastName, profileSalt, profileUserName FROM profile WHERE profileEmail = :profileEmail";
		$statement = $pdo->prepare($query);
		// bind the profile email to the place holder in the template
		$parameters = ["profileEmail" => $profileEmail];
		$statement->execute($parameters);
		// grab the Profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileBio"], $row["profileEmail"], $row["profileFirstName"], $row["profileHash"], $row["profileImage"], $row["profileLastName"], $row["profileSalt"], $row["profileUserName"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}

	/**
	 * gets the Profile by User Name
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileUserName to search for
	 * @return Profile|null Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileUserName(\PDO $pdo, string $profileUserName): ?Profile {
		// sanitize the UserName before searching
		$profileUserName = trim($profileUserName);
		$profileUserName = filter_var($profileUserName, FILTER_SANITIZE_STRING);
		if(empty($profileUserName) === true) {
			throw(new \PDOException("not a valid UserName"));
		}
		// create query template
		$query = "SELECT profileId, profileActivationToken, profileBio, profileEmail, profileFirstName, profileHash, profileImage, profileLastName, profileSalt, profileUserName FROM profile WHERE profileUserName = :profileUserName";
		$statement = $pdo->prepare($query);
		// bind the profile UserName to the place holder in the template
		$parameters = ["profileUserName" => $profileUserName];
		$statement->execute($parameters);
		// grab the Profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileBio"], $row["profileEmail"], $row["profileFirstName"], $row["profileHash"], $row["profileImage"], $row["profileLastName"], $row["profileSalt"], $row["profileUserName"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}
	/**
	 * get the profile by profile activation token
	 *
	 * @param string $profileActivationToken
	 * @param \PDO object $pdo
	 * @return Profile|null Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileActivationToken(\PDO $pdo, string $profileActivationToken): ?Profile {
		//make sure activation token is in the right format and that it is a string representation of a hexadecimal
		$profileActivationToken = trim($profileActivationToken);
		if(ctype_xdigit($profileActivationToken) === false) {
			throw(new \InvalidArgumentException("profile activation token is empty or in the wrong format"));
		}
		//create the query template
		$query = "SELECT  profileId, profileActivationToken, profileBio, profileEmail, profileFirstName, profileHash, profileImage, profileLastName, profileSalt, profileUserName FROM profile WHERE profileActivationToken = :profileActivationToken";
		$statement = $pdo->prepare($query);
		// bind the profile activation token to the placeholder in the template
		$parameters = ["profileActivationToken" => $profileActivationToken];
		$statement->execute($parameters);
		// grab the Profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileBio"], $row["profileEmail"], $row["profileFirstName"], $row["profileHash"], $row["profileImage"], $row["profileLastName"], $row["profileSalt"], $row["profileUserName"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}

	/**
	 * gets the Profile by First an/or Last Name
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileName is the search term that includes profile first name and last name
	 * @return \SplFixedArray SplFixedArray of Profiles found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileName(\PDO $pdo, string $profileName): \SPLFixedArray {
		// sanitize the name before searching
		$profileName = trim($profileName);
		$profileName = filter_var($profileName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileName) === true) {
			throw(new \PDOException("not a valid name"));
		}

		// create query template
		$query = "SELECT profileId, profileActivationToken, profileBio, profileEmail, profileFirstName, profileHash, profileImage, profileLastName, profileSalt, profileUserName FROM profile WHERE :profileName LIKE CONCAT('%', REPLACE(:profileName, ' ', '%'),'%')";
		$statement = $pdo->prepare($query);

		// bind the profile to the place holder in the template
		$profileName = "profileName";
		$parameters = ["profileName" => $profileName];
		$statement->execute($parameters);

		// build an array of profiles
		$profileNames = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profileName = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileBio"], $row["profileEmail"], $row["profileFirstName"], $row["profileHash"], $row["profileImage"], $row["profileLastName"], $row["profileSalt"], $row["profileUserName"]);
				$profileNames[$profileNames->key()] = $profileName;
				$profileNames->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profileNames);
	}

	/**
	 * gets all Profiles
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Events found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
//	public static function getAllProfiles(\PDO $pdo) : \SplFixedArray {
//		// create query template
//		$query = "SELECT profileId, profileActivationToken, profileBio, profileEmail, profileFirstName, profileHash, profileImage, profileLastName, profileSalt, profileUsername FROM profile";
//		$statement = $pdo->prepare($query);
//		$statement->execute();
//
//		// build an array of profiles
//		$profiles = new \SplFixedArray($statement->rowCount());
//		$statement->setFetchMode(\PDO::FETCH_ASSOC);
//		while(($row = $statement->fetch()) !== false) {
//			try {
//				$profile = new Profile($row ["profileId"], $row ["profileActivationToken"], $row ["profileBio"], $row["profileEmail"], $row ["profileFirstName"], $row ["profileHash"], $row ["profileImage"], $row ["profileLastName"], $row ["profileSalt"], $row ["profileUserName"]);
//				$profiles[$profiles->key()] = $profile;
//				$profiles->next();
//			} catch(\Exception $exception) {
//				// if the row couldn't be converted, rethrow it
//				throw (new \PDOException($exception->getMessage(), 0, $exception));
//				}
//		}
//		return ($profiles);
//	}


	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public
	function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["profileId"] = $this->profileId->toString();
		unset($fields["profileHash"]);
		unset($fields["profileSalt"]);
		return ($fields);
	}
}
