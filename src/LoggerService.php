<?php
namespace braga\graylogger;
use Monolog\Level;
use Monolog\Logger;
class LoggerService extends Logger
{
	// -----------------------------------------------------------------------------------------------------------------
	const LOG_ID = "logID";
	const CODE = "code";
	const TRACE = "trace";
	const USER_ID = "userID";
	const LOGIN = "login";
	const SESSION_ID = "sessionID";
	const IP = "IP";
	const CODE_LINE = "codeLine";
	const FILE = "file";
	// -----------------------------------------------------------------------------------------------------------------
	private static $systemReqestId;
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $message
	 * @param array $context
	 */
	public function emergency($message, array $context = []): void
	{
		$this->decorateContext($context);
		parent::emergency($message, $context);
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
	public function alert($message, array $context = []): void
	{
		$this->decorateContext($context);
		parent::alert($message, $context);
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
	public function critical($message, array $context = []): void
	{
		$this->decorateContext($context);
		parent::critical($message, $context);
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
	public function error($message, array $context = []): void
	{
		$this->decorateContext($context);
		parent::error($message, $context);
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
	public function warning($message, array $context = []): void
	{
		$this->decorateContext($context);
		parent::warning($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * Normal but significant events.
	 * @param string $message
	 * @param mixed[] $context
	 *
	 * @return void
	 */
	public function notice($message, array $context = []): void
	{
		$this->decorateContext($context);
		parent::notice($message, $context);
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
	public function info($message, array $context = []): void
	{
		$this->decorateContext($context);
		parent::info($message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * Detailed debug information.
	 * @param string $message
	 * @param mixed[] $context
	 *
	 * @return void
	 */
	public function debug($message, array $context = []): void
	{
		$this->decorateContext($context);
		parent::debug($message, $context);
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
	public function log($level, $message, array $context = []): void
	{
		$this->decorateContext($context);
		parent::log($level, $message, $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * Logs with an arbitrary level.
	 * @param \Throwable $exception
	 *
	 * @param int $logLevel
	 * @return void
	 */
	public function exception(\Throwable $exception, Level $logLevel = Level::Critical, array $context = array())
	{
		$context = array_merge([
			self::CODE      => Factory::$errorCodePrefix . ":" . $exception->getCode(),
			self::TRACE     => $exception->getTraceAsString(),
			self::CODE_LINE => $exception->getLine(),
			self::FILE      => $exception->getFile() ], $context);

		$this->decorateContext($context);
		self::log($logLevel, $exception->getMessage(), $context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param array $context
	 */
	private function decorateContext(array &$context)
	{
		$context = array_merge([ self::LOG_ID => strval($this->getUniqRequestGuid()) ], $context);
		$context = array_merge([ self::IP => strval($this->getRemoteIp()) ], $context);
		if(!empty(Factory::$uniqUserId))
		{
			$context = array_merge([ self::USER_ID => strval(Factory::$uniqUserId) ], $context);
		}
		if(!empty(Factory::$userNameContex))
		{
			$context = array_merge([ self::LOGIN => strval(Factory::$userNameContex) ], $context);
		}
		if(!empty(Factory::$sessionId))
		{
			$context = array_merge([ self::SESSION_ID => strval(Factory::$sessionId) ], $context);
		}
		return $this->cleanup($context);
	}
	// -----------------------------------------------------------------------------------------------------------------
	private function cleanup($context)
	{
		$retval = [];
		foreach($context as $key => $value)
		{
			if(is_array($value))
			{
				$retval[strval($key)] = mb_substr(json_encode($value, JSON_PRETTY_PRINT) ?? "", 0, 32766);
			}
			elseif(is_object($value))
			{
				$retval[strval($key)] = mb_substr(json_encode($value, JSON_PRETTY_PRINT) ?? "", 0, 32766);
			}
			else
			{
				$retval[strval($key)] = mb_substr($value ?? "", 0, 32766);
			}
		}
		return $retval;
	}
	// -----------------------------------------------------------------------------------------------------------------
	protected function getUniqRequestGuid()
	{
		if(empty(self::$systemReqestId))
		{
			self::$systemReqestId = strtoupper(sprintf('%04x%04x%04x%04x%04x%04x%04x%04x',
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
		return self::$systemReqestId;
	}
	// =============================================================================
	function getRemoteIp()
	{
		$ip = isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : '127.0.0.1';
		if(isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
		{
			$tmp = explode(",", $_SERVER["HTTP_X_FORWARDED_FOR"]);
			$ip = trim(current($tmp));
		}
		return $ip;
	}
	// -----------------------------------------------------------------------------------------------------------------
}