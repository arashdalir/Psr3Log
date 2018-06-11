<?php
/**
 * Created by PhpStorm.
 * User: ada
 * Date: 11-Jun-18
 * Time: 17:21
 */

namespace arashdalir\Handler\SysLog\Exception;

class InvalidFacilityException extends \Exception{
	function __construct($facility, $name)
	{
		$message = "Facility \"{$name} ({$facility})\" is not allowed.";

		if (defined("PHP_WINDOWS_VERSION_BUILD"))
		{
			$message .= " You are using PHP on \"".PHP_OS."\"! on Windows, only \"LOG_USER (".LOG_USER.")\" is allowed.";
		}
		parent::__construct($message);
	}
}