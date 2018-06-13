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
	const FORMAT_V0 = '<{$facility_level}>{$timestamp_syslog_v0} {$host_name} {$app_name} [{$process_id}-{$message_id}]: {$message}{$context}';
	/** @var string - V1 format based on https://tools.ietf.org/html/rfc5424#section-6 */
	const FORMAT_V1 = '<{$facility_level}>{$version} {$timestamp} {$host_name} {$app_name} {$process_id} {$message_id} \xEF\xBB\xBF{$message}{$context}';
	/** @var string  */
	const FORMAT_LOCAL_SYSLOG = '{$app_name}[{$process_id}-{$message_id}]: {$message}{$context}';
}