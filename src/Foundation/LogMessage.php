<?php
/**
 * Created by PhpStorm.
 * User: ada
 * Date: 12-Jun-18
 * Time: 11:20
 */

namespace ArashDalir\Foundation;

abstract class LogMessage implements ILogMessage{
	protected $app_name;
	protected $message_id;
	protected $process_id;
	protected $auto_message_id;
	protected $message;
	protected $level;
	protected $context;
	protected $timestamp;
	protected $format;


	function __construct()
	{
		$this->process_id = getmypid();
	}

	/**
	 * @return mixed
	 */
	public function getAppName()
	{
		return $this->app_name;
	}

	/**
	 * @param mixed $app_name
	 *
	 * @return LogMessage
	 */
	public function setAppName($app_name)
	{
		$this->app_name = $app_name;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getMessageId()
	{
		return $this->message_id;
	}

	/**
	 * @param mixed $message_id
	 *
	 * @return LogMessage
	 */
	public function setMessageId($message_id)
	{
		$this->message_id = $message_id;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getProcessId()
	{
		return $this->process_id;
	}

	/**
	 * @param int $process_id
	 *
	 * @return LogMessage
	 */
	public function setProcessId($process_id)
	{
		$this->process_id = $process_id;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getAutoMessageId()
	{
		return $this->auto_message_id;
	}

	/**
	 * @param mixed $auto_message_id
	 *
	 * @return LogMessage
	 */
	public function setAutoMessageId($auto_message_id)
	{
		$this->auto_message_id = $auto_message_id;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getMessage()
	{
		return $this->message;
	}

	/**
	 * @param mixed $message
	 *
	 * @return LogMessage
	 */
	public function setMessage($message)
	{
		$this->message = $message;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getLevel()
	{
		return $this->level;
	}

	/**
	 * @param mixed $level
	 *
	 * @return LogMessage
	 */
	public function setLevel($level)
	{
		$this->level = $level;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getContext()
	{
		return $this->context;
	}

	/**
	 * @param mixed $context
	 *
	 * @return LogMessage
	 */
	public function setContext($context)
	{
		$this->context = $context;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getTimestamp()
	{
		return $this->timestamp;
	}

	/**
	 * @param mixed $timestamp
	 *
	 * @return LogMessage
	 */
	public function setTimestamp($timestamp = null)
	{
		if (!$timestamp)
		{
			$timestamp = microtime(true);
		}
		$this->timestamp = $timestamp;
		return $this;
	}


	/**
	 * @param mixed $format
	 *
	 * @return LogMessage
	 */
	public function setFormat($format)
	{
		$this->format = $format;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getFormat()
	{
		return $this->format;
	}

	function asString($property)
	{
		$value = null;

		if (property_exists(static::class, $property))
		{
			$value = $this->$property;

			switch($property)
			{
			case "context":
				if($value)
				{
					$value = json_encode($value, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
				}
				else
				{
					$value = "";
				}
				break;

			case "timestamp":
				$value = date('c', $value);
				break;

			case "message_id":
				$value = $this->message_id;

				if(!$value && !is_null($this->auto_message_id))
				{
					$value = $this->auto_message_id++;
				}
				break;
			}
		}

		return $value;
	}

	abstract function __toString();

	function format($format){
		$variables = get_object_vars($this);

		foreach ($variables as $property => &$variable)
		{
			$variable = $this->asString($property);
		}

		extract($variables);

		$message = eval("return \"$format\";");

		return trim($message);
	}
}