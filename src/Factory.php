<?php
namespace braga\graylogger;
use Gelf\Publisher;
use Gelf\Transport\TcpTransport;
use Monolog\Handler\FingersCrossed\ErrorLevelActivationStrategy;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\FingersCrossedHandler;
use Monolog\Handler\GelfHandler;
use Monolog\Handler\StreamHandler;
class Factory
{
	// -----------------------------------------------------------------------------------------------------------------
	public static string $errorCodePrefix = "BRG";
	private static int $gelfPort = 12201;
	private static ?string $gelfHost = null;
	private static Level $logLevel = Level::Notice;
	private static ?string $fileLogPath;
	public static ?string $userNameContex;
	public static ?string $uniqUserId;
	public static ?string $sessionId;
	// -----------------------------------------------------------------------------------------------------------------
	public static function setStartupConfig(GrayLoggerConfig $config)
	{
		self::$errorCodePrefix = $config->getErrorCodePrefix();
		self::$gelfHost = $config->getGelfHost();
		self::$gelfPort = $config->getGelfPort();
		self::$logLevel = $config->getLogLevel();
		self::$fileLogPath = $config->getFileLogPath();
	}
	// -----------------------------------------------------------------------------------------------------------------
	public static function setUserNameContext($userName, $uniqUserId = null, $sessionId = null)
	{
		self::$userNameContex = $userName;
		self::$uniqUserId = $uniqUserId;
		self::$sessionId = $sessionId;
	}
	// -----------------------------------------------------------------------------------------------------------------
	public static function setSessionId(string $sessionId)
	{
		self::$sessionId = $sessionId;
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
	/** @var LoggerService[] */
	private static $instances = array();
	// -----------------------------------------------------------------------------------------------------------------
	public static function getInstance($name): LoggerService
	{
		if(!array_key_exists($name, self::$instances))
		{
			$logHandlers = array();
			if(!empty(self::$gelfHost))
			{
				$logHandlers[] = new FingersCrossedHandler(new GelfHandler(new Publisher(new TcpTransport(self::$gelfHost, self::$gelfPort))), new ErrorLevelActivationStrategy(self::$logLevel), 0, true, true, null);
			}
			if(!empty(self::$fileLogPath))
			{
				$logHandlers[] = new FingersCrossedHandler(new StreamHandler(sprintf(self::$fileLogPath, mb_strtolower($name), date("Y-m-d"))), new ErrorLevelActivationStrategy(self::$logLevel), 0, true, true, null);
			}

			$logger = new LoggerService($name, $logHandlers);
			self::$instances[$name] = $logger;
		}
		return self::$instances[$name];
	}
	// -----------------------------------------------------------------------------------------------------------------
}