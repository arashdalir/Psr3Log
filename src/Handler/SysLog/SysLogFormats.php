<?php
/**
 * Created by PhpStorm.
 * User: ada
 * Date: 12-Jun-18
 * Time: 13:03
 */

namespace ArashDalir\Handler\SysLog;

class SysLogFormats{
	const FORMAT_DEFAULT = '<{$facility_level}>{$timestamp} {$host_name} {$app_name} {$process_id} {$message_id} {$message}{$context}';
}