<?php
/**
 * Created by PhpStorm.
 * User: phil
 * Date: 01/03/17
 * Time: 17:30
 */

namespace AliyunMQ\Model;


use AliyunMQ\Traits\ArrayTrait;

/**
 * Class MessageArray
 * @package AliyunMQ\Model
 */
class MultiMessage extends \ArrayObject
{
	public $code;
	public $status;

	/**
	 * @return Message[]
	 */
	public function items() {
		return $this;
	}
}