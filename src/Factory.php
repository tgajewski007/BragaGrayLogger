<?php

namespace braga\graylogger;

use Gelf\Publisher;
use Gelf\Transport\TcpTransport;
use Monolog\Logger;
use Monolog\Handler\FingersCrossedHandler;
use Monolog\Handler\GelfHandler;
use Monolog\Handler\StreamHandler;
use braga\tools\tools\Guid;

class Factory
{

	// -----------------------------------------------------------------------------------------------------------------
	public static function setStartupConfig(GrayLoggerConfig $config)
	{
		self::$errorCodePrefix = $config->getErrorCodePrefix();
		self::$gelfHost = $config->getGelfHost();
		self::$gelfPort = $config->getGelfPort();
		self::$logLevel = $config->getLogLevel();
	}
	// -----------------------------------------------------------------------------------------------------------------
	// True Singleton privatization
	private function __construct()
	{
	}
	// -----------------------------------------------------------------------------------------------------------------
	private function __clone()
	{
	}
	// -----------------------------------------------------------------------------------------------------------------
	private function __wakeup()
	{
	}
	// -----------------------------------------------------------------------------------------------------------------
	public static $errorCodePrefix = "BRG";
	private static $gelfPort = TcpTransport::DEFAULT_HOST;
	private static $gelfHost = null;
	private static $logLevel = Logger::NOTICE;
	// -----------------------------------------------------------------------------------------------------------------
	/** @var LoggerService[] */
	private static $instances = array();
	// -----------------------------------------------------------------------------------------------------------------
	public static function getInstance($name): LoggerService
	{
		if(!array_key_exists($name, self::$instances))
		{
			$logger = new LoggerService($name, [
							new FingersCrossedHandler(new GelfHandler(new Publisher(new TcpTransport(self::$gelfHost, self::$gelfPort))), null, 0, true, true, self::$logLevel),
							new FingersCrossedHandler(new StreamHandler(sprintf(LOGS_PATH_STRING, $name . ".log")), null, 0, true, true, self::$logLevel) ]);
			$logger->uniqueLogId = Guid::get();
			self::$instances[$name] = $logger;
		}
		return self::$instances[$name];
	}
	// -----------------------------------------------------------------------------------------------------------------
	public static function setGUID(string $name, string $guid)
	{
		$logger = self::getInstance($name);
		$logger->uniqueLogId = $guid;
	}
	// -----------------------------------------------------------------------------------------------------------------
}