<?php

namespace braga\graylogger;

use Monolog\Logger;

class BaseLogger
{
	protected static $loggerName = "braga";
	// -----------------------------------------------------------------------------------------------------------------
	public static function emergency(string $message, array $context = array())
	{
		Factory::getInstance(self::loggerName)->emergency($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $message
	 * @param array $context
	 */
	public static function alert(string $message, array $context = array())
	{
		Factory::getInstance(self::loggerName)->alert($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $message
	 * @param array $context
	 */
	public static function critical(string $message, array $context = array())
	{
		Factory::getInstance(self::loggerName)->critical($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $message
	 * @param array $context
	 */
	public static function error(string $message, array $context = array())
	{
		Factory::getInstance(self::loggerName)->error($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $message
	 * @param array $context
	 */
	public static function warning(string $message, array $context = array())
	{
		Factory::getInstance(self::loggerName)->warning($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $message
	 * @param array $context
	 */
	public static function notice(string $message, array $context = array())
	{
		Factory::getInstance(self::loggerName)->notice($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $message
	 * @param array $context
	 */
	public static function info(string $message, array $context = array())
	{
		Factory::getInstance(self::loggerName)->info($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $message
	 * @param array $context
	 */
	public static function debug(string $message, array $context = array())
	{
		Factory::getInstance(self::loggerName)->debug($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param int $level
	 * @param string $message
	 * @param array $context
	 */
	public static function log($level, string $message, array $context = array())
	{
		Factory::getInstance(self::loggerName)->log($level, $message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param \Throwable $exception
	 * @param int $logLevel
	 */
	public static function exception(\Throwable $exception, int $logLevel = Logger::NOTICE)
	{
		Factory::getInstance(self::loggerName)->exception($exception, $logLevel);
	}
	// -----------------------------------------------------------------------------------------------------------------
}

