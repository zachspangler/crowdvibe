<?php
namespace Edu\Cnm\CrowdVibe;
require_once("autoload.php");

require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;

/**
 * CrowdVibe Event Attendance
 *
 * This is the event attendance information stored for a CrowdVibe user.
 *
 * @author Chris Owens
 * @email cowens17@cnm.edu
 * @version 1.0.0
 **/

class EventAttendance implements \JsonSerializable {
	/**
	 * id for the amount of people attending.
	 * @var string $attendanceId
	 */
	protected $attendanceId;
	/**
	 * Id for attendance to a particular event
	 * @var string $attendanceEventId
	 */
	protected $attendanceEventId;
	/**
	 * Id that relates the amount of people attending to a profile
	 * @var string $attendanceProfileId
	 */
	protected $attendanceProfileId;
	/**
	 * how to keep track of which users attend the event
	 * @var int $attendanceCheckIn
	 */
	protected $attendanceCheckIn;
	/**
	 * records how many people are attending
	 * @var int $attendanceNumberAttending
	 */
	protected $attendanceNumberAttending;

	/**
	 * constructor for this Comments
	 *
	 * @param Uuid|string $newAttendanceId id of this events or null if a new events
	 * @param Uuid|string $newAttendanceProfileId id of the Profile that created the event
	 * @param Uuid|string $newAttendanceEventId id of the Event people attend
	 * @param int $newAttendanceCheckIn how people are going to notify their attendance
	 * @param int $newAttendanceNumberAttending containing actual data on the amount of people
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newAttendanceId, $newAttendanceProfileId, $newAttendanceEventId, $newAttendanceCheckIn, string $newAttendanceNumberAttending) {
		try {
			$this->setAttendanceId($newAttendanceId);
			$this->setAttendanceProfileId($newAttendanceProfileId);
			$this->setAttendanceEventId($newAttendanceEventId);
			$this->setAttendanceCheckIn($newAttendanceCheckIn);
			$this->setAttendanceNumberAttending($newAttendanceNumberAttending);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for attendance id
	 *
	 * @return Uuid | string of attendance id
	 **/
	public function getAttendanceId(): Uuid {
		return ($this->attendanceId);
	}

	/**
	 * mutator method for attendance id
	 *
	 * @param Uuid | string $newAttendanceId new value of Attendance id
	 * @throws \RangeException if $newAttendanceId is not positive
	 * @throws \TypeError if $newAttendanceId is not a uuid or string
	 **/
	public function setAttendanceId($newAttendanceId): void {
		try {
			$uuid = self::validateUuid($newAttendanceId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the tweet id
		$this->attendanceId = $uuid;
	}

	/**
	 * accessor method for Attendance Event id
	 *
	 * @return Uuid | string value of Attendance Event id
	 **/
	public function getAttendanceEventId() : Uuid{
		return $this->attendanceEventId;
	}

	/**
	 * mutator method for Attendance event id
	 *
	 * @param Uuid $newAttendanceEventId new value of Attendance Event id
	 * @throws \UnexpectedValueException if $newAttendanceEventId is not a UUID
	 **/
	public function setAttendanceEventId($newAttendanceEventId): void {
		try {
			$uuid = self::validateUuid($newAttendanceEventId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the Attendance Event id
		$this->AttendanceEventId = $uuid;
	}

	/**
	 * accessor method for Attendance Profile id
	 *
	 * @return Uuid | string value of Attendance Profile id
	 **/
	public function getAttendanceProfileId() : Uuid {
		return $this->attendanceProfileId;
	}
	/**
	 * mutator method for Attendance Profile id
	 *
	 * @param Uuid $newAttendanceProfileId new value of comments post id
	 * @throws \UnexpectedValueException if $newAttendanceProfileId is not a UUID
	 **/
	public function setAttendanceProfileId($newAttendanceProfileId): void {
		try {
			$uuid = self::validateUuid($newAttendanceProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the Attendance Profile id
		$this->attendanceProfileId = $uuid;
	}
	/**
	 * accessor method for Attendance Check In
	 *
	 * @return int value of Attendance Check In this will be a 0 or 1 and treated as a boolean
	 **/
	public function getAttendanceCheckIn() {
		return $this->attendanceCheckIn;
	}
	/**
	 * mutator method for Attendance Number Attending
	 *
	 * @param int $newAttendanceCheckIn new value of Attendance Number
	 * @throws \InvalidArgumentException if $newAttendanceCheckIn is not a integer
	 * @throws \RangeException if $newAttendanceCheckIn is > 1 characters
	 * @throws \TypeError if $newAttendanceCheckIn is not a string
	 **/
	public function setAttendanceCheckIn($newAttendanceCheckIn): void {
		//verify the post content is secure
		$newAttendanceCheckIn = trim($newAttendanceCheckIn);
		$newAttendanceCheckIn = filter_var($newAttendanceCheckIn, FILTER_VALIDATE_INT, FILTER_FLAG_ALLOW_OCTAL);
		if(empty($newAttendanceCheckIn) === true) {
			throw(new \InvalidArgumentException("attendance check is empty or insecure"));
		}
		//verify the Attendance content is 0 or 1
		if($newAttendanceCheckIn !== 0 || 1) {
			throw(new \RangeException("attendance check is not correct"));
		}
		// convert and store the profile id
		$this->attendanceCheckIn;
		}
	/**
	 * accessor method for Attendance Number Attending
	 *
	 * @return int value of Number Attending
	 **/
	public function getAttendanceNumberAttending() {
		return $this->attendanceNumberAttending;
	}
	/**
	 * mutator method for Attendance Number Attending
	 *
	 * @param int $newAttendanceNumberAttending new value of Attendance Number
	 * @throws \InvalidArgumentException if $newAttendanceNumberAttending is not a string or insecure
	 * @throws \RangeException if $newAttendanceNumberAttending is < 500 attendees
	 * @throws \TypeError if $newCommentsContent is not a string
	 **/
	public function setAttendanceNumberAttending($newAttendanceNumberAttending): void {
		//verify the post content is secure
		$newAttendanceNumberAttending = trim($newAttendanceNumberAttending);
		$newAttendanceNumberAttending = filter_var($newAttendanceNumberAttending, FILTER_VALIDATE_INT, FILTER_FLAG_ALLOW_OCTAL);
		if(empty($newAttendanceNumberAttending) === true) {
			throw(new \InvalidArgumentException("attendance number is empty or insecure"));
		}
		//verify the Attendance number is less than 500
		if($newAttendanceNumberAttending < 500) {
			throw(new \RangeException("attendance is greater an maximum"));
		}
		// convert and store the profile id
		$this->attendanceNumberAttending;
		}
	/**
	 * inserts this Event Attendance into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public function insert(\PDO $pdo): void {
		// create query template
		$query = "INSERT INTO eventAttendance(attendanceId, attendanceProfileId, attendanceEventId, attendanceCheckIn, attendanceNumberAttending) VALUES (:attendanceId, :attendanceProfileId, :attendanceEventId, :attendanceCheckIn, :attendanceNumberAttending)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["attendanceId" => $this->attendanceId->getBytes(), "attendanceProfileId" => $this->attendanceProfileId->getBytes(), "attendanceEventId" => $this->attendanceEventId->getBytes(), "attendanceCheckIn" => $this->attendanceCheckIn,"attendanceNumberAttending" => $this->attendanceNumberAttending];
		$statement->execute($parameters);
	}
	public function delete(\PDO $pdo): void {
		// create query template
		$query = "INSERT INTO eventAttendance(attendanceId, attendanceProfileId, attendanceEventId, attendanceCheckIn, attendanceNumberAttending) VALUES (:attendanceId, :attendanceProfileId, :attendanceEventId, :attendanceCheckIn, :attendanceNumberAttending)";
		$statement = $pdo->execute($query);

		// delete the variables from the place holders in the template
		$parameters = ["attendanceId" => $this->attendanceId->getBytes(), "attendanceProfileId" => $this->attendanceProfileId->getBytes(), "attendanceEventId" => $this->attendanceEventId->getBytes(), "attendanceCheckIn" => $this->attendanceCheckIn, "attendanceNumberAttending" => $this->attendanceNumberAttending];
		$statement->execute($parameters);
	}
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["attendanceId"] = $this->attendanceId->toString();
		$fields["attendanceEventId"] = $this->attendanceEventId->toString();
		$fields["attendanceProfileId"] = $this->attendanceProfileId->toString();
		return ($fields);
	}
}