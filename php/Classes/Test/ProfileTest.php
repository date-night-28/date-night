<?php
namespace DateNight28\DateNight\Test;

use DateNight28\DateNight\{Profile};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");


class ProfileTest extends DateNightTest {

	protected $VALID_PROFILE_ID; //ID
	protected $VALID_ACTIVATION_TOKEN; //later
	protected $VALID_PROFILE_EMAIL = "gabrielaveloz@yahoo.com";
	protected $VALID_PROFILE_HASH; //later
	protected $VALID_PROFILE_NAME = "gaby veloz";

	/**
	 * run the default setup operation to create salt and hash.
	 */
	public final function setUp(): void {
		parent::setUp();
		//
		$password = "abc1234";
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 8]);
		$this->VALID_ACTIVATION_TOKEN = bin2hex(random_bytes(16));
	}

	public function testInsertValidProfile(): void {
		//this will get count of profile records in b before test is ran.
		$numRows = $this->getConnection()->getRowCount("profile");

		//insert ab profile record in db
		$profileId = generateUuidV4()->toString();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_NAME);
		$profile->insert($this->getPDO());

		//get a copy of the record we inserted and validate the values
		//make sure the values that went in the record are the same ones that come out.


		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId()->toString());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILE_NAME);
	}

	/**
	 * test inserting a Profile, editing it, and then updating it
	 **/
	public function testUpdateValidProfile() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert to into mySQL
		$profileId = generateUuidV4()->toString();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_NAME);
		$profile->insert($this->getPDO());

		// edit the Profile and update it in mySQL
		$profile->setProfileName($this->VALID_PROFILE_NAME . "more name");
		$profile->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId()->toString());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILE_NAME . "more name");
	}


	/**
	 * test creating a Profile and then deleting it
	 **/
	public function testDeleteValidProfile(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert to into mySQL
		$profileId = generateUuidV4()->toString();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_NAME);
		$profile->insert($this->getPDO());

		// delete the Profile from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$profile->delete($this->getPDO());

		// grab the data from mySQL and enforce the Profile does not exist
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId()->toString());
		$this->assertNull($pdoProfile);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("profile"));
	}


	/**
	 * test inserting a Profile and regrabbing it from mySQL
	 **/
	public function testGetValidProfileByProfileId(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		$profileId = generateUuidV4()->toString();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_NAME);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId()->toString());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILE_NAME);
	}


	/**
	 * test grabbing a Profile by email
	 **/
	public function testGetValidProfileByEmail() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		$profileId = generateUuidV4()->toString();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_NAME);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileEmail($this->getPDO(), $profile->getProfileEmail());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILE_NAME);
	}
	/**
	 * test grabbing a Profile by an email that does not exists
	 **/
	public function testGetInvalidProfileByEmail() : void {
		// grab an email that does not exist
		$profile = Profile::getProfileByProfileEmail($this->getPDO(), "does@not.exist");
		$this->assertNull($profile);
	}



	/**
	 * test grabbing a profile by its activation
	 */
	public function testGetValidProfileByActivationToken() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		$profileId = generateUuidV4()->toString();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_NAME);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileActivationToken($this->getPDO(), $profile->getProfileActivationToken());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILE_NAME);
	}
	/**
	 * test grabbing a Profile by an email that does not exists
	 **/
	public function testGetInvalidProfileActivation() : void {
		// grab an email that does not exist
		$profile = Profile::getProfileByProfileActivationToken($this->getPDO(), "6675636b646f6e616c646472756d7066");
		$this->assertNull($profile);
	}



	/**
	 * test grabbing a Profile that does not exist
	 **/
	public function testGetInvalidProfileByProfileId(): void {

		// grab a profile id that exceeds the maximum allowable profile id
		$fakeProfileId = generateUuidV4()->toString();
		$profile = Profile::getProfileByProfileId($this->getPDO(), $fakeProfileId);
		$this->assertNull($profile);
	}


	public function testGetValidProfileByProfileName() {

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");
		$profileId = generateUuidV4()->toString();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_NAME);
		$profile->insert($this->getPDO());

		//grab the data from MySQL
		$pdoProfile = Profile::getProfileByProfileName($this->getPDO(), $this->VALID_PROFILE_NAME);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILE_NAME);
	}
	/**
	 * test grabbing a Profile by name that does not exist
	 **/
	public function testGetInvalidProfileByProfileName(): void {
		// grab an at name that does not exist
		$profile = Profile::getProfileByProfileName($this->getPDO(), "@doesnotexist");
		$this->assertNull($profile);
	}

}