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

//$secrets = new \Secrets("/etc/apache2/capstone-mysql/dncrew.ini");
//$pdo = $secrets->getPdoObject();

use DateNight28\DateNight\{DateNightTest, Favorite};

//fix url code

$favoriteProfileId = "74dce972-aa41-4681-93d8-09aba24b83c4";
$favoriteActivityId = "556d3923-dcbe-4477-88dd-183c110525d5";
$favoriteDate = "";

try {
	$favorite = new Favorite($favoriteProfileId, $favoriteActivityId, $favoriteDate);
	echo "<h1>" . $favorite->getFavoriteProfileId(), $favorite->getFavoriteActivityId(), $favorite->getFavoriteDate(). "</h1>";
}

catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
	$exceptionType = get_class($exception);
	var_dump($exception->getLine());
}
