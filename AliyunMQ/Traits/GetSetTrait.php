<?php
/**
 * Created by PhpStorm.
 * User: phil
 * Date: 01/03/17
 * Time: 22:08
 */

namespace AliyunMQ\Traits;


trait GetSetTrait
{
	public function __get($name)
	{
		if(!method_exists($this, $name)){

		}
		return call_user_func([$this, $name]);
	}

	public function __set($name, $value)
	{
		if(!method_exists($this, '__set_' . $name)){

		}
		call_user_func([$this, '__set_' . $name], [$value]);
	}
}