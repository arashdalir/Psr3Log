<?php
/**
 * Created by PhpStorm.
 * User: ada
 * Date: 11-Jun-18
 * Time: 15:27
 */

namespace ArashDalir;

use ArashDalir\Foundation\AbstractLog;

class SysLog extends AbstractLog{
	protected $address;
	protected $port;
	protected $sock;
	protected $facility;
	protected $hostname = '';

	function init(){
		parent::init();
		static::$log_extra_format = '{$hostname} '. parent::$log_extra_format;
	}

	public function __construct($addr = null, $port = 514)
	{
		parent::__construct();
		$this->address = $addr;
		$this->port = $port;
		$this->sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
	}

	public function facility($facility)
	{
		if($facility < 0)
		{
			$facility = 0;
		}
		if($facility > 23)
		{
			$facility = 23;
		}

		$this->facility = $facility;
		return $this;
	}

	public function hostname($hostname)
	{
		$this->hostname = $hostname;
		return $this;
	}

	public function __destruct()
	{
		if($this->sock)
		{
			socket_close($this->sock);
		}
	}

	function send($msg, $flags = 0)
	{
		return socket_sendto($this->sock, $msg, strlen($msg), $flags, $this->address, $this->port);
	}

	function prepareLevel($level)
	{
		return ($this->facility << 3)|$this->$level;
	}

	function prepareLogExtra()
	{
		$parameters = parent::prepareLogExtra();
		$parameters["hostname"] = $this->hostname;

		return $parameters;
	}

	function prepareContext($context)
	{
		$context = parent::prepareContext($context);

		if ($context)
		{
			$context = "|{$context}";
		}

		return $context;
	}
}