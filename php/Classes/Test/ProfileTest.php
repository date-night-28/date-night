<?php
namespace DateNight28\DateNight\Test;

use DateNight28\DateNight\{DateNightTest, Profile};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "../lib/uuid.php");


class ProfileTest extends DateNightTest {

	protected $VALID_PROFILE_ID; //ID
	protected $VALID_ACTIVATION_TOKEN; //later
	protected $VALID_PROFILE_EMAIL = "gabrielaveloz@yahoo.com";
	protected $VALID_PROFILE_HASH; //later
	protected $VALID_NAME = "gaby veloz";


	public final function setUp() : void {
		parent::setUp();
		$password = "mypassword";
		$this->VALID_PROFILE_HASH = password_hash("mypassword", PASSWORD_ARGON2ID, ["time_cost" => 9]);
	}



	public function testInsertValidProfile() :void{
		//this will get count of profile records in b before test is ran.
		$numRows = $this->getConnection()->getRowCount("profile");

		//insert ab profile record in db
		$profileId = generateUuidV4()->toString();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_HASH, $this->VALID_NAME);

		//check count of profile records in the db after the insert
		$numRowsAfterInsert = $this->getConnection()->getRowCount("profile");
		self::assertEquals($numRows + 1, $numRowsAfterInsert);

		//get a copy of the record we inserted and validate the values
		//make sure the values that went in the record are the same ones that come out.


		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId()->toString());
		self::assertEquals($profileId, $pdoProfile->getProfileId());
		self::assertEquals($this->VALID_ACTIVATION_TOKEN, $pdoProfile->getProfileActivationToken());
		self::assertEquals($this->VALID_PROFILE_EMAIL, $pdoProfile->getProfileEmail());
		self::assertEquals($this->VALID_PROFILE_HASH, $pdoProfile->getProfileHash());
		self::assertEquals($this->VALID_NAME, $pdoProfile->getProfileName());
	}



	public function testUpdateValidProfile() :void{
		//this will get count of profile records in b before test is ran.
		$numRows = $this->getConnection()->getRowCount("profile");

		//insert ab profile record in db
		$profileId = generateUuidV4()->toString();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_AVATAR_URL, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_HASH, $this->VALID_NAME);
		$profile->insert($this->getPDO());

		//update a value on the record I just inserted.
		$changedProfileName = $this>$this->VALID_NAME . "changed";
		$profile->setProfileName($changedProfileName);
		$profile->update($this->getPDO());

		//check count of profile records in the db after the insert
		$numRowsAfterInsert = $this->getConnection()->getRowCount("profile");
		self::assertEquals($numRows + 1, $numRowsAfterInsert);

	}

	/*public function tesDeletetValidProfile() :void{
	}
	public function testGetValidProfileByProfileId() :void{
	}
	public function tesDeletetValidProfiles() :void{
	}
	*/
}
