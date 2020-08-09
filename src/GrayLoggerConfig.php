<?php

namespace braga\graylogger;

use Gelf\Transport\TcpTransport;
use Gelf\Logger;

class GrayLoggerConfig
{

	// -----------------------------------------------------------------------------------------------------------------
	function __construct($errorCodePrefix, $gelfHost, $gelfPort = TcpTransport::DEFAULT_PORT, $logLevel = Logger::NOTICE)
	{
		$this->errorCodePrefix = $errorCodePrefix;
		$this->gelfHost = $gelfHost;
		$this->gelfPort = $gelfPort;
		$this->logLevel = $logLevel;
	}
	// -----------------------------------------------------------------------------------------------------------------
	protected $errorCodePrefix;
	protected $gelfPort;
	protected $gelfHost;
	protected $logLevel;
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
}

