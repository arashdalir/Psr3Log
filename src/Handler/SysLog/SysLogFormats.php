<?php
/**
 * Created by PhpStorm.
 * User: ada
 * Date: 12-Jun-18
 * Time: 13:03
 */

namespace ArashDalir\Handler\SysLog;

class SysLogFormats{
	/** @var string - default format based on https://www.ietf.org/rfc/rfc3164.txt (<PRI>HEADER MSG where HEADER = {TIMESTAMP HOSTNAME} AND MSG = {TAG MESSAGE} */
	const FORMAT_DEFAULT = '<{$facility_level}>{$timestamp_syslog} {$host_name} {$app_name} [{$process_id}-{$message_id}]: {$message}{$context}';
	const FORMAT_LOCAL_SYSLOG = '{$app_name}[{$process_id}-{$message_id}]: {$message}{$context}';
}