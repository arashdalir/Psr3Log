<?php
/**
 * Created by PhpStorm.
 * User: ada
 * Date: 11-Jun-18
 * Time: 17:29
 */

namespace arashdalir\Handler\SysLog;

use arashdalir\Handler\SysLog\Exception\InvalidFacilityException;

final class Facilities{
	static protected $facilities = array(
		LOG_AUTH => 'log_auth',
		LOG_AUTHPRIV => 'log_authpriv',
		LOG_CRON => 'log_cron',
		LOG_DAEMON => 'log_daemon',
		LOG_KERN => 'log_kern',
		LOG_LPR => 'log_lpr',
		LOG_MAIL => 'log_mail',
		LOG_NEWS => 'log_news',
		LOG_SYSLOG => 'log_syslog',
		LOG_USER => 'log_user',
		LOG_UUCP => 'log_uucp',
		LOG_LOCAL0 => 'log_local0',
		LOG_LOCAL1 => 'log_local1',
		LOG_LOCAL2 => 'log_local2',
		LOG_LOCAL3 => 'log_local3',
		LOG_LOCAL4 => 'log_local4',
		LOG_LOCAL5 => 'log_local5',
		LOG_LOCAL6 => 'log_local6',
		LOG_LOCAL7 => 'log_local7',
	);

	/**
	 * @param $facility
	 *
	 * @return bool
	 * @throws InvalidFacilityException
	 */
	static function isFacilityValid($facility)
	{
		$valid = false;

		if(isset(static::$facilities[$facility]))
		{
			$valid = true;
			if(defined("PHP_WINDOWS_VERSION_BUILD"))
			{
				if($facility != LOG_USER)
				{
					$valid = false;
				}
			}
		}

		if (!$valid)
		{
			throw new InvalidFacilityException($facility, static::facilityName($facility));
		}

		return $valid;
	}

	static function facilityName($facility)
	{
		$facility = static::$facilities[$facility];

		if (!$facility)
		{
			$facility = "UNKNOWN";
		}

		$facility = strtoupper($facility);

		return $facility;
	}
}