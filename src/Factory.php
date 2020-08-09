<?php

namespace braga\graylogger;

use Gelf\Publisher;
use Gelf\Transport\TcpTransport;
use Monolog\Logger;
use Monolog\Handler\FingersCrossedHandler;
use Monolog\Handler\GelfHandler;
use Monolog\Handler\StreamHandler;

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
			$logger->uniqueLogId = self::get();
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
	static function get()
	{
		return strtoupper(sprintf('%04x%04x%04x%04x%04x%04x%04x%04x',
				// 32 bits for "time_low"
				mt_rand(0, 0xffff), mt_rand(0, 0xffff),
				// 16 bits for "time_mid"
				mt_rand(0, 0xffff),
				// 16 bits for "time_hi_and_version",
				// four most significant bits holds version number 4
				mt_rand(0, 0x0fff) | 0x4000,
				// 16 bits, 8 bits for "clk_seq_hi_res",
				// 8 bits for "clk_seq_low",
				// two most significant bits holds zero and one for
				// variant DCE1.1
				mt_rand(0, 0x3fff) | 0x8000,
				// 48 bits for "node"
				mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)));
	}
	// -----------------------------------------------------------------------------------------------------------------
}