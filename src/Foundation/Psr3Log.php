<?php
/**
 * Created by PhpStorm.
 * User: ada
 * Date: 11-Jun-18
 * Time: 11:37
 *
 * ported version of https://github.com/lvht/udplog/ for php 5.6.30
 */

namespace ArashDalir\Foundation;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

abstract class Psr3Log implements LoggerInterface, ILog{
	/** @var LogMessage */
	protected $log_message = null;

	/**
	 * Psr3Log constructor.
	 *
	 * @param string $log_message_type
	 */
	public function __construct($log_message_type)
	{
		$this->log_message = new $log_message_type();
	}

	/**
	 * @return LogMessage
	 */
	public function getLogMessage(){
		return $this->log_message;
	}

	public function log($level, $message, array $context = array(), $timestamp = null)
	{
		$log_message = clone $this->log_message;
		$log_message
			->setTimestamp($timestamp)
			->setLevel($level)
			->setMessage($message)
			->setContext($context);
		$this->send($log_message);
	}

	public function emergency($message, array $context = array())
	{
		$this->log(LogLevel::EMERGENCY, $message, $context);
	}

	public function alert($message, array $context = array())
	{
		$this->log(LogLevel::ALERT, $message, $context);
	}

	public function critical($message, array $context = array())
	{
		$this->log(LogLevel::CRITICAL, $message, $context);
	}

	public function error($message, array $context = array())
	{
		$this->log(LogLevel::ERROR, $message, $context);
	}

	public function warning($message, array $context = array())
	{
		$this->log(LogLevel::WARNING, $message, $context);
	}

	public function notice($message, array $context = array())
	{
		$this->log(LogLevel::NOTICE, $message, $context);
	}

	public function info($message, array $context = array())
	{
		$this->log(LogLevel::INFO, $message, $context);
	}

	public function debug($message, array $context = array())
	{
		$this->log(LogLevel::DEBUG, $message, $context);
	}
}