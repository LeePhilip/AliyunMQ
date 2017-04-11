<?php
/**
 * Created by PhpStorm.
 * User: phil
 * Date: 11/04/17
 * Time: 14:52
 */

namespace AliyunMQ;

use AliyunMQ\Model\Message;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

abstract class MsgHandler
{
	/** @var Monolog\Logger */
	protected $logger;
	protected $logname = 'AliyunMq';
	protected $logfile = 'aliyunmq.log';

	public function __construct()
	{
		$this->logger = new Logger($this->logname, [
			(new StreamHandler(storage_path('logs/' . $this->logfile)))->setFormatter(new LineFormatter(null, null, true, true))
		]);
	}

	abstract public function handle(Message $message);
}