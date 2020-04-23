<?php
namespace GabyVeloz\DateNight;

require_once("");
require_once(dirname(__DIR__) . "");

use Ramsey\Uuid\Uuid;


class Profile

private $profileId;

private $profileActivationToken;

private $profileEmail;

private $profileHash;

private $profileName;




public function __construct($profileId, string $profileActivationToken, string $profileEmail, string $profileHash, string $profileName) {
	try {
		$this->setProfileId($profileId);
		$this->setProfileActivationToken($profileActivationToken);
		$this->setProfileEmail($profileEmail);
		$this->setProfileHash($profileHash);
		$this->setProfileName($profileName);
	}
	//determine what exception type was thrown
	catch
	(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
}

/** accessor method for profile id
 *@return uuid value of profile id
 *
 */
public function getProfileId(): Uuid {
	return ($this->profileId);
}

/** mutator method for profile id
 *
 * @param Uuid|string $profileId new value of author id
 * @throws \InvalidArgumentException if data types are not valid
 * @throws \RangeException if #profileId is out of range
 * @throws \TypeError if $profileId is not a uuid or string
 *
 */
	public function setProfileId($profileId): void {
	try {
		$Uuid = self::validateUuid($profileId);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
	// convert and store the profile id
	$this->profileId = $Uuid;
}

/**
 * accessor method for profile activation token
 * @return string value of activations token
 */
	public function getProfileActivationToken(): ?string {
	return ($this->profileActivationToken);
}

/**mutator method for profile activation Token
 * @param string $profileActivationToken
 * @throws \InvalidArgumentException if the token is not a string or insecure
 * @throws \RangeException if the token is not exactly 32 characters
 * @throws \TypeError if the activation token is not a string
 *
 */
	public function setProfileActivationToken(?string $profileActivationToken): void {

/**
 *  try {
 * $uuid = self::validateUuid($profileActivationToken);
 * } catch(\InvalidArgumentException | \RangeException | \Exception |
 * \TypeError $exception) {
 * $exceptionType = get_class($exception);
 * throw(new $exceptionType($exception->getMessage(), 0, $exception));
 * }
 *
 */

	// convert and store the profile activation token
	$this->ProfileActivationToken = $profileActivationToken;
}

/**
 * accessor method for profile email
 *
 */
	public function getProfileEmail(): string {
	return ($this->profileEmail);
}

	/**
	 * mutator method for profile Email
	 *
	 */
	public function setProfileEmail($profileEmail): void {
	// verify the content is secure
	$profileEmail = trim($profileEmail);
	$profileEmail = filter_var($profileEmail, FILTER_VALIDATE_EMAIL, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($profileEmail) === true) {
		throw(new \InvalidArgumentException("email is required"));
	}

	// verify email content will fit in the database
	if(strlen($profileEmail) > 128) {
		throw(new \RangeException("email too large"));
	}
	// store the email content
	$this->profileEmail = $profileEmail;
}

/**
 * accessor method for profile Hash
 */
	public function getProfileHash(): string {
	return ($this->profileHash);
}

	/**
	 * mutator method for profile Hash
	 */
	public function setProfileHash(string $profileHash): void {
	//enforce that the hash is properly formatted
	$profileHash = trim($profileHash);
	if(empty($profilerHash) === true) {
		throw(new \InvalidArgumentException("profile password hash empty or insecure"));
	}

	//enforce the hash is really an Argon hash
	/*
	$profileHashInfo = password_get_info($profileHash);
	if($profileHashInfo["algoName"] !== "argon2i") {
		throw(new \InvalidArgumentException("profile hash is not a valid hash"));
}
	*/
	//enforce that the hash is exactly 97 characters.
	if(strlen($profileHash) > 97) {
		throw(new \RangeException("email too large"));
	}
	//store the hash
	$this->profileHash = $profileHash;
}

/**
 * accessor method for profile name
 */
	public function getProfilename(): string {
	return ($this->profileName);
}

	/**
	 * mutator method for profile name
	 */
	public function setProfileName(string $profileName): void {
	// verify the at handle is secure
	$profileName = trim($profileName);
	$profileName = filter_var($profileName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($profileName) === true) {
		throw(new \InvalidArgumentException("username is empty or insecure"));
	}
	// verify the at handle will fit in the database

	if(strlen($profileName) > 32) {
		throw(new \RangeException("username is too large"));
	}

	// store the at handle
	$this->profileName = $profileName;
}

public function insert(\PDO $pdo): void {

	// create query template
	$query = "INSERT INTO profile(profileId, profileActivationToken, profileEmail, profileHash, profileName) 
						VALUES (:profileId, :profileActivationToken, :profileEmail, :profileHash, :profileName)";
	$statement = $pdo->prepare($query);
	$parameters = ["profileId" => $this->profileId->getBytes(), "profileActivationToken" => $this->profileActivationToken, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash,
		"profileName" => $this->profileName];
	$statement->execute($parameters);
}

	/**
	 * deletes this Profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {

	// create query template

	$query = "DELETE FROM profile WHERE profileId = :profileId";
	$statement = $pdo->prepare($query);

	//bind the member variables to the place holders in the template

	$parameters = ["profileId" => $this->profileId->getBytes()];
	$statement->execute($parameters);
}
	/**
	 * updates this Profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 **/

	public function update(\PDO $pdo): void {

	// create query template
	$query = "UPDATE profile 
						SET profileActivationToken = :profileActivationToken, 						profileEmail = :profileEmail, 
						profileHash = :profileHash, 
						profileName = :profileName, 
						WHERE profileId = :profileId";
	$statement = $pdo->prepare($query);

	// bind the member variables to the place holders in the template

	$parameters = ["profileId" => $this->profileId->getBytes(), "profileActivationToken" => $this->profileActivationToken, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash, "profileName" => $this->profileName];
	$statement->execute($parameters);
}

	  // next example

	public static function getProfileByProfileId(\PDO $pdo, $profileId):?Profile {
	// sanitize the profile id before searching

	try {
		$profileId = self::validateUuid($profileId);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		throw(new \PDOException($exception->getMessage(), 0, $exception));
	}

	// create query template
	$query = "SELECT profileId, profileActivationToken, profileEmail, profileHash, profileName
 						FROM profile 
 						WHERE profileId = :profileId";
	$statement = $pdo->prepare($query);

	// bind the profile id to the place holder in the template
	$parameters = ["profileId" => $profileId->getBytes()];
	$statement->execute($parameters);

	// grab the profile from mySQL
	try {
		$profile = null;
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$row = $statement->fetch();
		if($row !== false) {

			$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileEmail"],$row["profileHash"], $row["profileName"]);
		}
	} catch(\Exception $exception) {
		// if the row couldn't be converted, rethrow it
		throw(new \PDOException($exception->getMessage(), 0, $exception));
	}

	return ($profile);

}


//next example

	/**
	 * gets all Profiles
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of content found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllProfiles(\PDO $pdo) : \SPLFixedArray {
	// create query template
	$query = "SELECT profileActivationToken, profileAvatarUrl, profileEmail, profileHash, profileName
 						FROM profile";
	$statement = $pdo->prepare($query);
	$statement->execute();

	// build an array of ...
	$profile = new \SplFixedArray($statement->rowCount());
	$statement->setFetchMode(\PDO::FETCH_ASSOC);
	while(($row = $statement->fetch()) !== false) {
		try {
			$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileEmail"], $row["profileHash"], $row["profileName"]);
			$profiles[$profiles->key()] = $profile;
			$profiles->next();
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
	}
	return ($profiles);
}

	/**
	 * @inheritDoc
	 */
	public function jsonSerialize() {
	// TODO: Implement jsonSerialize() method.
}
}