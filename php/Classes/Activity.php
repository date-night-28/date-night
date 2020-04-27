<?php
namespace DylanSmithcg\DateNight;

require_once("");
require_once(dirname(__DIR__) . "");

use Ramsey\Uuid\Uuid;


class Activity implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for the activity; this is the primary key
	 * @var Uuid $activityId
	 */
	private $activityId;
	/**
	 * category
	 * @var string $activityCategory
	 */
	private $activityCategory;
	
	
	
	private $activityContent;
	
	
	
	private $activityLat;
	
	
	
	private $activityLink;
	
	
	
	private $activityLng;
	
	
	
	private $activityTitle;
	
	
	
	
	
	public function __construct($newActivityId, $newActivityCategory, $newActivityContent, $newActivityLat, $newActivityLink, $newActivityLng, $newActivityTitle) {
		try {
			$this->setActivityId($newActivityId);
			$this->setActivityCategory($newActivityCategory);
			$this->setActivityContent($newActivityContent);
			$this->setActivityLat($newActivityLat);
			$this->setActivityLink($newActivityLink);
			$this->setActivityLng($newActivityLng);
			$this->setActivityTitle($newActivityTitle);
		}
		//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	public function getActivityId() : Uuid {
		return($this->activityId);
	}

	public function setActivityId($newActivityId){
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
	public function getActivityContent() {
		return $this->activityContent;
	}

	/**
	 * @param mixed $newActivityContent
	 */

	public function setActivityContent($newActivityContent) {
		$newActivityContent = filter_var($newActivityContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newActivityContent) === true) {
			throw(new \InvalidArgumentException("Activity Content is empty or insecure"));
		}
		//Just truncate and issue warning.
		if(strlen($newActivityContent) > 256) {
			throw(new \RangeException("Activity Content is longer than 256 characters"));
		}
		$this->activityContent = $newActivityContent;
	}
	/**
	 * @return mixed
	 */
	public function getActivityLat() : float {
		return $this->activityLat;
	}

	/**
	 * @param mixed $activityLat
	 */
	public function setActivityLat(float $newActivityLat) {
		//ensure this is decimal data type
		try {
			$newActivityLat = filter_var($newActivityLat, FILTER_VALIDATE_FLOAT);
		} catch (\TypeError $exception) {
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
	 * @param mixed $activityLink
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
	public function getActivityLng() : float {
		return $this->activityLng;
	}

	/**
	 * @param mixed $activityLng
	 */
	public function setActivityLng(float $newActivityLng) {
		//ensure this is decimal data type
		try {
			$newActivityLng = filter_var($newActivityLng, FILTER_VALIDATE_FLOAT);
		} catch (\TypeError $exception) {
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
	 * @param mixed $activityTitle
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
}


