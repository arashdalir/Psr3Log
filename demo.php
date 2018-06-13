<?php
include 'vendor/autoload.php';

$udp = new ArashDalir\Handler\SysLog\SysLog('127.0.0.1');
$udp->getLogMessage()->setFacility(LOG_USER, false)
	->setVersion(\ArashDalir\Handler\SysLog\SysLogMessage::VERSION_1) // available as of V1.1.0
    ->setHostname('ada')
    ->setProcessId(1234)
    ->setMessageId('demo')
    ->setAppName('php');

$udp->error('UDP SysLog Error Test');
$udp->info('UDP SysLog Info Test');
$udp->debug('UDP SysLog Debug Test');
$udp->emergency('UDP SysLog Emergency Test');

$local = new \ArashDalir\Handler\SysLog\SysLog();
$local->getLogMessage()->setFacility(LOG_USER)
	->setHostname('ada')
	->setProcessId(1234)
	->setMessageId('demo')
	->setAppName('php');

$local->error('Local SysLog Error Test');
$local->info('Local SysLog Info Test');
$local->debug('Local SysLog Debug Test');
$local->emergency('Local SysLog Emergency Test');
