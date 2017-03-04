<?php
/**
 * Created by PhpStorm.
 * User: phil
 * Date: 01/03/17
 * Time: 22:37
 */

namespace AliyunMQ\Model;


class PushMsgModel
{
	public $key;
	public $tag;
	public $body;

	public function __construct($body = '', $tag = '', $key = '')
	{
		$this->key = $key;
		$this->tag = $tag;
		$this->body = $body;
	}
}