<?php
namespace braga\graylogger;
use Gelf\Transport\TcpTransport;
use Monolog\Level;
use Monolog\Logger;

class GrayLoggerConfig
{
	// -----------------------------------------------------------------------------------------------------------------
	protected $errorCodePrefix;
	protected $gelfPort;
	protected $gelfHost;
	protected $logLevel;
	protected $fileLogPath;
	// -----------------------------------------------------------------------------------------------------------------
	function __construct($errorCodePrefix, $gelfHost, $gelfPort = null, $logLevel = Level::Notice, $fileLogPath = null)
	{
		$this->errorCodePrefix = $errorCodePrefix;
		$this->gelfHost = $gelfHost;
		$this->gelfPort = $gelfPort;
		$this->logLevel = $logLevel;
		$this->fileLogPath = $fileLogPath;
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @return mixed
	 */
	public function getErrorCodePrefix()
	{
		return $this->errorCodePrefix;
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @return mixed
	 */
	public function getGelfPort()
	{
		return $this->gelfPort;
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @return mixed
	 */
	public function getGelfHost()
	{
		return $this->gelfHost;
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @return mixed
	 */
	public function getLogLevel()
	{
		return $this->logLevel;
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @return string
	 */
	public function getFileLogPath()
	{
		return $this->fileLogPath;
	}
	// -----------------------------------------------------------------------------------------------------------------
}

