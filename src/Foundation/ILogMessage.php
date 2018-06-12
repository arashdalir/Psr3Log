<?php
/**
 * Created by PhpStorm.
 * User: ada
 * Date: 12-Jun-18
 * Time: 11:37
 */

namespace ArashDalir\Foundation;

interface ILogMessage{
	function asString($property);
	function __toString();
}