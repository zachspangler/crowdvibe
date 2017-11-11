<?php
namespace Edu\Cnm\CrowdVibe;
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;
/**
 * CrowdVibe Rating
 *
 * This is the rating information to be stored for both CrowdVibe events and profiles.
 *
 * @author Matt David <mdavid3636@gmail.com>
 * @version 1.0.0
 **/

class Rating implements \JsonSerializable {
    use ValidateDate;
    use ValidateUuid;

    /**
     * id for the Rating; this is the primary key
     * @var Uuid $ratingId
     */
    private $ratingId;

    /**
     * id of the event attended before being able to rate; this is a foreign key
     * @var Uuid $ratingEventAttendanceId
     */
    private $ratingEventAttendanceId;

    /**
     * id of a profile being rated only after attending similar event; this is a foreign key
     * @var Uuid $ratingRateeProfileId
     */
    private $ratingRateeProfileId;

    /**
     * id of the profile giving a rating; this is a foreign key
     * @var Uuid $ratingRaterProfileId
     */
    private $ratingRaterProfileId;

    /**
     * rating that has been given to a ratee or event by rater after attending events
     * @var tinyint(3) $ratingScore
     */
    private $ratingScore;

    /**
     * constructor for this Rating
     *
     * @param string|Uuid $newRatingId id of the rating or null if a new Tweet
     * @param string|Uuid $newRatingEventAttendanceId id of the event that was attended in order to make a Rating
     * @param string|Uuid $newRatingRateeProfileId id of a profile receiving Rating
     * @param string|Uuid $newRatingRaterProfileId id giving a Rating
     * @param string $newRatingScore this is the actual rating content
     * @throws \InvalidArgumentException if the date types are not valid
     * @throws \RangeException if data values are out of bounds (e.g., strings too long)
     * @throws \TypeError if date types violate type hints
     * @throws \Exception if some other exception occurs
     * @Documentation https://php.net/manuel/en/language.oop5.decon.php
     **/
    public function__construct($newRatingId, $newEventAttendanceId, $newRateeProfileId, $newRaterProfileId, string $newRatingScore) {
        try {
            $this->setRatingId($newRatingId);
            $this->setRatingEventAttendanceId($newEventAttendanceId);

}
}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["profileId"] = $this->profileId->toString();
		unset($fields["profileHash"]);
		unset($fields["profileSalt"]);
		return ($fields);
	}
}