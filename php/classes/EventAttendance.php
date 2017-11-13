<?php
namespace Edu\Cnm\CrowdVibe;
require_once("autoload.php");

require_once(dirname(__DIR__, 2) . "vendor/autoload.php");


use Ramsey\Uuid\Uuid;
use RangeException;


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
	 * id for the amount of people attending
	 * @var string binary $attendanceId
	 */
	protected $eventAttendanceId;
	/**
	 * Id for attendance to a particular event
	 * @var Uuid $attendanceEventId
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
	 * @throws RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newEventAttendanceId, $newEventAttendanceProfileId, $newEventAttendanceEventId, $newEventAttendanceCheckIn, string $newEventAttendanceNumberAttending) {
		try {
			$this->setEventAttendanceId($newEventAttendanceId);
			$this->setEventAttendanceEventId($newEventAttendanceProfileId);
			$this->setEventAttendanceProfileId($newEventAttendanceEventId);
			$this->setEventAttendanceCheckIn($newEventAttendanceCheckIn);
			$this->setEventAttendanceNumberAttending($newEventAttendanceNumberAttending);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	private function validateUuid($newEventAttendanceEventId) {
	}

	/**
	 * accessor method for eventAttendanceId
	 *
	 * @return Uuid | string of  eventAttendanceId
	 **/
	public function getEventAttendanceId(): Uuid {
		return ($this->eventAttendanceId);
	}

	/**
	 * mutator method for eventAttendanceId
	 *
	 * @param Uuid | string $newEventAttendanceId new value of eventAttendance id
	 * @throws RangeException if $newEventAttendanceId is not positive
	 * @throws \TypeError if $newEventAttendanceId is not a uuid or string
	 **/
	public function setEventAttendanceId($newEventAttendanceId): void {
		try {
			$uuid = self::validateUuid($newEventAttendanceId);
		} catch(\InvalidArgumentException | RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the  eventAttendance id
		$this->eventAttendanceId = $uuid;
	}

	/**
	 * accessor method for Attendance Event id
	 *
	 * @return Uuid | string value of Attendance Event id
	 **/
	public function getEventAttendanceEventId(): Uuid {
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
		} catch(\InvalidArgumentException | RangeException | \Exception | \TypeError $exception) {
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
	public function getEventAttendanceProfileId(): Uuid {
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
		} catch(\InvalidArgumentException | RangeException | \Exception | \TypeError $exception) {
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
	 * @throws RangeException if $newEventAttendanceCheckIn is > 1 characters
	 * @throws \TypeError if $newEventAttendanceCheckIn is not a string
	 **/
	public function setEventAttendanceCheckIn($newEventAttendanceCheckIn): void {
		//verify the Event content is secure
		$newEventAttendanceCheckIn = trim($newEventAttendanceCheckIn);
		$newEventAttendanceCheckIn = filter_var($newEventAttendanceCheckIn, FILTER_VALIDATE_INT, FILTER_FLAG_ALLOW_OCTAL);
		if(empty($newEventAttendanceCheckIn) === true) {
			throw(new\InvalidArgumentException(" if event attendance check in is empty"));
		}
		//verify the Attendance content
		if($newEventAttendanceCheckIn) {
			throw(RangeException("if event attendance check is not selected"));
		}
		// convert and store
		$this->eventAttendanceCheckIn;
	}

	/**
	 * accessor method for Event Attendance Number Attending
	 *
	 * @return int value of Number Attending
	 **/
	public function getEventAttendanceNumberAttending() {
		return $this->eventAttendanceNumberAttending;
	}

	/**
	 * mutator method for Attendance Number Attending
	 *
	 * @param int $newEventAttendanceNumberAttending new value of Attendance Number
	 * @throws \InvalidArgumentException if $newEventAttendanceNumberAttending is not a string or insecure
	 * @throws RangeException if $newEventAttendanceNumberAttending is < 500 attendees
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
		$this->eventAttendanceNumberAttending;
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
		$parameters = ["eventAttendanceId" => $this->eventAttendanceId,"eventAttendanceEventId" => $this->eventAttendanceEventId, "eventAttendanceProfileId" => $this->eventAttendanceProfileId,  "eventAttendanceCheckIn" => $this->eventAttendanceCheckIn, "eventAttendanceNumberAttending" => $this->eventAttendanceNumberAttending];
		$statement->execute($parameters);
	}

	/**
	 * deletes this EventAttendance from mySQL
	 *
	 * @internal param \PDO $pdo PDO connection object
	 */
	public function delete(): void {
		$query = "DELETE FROM eventAttendance WHERE :eventAttendanceId";
		$statement = $pdo = ($query);

		// delete the variables from the place holders in the template
		$parameters = ["eventAttendanceId" => $this->eventAttendanceId, "eventAttendanceProfileId" => $this->eventAttendanceProfileId, "eventAttendanceEventId" => $this->eventAttendanceEventId, "eventAttendanceCheckIn" => $this->eventAttendanceCheckIn, "eventAttendanceNumberAttending" => $this->eventAttendanceNumberAttending];
		$statement->$parameters;
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
		$query = "UPDATE eventAttendance SET eventAttendancId = :eventAttendanceId, eventAttendanceEventId = :eventAttentionEventId, eventAttendanceProfileId = :eventAttendanceProfileId, eventAttendanceCheckIn = :eventAttendanceCheckin, eventAttendanceNumberAttending = :eventAttendanceNumberAttending WHERE eventAttendanceId = :eventAttendanceId";
		$statement = $pdo->prepare($query);


		// delete the variables from the place holders in the template
		$parameters = ["eventAttendanceId" => $this->eventAttendanceId, "eventAttendanceEventId"=> $this->eventAttendanceEventId, "eventAttendanceProfileId" => $this->eventAttendanceProfileId,  "eventAttendanceCheckIn" => $this->eventAttendanceCheckIn, "eventAttendanceNumberAttending" => $this->eventAttendanceNumberAttending];
		$statement->execute($parameters);
	}
	/**
	 * gets the Event Attendance by EventAttendanceId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param $eventAttendanceId
	 * @return EventAttendance|null Event Attendance found or null if not found
	 * @internal param  $EventAttendanceId to search for
	 */
	public static function getEventAttendanceByEventAttendanceId(\PDO $pdo, $eventAttendanceId): ?EventAttendance {
		// sanitize the eventAttendanceId before searching
		try {
			$eventAttendanceId = ($eventAttendanceId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT eventAttendanceId, eventAttendanceEventid,eventAttendanceProfileId,  eventAttendanceCheckIn, eventAttendanceNumberAttending FROM eventAttendance WHERE eventAttendanceId = :eventAttendanceId";
		$statement = $pdo->prepare($query);
		// bind the eventAttendanceId to the place holder in the template
		$parameters = ["eventAttendanceId" => $eventAttendanceId];
		$statement->execute($parameters);
		// grab eventAttendanceId from mySQL
		try {
			$eventAttendanceId = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$eventAttendanceId = new eventAttendance($row["eventAttendanceId"],$row["eventAttendanceEventId"],  $row["eventAttendanceProfileId"], $row["eventAttendanceCheckIn"], $row["eventAttendanceNumberAttending"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($eventAttendanceId);
	}
	/**
	 * gets the Event Attendance by eventAttendanceEventId
	 * @param \PDO $pdo PDO connection object
	 * @param $eventAttendanceEventId
	 * @return \SPLFixedArray eventAttendanceEventId found or null if not found
	 * @internal param $eventAttendanceEventId
	 * @internal param $eventAttendanceEventId to search for
	 */
	public static function getEventAttendancesByEventAttendanceEventId(\PDO $pdo, $eventAttendanceEventId): \SplFixedArray {
		try {
			$eventAttendanceEventId = ($eventAttendanceEventId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT eventAttendanceId, eventAttendanceEventId, eventAttendanceProfileId,  EventAttendanceCheckIn, eventAttendanceNumberAttending FROM eventAttendance WHERE eventAttendanceEventId = :eventAttendanceEventId";
		$statement = $pdo->prepare($query);
		// bind the EventAttendanceEventId to the place holder in the template
		$parameters = ["eventAttendanceEventId" => $eventAttendanceEventId];
		$statement->execute($parameters);
		// build and array of EventAttendanceEventId
		$eventAttendanceEventIdArray = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$eventAttendanceEventIdArray = new eventAttendance($row["eventAttendanceId"],$row["eventAttendanceEventId"], $row["eventAttendanceProfileId"],  $row["eventAttendanceCheckIn"], $row["eventAttendanceNumberAttending"]);
				$eventAttendanceEventIdArray[$eventAttendanceEventIdArray = key()] = $eventAttendanceEventId;
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($eventAttendanceEventId);
	}

	/**
	 * gets the Event Attendance by eventAttendanceProfileId
	 * @param \PDO $pdo PDO connection object
	 * @param $eventAttendanceProfileId
	 * @return \SPLFixedArray eventAttendanceProfileId found or null if not found
	 * @internal param $eventAttendanceProfileId
	 * @internal param $eventAttendanceProfileId to search for
	 */
	public static function getEventAttendancesByEventAttendanceProfileId(\PDO $pdo, $eventAttendanceProfileId): \SPLFixedArray {
		try {
			$eventAttendanceProfileId = ($eventAttendanceProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT eventAttendanceId, eventAttendanceEventId, eventAttendanceProfileId,  eventAttendanceCheckIn, eventAttendanceNumberAttending FROM eventAttendance WHERE eventAttendanceProfileId = :eventAttendanceProfileId";
		$statement = $pdo->prepare($query);
		// bind the eventAttendanceProfileId to the place holder in the template
		$parameters = ["eventAttendanceProfileId" => $eventAttendanceProfileId];
		$statement->execute($parameters);
		// build an array of eventAttendanceProfileId
		$eventAttendanceProfileIdArray = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$eventAttendanceProfileId = new eventAttendance ($row["eventAttendanceId"], $row["eventAttendanceProfileId"], $row["eventAttendanceEventId"], $row["eventAttendanceCheckIn"], $row["eventAttendanceNumberAttending"]);
				$eventAttendanceProfileIdArray[$eventAttendanceProfileIdArray = key($eventAttendanceProfileId)] = $eventAttendanceProfileId;
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($eventAttendanceProfileId);
	}


	/**
	 * gets the Event Attendance Check In by eventAttendanceCheckIn
	 * @param \PDO $pdo PDO connection object
	 * @param $eventAttendanceCheckIn
	 * @return \SPLFixedArray eventAttendanceCheckIn found or null if not found
	 * @internal param $eventAttendanceCheckIn
	 * @internal param $eventAttendanceCheckIn to search for
	 */
	public static function getEventAttendancesByEventAttendanceCheckIn(\PDO $pdo, $eventAttendanceCheckIn): \SplFixedArray {
		try {
			$eventAttendanceCheckIn = ($eventAttendanceCheckIn);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT eventAttendanceId, eventAttendanceEventId, eventAttendanceProfileId,  EventAttendanceCheckIn, eventAttendanceNumberAttending FROM eventAttendance WHERE eventAttendanceCheckIn = :eventAttendanceCheckIn";
		$statement = $pdo->prepare($query);
		// bind the EventAttendanceCheckIn to the place holder in the template
		$parameters = ["eventAttendanceCheckIn" => $eventAttendanceCheckIn];
		$statement->execute($parameters);
		// build and array of EventAttendanceCheckIn
		$eventAttendanceCheckInArray = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$eventAttendanceCheckInArray = new eventAttendance($row["eventAttendanceId"], $row["eventAttendanceEventId"],$row["eventAttendanceProfileId"],  $row["eventAttendanceCheckIn"], $row["eventAttendanceNumberAttending"]);
				$eventAttendanceCheckInArray[$eventAttendanceCheckInArray = key()] = $eventAttendanceCheckIn;
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($eventAttendanceCheckIn);
	}

	/**
	 * gets the Event Attendance by eventAttendanceNumberAttending
	 * @param \PDO $pdo PDO connection object
	 * @param $eventAttendanceNumberAttending
	 * @return \SPLFixedArray eventAttendanceNumberAttending found or null if not found
	 * @internal param $eventAttendanceNumberAttending
	 * @internal param $eventAttendanceNumberAttending to search for
	 */
	public static function getEventAttendancesByNumberAttending(\PDO $pdo, $eventAttendanceNumberAttending): \SplFixedArray {
		try {
			$eventAttendanceNumberAttending = ($eventAttendanceNumberAttending);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT eventAttendanceId, eventAttendanceEventId, eventAttendanceProfileId,  EventAttendanceCheckIn, eventAttendanceNumberAttending FROM eventAttendance WHERE eventAttendanceNumberAttending = :eventAttendanceNumberAttending";
		$statement = $pdo->prepare($query);
		// bind the EventAttendanceNumberAttending to the place holder in the template
		$parameters = ["eventAttendanceNumberAttending" => $eventAttendanceNumberAttending];
		$statement->execute($parameters);
		// build and array of EventAttendanceNumberAttending
		/** @var $eventAttendanceNumberAttendingArray
		 */
		$eventAttendanceNumberAttendingArray = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$eventAttendanceNumberAttendingArray = new eventAttendance($row["eventAttendanceId"],$row["eventAttendanceEventId"], $row["eventAttendanceProfileId"],  $row["eventAttendanceCheckIn"], $row["eventAttendanceNumberAttending"]);
				$eventAttendanceNumberAttendingArray[$eventAttendanceNumberAttendingArray = key()] = $eventAttendanceNumberAttending;
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($eventAttendanceNumberAttending);
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