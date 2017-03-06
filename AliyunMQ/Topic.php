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
class Topic
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
		$producer = new Producer($producerId, $this->url, $this->accessKey, $this->accessSecret);
		$producer->setTopic($this->topic);
		return $producer;
	}

	/**
	 * @param $consumerId
	 * @return Consumer
	 */
	public function consumer($consumerId) {
		$consumer = new Consumer($consumerId, $this->url, $this->accessKey, $this->accessSecret);
		$consumer->setTopic($this->topic);
		return $consumer;
	}
}