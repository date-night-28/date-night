<?php
require_once(dirname(__DIR__, 1) . "/Classes/Activity.php");
require_once("uuid.php");
require_once("yelpconfigs.php");

use DateNight28\DateNight\Activity;

// The pdo object has been created for you.
require_once("/etc/apache2/capstone-mysql/Secrets.php");
$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort28/dncrew.ini");
$pdo = $secrets->getPdoObject();

//cURL - https://www.php.net/manual/en/function.curl-setopt.php
//$yelpToken is in a separate configs.php file that is not committed to github.
$authorization = "Authorization: Bearer " . $yelpToken;

$searchTerms = ["activity", "restaurants", "events"];

foreach ($searchTerms as $searchTerm) {


	for($offset = 0; $offset < 100; $offset = $offset + 20) {

		$ch = curl_init('https://api.yelp.com/v3/businesses/search?term=' . $searchTerm .'&location=NM&offset=' . $offset);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);

//		if (!json_decode($result)->error) {


		$businesses = json_decode($result)->businesses;

		foreach($businesses as $business) {
			if (!($business->coordinates->latitude == null)) {
				echo($business->id . "<br>");
				echo($business->name . "<br>");
				echo($business->url . "<br>");
				echo($business->coordinates->latitude . "<br>");
				echo($business->coordinates->longitude . "<br>");
				echo "<br>";

				$activity = new Activity(generateUuidV4()->toString(), $business->image_url, $business->coordinates->latitude, $business->url, $business->coordinates->longitude, $business->name);
				$activity->insert($pdo);
			}
		}
		}
//	}
}