# Psr3Log

`ArashDalir/Psr3Log` is a [PSR3](http://www.php-fig.org/psr/psr-3/) implementation,
which sending log according [RFC 5424](https://tools.ietf.org/html/rfc5424).
This library forks the implementation of UDP-Based SysLog library implemented as [lvht\updlog](https://github.com/lvht/udplog), generalises it and allows further extension of the base system.

## Install

Use following command to add the repository to your project:

	composer require ArashDalir/SysLog:dev-master

Or add following line to your composer.json:

```json
{
  "require": {
     "arashdalir/psr3log": "dev-master"
  }
}
```
## Usage
Currently, there is only one realization of Psr3Log Handlers for SysLog over UDP format.


### Usage on Windows:
Please note that on Windows [only LOG_USER facility is allowed](http://php.net/manual/en/function.openlog.php). Using other facilities will throw an Exception of type `ArashDalir\Handler\SysLog\InvalidFacilityException`. 
```php
<?php
$log = new ArashDalir\Handler\SysLog\SysLog('ip addr', 'port');
$log->facility(LOG_KERN)
    ->hostname('foo.com')
    ->procid(8848)
    ->msgid('demo')
    ->appname('php');

$log->error('UDP SysLog Error Test');
$log->info('UDP SysLog Info Test');
$log->debug('UDP SysLog Debug Test');
$log->emergency('UDP SysLog Emergency Test');
```

## Status
SysLog extends Udplog, which implements PSR3, so the API is stable. As Udplog, Psr3Log doesn't support [STRUCTURED-DATA](https://tools.ietf.org/html/rfc5424#section-6.3). It will be added if [lvht\updlog](https://github.com/lvht/udplog) implements this feature.
