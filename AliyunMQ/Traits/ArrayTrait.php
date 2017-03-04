<?php
/**
 * Created by PhpStorm.
 * User: phil
 * Date: 01/03/17
 * Time: 17:35
 */
namespace AliyunMQ\Traits;

trait ArrayTrait
{
	protected $_array = [];

	public function offsetGet($offset)
	{
		return isset($this->_array[$offset]) ? $this->_array[$offset] : null;
	}

	public function offsetExists($offset)
	{
		return isset($this->_array[$offset]);
	}

	public function offsetSet($offset, $value)
	{
		return $this->_array[$offset] = $value;
	}

	public function offsetUnset($offset)
	{
		unset($this->_array[$offset]);
	}

	public function count(){
		return count($this->_array);
	}
}