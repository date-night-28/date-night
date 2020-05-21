<?php
namespace DateNight28\DateNight;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;


class Favorite implements \JsonSerializable {
use ValidateDate;
use ValidateUuid;

private $favoriteProfileId;
private $favoriteActivityId;
private $favoriteDate;

	/**
	 * constructor for this Favorite
	 *
	 * @param string|Uuid $newFavoriteProfileId id of the parent Profile
	 * @param string|Uuid $newFavoriteActivityId id of the parent Activity
	 * @param \DateTime|null $newFavoriteDate date the activity was marked favorite (or null for current time)
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception is thrown
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 */
	public function __construct( $newFavoriteProfileId,  $newFavoriteActivityId, $newFavoriteDate = null) {
		// use the mutator methods to do the work for us!
		try {
			$this->setFavoriteProfileId($newFavoriteProfileId);
			$this->setFavoriteActivityId($newFavoriteActivityId);
			$this->setFavoriteDate($newFavoriteDate);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {

			// determine what exception type was thrown
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	
	/**
	 * accessor method for profile id
	 *
	 * @return Uuid value of profile id
	 **/
	public function getFavoriteProfileId() : Uuid {
		return ($this->favoriteProfileId);
	}
	
	/**
	 * mutator method for profile id
	 *
	 * @param string  $newFavoriteProfileId new value of profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 **/
	public function setFavoriteProfileId($newFavoriteProfileId) : void {
		try {
			$uuid = self::validateUuid($newFavoriteProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the profile id
		$this->favoriteProfileId = $uuid;
	}
	
	/**
	 * accessor method for activity id
	 *
	 * @return uuid value of activity id
	 **/
	public function getFavoriteActivityId() : Uuid{
		return ($this->favoriteActivityId);
	}
	
	/**
	 * mutator method for activity id
	 *
	 * @param string  $newFavoriteActivityId new value of activity id
	 * @throws \RangeException if $newActivityId is not positive
	 * @throws \TypeError if $newFavoriteActivityId is not an integer
	 **/
	public function setFavoriteActivityId( $newFavoriteActivityId) : void {
		try {
			$uuid = self::validateUuid($newFavoriteActivityId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the activity id
		$this->favoriteActivityId = $uuid;
	}
	
	/**
	 * accessor method for favorite date
	 *
	 * @return \DateTime value of favorite date
	 **/
	public function getFavoriteDate() : \DateTime {
		return ($this->favoriteDate);
	}
	
	/**
	 * mutator method for favorite date
	 *
	 * @param \DateTime|string|null $newFavoriteDate favorite date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newFavoriteDate is not a valid object or string
	 * @throws \RangeException if $newFavoriteDate is a date that does not exist
	 **/
	public function setFavoriteDate($newFavoriteDate): void {
		// base case: if the date is null, use the current date and time
		if($newFavoriteDate === null) {
			$this->favoriteDate = new \DateTime();
			return;
		}

		// store the favorite date using the ValidateDate trait
		try {
			$newFavoriteDate = self::validateDateTime($newFavoriteDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->favoriteDate = $newFavoriteDate;
	}

	/**
	 * inserts this Favorite into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public function insert(\PDO $pdo) : void {

		// create query template
		$query = "INSERT INTO `favorite`(favoriteProfileId, favoriteActivityId, favoriteDate) VALUES(:favoriteProfileId, :favoriteActivityId, :favoriteDate)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->favoriteDate->format("Y-m-d H:i:s.u");
		$parameters = ["favoriteProfileId" => $this->favoriteProfileId->getBytes(), "favoriteActivityId" => $this->favoriteActivityId->getBytes(), "favoriteDate" => $formattedDate];
		$statement->execute($parameters);
	}

	/**
	 * deletes this Like from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public function deleteFavoriteByProfileIdAndActivityId(\PDO $pdo) : void {

		// create query template
		$query = "DELETE FROM `favorite` WHERE favoriteProfileId = :favoriteProfileId AND favoriteActivityId = :favoriteActivityId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the placeholders in the template
		$parameters = ["favoriteProfileId" => $this->favoriteProfileId->getBytes(), "favoriteActivityId" => $this->favoriteActivityId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * gets the Favorite by activity id and profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $favoriteProfileId profile id to search for
	 * @param string $favoriteActivityId activity id to search for
	 * @return Favorite|null Favorite found or null if not found
	 */
	public static function getFavoriteByFavoriteActivityIdAndFavoriteProfileId(\PDO $pdo, string $favoriteProfileId, string $favoriteActivityId) : ?Favorite {
		try {
			$favoriteProfileId = self::validateUuid($favoriteProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		try {
			$favoriteActivityId = self::validateUuid($favoriteActivityId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT favoriteProfileId, favoriteActivityId, favoriteDate FROM `favorite` WHERE favoriteProfileId = :favoriteProfileId AND favoriteActivityId = :favoriteActivityId";
		$statement = $pdo->prepare($query);

		// bind the activity id and profile id to the place holder in the template
		$parameters = ["favoriteProfileId" => $favoriteProfileId->getBytes(), "favoriteActivityId" => $favoriteActivityId->getBytes()];
		$statement->execute($parameters);

		// grab the favorite from mySQL
		try {
			$favorite = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();

			if($row !== false) {
				$favorite = new Favorite($row["favoriteProfileId"], $row["favoriteActivityId"], $row["favoriteDate"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($favorite);
	}

	/**
	 * gets the Favorite by profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $favoriteProfileId profile id to search for
	 * @return \SplFixedArray SplFixedArray of Favorites found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public static function getFavoriteByFavoriteProfileId(\PDO $pdo, string $favoriteProfileId) : \SPLFixedArray {
		try {
			$favoriteProfileId = self::validateUuid($favoriteProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT favoriteProfileId, favoriteActivityId, favoriteDate FROM `favorite` WHERE favoriteProfileId = :favoriteProfileId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["favoriteProfileId" => $favoriteProfileId->getBytes()];
		$statement->execute($parameters);

		// build an array of likes
		$favorites = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$favorite = new Favorite($row["favoriteProfileId"], $row["favoriteActivityId"], $row["favoriteDate"]);
				$favorites[$favorites->key()] = $favorite;
				$favorites->next();
			} catch(\Exception $exception) {

				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($favorites);
	}

	/**
	 * gets the favorites by activity id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $favoriteActivityId activity id to search for
	 * @return \SplFixedArray array of favorites found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 **/

	public static function getFavoriteByFavoriteActivityId(\PDO $pdo, string $favoriteActivityId) : \SplFixedArray {
		try {
			$favoriteActivityId = self::validateUuid($favoriteActivityId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT favoriteProfileId, favoriteActivityId, favoriteDate FROM `favorite` WHERE favoriteActivityId = :favoriteActivityId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["favoriteActivityId" => $favoriteActivityId->getBytes()];
		$statement->execute($parameters);

		// build the array of likes
		$favorites = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$favorite = new Favorite($row["favoriteProfileId"], $row["favoriteActivityId"], $row["favoriteDate"]);
				$favorites[$favorites->key()] = $favorite;
				$favorites->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($favorites);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);

		//format the date so that the front end can consume it
		$fields["favoriteProfileId"] = $this->favoriteProfileId;
		$fields["favoriteActivityId"] = $this->favoriteActivityId;
		$fields["favoriteDate"] = round(floatval($this->favoriteDate->format("U.u")) * 1000);

		return ($fields);
	}
}