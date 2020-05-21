<?php

namespace DateNight28\DateNight\Test;

use DateNight28\DateNight\{Activity};

//hack! -added for practice

//require_once(dirname(__DIR__) . "/Test/DateNightTest.php");

// grab the uuid generator

require_once(dirname(__DIR__) . "/autoload.php");

require_once(dirname(__DIR__, 2) . "/lib/uuid.php");


class ActivityTest extends DateNightTest {


	protected $VALID_ACTIVITY_ID;
	protected $VALID_ACTIVITY_IMAGE_URl = "https://s3-media4.fl.yelpcdn.com/bphoto/vlwEQaAWuHi-WZxZp_gKXw/o.jpg";
	protected $VALID_ACTIVITY_LAT = 35.095403;
	protected $VALID_ACTIVITY_LINK = "https://www.yelp.com/biz/cocina-azul-albuquerque-2?adjust_creative=_DZJDjcOvE6RksaUKr-uvA&utm_campaign=yelp_api_v3&utm_medium=api_v3_business_lookup&utm_source=_DZJDjcOvE6RksaUKr-uvA";
	protected $VALID_ACTIVITY_LNG = -106.658516;
	protected $VALID_ACTIVITY_TITLE = "Cocina Azul";

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp()  : void {
		parent::setUp();
	}

	/**
	 * test inserting a valid Activity and verify that the actual mySQL data matches
	 **/
	public function testInsertValidActivity() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("activity");

		// create a new Activity and insert to into mySQL
		$activityId = generateUuidV4()->toString();
		$activity = new Activity($activityId, $this->VALID_ACTIVITY_IMAGE_URl, $this->VALID_ACTIVITY_LAT, $this->VALID_ACTIVITY_LINK, $this->VALID_ACTIVITY_LNG, $this->VALID_ACTIVITY_TITLE);
		$activity->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoActivity = Activity::getActivityByActivityId($this->getPDO(), $activity->getActivityId()->toString());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activity"));
		$this->assertEquals($pdoActivity->getActivityId(), $activityId);
		$this->assertEquals($pdoActivity->getActivityImageUrl(), $this->VALID_ACTIVITY_IMAGE_URl);
		$this->assertEquals($pdoActivity->getActivityLat(), $this->VALID_ACTIVITY_LAT);
		$this->assertEquals($pdoActivity->getActivityLink(), $this->VALID_ACTIVITY_LINK);
		$this->assertEquals($pdoActivity->getActivityLng(), $this->VALID_ACTIVITY_LNG);
		$this->assertEquals($pdoActivity->getActivityTitle(), $this->VALID_ACTIVITY_TITLE);
	}

	/**
	 * test inserting a Activity, editing it, and then updating it
	 **/
	public function testUpdateValidActivity() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("activity");

		// create a new Activity and insert to into mySQL
		$activityId = generateUuidV4()->toString();
		$activity = new Activity($activityId, $this->VALID_ACTIVITY_IMAGE_URl, $this->VALID_ACTIVITY_LAT, $this->VALID_ACTIVITY_LINK, $this->VALID_ACTIVITY_LNG, $this->VALID_ACTIVITY_TITLE);
		$activity->insert($this->getPDO());

		// edit the Activity and update it in mySQL
		$activity->setActivityImageUrl($this->VALID_ACTIVITY_IMAGE_URl);
		$activity->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoActivity = Activity::getActivityByActivityId($this->getPDO(), $activity->getActivityId()->toString());
		$this->assertEquals($pdoActivity->getActivityId(), $activityId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activity"));
		$this->assertEquals($pdoActivity->getActivityImageUrl(), $this->VALID_ACTIVITY_IMAGE_URl);
		$this->assertEquals($pdoActivity->getActivityLat(), $this->VALID_ACTIVITY_LAT);
		$this->assertEquals($pdoActivity->getActivityLink(), $this->VALID_ACTIVITY_LINK);
		$this->assertEquals($pdoActivity->getActivityLng(), $this->VALID_ACTIVITY_LNG);
		$this->assertEquals($pdoActivity->getActivityTitle(), $this->VALID_ACTIVITY_TITLE);
	}


	/**
	 * test creating a Activity and then deleting it
	 **/
	public function testDeleteValidActivity() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("activity");

		// create a new Activity and insert to into mySQL
		$activityId = generateUuidV4()->toString();
		$activity = new Activity($activityId, $this->VALID_ACTIVITY_IMAGE_URl, $this->VALID_ACTIVITY_LAT, $this->VALID_ACTIVITY_LINK, $this->VALID_ACTIVITY_LNG, $this->VALID_ACTIVITY_TITLE);
		$activity->insert($this->getPDO());

		// delete the Activity from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activity"));
		$activity->delete($this->getPDO());

		// grab the data from mySQL and enforce the Activity does not exist
		$pdoActivity = Activity::getActivityByActivityId($this->getPDO(), $activity->getActivityId()->toString());
		$this->assertNull($pdoActivity);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("activity"));
	}

	/**
	 * test inserting a Activity and regrabbing it from mySQL
	 **/
	public function testGetValidActivityByActivityId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("activity");

		// create a new Activity and insert to into mySQL
		$activityId = generateUuidV4()->toString();
		$activity = new Activity($activityId, $this->VALID_ACTIVITY_IMAGE_URl, $this->VALID_ACTIVITY_LAT, $this->VALID_ACTIVITY_LINK, $this->VALID_ACTIVITY_LNG, $this->VALID_ACTIVITY_TITLE);
		$activity->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoActivity = Activity::getActivityByActivityId($this->getPDO(), $activity->getActivityId()->toString());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activity"));

		$this->assertEquals($pdoActivity->getActivityId(), $activityId);
		$this->assertEquals($pdoActivity->getActivityImageUrl(), $this->VALID_ACTIVITY_IMAGE_URl);
		$this->assertEquals($pdoActivity->getActivityLat(), $this->VALID_ACTIVITY_LAT);
		$this->assertEquals($pdoActivity->getActivityLink(), $this->VALID_ACTIVITY_LINK);
		$this->assertEquals($pdoActivity->getActivityLng(), $this->VALID_ACTIVITY_LNG);
		$this->assertEquals($pdoActivity->getActivityTitle(), $this->VALID_ACTIVITY_TITLE);
	}


//probably not needed
//	/**
//	 * test grabbing a Activity by activity image url
//	 **/
//	public function testGetValidActivityByActivityImageUrl() : void {
//		// count the number of rows and save it for later
//		$numRows = $this->getConnection()->getRowCount("activity");
//
//		// create a new Activity and insert to into mySQL
//		$activityId = generateUuidV4()->toString();
//		$activity = new Activity($activityId, $this->VALID_ACTIVITY_IMAGE_URl, $this->VALID_ACTIVITY_LAT, $this->VALID_ACTIVITY_LINK, $this->VALID_ACTIVITY_LNG, $this->VALID_ACTIVITY_TITLE);
//		$activity->insert($this->getPDO());
//
//		// grab the data from mySQL and enforce the fields match our expectations
//		$results = Activity::getActivityByActivityImageUrl($this->getPDO(), $activity->getActivityImageUrl());
//		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activity"));
//		$this->assertCount(1, $results);
//
//		// enforce no other objects are bleeding into the test
//		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DateNight\\Activity", $results);
//
//
//
//		$pdoActivity = $results[0];
//
//		$this->assertEquals($pdoActivity->getActivityId(), $activityId);
//		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activity"));
//		$this->assertEquals($pdoActivity->getActivityImageUrl(), $this->VALID_ACTIVITY_IMAGE_URl);
//		$this->assertEquals($pdoActivity->getActivityLat(), $this->VALID_ACTIVITY_LAT);
//		$this->assertEquals($pdoActivity->getActivityLink(), $this->VALID_ACTIVITY_LINK);
//		$this->assertEquals($pdoActivity->getActivityLng(), $this->VALID_ACTIVITY_LNG);
//		$this->assertEquals($pdoActivity->getActivityTitle(), $this->VALID_ACTIVITY_TITLE);
//	}

//	/**
//	 * test grabbing a Activity by activity Lat
//	 **/
//	public function testGetValidActivityByActivityLat() : void {
//		// count the number of rows and save it for later
//		$numRows = $this->getConnection()->getRowCount("activity");
//
//		// create a new Activity and insert to into mySQL
//		$activityId = generateUuidV4();
//		$activity = new Activity($activityId, $this->VALID_ACTIVITY_IMAGE_URl, $this->VALID_ACTIVITY_LAT, $this->VALID_ACTIVITY_LINK, $this->VALID_ACTIVITY_LNG, $this->VALID_ACTIVITY_TITLE);
//		$activity->insert($this->getPDO());
//
//		// grab the data from mySQL and enforce the fields match our expectations
//		$results = Activity::getActivityByActivityLat($this->getPDO(), $activity->getActivityLat());
//		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activity"));
//		$this->assertCount(1, $results);
//
//		// enforce no other objects are bleeding into the test
//		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DateNight\\Activity", $results);
//
//
//
//		$pdoActivity = $results[0];
//
//		$this->assertEquals($pdoActivity->getActivityId(), $activityId);
//		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activity"));
//		$this->assertEquals($pdoActivity->getActivityImageUrl(), $this->VALID_ACTIVITY_IMAGE_URl);
//		$this->assertEquals($pdoActivity->getActivityLat(), $this->VALID_ACTIVITY_LAT);
//		$this->assertEquals($pdoActivity->getActivityLink(), $this->VALID_ACTIVITY_LINK);
//		$this->assertEquals($pdoActivity->getActivityLng(), $this->VALID_ACTIVITY_LNG);
//		$this->assertEquals($pdoActivity->getActivityTitle(), $this->VALID_ACTIVITY_TITLE);
//	}
//
//	/**
//	 * test grabbing a Activity by activity Link
//	 **/
//	public function testGetValidActivityByActivityLink() : void {
//		// count the number of rows and save it for later
//		$numRows = $this->getConnection()->getRowCount("activity");
//
//		// create a new Activity and insert to into mySQL
//		$activityId = generateUuidV4();
//		$activity = new Activity($activityId, $this->VALID_ACTIVITY_IMAGE_URl, $this->VALID_ACTIVITY_LAT, $this->VALID_ACTIVITY_LINK, $this->VALID_ACTIVITY_LNG, $this->VALID_ACTIVITY_TITLE);
//		$activity->insert($this->getPDO());
//
//		// grab the data from mySQL and enforce the fields match our expectations
//		$results = Activity::getActivityByActivityLink($this->getPDO(), $activity->getActivityLink());
//		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activity"));
//		$this->assertCount(1, $results);
//
//		// enforce no other objects are bleeding into the test
//		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DateNight\\Activity", $results);
//
//
//
//		$pdoActivity = $results[0];
//
//		$this->assertEquals($pdoActivity->getActivityId(), $activityId);
//		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activity"));
//		$this->assertEquals($pdoActivity->getActivityImageUrl(), $this->VALID_ACTIVITY_IMAGE_URl);
//		$this->assertEquals($pdoActivity->getActivityLat(), $this->VALID_ACTIVITY_LAT);
//		$this->assertEquals($pdoActivity->getActivityLink(), $this->VALID_ACTIVITY_LINK);
//		$this->assertEquals($pdoActivity->getActivityLng(), $this->VALID_ACTIVITY_LNG);
//		$this->assertEquals($pdoActivity->getActivityTitle(), $this->VALID_ACTIVITY_TITLE);
//	}
//
//	/**
//	 * test grabbing a Activity by activity Lng
//	 **/
//	public function testGetValidActivityByActivityLng() : void {
//		// count the number of rows and save it for later
//		$numRows = $this->getConnection()->getRowCount("activity");
//
//		// create a new Activity and insert to into mySQL
//		$activityId = generateUuidV4();
//		$activity = new Activity($activityId, $this->VALID_ACTIVITY_IMAGE_URl, $this->VALID_ACTIVITY_LAT, $this->VALID_ACTIVITY_LINK, $this->VALID_ACTIVITY_LNG, $this->VALID_ACTIVITY_TITLE);
//		$activity->insert($this->getPDO());
//
//		// grab the data from mySQL and enforce the fields match our expectations
//		$results = Activity::getActivityByActivityLng($this->getPDO(), $activity->getActivityLng());
//		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activity"));
//		$this->assertCount(1, $results);
//
//		// enforce no other objects are bleeding into the test
//		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DateNight\\Activity", $results);
//
//
//
//		$pdoActivity = $results[0];
//
//		$this->assertEquals($pdoActivity->getActivityId(), $activityId);
//		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activity"));
//		$this->assertEquals($pdoActivity->getActivityImageUrl(), $this->VALID_ACTIVITY_IMAGE_URl);
//		$this->assertEquals($pdoActivity->getActivityLat(), $this->VALID_ACTIVITY_LAT);
//		$this->assertEquals($pdoActivity->getActivityLink(), $this->VALID_ACTIVITY_LINK);
//		$this->assertEquals($pdoActivity->getActivityLng(), $this->VALID_ACTIVITY_LNG);
//		$this->assertEquals($pdoActivity->getActivityTitle(), $this->VALID_ACTIVITY_TITLE);
//	}
//
	/**
	 * test grabbing a Activity by activity Title
	 **/
	public function testGetValidActivityByActivityTitle() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("activity");

		// create a new Activity and insert to into mySQL
		$activityId = generateUuidV4()->toString();
		$activity = new Activity($activityId, $this->VALID_ACTIVITY_IMAGE_URl, $this->VALID_ACTIVITY_LAT, $this->VALID_ACTIVITY_LINK, $this->VALID_ACTIVITY_LNG, $this->VALID_ACTIVITY_TITLE);
		$activity->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Activity::getActivityByActivityTitle($this->getPDO(), $activity->getActivityTitle());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activity"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("DateNight28\\DateNight\\Activity", $results);



		$pdoActivity = $results[0];

		$this->assertEquals($pdoActivity->getActivityId(), $activityId);
		$this->assertEquals($pdoActivity->getActivityImageUrl(), $this->VALID_ACTIVITY_IMAGE_URl);
		$this->assertEquals($pdoActivity->getActivityLat(), $this->VALID_ACTIVITY_LAT);
		$this->assertEquals($pdoActivity->getActivityLink(), $this->VALID_ACTIVITY_LINK);
		$this->assertEquals($pdoActivity->getActivityLng(), $this->VALID_ACTIVITY_LNG);
		$this->assertEquals($pdoActivity->getActivityTitle(), $this->VALID_ACTIVITY_TITLE);
	}
// probably not needed
//	/**
//	 * test grabbing all Activities
//	 **/
//	public function testGetAllValidActivities() : void {
//		// count the number of rows and save it for later
//		$numRows = $this->getConnection()->getRowCount("activity");
//
//		// create a new Activity and insert to into mySQL
//		$activityId = generateUuidV4();
//		$activity = new Activity($activityId, $this->VALID_ACTIVITY_IMAGE_URl, $this->VALID_ACTIVITY_LAT, $this->VALID_ACTIVITY_LINK, $this->VALID_ACTIVITY_LNG, $this->VALID_ACTIVITY_TITLE);
//		$activity->insert($this->getPDO());
//
//		// grab the data from mySQL and enforce the fields match our expectations
//		$results = Activity::getAllActivities($this->getPDO());
//		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activity"));
//		$this->assertCount(1, $results);
//		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Activity", $results);
//
//
//		$pdoActivity = $results[0];
//
//		$this->assertEquals($pdoActivity->getActivityId(), $activityId);
//		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activity"));
//		$this->assertEquals($pdoActivity->getActivityImageUrl(), $this->VALID_ACTIVITY_IMAGE_URl);
//		$this->assertEquals($pdoActivity->getActivityLat(), $this->VALID_ACTIVITY_LAT);
//		$this->assertEquals($pdoActivity->getActivityLink(), $this->VALID_ACTIVITY_LINK);
//		$this->assertEquals($pdoActivity->getActivityLng(), $this->VALID_ACTIVITY_LNG);
//		$this->assertEquals($pdoActivity->getActivityTitle(), $this->VALID_ACTIVITY_TITLE);
//	}
}