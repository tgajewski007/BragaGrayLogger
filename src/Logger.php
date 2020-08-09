<?php
/**
 * @author tgaje
 * @deprecated
 */
class Logger
{
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
	/**
	 * @var Logger[]
	 */
	private static $instance = array();
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @var \braga\graylogger\LoggerService
	 */
	protected $logger;
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $name
	 * @return \braga\graylogger\LoggerService
	 */
	public static function getLogger($name)
	{
		if(!isset(self::$instance[$name]))
		{
			$retval = new self();
			$retval->logger = \braga\graylogger\Factory::getInstance($name);
			self::$instance[$name] = $retval;
		}
		return self::$instance[$name];
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $message
	 * @param \Throwable $throwable
	 */
	public function trace(string $message, \Throwable $throwable = null)
	{
		$context = array();
		if(!empty($throwable))
		{
			$context[self::CODE] = \braga\graylogger\Factory::$errorCodePrefix . ":" . $throwable->getCode();
			$context[self::TRACE] = $throwable->getTraceAsString();
		}
		$this->logger->debug($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $message
	 * @param \Throwable $throwable
	 */
	public function debug(string $message, \Throwable $throwable = null)
	{
		$context = array();
		if(!empty($throwable))
		{
			$context[self::CODE] = \braga\graylogger\Factory::$errorCodePrefix . ":" . $throwable->getCode();
			$context[self::TRACE] = $throwable->getTraceAsString();
		}
		$this->logger->debug($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $message
	 * @param \Throwable $throwable
	 */
	public function info(string $message, \Throwable $throwable = null)
	{
		$context = array();
		if(!empty($throwable))
		{
			$context[self::CODE] = \braga\graylogger\Factory::$errorCodePrefix . ":" . $throwable->getCode();
			$context[self::TRACE] = $throwable->getTraceAsString();
		}
		$this->logger->info($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $message
	 * @param \Throwable $throwable
	 */
	public function warn(string $message, \Throwable $throwable = null)
	{
		$context = array();
		if(!empty($throwable))
		{
			$context[self::CODE] = \braga\graylogger\Factory::$errorCodePrefix . ":" . $throwable->getCode();
			$context[self::TRACE] = $throwable->getTraceAsString();
		}
		$this->logger->warning($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $message
	 * @param \Throwable $throwable
	 */
	public function error(string $message, \Throwable $throwable = null)
	{
		$context = array();
		if(!empty($throwable))
		{
			$context[self::CODE] = \braga\graylogger\Factory::$errorCodePrefix . ":" . $throwable->getCode();
			$context[self::TRACE] = $throwable->getTraceAsString();
		}
		$this->logger->error($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $message
	 * @param \Throwable $throwable
	 */
	public function fatal(string $message, \Throwable $throwable = null)
	{
		$context = array();
		if(!empty($throwable))
		{
			$context[self::CODE] = \braga\graylogger\Factory::$errorCodePrefix . ":" . $throwable->getCode();
			$context[self::TRACE] = $throwable->getTraceAsString();
		}
		$this->logger->critical($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
}

