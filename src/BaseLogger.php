<?php

namespace braga\graylogger;

use Monolog\Level;
use Monolog\Logger;

class BaseLogger
{
	const NAME = "braga";
	// -----------------------------------------------------------------------------------------------------------------
	public static function emergency(string $message, array $context = array())
	{
		Factory::getInstance(static::NAME)->emergency($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $message
	 * @param array $context
	 */
	public static function alert(string $message, array $context = array())
	{
		Factory::getInstance(static::NAME)->alert($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $message
	 * @param array $context
	 */
	public static function critical(string $message, array $context = array())
	{
		Factory::getInstance(static::NAME)->critical($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $message
	 * @param array $context
	 */
	public static function error(string $message, array $context = array())
	{
		Factory::getInstance(static::NAME)->error($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $message
	 * @param array $context
	 */
	public static function warning(string $message, array $context = array())
	{
		Factory::getInstance(static::NAME)->warning($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $message
	 * @param array $context
	 */
	public static function notice(string $message, array $context = array())
	{
		Factory::getInstance(static::NAME)->notice($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $message
	 * @param array $context
	 */
	public static function info(string $message, array $context = array())
	{
		Factory::getInstance(static::NAME)->info($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $message
	 * @param array $context
	 */
	public static function debug(string $message, array $context = array())
	{
		Factory::getInstance(static::NAME)->debug($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param int $level
	 * @param string $message
	 * @param array $context
	 */
	public static function log($level, string $message, array $context = array())
	{
		Factory::getInstance(static::NAME)->log($level, $message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param \Throwable $exception
	 * @param int $logLevel
	 */
	public static function exception(\Throwable $exception, Level $logLevel = Level::Critical)
	{
		Factory::getInstance(static::NAME)->exception($exception, $logLevel);
	}
	// -----------------------------------------------------------------------------------------------------------------
}

