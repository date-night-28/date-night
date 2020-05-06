<?php
/**phase2
 *
 * PDO-METHODS
 * Write these in the Activity.php file.
 * Write and Document an insert statement method
 * Write and Document an update statement method
 * Write and Document a delete statement method.
 * Write and document a getFooByBar method that returns a single object
 * Write and document a getFooByBar method that returns a full array
 */


require_once dirname(__DIR__, 1) . "Classes/autoload.php";
//require_once("/etc/apache2/capstone-mysql/Secrets.php");
//require("uuid.php");

//$secrets = new Secrets("/etc/apache2/capstone-mysql/cohort28/dncrew.ini”);
//$pdo = $secrets->getPdoObject();

use DateNight28\DateNight\{DateNightTest, Activity};

//fix url code

$activityId = "461e6eb7-ec9e-4c29-9be8-7ccab29f3185";
$activityImageUrl = "";
$activityLat = "";
$activityLink = "";
$activityLng = "";
$activityTitle ="";


try {
	$activity = new Activity($activityId, $activityImageUrl, $activityLat, $activityLink, $activityLng, $activityTitle);
	echo "<h1>" . $activity->getActivityTitle() . "</h1>";
}

catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
	$exceptionType = get_class($exception);
	var_dump($exception->getLine());
}

