<?php
/**phase2
 *
 * PDO-METHODS
 * Write these in the Profile.php file.
 * Write and Document an insert statement method
 * Write and Document an update statement method
 * Write and Document a delete statement method.
 * Write and document a getFooByBar method that returns a single object
 * Write and document a getFooByBar method that returns a full array
 */


require_once dirname(__DIR__, 1) . "/Classes/autoload.php";
require_once(dirname(__DIR__) . "/Classes/autoload.php");
//require_once("/etc/apache2/capstone-mysql/Secrets.php");
//require("uuid.php");

//$secrets = new \Secrets("/etc/apache2/capstone-mysql/ddctwitter.ini");
//$pdo = $secrets->getPdoObject();

use DateNight28\DateNight\{DateNightTest, Profile};

//fix url code

$profileId = "74dce972-aa41-4681-93d8-09aba24b83c4";
$profileActivationToken = "556d3923-dcbe-4477-88dd-183c110525d5";
$profileEmail = "anyemail@none.com";
$profileHash = password_hash("mypw123", PASSWORD_ARGON2ID, ["time_cost" => 9]);
$profileName = "anyname";
try {
	$profile = new Profile($profileId, $profileActivationToken, $profileEmail, $profileHash, $profileName);
	echo "<h1>" . $profile->getProfileName() . "</h1>";
}

catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
	$exceptionType = get_class($exception);
	var_dump($exception->getLine());
}
