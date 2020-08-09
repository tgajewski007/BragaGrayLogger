<?php

namespace braga\graylogger;

use Monolog\Logger;

class LoggerService extends Logger
{
	// -----------------------------------------------------------------------------------------------------------------
	const LOG_ID = "logID";
	const CODE = "code";
	const TRACE = "trace";
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @var string
	 */
	public $uniqueLogId = null;
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $message
	 * @param array $context
	 */
	public function emergency(string $message, array $context = array())
	{
		$context = array_merge([
						self::LOG_ID => $this->uniqueLogId ], $context);

		$this->emergency($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * Action must be taken immediately.
	 * Example: Entire website down, database unavailable, etc. This should
	 * trigger the SMS alerts and wake you up.
	 * @param string $message
	 * @param mixed[] $context
	 *
	 * @return void
	 */
	public function alert($message, array $context = array())
	{
		$context = array_merge([
						self::LOG_ID => $this->uniqueLogId ], $context);

		$this->alert($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * Critical conditions.
	 * Example: Application component unavailable, unexpected exception.
	 * @param string $message
	 * @param mixed[] $context
	 *
	 * @return void
	 */
	public function critical($message, array $context = array())
	{
		$context = array_merge([
						self::LOG_ID => $this->uniqueLogId ], $context);

		$this->critical($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * Runtime errors that do not require immediate action but should typically
	 * be logged and monitored.
	 * @param string $message
	 * @param mixed[] $context
	 *
	 * @return void
	 */
	public function error($message, array $context = array())
	{
		$context = array_merge([
						self::LOG_ID => $this->uniqueLogId ], $context);

		$this->error($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * Exceptional occurrences that are not errors.
	 * Example: Use of deprecated APIs, poor use of an API, undesirable things
	 * that are not necessarily wrong.
	 * @param string $message
	 * @param mixed[] $context
	 *
	 * @return void
	 */
	public function warning($message, array $context = array())
	{
		$context = array_merge([
						self::LOG_ID => $this->uniqueLogId ], $context);

		$this->warning($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * Normal but significant events.
	 * @param string $message
	 * @param mixed[] $context
	 *
	 * @return void
	 */
	public function notice($message, array $context = array())
	{
		$context = array_merge([
						self::LOG_ID => $this->uniqueLogId ], $context);

		$this->notice($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * Interesting events.
	 * Example: User logs in, SQL logs.
	 * @param string $message
	 * @param mixed[] $context
	 *
	 * @return void
	 */
	public function info($message, array $context = array())
	{
		$context = array_merge([
						self::LOG_ID => $this->uniqueLogId ], $context);

		$this->info($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * Detailed debug information.
	 * @param string $message
	 * @param mixed[] $context
	 *
	 * @return void
	 */
	public function debug($message, array $context = array())
	{
		$context = array_merge([
						self::LOG_ID => $this->uniqueLogId ], $context);

		$this->debug($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * Logs with an arbitrary level.
	 * @param mixed $level
	 * @param string $message
	 * @param mixed[] $context
	 *
	 * @return void
	 */
	public function log($level, $message, array $context = array())
	{
		$context = array_merge([
						self::LOG_ID => $this->uniqueLogId ], $context);

		$this->log($level, $message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * Logs with an arbitrary level.
	 * @param \Throwable $exception
	 *
	 * @param int $logLevel
	 * @return void
	 */
	public function exception(\Throwable $exception, int $logLevel = Logger::NOTICE)
	{
		self::log($logLevel, $exception->getMessage(), [
						self::CODE => self::$errorCodePrefix . ":" . $exception->getCode(),
						self::TRACE => $exception->getTraceAsString() ]);
	}
	// -----------------------------------------------------------------------------------------------------------------
}