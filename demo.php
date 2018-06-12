<?php
include 'vendor/autoload.php';

$udp = new ArashDalir\Handler\SysLog\SysLog('127.0.0.1');
$udp->getLogMessage()->setFacility(LOG_AUTH, false)
    ->setHostname('ada.gemik')
    ->setProcessId(8848)
    ->setMessageId('demo')
    ->setAppName('php');

$udp->error('UDP SysLog Error Test');
$udp->info('UDP SysLog Info Test');
$udp->debug('UDP SysLog Debug Test');
$udp->emergency('UDP SysLog Emergency Test');

$local = new \ArashDalir\Handler\SysLog\SysLog();
$local->getLogMessage()->setFacility(LOG_USER)
	->setHostname('ada.gemik')
	->setProcessId(8848)
	->setMessageId('demo')
	->setAppName('php');

$local->error('Local SysLog Error Test');
$local->info('Local SysLog Info Test');
$local->debug('Local SysLog Debug Test');
$local->emergency('Local SysLog Emergency Test');
