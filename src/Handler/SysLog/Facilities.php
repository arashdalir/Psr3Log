<?php
/**
 * Created by PhpStorm.
 * User: ada
 * Date: 11-Jun-18
 * Time: 17:29
 */

namespace arashdalir\Handler\SysLog;

use ArashDalir\Handler\SysLog\Exception\InvalidFacilityException;

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
	);

	static function __callStatic($method, $args)
	{
		if(method_exists(static::class, $method))
		{
			static::init();
			return call_user_func(array(static::class, $method), $args);
		}
	}

	static function init()
	{
		if(!defined("PHP_WINDOWS_VERSION_BUILD"))
		{
			static::$facilities[LOG_LOCAL0] = 'log_local0';
			static::$facilities[LOG_LOCAL1] = 'log_local1';
			static::$facilities[LOG_LOCAL2] = 'log_local2';
			static::$facilities[LOG_LOCAL3] = 'log_local3';
			static::$facilities[LOG_LOCAL4] = 'log_local4';
			static::$facilities[LOG_LOCAL5] = 'log_local5';
			static::$facilities[LOG_LOCAL6] = 'log_local6';
			static::$facilities[LOG_LOCAL7] = 'log_local7';
		}
	}

	/**
	 * @param      $facility
	 *
	 * @param bool $validate_os_facilities
	 *
	 * @return bool
	 * @throws InvalidFacilityException
	 */
	static function isFacilityValid($facility, $validate_os_facilities = true)
	{
		$valid = false;

		if(isset(static::$facilities[$facility]))
		{
			$valid = true;
			if(defined("PHP_WINDOWS_VERSION_BUILD") && $validate_os_facilities)
			{
				if($facility != LOG_USER)
				{
					$valid = false;
				}
			}
		}

		if(!$valid)
		{
			throw new InvalidFacilityException($facility, static::facilityName($facility));
		}

		return $valid;
	}

	static function facilityName($facility)
	{
		$facility = static::$facilities[$facility];

		if(!$facility)
		{
			$facility = "UNKNOWN";
		}

		$facility = strtoupper($facility);

		return $facility;
	}
}