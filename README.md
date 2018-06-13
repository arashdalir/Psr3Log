# PHP-Psr3Log

`ArashDalir\Psr3Log` is a [PSR3](http://www.php-fig.org/psr/psr-3/) implementation,
which sending log according [RFC 5424](https://tools.ietf.org/html/rfc5424).
This library forks the implementation of UDP-Based SysLog library implemented as [lvht\updlog](https://github.com/lvht/udplog), generalises it and allows further extension of the base system.

## Install

Use following command to add the repository to your project:

	composer require arashdalir/php-psr3log:dev-master


Or add following line to your composer.json:

```json
{
  "require": {
     "arashdalir/php-psr3log": "dev-master"
  }
}
```
## Usage
Currently, there is only one realization of Psr3Log Handlers for SysLog over UDP format and local SysLog.

### Local SysLog:
By not defining an address when creating an object, the object tries to write the values in local syslog.

### UDP-Based SysLog Client:
The constructor function accepts an IP-Address and a port where the syslog server is, and will send logs to the remote server.

#### Usage on Windows:
Please note that on Windows [only LOG_USER facility is allowed](http://php.net/manual/en/function.openlog.php). Using other facilities will throw an Exception of type `ArashDalir\Handler\SysLog\InvalidFacilityException`, if the second parameter for `setFacility($facility, $os_form)` is set to true.

```php
<?php
include 'vendor/autoload.php';

$udp = new ArashDalir\Handler\SysLog\SysLog('127.0.0.1');
$udp->getLogMessage()->setFacility(LOG_AUTH, false)
    ->setVersion(\ArashDalir\Handler\SysLog\SysLogMessage::VERSION_1) // available as of V1.1.0
    ->setHostname('ada')
    ->setProcessId(8848)
    ->setMessageId('demo')
    ->setAppName('php');

$udp->error('UDP SysLog Error Test');
$udp->info('UDP SysLog Info Test');
$udp->debug('UDP SysLog Debug Test');
$udp->emergency('UDP SysLog Emergency Test');

$local = new \ArashDalir\Handler\SysLog\SysLog();
$local->getLogMessage()->setFacility(LOG_USER)
    ->setHostname('ada')
    ->setProcessId(8848)
    ->setMessageId('demo')
    ->setAppName('php');

$local->error('Local SysLog Error Test');
$local->info('Local SysLog Info Test');
$local->debug('Local SysLog Debug Test');
$local->emergency('Local SysLog Emergency Test');
```

## Status
Psr3Log extends Udplog. It provides a PSR-3 conform implementation of a logger. As Udplog, Psr3Log doesn't support [STRUCTURED-DATA](https://tools.ietf.org/html/rfc5424#section-6.3). Hopefully the future releases will cover this up...

## Versions

### v1.1.0:
 * added support for [RFC5424 (syslog V1)](https://tools.ietf.org/html/rfc5424)
 * message timestamp can be set manually if psr3log->log function is used directly - mainly implemented for extension purposes, so that log messages from other loggers can be fed into this library.
 

### v1.0.0:
first stable release - following features implemented
 * local syslog entries
 * udp-based syslog client
 * based on [RFC3164 (syslog V0)](https://www.ietf.org/rfc/rfc3164.txt)