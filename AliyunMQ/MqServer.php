<?php
/**
 * Created by PhpStorm.
 * User: phil
 * Date: 11/04/17
 * Time: 15:02
 */

namespace AliyunMQ;

use AliyunMQ\Model\Message;
use Illuminate\Http\Request;

class MqServer
{
	const SUCCESS = '{"status":0}';
	const SUSPEND = '{"status":-1,"msg":"failed"}';

	public static function handle(MsgHandler $handler, Request &$request) {
		$msg = new Message();
		$msg->body = $request->getContent();
		$msg->tag = $request->header('tag', '');
		$msg->handle = $request->header('handle', '');
		$msg->id = $request->header('id', '');
		$msg->bornTime = $request->header('bornTime', '');;
		$msg->reconsumeTimes = (int)$request->header('reconsumeTimes', 0);

		return $handler->handle($msg) ? static::SUCCESS : static::SUSPEND;
	}
}