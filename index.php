<?php
/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @link https://github.com/ammarfaizi2/prgc2
 */
$f = implode(",", array_filter(get_defined_functions()["internal"], function ($f) {
	return ! in_array($f, ["show_source", "get_class", "json_encode", "header", "is_numeric", "preg_match"]);
}));

define("FX", rand(0, 1024));
define("FY", rand(1025, 2048));
define("FZ", rand(2049, 4096));

ini_set("display_errors", true);
ini_set("disable_functions", $f);

if (isset($_POST["x"], $_FILES["y"]["tmp_name"], $_POST["z"])) {
	header("Content-type:text/plain");
	
	interface PrgcContract {} 

	if (anti_cheat_system(file_get_contents($_FILES["y"]["tmp_name"]))) 
		exit("exit 0: Cheat");
	

	if (! is_numeric($_POST["z"]) || $_FILES["y"]["name"] !== $_POST["z"]) 
		exit("exit 1: \$_POST[\"z\"] must be numeric and file name must be equals to \$_POST[\"z\"].");

	include $_FILES["y"]["tmp_name"];
	$_POST["x"] = new $_POST["x"];

	if (! ($_POST["x"] instanceof PrgcContract)) 
		exit(get_class($_POST["x"])." must be implements PrgcContract interface!");

	if ($_POST["x"]->a !== 1 || $_POST["x"]->a !== 2 || $_POST["x"]->a !== 3) 
		exit("exit 2: ???");

	if ($_POST["x"]->a !== FX || $_POST["x"]->a !== FY || $_POST["x"]->a !== FZ) 
		exit("exit 3: ???");

	if ($_POST["x"]->b !== ($_POST["x"]->b + $_POST["x"]->a) || $_POST["x"]->b === substr("abcdefg", 2, 3))
		exit("exit 4: ???");

	if ($_POST["x"]->c !== "\x70" || $_POST["x"]->c !== '\x70' || $_POST["x"]->c !== '{$_POST[x]->e}')
		exit("exit 5: ???");

	try {
		class PrgcException extends \Exception {}
		$_POST["x"]->go();
	} catch (PrgcException $e) {
		$f0 = "abc123";
		$f1 = $_POST["z"];
		$f2 = $_POST["z"].FX.FY.FZ;
		$rr = str_repeat((string) rand(1, 9), 1000);
		$cc = $_POST["x"]($rr);
		for($i=0;$i<1000;$i++){
			$cc = substr($rr, 0, 1000 - $i) === $_POST["x"]() && $cc;
		}
		if ($cc && $_POST["x"]->{$f0}()->{$f1}()->{$f2}() === 123) {
			if (json_encode($_POST["x"]["?"]) === json_encode([1, 2, 3])) {
				$_POST["x"]->amp($e);
				if ($_POST["x"]["y"]["z"] instanceof PrgcException) {
					$_POST["x"]["y"]["z"] = $_POST["x"]();
					if ($_POST["x"]["y"]["z"]() === 123) {
						if ($_POST["x"]["y"]["z"]() === 456) {
							if ($_POST["x"]["y"]["z"]() === 789) {
								if (get_class($_POST["x"]["?"]) === get_class($_POST["x"])) {
									include "^"; // The next instructions will be shown at this point.
									exit();
								}
							}
						}
					}
				}
				exit("exit 8: ???");
			}
		}
		exit("exit 7: ???");
	}
	exit("exit 6: You must throw an instance of PrgcException.");
} else {
	echo PHP_VERSION . "<br/>";
	show_source(__FILE__);
}


function anti_cheat_system($s)
{
	// Prevent you to include the next instructions file directly.
	// For example when you are upload this code:
	/*
		<?php
		include "^";
	
		<?php
		include "\x5e";

		<?php
		echo file_get_contents("^");

		<?php
		// You should have to know that eval isn't a function. 
		// So you can't disable eval from php.ini or ini_set.
		eval('$a = "\x'.'5e";'); 
		include $a;

	*/
	return preg_match("/(eval|\^|x5e|include|require)/i", $s);
}