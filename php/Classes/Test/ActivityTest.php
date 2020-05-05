<?php

namespace DateNight28\DateNight\Test;

use DateNight28\DateNight\{DateNightTest, Activity};

//hack! -added for practice

require_once(dirname(__DIR__) . "/Test/DateNightTest.php");

// grab the uuid generator

require_once(dirname(__DIR__, 2) . "/lib/uuid.php");




class ActivityTest extends DateNightTest {
	/**
	 * content of the Activity
	 * @var string $VALID_ACTIVITYCONTENT
	 **/
	protected $VALID_ACTIVITYCONTENT = "PHPUnit test passing";

	/**
	 * content of the updated Activity
	 * @var string $VALID_ACTIVITYCONTENT2
	 **/
	protected $VALID_ACTIVITYCONTENT2 = "PHPUnit test still passing";

	/**
	 * timestamp of the Activity; this starts as null and is assigned later
	 * @var \DateTime $VALID_ACTIVITYDATE
	 **/
	protected $VALID_ACTIVITYDATE = null;

	/**
	 * Valid timestamp to use as sunriseActivityDate
	 */
	protected $VALID_SUNRISEDATE = null;

	/**
	 * Valid timestamp to use as sunsetActivityDate
	 */
	protected $VALID_SUNSETDATE = null;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp()  : void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);


		// create and insert a Profile to own the test Activity
		$this->profile = new Profile(generateUuidV4(), null,"@handle", "https://media.giphy.com/media/3og0INyCmHlNylks9O/giphy.gif", "test@phpunit.de",$this->VALID_PROFILE_HASH, "+12125551212");
		$this->profile->insert($this->getPDO());

		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_ACTIVITYDATE = new \DateTime();

		//format the sunrise date to use for testing
		$this->VALID_SUNRISEDATE = new \DateTime();
		$this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));

		//format the sunset date to use for testing
		$this->VALID_SUNSETDATE = new\DateTime();
		$this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));



	}

	/**
	 * test inserting a valid Activity and verify that the actual mySQL data matches
	 **/
	public function testInsertValidActivity() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("activity");

		// create a new Activity and insert to into mySQL
		$activityId = generateUuidV4();
		$activity = new Activity($activityId, $this->profile->getProfileId(), $this->VALID_ACTIVITYCONTENT, $this->VALID_ACTIVITYDATE);
		$activity->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoActivity = Activity::getActivityByActivityId($this->getPDO(), $activity->getActivityId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activity"));
		$this->assertEquals($pdoActivity->getActivityId(), $activityId);
		$this->assertEquals($pdoActivity->getActivityProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoActivity->getActivityContent(), $this->VALID_ACTIVITYCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoActivity->getActivityDate()->getTimestamp(), $this->VALID_ACTIVITYDATE->getTimestamp());
	}

	/**
	 * test inserting a Activity, editing it, and then updating it
	 **/
	public function testUpdateValidActivity() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("activity");

		// create a new Activity and insert to into mySQL
		$activityId = generateUuidV4();
		$activity = new Activity($activityId, $this->profile->getProfileId(), $this->VALID_ACTIVITYCONTENT, $this->VALID_ACTIVITYDATE);
		$activity->insert($this->getPDO());

		// edit the Activity and update it in mySQL
		$activity->setActivityContent($this->VALID_ACTIVITYCONTENT2);
		$activity->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoActivity = Activity::getActivityByActivityId($this->getPDO(), $activity->getActivityId());
		$this->assertEquals($pdoActivity->getActivityId(), $activityId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activity"));
		$this->assertEquals($pdoActivity->getActivityProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoActivity->getActivityContent(), $this->VALID_ACTIVITYCONTENT2);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoActivity->getActivityDate()->getTimestamp(), $this->VALID_ACTIVITYDATE->getTimestamp());
	}


	/**
	 * test creating a Activity and then deleting it
	 **/
	public function testDeleteValidActivity() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("activity");

		// create a new Activity and insert to into mySQL
		$activityId = generateUuidV4();
		$activity = new Activity($activityId, $this->profile->getProfileId(), $this->VALID_ACTIVITYCONTENT, $this->VALID_ACTIVITYDATE);
		$activity->insert($this->getPDO());

		// delete the Activity from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activity"));
		$activity->delete($this->getPDO());

		// grab the data from mySQL and enforce the Activity does not exist
		$pdoActivity = Activity::getActivityByActivityId($this->getPDO(), $activity->getActivityId());
		$this->assertNull($pdoActivity);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("activity"));
	}

	/**
	 * test inserting a Activity and regrabbing it from mySQL
	 **/
	public function testGetValidActivityByActivityProfileId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("activity");

		// create a new Activity and insert to into mySQL
		$activityId = generateUuidV4();
		$activity = new Activity($activityId, $this->profile->getProfileId(), $this->VALID_ACTIVITYCONTENT, $this->VALID_ACTIVITYDATE);
		$activity->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Activity::getActivityByActivityProfileId($this->getPDO(), $activity->getActivityProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activity"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Activity", $results);

		// grab the result from the array and validate it
		$pdoActivity = $results[0];

		$this->assertEquals($pdoActivity->getActivityId(), $activityId);
		$this->assertEquals($pdoActivity->getActivityProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoActivity->getActivityContent(), $this->VALID_ACTIVITYCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoActivity->getActivityDate()->getTimestamp(), $this->VALID_ACTIVITYDATE->getTimestamp());
	}

	/**
	 * test grabbing a Activity by activity content
	 **/
	public function testGetValidActivityByActivityContent() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("activity");

		// create a new Activity and insert to into mySQL
		$activityId = generateUuidV4();
		$activity = new Activity($activityId, $this->profile->getProfileId(), $this->VALID_ACTIVITYCONTENT, $this->VALID_ACTIVITYDATE);
		$activity->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Activity::getActivityByActivityContent($this->getPDO(), $activity->getActivityContent());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activity"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Activity", $results);

		// grab the result from the array and validate it
		$pdoActivity = $results[0];
		$this->assertEquals($pdoActivity->getActivityId(), $activityId);
		$this->assertEquals($pdoActivity->getActivityProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoActivity->getActivityContent(), $this->VALID_ACTIVITYCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoActivity->getActivityDate()->getTimestamp(), $this->VALID_ACTIVITYDATE->getTimestamp());
	}

	/**
	 * test grabbing all Activitys
	 **/
	public function testGetAllValidActivitys() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("activity");

		// create a new Activity and insert to into mySQL
		$activityId = generateUuidV4();
		$activity = new Activity($activityId, $this->profile->getProfileId(), $this->VALID_ACTIVITYCONTENT, $this->VALID_ACTIVITYDATE);
		$activity->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Activity::getAllActivitys($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activity"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Activity", $results);

		// grab the result from the array and validate it
		$pdoActivity = $results[0];
		$this->assertEquals($pdoActivity->getActivityId(), $activityId);
		$this->assertEquals($pdoActivity->getActivityProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoActivity->getActivityContent(), $this->VALID_ACTIVITYCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoActivity->getActivityDate()->getTimestamp(), $this->VALID_ACTIVITYDATE->getTimestamp());
	}
}