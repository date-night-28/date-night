<?php
//namespace DateNight28\DateNight\Test;
//
//use DateNight28\DateNight\{Favorite};
////hack! -added for practice
//require_once(dirname(__DIR__) . "/Test/DateNightTest.php");
//
//// grab the uuid generator
//require_once(dirname(__DIR__, 2) . "/lib/uuid.php");
//
//class FavoriteTest extends DateNightTest {
//
//	private $VALID_FAVORITE_PROFILE_ID = "";
//	private $VALID_FAVORITE_ACTIVITY_ID = "";
//	/**
//	 * timestamp of the Favorite; this starts as null and is assigned later
//	 * @var \DateTime $VALID_FAVORITE_DATE
//	 **/
//	protected $VALID_FAVORITE_DATE = null;
//
///**
// * create dependent objects before running each test
// **/
//
//	public final function setUp() : void {
//		parent::setUp();
//		$this->VALID_FAVORITE_PROFILE_ID = bin2hex(random_bytes(16));
//		$this->VALID_FAVORITE_ACTIVITY_ID = bin2hex(random_bytes(16));
//
//		// calculate the date (just use the time the unit test was setup...)
//		$this->VALID_FAVORITE_DATE = new \DateTime();
//	}
//
//
//
//	public function testInsertValidFavorite() :void {
//		//this will get count of profile records in b before test is ran.
//		$numRows = $this->getConnection()->getRowCount("profile");
//
//		// create a new Favorite and insert to into mySQL
//		$favoriteProfileId = generateUuidV4()->toString();
//		$favoriteProfileId = new Favorite ($favoriteProfileId, $this->VALID_FAVORITE_PROFILE_ID, $this->VALID_FAVORITE_ACTIVITY_ID, $this->VALID_FAVORITE_DATE);
//
//		// grab the data from mySQL and enforce the fields match our expectations
//		$pdoFavorite = Favorite::getFavoriteByFavoriteProfileId($this->getPDO(), $favoriteProfileId->getFavoriteProfileId());
//		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
//		$this->assertEquals($pdoFavorite->getFavoriteProfileId(), $this->favoriteProfileId);
//		$this->assertEquals($pdoFavorite->getFavoriteProfileId(), $this->favorite->getProfileProfileId());
//		$this->assertEquals($pdoFavorite->getFavoriteActivity(), $this->VALID_FAVORITE_ACTIVITY_ID);
//		//format the date too seconds since the beginning of time to avoid round off error
//		$this->assertEquals($pdoFavorite->getFavoriteDate()->getTimestamp(), $this->VALID_FAVORITE_DATE->getTimestamp());
//
//
//		//get a copy of the record we inserted and validate the values
//		//make sure the values that went in the record are the same ones that come out.
//
//
//		$pdoFavoriteProfileId = Favorite::getFavoriteByFavoriteProfileId($this->getPDO(), $favoriteProfileId->getProfileId()->toString());
//		self::assertEquals($favoriteProfileId, $pdoFavorite->getFavoriteProfileId());
//		self::assertEquals($this->VALID_FAVORITE_PROFILE_ID, $pdoFavorite->getFavoriteProfileId());
//		self::assertEquals($this->VALID_FAVORITE_ACTIVITY_ID, $pdoFavorite->getFavoriteActivityId());
//		self::assertEquals($this->VALID_FAVORITE_DATE, $pdoFavorite->getFavoriteDate()->getTimeStamp());
//	}
//
//
//		/**
//		 * test grabbing a Favorite by Activity id
//		 **/
//		public
//		function testGetValidFavoriteByFavoriteActivityId(): void {
//			// count the number of rows and save it for later
//			$numRows = $this->getConnection()->getRowCount("favorite");
//
//			// create a new Favorite and insert to into mySQL
//			$favoriteActivityId = generateUuidV4();
//			$favoriteActivityId = new Favorite ($favoriteActivityId, $this->VALID_FAVORITE_PROFILE_ID, $this->VALID_FAVORITE_ACTIVITY_ID, $this->VALID_FAVORITE_DATE);
//			$favoriteActivityId->insert($this->getPDO());
//
//			// grab the data from mySQL and enforce the fields match our expectations
//			$results = FavoriteActivity::getFavoriteActivityByFavoriteActivityId($this->getPDO(), $favoriteActivityId->getFavoriteActivityId());
//			$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favoriteActivityId"));
//			$this->assertCount(1, $results);
//
//			// enforce no other objects are bleeding into the test
//			$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\FavoriteActivity", $results);
//
//			// grab the result from the array and validate it
//			$pdoFavoriteActivityId = $results[0];
//			$this->assertEquals($pdoFavoriteActivityId->getFavoriteActivityId(), $favoriteActivityId);
//			$this->assertEquals($pdoFavoriteProfileId->getFavoriteProfileId(), $this->profile->getProfileId());
//			//format the date too seconds since the beginning of time to avoid round off error
//			$this->assertEquals($pdoFavoriteDate->getFavoriteDate()->getTimestamp(), $this->VALID_FAVORITE_DATE->getTimestamp());
//		}
//	}
//
//	/**
//	 * test creating a Favorite and then deleting it
//	 **/
//	public function testDeleteValidFavorite() : void {
//		// count the number of rows and save it for later
//		$numRows = $this->getConnection()->getRowCount("favorite");
//
//		// create a new Favorite and insert to into mySQL
//		$favoriteActivityId = generateUuidV4();
//		$favorite = new Favorite($favoriteActivityId, $this->activity->getActivityId(), $this->VALID_FAVORITE_ACTIVITY_ID, $this->VALID_FAVORITE_DATE;
//		$favorite->insert($this->getPDO());
//
//		// delete the Favorite from mySQL
//		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
//		$favorite->delete($this->getPDO());
//
//		// grab the data from mySQL and enforce the Tweet does not exist
//		$pdoFavorite = Favorite::getFavoriteByFavoriteActivityId($this->getPDO(), $favorite->getFavoriteId());
//		$this->assertNull($pdoFavorite);
//		$this->assertEquals($numRows, $this->getConnection()->getRowCount("favorite"));
//	}
//}