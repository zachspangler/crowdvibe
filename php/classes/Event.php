<?php

namespace Edu\Cnm\CrowdVibe;
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;


/**
 * An event is user created, it is allow people to join you in any activity you are participating in.
 *
 * @author Luther Mckeiver <lmckeiver@cnm.edu>
 * @version 1.0.0
 **/
class Event implements \JsonSerializable
{

    use ValidateDate;
    use ValidateUuid;
    /**
     * id for this Event; this is the primary key
     * @var uuid $eventId
     **/
    private $eventId;

    /**
     * id of the profile that sent the event, this is foreign key
     * @var uuid $eventProfileId ;
     **/
    private $eventProfileId;
    /**
     * this is the actual text detail of the event
     *
     * @var string $eventDetail
     **/
    private $eventDetail;
    /**
     * this is the latitude of the event
     *
     * @var float $eventLat
     **/
    private $eventLat;
    /**
     * this is the longitude of the event
     *
     * @var float $eventLong
     **/
    private $eventLong;
    /**
     * this specifies whether the event will cost money or will be free
     *
     * @var float $eventPrice
     **/
    private $eventPrice;
    /**
     * this will specify when the event will begin
     *
     * @var \DateTime $eventStartTime
     **/
    private $eventStartDateTime;
    /**
     * this specifies the time the event will end.
     *
     * @var \DateTime $eventEndDateTime
     **/
    private $eventEndDateTime;
    /**
     * this specifies the limit of individuals that can attend an event
     *
     * @var int $eventAttendeeLimit
     **/
    private $eventAttendeeLimit;
    /**
     * this is an image for an event
     *
     * @var null $eventImage
     */
    private $eventImage;
    /**
     * this is the name of the event
     *
     * @var string $eventName
     */
    private $eventName;


    /**
     * Event constructor.
     * @param string|Uuid $newEventId
     * @param string|Uuid $newEventProfileId
     * @param string $newEventDetail
     * @param \DateTime|string $newEventStartDateTime
     * @param \DateTime|string $newEventEndDateTime
     * @param int $newEventPrice
     * @param float $newEventLat
     * @param int $newEventAttendeeLimit
     * @param float $newEventLong
     * @param string|null $newEventImage
     * @param string $newEventName
     * @throws \InvalidArgumentException if data types are out of bounds (e.g., strings to long, negative integers)
     * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
     * @throws \TypeError if a data type violates a data hint
     * @throws \Exception if some other exception occurs
     */

    public function __construct($newEventId, $newEventProfileId, int $newEventAttendeeLimit, $newEventEndDateTime = null, string $newEventDetail, $newEventImage = null, float $newEventLat, float $newEventLong, string $newEventName, int $newEventPrice, $newEventStartDateTime = null)
    {
        try {
            $this->setEventId($newEventId);
            $this->setEventProfileId($newEventProfileId);
            $this->setEventDetail($newEventDetail);
            $this->setEventStartDateTime($newEventStartDateTime);
            $this->setEventEndDateTime($newEventEndDateTime);
            $this->setEventPrice($newEventPrice);
            $this->setEventLat($newEventLat);
            $this->setEventLong($newEventLong);
            $this->setEventImage($newEventImage);
            $this->setEventName($newEventName);
            $this->setEventAttendeeLimit($newEventAttendeeLimit);
        } //determine what exception type was thrown
        catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw (new $exceptionType($exception->getMessage(), 0, $exception));
        }
    }
    /**
     * accessor method for event id
     *
     * @return uuid value of event id
     **/

    public function getEventId(): uuid
    {
        return ($this->eventId);
    }

    /**
     * mutator method for event id
     *
     * @param uuid $newEventId new value of event id
     * @throws \RangeException if $nevEventId is not positive
     * @throws \TypeError if $newEventId is not an integer
     **/
    public function setEventId( $newEventId): void {
        try {
            $uuid = self::validateUuid($newEventId);
        } catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
        // convert and store event id
        $this->eventId = $uuid;

    }

    /**
     * accessor method for event profile id
     *
     * @return uuid value of event profile id
     **/
    public function getEventProfileId(): uuid
    {
        return ($this->eventProfileId);
    }

    /**
     * mutator method for event profile id
     *
     * @param uuid $newEventProfileId new value of event profile id
     * @throws \RangeException if $newProfileId is not positive
     * @throws \TypeError if $newProfileId is not an integer
     **/
    public function setEventProfileId($newEventProfileId): void {
        try {
            $uuid = self::validateUuid($newEventProfileId);
        } catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
        // convert and store event id
        $this->eventProfileId = $uuid;

    }

    /**
     * accessor method for event detail
     *
     * @return string value of event detail
     **/
    public
    function getEventDetail(): string
    {
        return ($this->eventDetail);
    }

    /**
     * mutator method for event detail
     *
     * @param string $newEventDetail new value of event detail
     * @throws \InvalidArgumentException if $newEventDetail is not a string or insecure
     * @throws \RangeException if $newEventDetail is > 500
     * @throws \TypeError if $newEventDetail is not a string
     **/
    public
    function setEventDetail(string $newEventDetail): void
    {
        // verify the event detail is secure
        $newEventDetail = trim($newEventDetail);
        $newEventDetail = filter_var($newEventDetail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        if (empty($newEventDetail) === true) {
            throw (new \InvalidArgumentException("event detail is empty or insecure"));
        }
        //verify the event detail will fit in the database
        if (strlen($newEventDetail) > 500) {
            throw (new \RangeException("event content is too long"));
        }
        //store the event detail
        $this->eventDetail = $newEventDetail;
    }

    /**
     * accessor method for event name
     *
     * @return string value of event name
     **/
    public
    function getEventName(): string
    {
        return ($this->eventName);
    }

    /**
     * mutator method for event name
     *
     * @param string $newEventName new value of event name
     * @throws \InvalidArgumentException if $newEventName is not a string or insecure
     * @throws \RangeException if $newEventName is > 64 characters
     * @throw \TypeError if $newEventName is not a string
     **/
    public
    function setEventName(string $newEventName): void
    {
        //verify the event name is secure
        $newEventName = trim($newEventName);
        $newEventName = filter_var($newEventName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        if (empty($newEventName) === true) {
            throw (new \InvalidArgumentException("event name is empty or insecure"));
        }
        //verify the event name will fit in the database
        if (strlen($newEventName) > 64) {
            throw (new \RangeException("event name is too long"));
        }

        // store the event name
        $this->eventName = $newEventName;
    }

    /**
     * accessor method for event image
     *
     * @return string value of event image
     **/
    public
    function getEventImage()
    {
        return ($this->eventImage);
    }

    /**
     * mutator method for event image
     *
     * @param string $newEventImage new value of event image
     * @throws \InvalidArgumentException if $newEventImage is not not a string or insecure
     * @throws \RangeException if $newEventImage is > 64 characters
     * @throw \TypeError if $newEventImage is not a string
     **/
    public
    function setEventImage(string $newEventImage): void
    {
        // verify the image is insecure
        $newEventImage = trim($newEventImage);
        $newEventImage = filter_var($newEventImage, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        if (empty($newEventImage) === true) {
            throw (new \InvalidArgumentException("event image is empty or insecure"));
        }
        // verify the event image will fit in the database
        if (strlen($newEventImage) > 64) {
            throw (new \RangeException("event image is too long"));
        }
        //store the event image
        $this->eventImage = $newEventImage;
    }

    /**
     * accessor method for event price
     *
     * @return float of event price
     **/
    public
    function getEventPrice()
    {
        return ($this->eventPrice);
    }

    /**
     * mutator method for event price
     *
     * @param float $newEventPrice new value of event price
     * @throws \InvalidArgumentException if $newEventPrice is not a float or insecure
     * @throws \RangeException if $newEventPrice is >
     * @throw |TypeError if $newEventPrice is not a float
     **/
    public
    function setEventPrice(float $newEventPrice): void
    {
        // verify the price is insecure
        $newEventPrice = trim($newEventPrice);
        $newEventPrice = filter_var($newEventPrice, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        if (empty($newEventPrice) === true) {
            throw (new \InvalidArgumentException("event price is empty or insecure"));
        }
        // verify the event price will fit in the database
        if (strlen($newEventPrice) <= 7) {
        } else {
            throw (new \RangeException("event price is too much"));
        }
        // store this event price
        $this->eventPrice = $newEventPrice;
    }

    /**
     * accessor method for event Latitude
     *
     * @return float value of event Latitude
     **/
    public
    function getEventLat(): float
    {
        return ($this->eventLat);
    }

    /**
     * mutator method for event Latitude
     *
     * @param float $newEventLat new value event Latitude
     * @throws \InvalidArgumentException if $newEventLat is not a valid latitude or insecure
     * @throws \RangeException if $newEventLat is > 12 characters
     * @throws \TypeError if $newEventLat is not a float
     **/
    public
    function setEventLat(float $newEventLat): void
    {
        // verify the float will fit in the database
        if (($newEventLat > 90) || ($newEventLat < -90)) {
            throw (new \RangeException("latitude is too big of a number"));
        }
        // store the latitude for event
        $this->eventLat = $newEventLat;
    }

    /**
     * accessor method for eventLong
     *
     * @return float value for event Longitude
     **/
    public
    function getEventLong(): float
    {
        return ($this->eventLong);
    }

    /**
     * mutator method for event Longitude
     *
     * @param float $newEventLong new value event Longitude
     * @throws \InvalidArgumentException if $newEventLong is not a valid longitude or insecure
     * @throws \RangeException if $newEventLong is > 12 characters
     * @throws \TypeError if $newEventLong is not a float
     **/
    public
    function setEventLong(float $newEventLong): void
    {
        // verify the float will fit in the database
        if (($newEventLong > 180) || ($newEventLong < -180)) {
            throw(new \RangeException("longitude is too large of a number"));
        }
        //store the event longitude
        $this->eventLong = $newEventLong;

    }

    /**
     * accessor method for eventStartDateTime
     *
     * @return \DateTime
     */
    public function getEventStartDateTime(): \DateTime
    {
        return ($this->eventStartDateTime);
    }

    /**
     * mutator method for eventStartDateTime
     *
     * @param \DateTime $newEventStartDateTime
     */
    public
    function setEventStartDateTime($newEventStartDateTime = null): void
    {
        //base case: if the date is null, use the current date and time
        if ($newEventStartDateTime === null) {
            $this->eventStartDateTime = new \DateTime();
            return;
        }
        // store the date/time using the Validate Trait
        try {
            $newEventStartDateTime = self::validateDateTime($newEventStartDateTime);
        } catch (\InvalidArgumentException | \RangeException $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }

        $this->eventStartDateTime = $newEventStartDateTime;
    }

    /**
     * accessor method to eventEndDateTime
     *
     * @return \DateTime
     **/
    public
    function getEventEndDateTime(): \DateTime
    {
        return ($this->eventEndDateTime);
    }

    /**
     * mutator method for eventEndDateTime
     *
     * @param \DateTime $newEventEndDateTime
     * @throws |DateTime|string\null $newEventDateTime comment date as a DateTime object or string (or null to load the current time)
     * @throws |InvalidArgumentException if $newEventEndDateTime is not a valid object or string
     * @throws \RangeException if $newEventEndDateTime is a date that does not exist
     **/
    public
    function setEventEndDateTime($newEventEndDateTime = null): void
    {
        //base case: if the date is null, use the current date and time
        if ($newEventEndDateTime === null) {
            $this->eventEndDateTime = new \DateTime();
            return;
        }
        // store the date/time using the Validate Trait
        try {
            $newEventEndDateTime = self::validateDateTime($newEventEndDateTime);
        } catch (\InvalidArgumentException | \RangeException $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
        $this->eventEndDateTime = $newEventEndDateTime;
    }

    /**
     * accessor method for eventAttendeeLimit
     *
     * @return int
     **/
    public function getEventAttendeeLimit(): int
    {
        return ($this->eventAttendeeLimit);
    }

    /**
     * mutator method for eventAttendeeLimit
     *
     * @param int $newEventAttendeeLimit new value of event Attendee
     * @throws \RangeException if $newEventAttendeeLimit is not positive
     **/
    public function setEventAttendeeLimit($newEventAttendeeLimit): void
    {
        // verify the attendance is less than <500
        $newEventAttendeeLimit = trim($newEventAttendeeLimit);
        $newEventAttendeeLimit = filter_var($newEventAttendeeLimit . FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_NO_ENCODE_QUOTES);
        if (empty($newEventAttendeeLimit) === true) {
            throw (new \InvalidArgumentException("event Attendance is empty or insecure"));
        }
        //verify the event attendance will fit in the database
        if (strlen($newEventAttendeeLimit) > 500) {
            throw (new \RangeException("event attendance is too large"));
        }

    }

    /**
     * Insert this Event into mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function insert(\PDO $pdo): void
    {
        //create query template
        $query = "INSERT INTO event(eventId, eventProfileId, eventAttendeeLimit, eventEndDateTime, eventDetail, eventImage, eventLat, eventLong, eventName, eventPrice, eventStartDateTime) VALUES (:eventId, :eventProfileId, :eventAttendeeLimit, :eventEndDateTime, :eventDetail, :eventImage, :eventLat, :eventLong, :eventName, :eventPrice, :eventStartDateTime)";
        $statement = $pdo->prepare($query);
        $parameters = ["eventId" => $this->eventId->getBytes(), "eventProfileId" => $this->eventProfileId, "eventAttendeeLimit" => $this->eventAttendeeLimit, "eventEndDateTime =>$this->eventEndDateTime", "eventDetail" => $this->eventDetail, "eventImage" => $this->eventImage, "eventLat" => $this->eventLat, "eventLong" => $this->eventLong, "eventName" => $this->eventName, "eventPrice" => $this->eventPrice, "eventStartDateTime" => $this->eventStartDateTime];
        $statement->execute($parameters);
    }

    /**
     * Delete this Event from mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function delete(\PDO $pdo): void
    {
        // create query template
        $query = "DELETE FROM event WHERE eventId = :eventId";
        $statement = $pdo->prepare($query);
        // bind the member variables to the place holders in the template
        $parameters = ["eventId" => $this->eventId->getBytes()];
        $statement->execute($parameters);

    }

    /**
     * updates this Event from mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     **/
    public function update(\PDO $pdo): void
    {
        //create query template
        $query = "UPDATE event SET eventId = :eventId, eventProfileId= :eventProfileId, eventAttendeeLimit= :eventAttendeeLimit, eventEndDateTime= :eventEndDateTime, eventDetail= :eventDetail, eventImage= :eventImage, eventLat= :eventLat, eventLong= :eventLong, eventName= :eventName, eventPrice= :eventPrice, eventStartDateTime= :eventStartDateTime";
        $statement = $pdo->prepare($query);
        // bind the member variables to the place holders in the template
        $parameters = ["eventId" => $this->eventId->getBytes(), "eventProfileId" => $this->eventProfileId, "eventAttendeeLimit" => $this->eventAttendeeLimit, "eventEndDateTime =>$this->eventEndDateTime", "eventDetail" => $this->eventDetail, "eventImage" => $this->eventImage, "eventLat" => $this->eventLat, "eventLong" => $this->eventLong, "eventName" => $this->eventName, "eventPrice" => $this->eventPrice, "eventStartDateTime" => $this->eventStartDateTime];
        $statement->execute($parameters);

    }


    /**
     * gets the Event by event id
     *
     * @param \PDO $pdo $pdo PDO Connection object
     * @param string $eventId event id to search for
     * @return Event|null Event found or null if not found
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when variables are not the correct data type
     **/
    public static function getEventByEventId(\PDO $pdo, string $eventId): ?Event{
        //sanitize the event id before searching
        try {
            $eventId = self::validateUuid($eventId);
        } catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw (new \PDOException($exception->getMessage(), 0, $exception));
        }
        // create query template
        $query = "SELECT eventId, eventProfileId, eventAttendeeLimit, eventEndDateTime, eventDetail, eventImage, eventLat, eventLong, eventName, eventPrice, eventStartDateTime FROM event WHERE eventId =:eventId";
        $statement = $pdo->prepare($query);
        // bind the event id to the placeholder in the template
        $parameters = ["eventId" => $eventId->getBytes()];
        $statement->execute($parameters);
        // grab the event id from mySQL
        try {
            $event = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if ($row !== false) {
                $event = new Event($row["eventId"], $row["eventProfileId"], $row["EventAttendeeLimit"], $row["EventEndDateTime"], $row["eventDetail"], $row["eventImage"], $row["eventLat"], $row["eventLong"], $row["eventName"], $row["eventPrice"], $row["eventStartDateTime"]);
            }
        } catch (\Exception $exception) {
            // if the row could not be converted, rethrow it
            throw (new \PDOException($exception->getMessage(), 0, $exception));
        }
        return ($event);

    }

    /**
     * gets the Event by event profile id
     *
     * @param \PDO $pdo $pdo PDO Connection object
     * @param string $eventProfileId event id to search for
     * @return Event|null Event or null if not found
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when variables are not the correct data type
     **/
    public static function getEventByEventProfileId(\PDO $pdo, string $eventProfileId):?\SplFixedArray {
        try {
            $eventProfileId = self::validateUuid($eventProfileId);
        } catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw (new \PDOException($exception->getMessage(), 0, $exception));
        }

        //create query template
        $query = "SELECT eventId, eventProfileId, eventAttendeeLimit, eventEndDateTime, eventDetail, eventImage, eventLat, eventLong, eventName, eventPrice, eventStartDateTime FROM event WHERE eventProfileId = :eventProfileId";
        $statement = $pdo->prepare($query);
        //bind the event profile id to the placeholder in the template
        $parameters = ["eventProfileId"=> $eventProfileId->getBytes()];
        $statement->execute($parameters);
        // build an array of events
        $events = new \SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while (($row = $statement->fetch())!== false) {
            try {
                $event = new Event($row["eventId"], $row["eventProfileId"],$row["eventAttendeeLimit"],$row["eventEndDateTime"], $row["eventDetail"], $row["eventImage"], $row["eventLat"], $row["eventLong"], $row["eventName"], $row["eventPrice"], $row["eventStartDateTime"]);
                $events[$events->key()] = $event;
                $events->next();
            } catch (\Exception $exception) {
                // if the row couldn't be converted, rethrow it
                throw (new \PDOException($exception->getMessage(), 0, $exception));
            }
        }
        return($events);
    }



    /**
     * gets the Event by event name
     *
     * @param \PDO $pdo $pdo PDO Connection object
     * @param string $eventName event id to search for
     * @return \SplFixedArray of all events found or null
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when variables are not the correct data type
     **/
    public static function getEventByEventName(\PDO $pdo, string $eventName):?\SplFixedArray {
        // sanitize the event name before searching
        $eventName = trim($eventName);
        $eventName = filter_var($eventName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        if (empty($eventName) === true) {
            throw (new \PDOException("not a valid event name"));
        }
        try {
            $eventName = self::validateUuid($eventName);
        } catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw (new \PDOException($exception->getMessage(), 0, $exception));
        }
        //create query template
        $query = "SELECT eventId, eventProfileId, eventAttendeeLimit, eventEndDateTime, eventDetail, eventImage, eventLat, eventLong, eventName, eventPrice, eventStartDateTime FROM event WHERE eventName =:eventName";
        $statement = $pdo->prepare($query);
        // bind the event name to the placeholder in the template
        $parameters = ["eventName" => $eventName->getBytes()];
        $statement->execute($parameters);
        //build an array of events
        $events = new \SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);

        while (($row = $statement->fetch()) !== false) {
            try {
                $event = new Event($row["eventId"], $row["eventProfileId"], $row ["eventAttendeeLimit"], $row["eventEndDateTime"], $row["eventDetail"], $row["eventImage"], $row["eventLat"], $row["eventLong"], $row["eventName"], $row["eventPrice"], $row["eventStartDateTime"]);
                $events[$events->key()] = $event;
                $events->next();

            } catch (\Exception $exception) {
                //if the row couldn't be converted, rethrow it
                throw (new \PDOException($exception->getMessage(), 0, $exception));
            }
            return ($events);
        }


        // grab the event Name from mySQL
        try {
            $eventName = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if ($row !== false) {
                $events = new Event($row["eventId"], $row["eventProfileId"], $row["EventAttendeeLimit"], $row["EventEndDateTime"], $row["eventDetail"],
                    $row["eventImage"], $row["eventLat"], $row["eventLong"], $row["eventName"], $row["eventPrice"], $row["eventStartDateTime"]);
            }
        } catch (\Exception $exception) {
            // if the row could not be converted rethrow it
            throw (new \PDOException($exception->getMessage(), 0, $exception));
        }
        return ($events);
    }


    public function jsonSerialize()
    {
        $fields = get_object_vars($this);
        $fields["eventId"] = $this->eventId;
        $fields["eventProfileId"] = $this->eventProfileId;

        //format the date so that the front end can consume it
        $fields["eventStartDateTime"] = round(floatval($this->eventStartDateTime->format("U.u")) * 1000);
        return ($fields);
    }
}





















