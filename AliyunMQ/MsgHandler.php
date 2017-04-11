<?php
/**
 * Created by PhpStorm.
 * User: phil
 * Date: 11/04/17
 * Time: 14:52
 */

namespace AliyunMQ;

use AliyunMQ\Model\Message;

abstract class MsgHandler
{
	abstract public function handle(Message $message);
}