<?php
/**
 * Created by PhpStorm.
 * User: ada
 * Date: 11-Jun-18
 * Time: 15:27
 */

namespace ArashDalir\Handler\SysLog;

use ArashDalir\Foundation\Psr3Log;

/**
 * Class SysLog
 *
 * @package ArashDalir\Handler\SysLog
 * @property SysLogMessage $log_message
 * @method SysLogMessage getLogMessage()
 */
class SysLog extends Psr3Log{
	protected $address;
	protected $port;
	private $log_connection;

	/**
	 * SysLog constructor.
	 *
	 * @param null $address
	 * @param null $port
	 *
	 * @throws Exception\InvalidFacilityException
	 */
	public function __construct($address = null, $port = null)
	{
		parent::__construct(SysLogMessage::class);

		if($address && is_null($port))
		{
			$port = 514;
		}

		$this->address = $address;
		$this->port = $port;

		$this->openSocket();

		$this->getLogMessage()
			->setFacility(LOG_USER);
	}

	public function __destruct()
	{
		if($this->log_connection)
		{
			if(!$this->address)
			{
				closelog();
			}
			else
			{
				socket_close($this->log_connection);
			}
		}

	}

	function openSocket()
	{
		if($this->address)
		{
			$this->log_connection = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
		}
	}

	/**
	 * @param      $facility
	 *
	 * @param bool $os_conform
	 *
	 * @return $this
	 * @throws Exception\InvalidFacilityException
	 */
	public function setFacility($facility, $os_conform = true)
	{
		$this->getLogMessage()
			->setFacility($facility, $os_conform);
		return $this;
	}

	/**
	 * @param SysLogMessage $message
	 * @param int           $flags
	 *
	 * @return bool|int|mixed
	 */
	function send($message, $flags = 0)
	{
		$message_string = (string)$message;

		if($this->address)
		{
			if(!$this->log_connection)
			{
				$this->openSocket();
			}
			return socket_sendto($this->log_connection, $message_string, strlen($message_string), $flags, $this->address, $this->port);
		}
		else
		{
			$cur_format = $message->getFormat();
			$message->setFormat(SysLogFormats::FORMAT_LOCAL_SYSLOG);
			$message_string = stripslashes((string)$message);
			$message->setFormat($cur_format);

			if(!$this->log_connection)
			{
				$this->log_connection = openlog(false, LOG_PID|LOG_PERROR|LOG_NDELAY, $message->getFacility(true));
			}

			return syslog($message->asString("level"), $message_string);
		}
	}
}