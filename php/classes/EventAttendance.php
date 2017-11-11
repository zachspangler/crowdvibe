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
	protected $eventAttendanceId;
	/**
	 * Id for attendance to a particular event
	 * @var string $attendanceEventId
	 */
	protected $eventAttendanceEventId;
	/**
	 * Id that relates the amount of people attending to a profile
	 * @var string $attendanceProfileId
	 */
	protected $eventAttendanceProfileId;
	/**
	 * how to keep track of which users attend the event
	 * @var int $attendanceCheckIn
	 */
	protected $eventAttendanceCheckIn;
	/**
	 * records how many people are attending
	 * @var int $attendanceNumberAttending
	 */
	protected $eventAttendanceNumberAttending;

	/**
	 * constructor for this Comments
	 *
	 * @param Uuid|string $newEventAttendanceId id of this events or null if a new events
	 * @param Uuid|string $newEventAttendanceProfileId id of the Profile that created the event
	 * @param Uuid|string $newEventAttendanceEventId id of the Event people attend
	 * @param int $newEventAttendanceCheckIn how people are going to notify their attendance
	 * @param int $newEventAttendanceNumberAttending containing actual data on the amount of people
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newEventAttendanceId, $newEventAttendanceProfileId, $newEventAttendanceEventId, $newEventAttendanceCheckIn, string $newEventAttendanceNumberAttending) {
		try {
			$this->setAttendanceId($newEventAttendanceId);
			$this->setAttendanceProfileId($newEventAttendanceProfileId);
			$this->setEventAttendanceEventId($newEventAttendanceEventId);
			$this->setAttendanceCheckIn($newEventAttendanceCheckIn);
			$this->setAttendanceNumberAttending($newEventAttendanceNumberAttending);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	private function validateUuid($newEventAttendanceEventId) {
	}

	/**
	 * accessor method for Event attendance id
	 *
	 * @return Uuid | string of  Event attendance id
	 **/
	public function getEventAttendanceId(): Uuid {
		return ($this->eventAttendanceId);
	}

	/**
	 * mutator method for attendance id
	 *
	 * @param Uuid | string $newEventAttendanceId new value of Attendance id
	 * @throws \RangeException if $newEventAttendanceId is not positive
	 * @throws \TypeError if $newEventAttendanceId is not a uuid or string
	 **/
	public function setEventAttendanceId($newEventAttendanceId): void {
		try {
			$uuid = self::validateUuid($newEventAttendanceId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the tweet id
		$this->eventAttendanceId = $uuid;
	}

	/**
	 * accessor method for Attendance Event id
	 *
	 * @return Uuid | string value of Attendance Event id
	 **/
	public function getEventAttendanceEventId() : Uuid{
		return $this->eventAttendanceId;
	}

	/**
	 * mutator method for Attendance event id
	 *
	 * @param Uuid $newEventAttendanceEventId new value of Attendance Event id
	 * @throws \UnexpectedValueException if $newEventAttendanceEventId is not a UUID
	 **/
	public function setEventAttendanceEventId($newEventAttendanceEventId): void {
		try {
			$uuid = self::validateUuid($newEventAttendanceEventId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the Attendance Event id
		$this->eventAttendanceEventId = $uuid;
	}

	/**
	 * accessor method for Attendance Profile id
	 *
	 * @return Uuid | string value of Attendance Profile id
	 **/
	public function getEventAttendanceProfileId() : Uuid {
		return $this->eventAttendanceProfileId;
	}
	/**
	 * mutator method for Event Attendance Profile id
	 *
	 * @param Uuid $newEventAttendanceProfileId new value of comments post id
	 * @throws \UnexpectedValueException if $newEventAttendanceProfileId is not a UUID
	 **/
	public function setEventAttendanceProfileId($newEventAttendanceProfileId): void {
		try {
			$uuid = self::validateUuid($newEventAttendanceProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the Event Attendance Profile id
		$this->eventAttendanceProfileId = $uuid;
	}
	/**
	 * accessor method for Event Attendance Check In
	 *
	 * @return int value of Event Attendance Check In this will be a 0 or 1 and treated as a boolean
	 **/
	public function getEventAttendanceCheckIn() {
		return $this->eventAttendanceCheckIn;
	}
	/**
	 * mutator method for Attendance Number Attending
	 *
	 * @param int $newEventAttendanceCheckIn new value of Attendance Number
	 * @throws \InvalidArgumentException if $newEventAttendanceCheckIn is not a integer
	 * @throws \RangeException if $newEventAttendanceCheckIn is > 1 characters
	 * @throws \TypeError if $newEventAttendanceCheckIn is not a string
	 **/
	public function setEventAttendanceCheckIn($newEventAttendanceCheckIn): void {
		//verify the post content is secure
		$newEventAttendanceCheckIn = trim($newEventAttendanceCheckIn);
		$newEventAttendanceCheckIn = filter_var($newEventAttendanceCheckIn, FILTER_VALIDATE_INT, FILTER_FLAG_ALLOW_OCTAL);
		if(empty($newEventAttendanceCheckIn) === true) {
			throw(new \InvalidArgumentException("event attendance check is empty or insecure"));
		}
		//verify the Attendance content
		if($newEventAttendanceCheckIn) {
			throw(new \RangeException("event attendance check is not correct"));
		}
		// convert and store
		$this->EventAttendanceCheckIn;
		}
	/**
	 * accessor method for Event Attendance Number Attending
	 *
	 * @return int value of Number Attending
	 **/
	public function getEventAttendanceNumberAttending() {
		return $this->attendanceNumberAttending;
	}
	/**
	 * mutator method for Attendance Number Attending
	 *
	 * @param int $newEventAttendanceNumberAttending new value of Attendance Number
	 * @throws \InvalidArgumentException if $newEventAttendanceNumberAttending is not a string or insecure
	 * @throws \RangeException if $newEventAttendanceNumberAttending is < 500 attendees
	 * @throws \TypeError if $newCommentsContent is not a string
	 **/
	public function setEventAttendanceNumberAttending($newEventAttendanceNumberAttending): void {
		//verify the post content is secure
		$newEventAttendanceNumberAttending = trim($newEventAttendanceNumberAttending);
		$newEventAttendanceNumberAttending = filter_var($newEventAttendanceNumberAttending, FILTER_VALIDATE_INT, FILTER_FLAG_ALLOW_OCTAL);
		if(empty($newEventAttendanceNumberAttending) === true) {
			throw(new \InvalidArgumentException(" event attendance number is empty or insecure"));
		}
		//verify the Attendance number is less than 500
		if($newEventAttendanceNumberAttending < 500) {
			throw(new \RangeException(" event attendance is greater an maximum"));
		}
		// convert and store the number of people attending
		$this->EventAttendanceNumberAttending;
		}
	/**
	 * inserts Event Attendance into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public function insert(\PDO $pdo): void {
		// create query template
		$query = "INSERT INTO eventAttendance(eventAttendanceId, eventAttendanceProfileId, eventAttendanceEventId, eventAttendanceCheckIn, eventAttendanceNumberAttending) VALUES (:eventAttendanceId, :eventAttendanceProfileId, :eventAttendanceEventId, :eventAttendanceCheckIn, :eventAttendanceNumberAttending)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["eventAttendanceId" => $this->eventAttendanceId->getBytes(), "eventAttendanceProfileId" => $this->eventAttendanceProfileId->getBytes(), "eventAttendanceEventId" => $this->eventAttendanceEventId->getBytes(), "eventAttendanceCheckIn" => $this->eventAttendanceCheckIn,"eventAttendanceNumberAttending" => $this->eventAttendanceNumberAttending];
		$statement->execute($parameters);
	}

	/**
	 * @param \PDO $pdo
	 */
	public function delete(\PDO $pdo): void {
		// create query template
		$query = "DELETE FROM EventAttendance(eventAttendanceId, eventAttendanceProfileId, eventAttendanceEventId, eventAttendanceCheckIn, eventAttendanceNumberAttending) VALUES (:eventAttendanceId, :eventAttendanceProfileId, :eventAttendanceEventId, :eventAttendanceCheckIn, :eventAttendanceNumberAttending)";
		$statement = $pdo->execute($query);

		// delete the variables from the place holders in the template
		$parameters = ["eventAttendanceId" => $this->attendanceId, "eventAttendanceProfileId" => $this->eventAttendanceProfileId, "eventAttendanceEventId" => $this->eventAttendanceEventId, "eventAttendanceCheckIn" => $this->eventAttendanceCheckIn, "eventAttendanceNumberAttending" => $this->eventAttendanceNumberAttending];
		$statement->execute($parameters);
	}
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["eventAttendanceId"] = $this->eventAttendanceId;
		$fields["eventAttendanceEventId"] = $this->eventAttendanceEventId;
		$fields["eventAttendanceProfileId"] = $this->eventAttendanceProfileId;
		return ($fields);
	}
}