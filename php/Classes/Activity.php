<?php
namespace DateNight28\DateNight;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;


class Activity {
	use ValidateUuid;

	/**
	 * id for the activity; this is the primary key
	 * @var Uuid $activityId
	 */
	private $activityId;


	private $activityImageUrl;


	private $activityLat;


	private $activityLink;


	private $activityLng;


	private $activityTitle;


	public function __construct($newActivityId, $newActivityImageUrl, $newActivityLat, $newActivityLink, $newActivityLng, $newActivityTitle) {
		try {
			$this->setActivityId($newActivityId);
			$this->setActivityImageUrl($newActivityImageUrl);
			$this->setActivityLat($newActivityLat);
			$this->setActivityLink($newActivityLink);
			$this->setActivityLng($newActivityLng);
			$this->setActivityTitle($newActivityTitle);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	public function getActivityId(): Uuid {
		return ($this->activityId);
	}

	public function setActivityId($newActivityId) {
		try {
			$uuid = self::validateUuid($newActivityId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		$this->activityId = $uuid;
	}

	/**
	 * @return mixed
	 */
	public function getActivityImageUrl() {
		return $this->activityImageUrl;
	}

	/**
	 * @param mixed $newActivityImageUrl
	 */

	public function setActivityImageUrl($newActivityImageUrl) {
		try {
			$newActivityImageUrl = filter_var($newActivityImageUrl, FILTER_VALIDATE_URL);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		if(strlen($newActivityImageUrl) > 255) {
			throw(new \RangeException("Activity Image Url is longer than 255 characters"));
		}
		$this->activityImageUrl = $newActivityImageUrl;
	}

	/**
	 * @return mixed
	 */
	public function getActivityLat(): float {
		return $this->activityLat;
	}

	/**
	 * @param mixed $newActivityLat
	 */
	public function setActivityLat(float $newActivityLat) {
		//ensure this is decimal data type
		try {
			$newActivityLat = filter_var($newActivityLat, FILTER_VALIDATE_FLOAT);
		} catch(\TypeError $exception) {
			throw(new \TypeError("Activity latitude value is an invalid data type"));
		}

		$this->activityLat = $newActivityLat;
	}

	/**
	 * @return mixed
	 */
	public function getActivityLink() {
		return $this->activityLink;
	}

	/**
	 * @param mixed $newActivityLink
	 */
	public function setActivityLink($newActivityLink) {
		try {
			$newActivityLink = filter_var($newActivityLink, FILTER_VALIDATE_URL);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		if(strlen($newActivityLink) > 255) {
			throw(new \RangeException("Activity Link is longer than 255 characters"));
		}

		$this->activityLink = $newActivityLink;
	}

	/**
	 * @return mixed
	 */
	public function getActivityLng(): float {
		return $this->activityLng;
	}

	/**
	 * @param mixed $newActivityLng
	 */
	public function setActivityLng(float $newActivityLng) {
		//ensure this is decimal data type
		try {
			$newActivityLng = filter_var($newActivityLng, FILTER_VALIDATE_FLOAT);
		} catch(\TypeError $exception) {
			throw(new \TypeError("Activity longitude value is an invalid data type"));
		}
		$this->activityLng = $newActivityLng;
	}

	/**
	 * @return mixed
	 */
	public function getActivityTitle() {
		return $this->activityTitle;
	}

	/**
	 * @param mixed $newActivityTitle
	 */
	public function setActivityTitle($newActivityTitle) {
		$newActivityTitle = filter_var($newActivityTitle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newActivityTitle) === true) {
			throw(new \InvalidArgumentException("Activity Title is empty or insecure"));
		}
		//Just truncate and issue warning.
		if(strlen($newActivityTitle) > 50) {
			throw(new \RangeException("Activity Title is longer than 50 characters"));
		}

		$this->activityTitle = $newActivityTitle;
	}


	public function insert(\PDO $pdo): void {

		// create query template
		$query = "INSERT INTO activity(activityId, activityImageUrl, activityLat, activityLink, activityLng, activityTitle) 
		VALUES(:activityId, :activityImageUrl, :activityLat, :activityLink, :activityLng, :activityTitle)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["activityId" => $this->activityId->getBytes(), "activityImageUrl" => $this->activityImageUrl, "activityLat" => $this->activityLat, "activityLink" => $this->activityLink, "activityLng" => $this->activityLng, "activityTitle" => $this->activityTitle];
		$statement->execute($parameters);
	}

	public function delete(\PDO $pdo): void {

		// create query template
		$query = "DELETE FROM activity WHERE activityId = :activityId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["activityId" => $this->activityId->getBytes()];
		$statement->execute($parameters);
	}

	public function update(\PDO $pdo): void {

		// create query template
		$query = "UPDATE activity SET activityId = :activityId, activityImageUrl = :activityImageUrl, activityLat = :activityLat, activityLink = :activityLink, activityLng = :activityLng, activityTitle = :activityTitle 
		WHERE activityId = :activityId";
		$statement = $pdo->prepare($query);


		$parameters = ["activityId" => $this->activityId->getBytes(), "activityImageUrl" => $this->activityImageUrl, "activityLat" => $this->activityLat, "activityLink" => $this->activityLink, "activityLng" => $this->activityLng, "activityTitle" => $this->activityTitle];
		$statement->execute($parameters);
	}

	public function getActivityByActivityId(\PDO $pdo, string $activityId){
		// sanitize the id before searching
		try {
			$activityId = self::validateUuid($activityId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT activityId, activityImageUrl, activityLat, activityLink, activityLng, activityTitle FROM activity WHERE activityId = :activityId";
		$statement = $pdo->prepare($query);
		// bind the id to the place holder in the template
		$parameters = ["activityId" => $activityId->getBytes()];
		$statement->execute($parameters);
		// grab the object from mySQL
		try {
			$activity = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$activity = new Activity($row["activityId"], $row["activityImageUrl"], $row["activityLat"],
					$row["activityLink"], $row["activityLng"], $row["activityTitle"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($activity);
	}

	public static function getActivityByActivityTitle(\PDO $pdo, string $activityTitle) : \SPLFixedArray {
		// sanitize the description before searching
		$activityTitle = trim($activityTitle);
		$activityTitle = filter_var($activityTitle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($activityTitle) === true) {
			throw(new \PDOException("activity title is invalid"));
		}

		// escape any mySQL wild cards
		$activityTitle = str_replace("_", "\\_", str_replace("%", "\\%", $activityTitle));

		// create query template
		$query = "SELECT activityId, activityImageUrl, activityLat, activityLink, activityLng, activityTitle FROM activity WHERE activityTitle LIKE :activityTitle";
		$statement = $pdo->prepare($query);

		// bind the activity title to the place holder in the template
		$activityTitle = "%$activityTitle%";
		$parameters = ["activityTitle" => $activityTitle];
		$statement->execute($parameters);

		// build an array of activities
		$activities = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$activity = new Activity($row["activityId"], $row["activityImageUrl"], $row["activityLat"], $row["activityLink"], $row["activityLng"], $row["activityTitle"]);
				$activities[$activities->key()] = $activity;
				$activities->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($activities);
	}

public static function getActivityByActivityImageUrl(\PDO $pdo, string $activityImageUrl) : \SPLFixedArray {
	// sanitize the description before searching
	$activityImageUrl = trim($activityImageUrl);
	$activityImageUrl = filter_var($activityImageUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($activityImageUrl) === true) {
		throw(new \PDOException("activity Image Url is invalid"));
	}

	// escape any mySQL wild cards
	$activityImageUrl = str_replace("_", "\\_", str_replace("%", "\\%", $activityImageUrl));

	// create query template
	$query = "SELECT activityId, activityImageUrl, activityLat, activityLink, activityLng, activityTitle FROM activity WHERE activityImageUrl LIKE :activityImageUrl";
	$statement = $pdo->prepare($query);

	// bind the activity title to the place holder in the template
	$activityImageUrl = "%$activityImageUrl%";
	$parameters = ["activityImageUrl" => $activityImageUrl];
	$statement->execute($parameters);

	// build an array of activities
	$activities = new \SplFixedArray($statement->rowCount());
	$statement->setFetchMode(\PDO::FETCH_ASSOC);
	while(($row = $statement->fetch()) !== false) {
		try {
			$activity = new Activity($row["activityId"], $row["activityImageUrl"], $row["activityLat"], $row["activityLink"], $row["activityLng"], $row["activityTitle"]);
			$activities[$activities->key()] = $activity;
			$activities->next();
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
	}
	return ($activities);
	}
}

