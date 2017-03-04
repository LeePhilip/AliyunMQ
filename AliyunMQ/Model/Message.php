<?php
/**
 * Created by PhpStorm.
 * User: phil
 * Date: 01/03/17
 * Time: 17:26
 */

namespace AliyunMQ\Model;


class Message
{
	public $id;
	public $tag;
	public $body;
	public $key;
	public $handle;
	public $bornTime;
	public $reconsumeTimes;
}