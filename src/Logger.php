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
	 * @return Logger
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
		$this->logger->debug($message, $this->getContextFromException($throwable));
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $message
	 * @param \Throwable $throwable
	 */
	public function debug(string $message, \Throwable $throwable = null)
	{
		$this->logger->debug($message, $this->getContextFromException($throwable));
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $message
	 * @param \Throwable $throwable
	 */
	public function info(string $message, \Throwable $throwable = null)
	{
		$this->logger->info($message, $this->getContextFromException($throwable));
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $message
	 * @param \Throwable $throwable
	 */
	public function warn(string $message, \Throwable $throwable = null)
	{
		$this->logger->warning($message, $this->getContextFromException($throwable));
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $message
	 * @param \Throwable $throwable
	 */
	public function error(string $message, \Throwable $throwable = null)
	{
		$this->logger->error($message, $this->getContextFromException($throwable));
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $message
	 * @param \Throwable $throwable
	 */
	public function fatal(string $message, \Throwable $throwable = null)
	{
		$this->logger->critical($message, $this->getContextFromException($throwable));
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param \Throwable $throwable
	 * @return string[]|NULL[]
	 */
	private function getContextFromException(\Throwable $throwable = null)
	{
		$context = array();
		if(!empty($throwable))
		{
			$context[\braga\graylogger\LoggerService::CODE] = \braga\graylogger\Factory::$errorCodePrefix . ":" . $throwable->getCode();
			$context[\braga\graylogger\LoggerService::TRACE] = $throwable->getTraceAsString();
			$context[\braga\graylogger\LoggerService::CODE_LINE] = $throwable->getLine();
			$context[\braga\graylogger\LoggerService::FILE] = $throwable->getFile();
		}
		return $context;
	}
	// -----------------------------------------------------------------------------------------------------------------
}

