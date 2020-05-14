<?php
namespace DateNight28\DateNight\Test;

use DateNight28\DateNight\{Favorite, Profile, Activity};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

class FavoriteTest extends DateNightTest {

	private $profile = null;
	private $activity = null;
	/**
	 * timestamp of the Favorite; this starts as null and is assigned later
	 * @var \DateTime $VALID_FAVORITE_DATE
	 **/
	protected $VALID_FAVORITE_DATE = null;

	/**
	 * create dependent objects before running each test
	 **/

	public final function setUp(): void {
		parent::setUp();

		$VALID_PROFILE_EMAIL = "gabrielaveloz@yahoo.com";
		$VALID_PROFILE_NAME = "gaby veloz";

		$password = "abc1234";
		$VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 8]);
		$VALID_ACTIVATION_TOKEN = bin2hex(random_bytes(16));

//insert ab profile record in db
		$profileId = generateUuidV4()->toString();
		$this->profile = new Profile($profileId, $VALID_ACTIVATION_TOKEN, $VALID_PROFILE_EMAIL, $VALID_PROFILE_HASH, $VALID_PROFILE_NAME);
		$this->profile->insert($this->getPDO());

		$VALID_ACTIVITY_IMAGE_URl = "https://s3-media4.fl.yelpcdn.com/bphoto/vlwEQaAWuHi-WZxZp_gKXw/o.jpg";
		$VALID_ACTIVITY_LAT = 35.095403;
		$VALID_ACTIVITY_LINK = "https://www.yelp.com/biz/cocina-azul-albuquerque-2?adjust_creative=_DZJDjcOvE6RksaUKr-uvA&utm_campaign=yelp_api_v3&utm_medium=api_v3_business_lookup&utm_source=_DZJDjcOvE6RksaUKr-uvA";
		$VALID_ACTIVITY_LNG = -106.658516;
		$VALID_ACTIVITY_TITLE = "Cocina Azul";

// create a new Activity and insert to into mySQL
		$activityId = generateUuidV4()->toString();
		$this->activity = new Activity($activityId, $VALID_ACTIVITY_IMAGE_URl, $VALID_ACTIVITY_LAT, $VALID_ACTIVITY_LINK, $VALID_ACTIVITY_LNG, $VALID_ACTIVITY_TITLE);
		$this->activity->insert($this->getPDO());

		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_FAVORITE_DATE = new \DateTime();
	}


	public function testInsertValidFavorite(): void {
		//this will get count of profile records in b before test is ran.
		$numRows = $this->getConnection()->getRowCount("favorite");

		// create a new Favorite and insert to into mySQL
		$favorite = new Favorite ($this->profile->getProfileId()->toString(), $this->activity->getActivityId()->toString(), $this->VALID_FAVORITE_DATE);
		$favorite->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Favorite::getFavoriteByFavoriteProfileId($this->getPDO(), $this->profile->getProfileId()->toString());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("DateNight28\\DateNight\\Favorite", $results);

		// grab the result from the array and validate it
		$pdoFavorite = $results[0];

		// grab the data from mySQL and enforce the fields match our expectations
		$this->assertEquals($pdoFavorite->getFavoriteProfileId(), $favorite->getFavoriteProfileId());
		$this->assertEquals($pdoFavorite->getFavoriteActivityId(), $favorite->getFavoriteActivityId());
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoFavorite->getFavoriteDate()->getTimestamp(), $favorite->getFavoriteDate()->getTimestamp());
	}


	/**
	 * test inserting a Favorite and regrabbing it from mySQL
	 **/
	public function testGetValidFavoriteByFavoriteActivityIdAndFavoriteProfileId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");

		// create a new Like and insert to into mySQL
		$favorite = new Favorite ($this->profile->getProfileId()->toString(), $this->activity->getActivityId()->toString(), $this->VALID_FAVORITE_DATE);
		$favorite->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoFavorite = Favorite::getFavoriteByFavoriteActivityIdAndFavoriteProfileId($this->getPDO(), $favorite->getFavoriteProfileId(), $favorite->getFavoriteActivityId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertEquals($pdoFavorite->getFavoriteProfileId(), $favorite->getFavoriteProfileId());
		$this->assertEquals($pdoFavorite->getFavoriteActivityId(), $favorite->getFavoriteActivityId());

		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoFavorite->getFavoriteDate()->getTimestamp(), $favorite->getFavoriteDate()->getTimestamp());
	}


		/**
		 * test grabbing a Favorite by Activity id
		 **/
		public
		function testGetValidFavoriteByFavoriteActivityId(): void {
			// count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("favorite");

			// create a new Favorite and insert to into mySQL
			$favorite = new Favorite ($this->profile->getProfileId()->toString(), $this->activity->getActivityId()->toString(), $this->VALID_FAVORITE_DATE);
			$favorite->insert($this->getPDO());

			// grab the data from mySQL and enforce the fields match our expectations
			$results = Favorite::getFavoriteByFavoriteActivityId($this->getPDO(), $favorite->getFavoriteActivityId()->toString());
			$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
			$this->assertCount(1, $results);

			// enforce no other objects are bleeding into the test
			$this->assertContainsOnlyInstancesOf("DateNight28\\DateNight\\Favorite", $results);

			// grab the result from the array and validate it
			$pdoFavorite = $results[0];
			$this->assertEquals($pdoFavorite->getFavoriteActivityId(), $favorite->getFavoriteActivityId());
			$this->assertEquals($pdoFavorite->getFavoriteProfileId(), $favorite->getFavoriteProfileId());
			//format the date too seconds since the beginning of time to avoid round off error
			$this->assertEquals($pdoFavorite->getFavoriteDate()->getTimestamp(), $favorite->getFavoriteDate()->getTimestamp());


		}

	/**
	 * test creating a Favorite and then deleting it
	 **/
	public function testDeleteValidFavorite() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");

		// create a new Favorite and insert to into mySQL
		$favorite = new Favorite ($this->profile->getProfileId()->toString(), $this->activity->getActivityId()->toString(), $this->VALID_FAVORITE_DATE);
		$favorite->insert($this->getPDO());

		// delete the Favorite from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$favorite->deleteFavoriteByProfileIdAndActivityId($this->getPDO());

		// grab the data from mySQL and enforce the favorite does not exist
		$results = Favorite::getFavoriteByFavoriteActivityId($this->getPDO(), $favorite->getFavoriteActivityId());
		$this->assertCount(0, $results);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("favorite"));
	}
}