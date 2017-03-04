<?php
/**
 * Created by PhpStorm.
 * User: phil
 * Date: 01/03/17
 * Time: 15:55
 */
namespace AliyunMQ;
use AliyunMQ\Traits\GetSetTrait;

/**
 * Class Client
 * @package AliyunMQ
 */
class Client
{
	use GetSetTrait;

	protected $topic;
	protected $url;
	protected $accessKey;
	protected $accessSecret;

	public function __construct($topic, $url, $accessKey, $accessSecret)
	{
		$this->topic = $topic;
		$this->url = $url;
		$this->accessKey = $accessKey;
		$this->accessSecret = $accessSecret;
	}

	/**
	 * @param $producerId
	 * @return Producer
	 */
	public function producer($producerId) {
		return new Producer($producerId, $this->topic, $this->url, $this->accessKey, $this->accessSecret);
	}

	/**
	 * @param $consumerId
	 * @return Consumer
	 */
	public function consumer($consumerId) {
		return new Consumer($consumerId, $this->topic, $this->url, $this->accessKey, $this->accessSecret);
	}
}