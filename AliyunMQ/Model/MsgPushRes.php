<?php
/**
 * Created by PhpStorm.
 * User: phil
 * Date: 01/03/17
 * Time: 20:58
 */

namespace AliyunMQ\Model;


class MsgPushRes
{
	public $msgId;
	public $sendStatus;

	/**
	 * @return bool
	 */
	public function ok() {
		return ($this->sendStatus == 'SEND_OK');
	}
}