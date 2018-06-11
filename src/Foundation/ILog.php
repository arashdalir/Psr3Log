<?php
/**
 * Created by PhpStorm.
 * User: ada
 * Date: 11-Jun-18
 * Time: 15:20
 */

namespace ArashDalir\Foundation;

interface ILog{
	function send($message);
	function prepareContext($context);
	function prepareTimestamp($timestamp);
	function prepareLevel($level);
	function prepareLogExtra();
}