<?php
namespace Edu\Cnm\CrowdVibe;
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
	use ValidateUuid;

	/**
	 * id for the amount of people attending
	 * @var Uuid|string $attendanceId
	 */
	protected $eventAttendanceId;
	/**
	 * Id for attendance to a particular event
	 * @var Uuid|string $attendanceEventId
	 */
	protected $eventAttendanceEventId;
	/**
	 * Id that relates the amount of people attending to a profile
	 * @var Uuid|string $attendanceProfileId
	 */
	protected $eventAttendanceProfileId;
	/**
	 * how to keep track of which users attend the event
	 * @var bool $attendanceCheckIn
	 */
	protected $eventAttendanceCheckIn;
	/**
	 * records how many people are attending
	 * @var int $attendanceNumberAttending
	 */
	protected $eventAttendanceNumberAttending;

	/**
	 * constructor for this Event Attendance
	 *
	 * @param Uuid|string $newEventAttendanceId id of this events or null if a new events
	 * @param Uuid|string $newEventAttendanceProfileId id of the Profile that created the event
	 * @param Uuid|string $newEventAttendanceEventId id of the Event people attend
	 * @param bool $newEventAttendanceCheckIn how people are going to notify their attendance
	 * @param int $newEventAttendanceNumberAttending containing actual data on the amount of people
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newEventAttendanceId, $newEventAttendanceProfileId, $newEventAttendanceEventId, bool $newEventAttendanceCheckIn, int $newEventAttendanceNumberAttending) {
		try {
			$this->setEventAttendanceId($newEventAttendanceId);
			$this->setEventAttendanceEventId($newEventAttendanceProfileId);
			$this->setEventAttendanceProfileId($newEventAttendanceEventId);
			$this->setEventAttendanceCheckIn($newEventAttendanceCheckIn);
			$this->setEventAttendanceNumberAttending($newEventAttendanceNumberAttending);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for eventAttendanceId
	 *
	 * @return Uuid|string of  eventAttendanceId
	 **/
	public function getEventAttendanceId(): Uuid {
		return ($this->eventAttendanceId);
	}

	/**
	 * mutator method for eventAttendanceId
	 *
	 * @param Uuid|string $newEventAttendanceId new value of eventAttendance id
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
		// convert and store the eventAttendance id
		$this->eventAttendanceId = $uuid;
	}

	/**
	 * accessor method for Attendance Event id
	 *
	 * @return Uuid | string value of Attendance Event id
	 **/
	public function getEventAttendanceEventId(): Uuid {
		return ($this->eventAttendanceId);
	}

	/**
	 * mutator method for Attendance event id
	 *
	 * @param Uuid|string $newEventAttendanceEventId new value of Attendance Event id
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
	 * @return Uuid|string value of Attendance Profile id
	 **/
	public function getEventAttendanceProfileId(): Uuid {
		return ($this->eventAttendanceProfileId);
	}

	/**
	 * mutator method for Event Attendance Profile id
	 *
	 * @param Uuid|string $newEventAttendanceProfileId new value of comments post id
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
	 * @return bool value of Event Attendance Check In this will be a 0 or 1 and treated as a bool
	 **/
	public function getEventAttendanceCheckIn() : bool {
		return ($this->eventAttendanceCheckIn);
	}

	/**
	 * mutator method for Attendance Number Attending
	 *
	 * @param bool $newEventAttendanceCheckIn new value of Attendance Number
	 * @throws \InvalidArgumentException if $newEventAttendanceCheckIn is not a integer
	 * @throws \RangeException if $newEventAttendanceCheckIn is > 1 characters
	 * @throws \TypeError if $newEventAttendanceCheckIn is not a string
	 **/
	public function setEventAttendanceCheckIn(bool $newEventAttendanceCheckIn): void {
		$this->eventAttendanceCheckIn = $newEventAttendanceCheckIn;
	}

	/**
	 * accessor method for Event Attendance Number Attending
	 *
	 * @return int value of Number Attending
	 **/
	public function getEventAttendanceNumberAttending() : int {
		return ($this->eventAttendanceNumberAttending);
	}

	/**
	 * mutator method for Attendance Number Attending
	 *
	 * @param int $newEventAttendanceNumberAttending new value of Attendance Number
	 * @throws \InvalidArgumentException if $newEventAttendanceNumberAttending is not a string or insecure
	 * @throws \RangeException if $newEventAttendanceNumberAttending is < 500 attendees
	 * @throws \TypeError if $newCommentsContent is not a string
	 **/

	public function setEventAttendanceNumberAttending(int $newEventAttendanceNumberAttending): void {
		//verify the Attendance number is less than 500
		if($newEventAttendanceNumberAttending > 500) {
			throw(new \RangeException("event attendance is greater an maximum"));
		}
		// store the number of people attending
		$this->eventAttendanceNumberAttending = $newEventAttendanceNumberAttending;
	}

	/**
	 * inserts Event Attendance into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public function insert(\PDO $pdo): void {
		// create query template
		$query = "INSERT INTO eventAttendance(eventAttendanceId, eventAttendanceEventId,eventAttendanceProfileId, eventAttendanceCheckIn, eventAttendanceNumberAttending) VALUES (:eventAttendanceId, :eventAttendanceProfileId, :eventAttendanceEventId, :eventAttendanceCheckIn, :eventAttendanceNumberAttending)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["eventAttendanceId" => $this-> eventAttendanceId->getBytes(),"eventAttendanceEventId"=>$this->eventAttendanceEventId->getBytes(), "eventAttendanceProfileId" => $this-> eventAttendanceProfileId->getBytes(), "eventAttendanceCheckIn" =>$this->eventAttendanceCheckIn, "eventAttendanceNumberAttending" => $this-> eventAttendanceNumberAttending];
		$statement->execute($parameters);
	}
	/**
	 * deletes this EventAttendance from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo): void {
		$query = "DELETE FROM eventAttendance WHERE :eventAttendanceId";
		$statement = $pdo->prepare($query);

		// delete the variables from the place holders in the template
		$parameters = ["eventAttendanceId" => $this->eventAttendanceId];
		$statement->execute($parameters);
	}
	/**
	 * updates this EventAttendance in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {
		// create query template
		$query = "UPDATE eventAttendance SET eventAttendanceId = :eventAttendanceId, eventAttendanceEventId = :eventAttentionEventId, eventAttendanceProfileId = :eventAttendanceProfileId, eventAttendanceCheckIn = :eventAttendanceCheckin, eventAttendanceNumberAttending = :eventAttendanceNumberAttending WHERE eventAttendanceId = :eventAttendanceId";
		$statement = $pdo->prepare($query);

		// delete the variables from the place holders in the template
		$parameters = ["eventAttendanceId" => $this->eventAttendanceId, "eventAttendanceEventId"=> $this->eventAttendanceEventId, "eventAttendanceProfileId" => $this->eventAttendanceProfileId,  "eventAttendanceCheckIn" => $this->eventAttendanceCheckIn, "eventAttendanceNumberAttending" => $this->eventAttendanceNumberAttending];
		$statement->execute($parameters);
	}
	/**
	 * gets the Event Attendance by eventAttendanceId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $eventAttendanceId event id to search by
	 * @return \SPLFixedArray SplFixedArray of eventAttendanceId
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getEventAttendanceByEventAttendanceId(\PDO $pdo, string $eventAttendanceId): EventAttendance {
		// sanitize the tweetId before searching
		try {
			$eventAttendanceId = self::validateUuid($eventAttendanceId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT eventAttendanceId, eventAttendanceEventId, eventAttendanceProfileId,  EventAttendanceCheckIn, eventAttendanceNumberAttending FROM eventAttendance WHERE eventAttendanceId = :eventAttendanceId";
		$statement = $pdo->prepare($query);

		// bind the EventAttendanceEventId to the place holder in the template
		$parameters = ["eventAttendanceId" => $eventAttendanceId];
		$statement->execute($parameters);

		// grab the event attendance from my SQL
		try {
			$eventAttendance = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				new EventAttendance($row["eventAttendanceId"], $row["eventAttendanceEventId"], $row["eventAttendanceProfileId"], $row["eventAttendanceCheckIn"], $row["eventAttendanceNumberAttending"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($eventAttendance);
	}
	/**
	 * gets the Event Attendance by eventAttendanceEventId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param $eventAttendanceEventId
	 * @return \SPLFixedArray eventAttendanceEventId found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getEventAttendanceByEventAttendanceEventId(\PDO $pdo, string $eventAttendanceEventId): \SplFixedArray {
		try {
			$eventAttendanceEventId = self::validateUuid($eventAttendanceEventId);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT eventAttendanceId, eventAttendanceEventId, eventAttendanceProfileId,  EventAttendanceCheckIn, eventAttendanceNumberAttending FROM eventAttendance WHERE eventAttendanceEventId = :eventAttendanceEventId";
		$statement = $pdo->prepare($query);

		// bind the EventAttendanceEventId to the place holder in the template
		$eventAttendanceEventId = "$eventAttendanceEventId";
		$parameters = ["eventAttendanceEventId" => $eventAttendanceEventId];
		$statement->execute($parameters);

		// build and array of EventAttendanceEventId
		$eventAttendanceEventIds = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$eventAttendanceEventId = new $eventAttendanceEventIds($row["eventAttendanceId"], $row["eventAttendanceEventId"], $row["eventAttendanceProfileId"], $row["eventAttendanceCheckIn"], $row["eventAttendanceNumberAttending"]);
				$eventAttendanceEventIds[$eventAttendanceEventIds->key()] = $eventAttendanceEventId;
				$eventAttendanceEventIds->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($eventAttendanceEventIds);
	}

	/**
	 * gets the Event Attendance by eventAttendanceProfileId
	 * @param \PDO $pdo PDO connection object
	 * @param $eventAttendanceProfileId
	 * @return \SPLFixedArray eventAttendanceProfileId found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getEventAttendanceByEventAttendanceProfileId(\PDO $pdo, string $eventAttendanceProfileId): \SplFixedArray {
		try {
			$eventAttendanceProfileId = self::validateUuid($eventAttendanceProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT eventAttendanceId, eventAttendanceEventId, eventAttendanceProfileId,  EventAttendanceCheckIn, eventAttendanceNumberAttending FROM eventAttendance WHERE eventAttendanceProfileId = :eventAttendanceProfileId";
		$statement = $pdo->prepare($query);

		// bind the EventAttendanceEventId to the place holder in the template
		$eventAttendanceProfileId = "$eventAttendanceProfileId";
		$parameters = ["eventAttendanceProfileId" => $eventAttendanceProfileId];
		$statement->execute($parameters);

		// build and array of EventAttendanceEventId
		$eventAttendanceProfileIds = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$eventAttendanceProfileId = new $eventAttendanceProfileIds($row["eventAttendanceId"], $row["eventAttendanceEventId"], $row["eventAttendanceProfileId"], $row["eventAttendanceCheckIn"], $row["eventAttendanceNumberAttending"]);
				$eventAttendanceProfileIds[$eventAttendanceProfileIds->key()] = $eventAttendanceProfileId;
				$eventAttendanceProfileIds->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($eventAttendanceProfileIds);
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