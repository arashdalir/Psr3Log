<?php
include 'vendor/autoload.php';

$log = new arashdalir\Handler\SysLog\SysLog('127.0.0.1');
$log->facility(LOG_KERN)
    ->hostname('yourname.com')
    ->procid(8848)
    ->msgid('demo')
    ->appname('php');

$log->error('UDP SysLog Error Test');
$log->info('UDP SysLog Info Test');
$log->debug('UDP SysLog Debug Test');
$log->emergency('UDP SysLog Emergency Test');
