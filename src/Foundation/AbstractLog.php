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

abstract class AbstractLog implements LoggerInterface, ILog{
	protected static $log_extra_format;

	public static $formats = array();

	protected $appname = '';
	protected $procid = '';
	protected $msgid = '';
	protected $format = null;
	protected $autoMsgId = false;

	function init(){
		static::$log_extra_format = '{$appname} {$procid} {$msgid}';
		static::$formats = array(
			"default" => '<{$level}>{$timestamp} {$log_extra} {$message} {$context}',
		);
	}
	public function __construct()
	{
		$this->init();
		$this->format(static::$formats["default"]);
	}

	/**
	 *
	 * @param null|int $begin -- if null, autoMsgId is deactivated, otherwise, the integer is used as base for automatic message ID counter
	 */
	function autoMsgId($begin = null)
	{
		$this->autoMsgId = $begin;
	}

	function format($format)
	{
		$this->format = $format;
	}

	public function appname($appname)
	{
		$this->appname = $appname;
		return $this;
	}

	public function procid($procid)
	{
		$this->procid = $procid;
		return $this;
	}

	public function msgid($msgid)
	{
		$this->msgid = $msgid;
		return $this;
	}

	public function log($level, $message, array $context = array())
	{
		$params = $this->prepareLogExtra();
		$log_extra = $this->prepareMessage(static::$log_extra_format, $params);

		$prival = $this->prepareLevel($level);
		$timestamp = $this->prepareTimestamp(time());

		$msg = $this->prepareMessage(
			$this->format,
			array(
				"level" => $prival,
				"timestamp" => $timestamp,
				"log_extra" => $log_extra,
				"message" => $message,
				"context" => $this->prepareContext($context),
			)
		);

		$this->send($msg);
	}

	public function emergency($message, array $context = array())
	{
		$this->log(LOG_EMERG, $message, $context);
	}

	public function alert($message, array $context = array())
	{
		$this->log(LOG_ALERT, $message, $context);
	}

	public function critical($message, array $context = array())
	{
		$this->log(LOG_EMERG, $message, $context);
	}

	public function error($message, array $context = array())
	{
		$this->log(LOG_ERR, $message, $context);
	}

	public function warning($message, array $context = array())
	{
		$this->log(LOG_WARNING, $message, $context);
	}

	public function notice($message, array $context = array())
	{
		$this->log(LOG_NOTICE, $message, $context);
	}

	public function info($message, array $context = array())
	{
		$this->log(LOG_INFO, $message, $context);
	}

	public function debug($message, array $context = array())
	{
		$this->log(LOG_DEBUG, $message, $context);
	}

	protected function prepareMessage($format, $params, $remove_spaces = false)
	{
		extract($params);
		$message = eval("return \"$format\";");

		if ($remove_spaces)
		{
			$message = preg_replace("/(\s{2,})/", " ", $message);
		}
		return trim($message);
	}

	function prepareContext($context)
	{
		if ($context)
		{
			$context = json_encode($context, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
		}
		else
		{
			$context = "";
		}
		return $context;
	}

	function prepareTimestamp($timestamp)
	{
		return date('c', $timestamp);
	}

	function prepareLevel($level){
		return $level;
	}

	function prepareLogExtra()
	{
		$msgId = $this->msgid;

		if (!$msgId && !is_null($this->autoMsgId))
		{
			$msgId = $this->autoMsgId++;
		}

		return array(
			"appname" => $this->appname,
			"procid" => $this->procid,
			"msgid" => $msgId,
		);
	}
}