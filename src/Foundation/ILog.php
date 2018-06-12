<?php
/**
 * Created by PhpStorm.
 * User: ada
 * Date: 11-Jun-18
 * Time: 15:20
 */

namespace ArashDalir\Foundation;

interface ILog{
	/**
	 * @param LogMessage $message
	 *
	 * @return mixed
	 */
	function send($message);
}