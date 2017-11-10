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

class Event implements \JsonSerializable {
    use ValidateDate;
    /**
     * id for this Event; this is the primary key
     * @var int $eventId
     **/
    private $eventId;

    /**
     * id of the profile that sent the event, this is foreign key
     * @var int $eventProfileId;
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
     * @var int $eventCost
     **/
    private $eventCost;
    /**
     * this will specify when the event will begin
     *
     * @var \DateTime $eventStartTime
     **/
    private $eventStartTime;
    /**
     * this specifies the time the event will end.
     *
     * @var \DateTime $eventEndStartTime
     **/
    private $eventEndStartTime;
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
     * this is the event Category
     *
     * @var boolean $eventCategory
     */
    private $eventCategory;

    /**
     * Event constructor.
     * @param int|null $newEventId
     * @param int $newEventProfileId
     * @param string $newEventDetail
     * @param \DateTime|null $newEventStartDateTime
     * @param \DateTime|null $newEventEndStartTime
     * @param int $newEventPrice
     * @param float $newEventLat
     * @param float $newEventLong
     * @param null $eventImage
     * @param string $newEventName
     */

    public function __construct(?int $newEventId, int $newEventProfileId, string $newEventDetail, \DateTime $newEventStartDateTime =
    null, \DateTime $newEventEndStartTime = null, int $newEventPrice, float $newEventLat, float $newEventLong, $eventImage= null,
string $newEventName, )

    {
    }


    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }
}