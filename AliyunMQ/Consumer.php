<?php
/**
 * Created by PhpStorm.
 * User: phil
 * Date: 01/03/17
 * Time: 16:21
 */

namespace AliyunMQ;

use AliyunMQ\Util\Util;
use AliyunMQ\Model\Message;
use AliyunMQ\Model\MultiMessage;

class Consumer
{
	protected $id;
	protected $topic;
	protected $url;
	protected $accessKey;
	protected $accessSecret;


	public function __construct($consumerId, $url, $accessKey, $accessSecret)
	{
		$this->id = $consumerId;
		$this->url = $url;
		$this->accessKey = $accessKey;
		$this->accessSecret = $accessSecret;
	}

	public function setTopic($topic) {
		$this->topic = $topic;
	}

	/**
	 * @param int $num
	 * @return MultiMessage
	 */
	public function receive($num) {
		$date = time() * 1000;
		//签名字符串
		$signString = $this->topic."\n".$this->id."\n".$date;
		//计算签名
		$sign = Util::calSignature($signString, $this->accessSecret);

		//构造HTTP请求URL
		$url = $this->url . '/message/?topic=' . $this->topic . '&time=' . $date . '&num=' . $num;

		$result = Util::request('GET', $url, $this->header($sign), null);

		//解析HTTP应答信息
		$response = json_decode($result, true);
		//如果应答信息中的没有包含任何的Topic信息,则直接跳过


		$messages = new MultiMessage();

		foreach((array)$response as &$item) {
			if(empty($item) || empty($item['msgId'])) {
				continue;
			}

			$msg = new Message();
			$msg->id = $item['msgId'];
			$msg->tag = $item['tag'];
			$msg->key = $item['key'];
			$msg->body = $item['body'];
			$msg->bornTime = $item['bornTime'];
			$msg->handle = $item['msgHandle'];
			$msg->reconsumeTimes = $item['reconsumeTimes'];

			$messages[] = $msg;
		}

		return $messages;
	}

	public function remove(Message $msg) {
		$date = (int) (microtime(true) * 1000);
		$url = $this->url .'/message/?msgHandle='.$msg->handle.'&topic='.$this->topic.'&time='.$date;
		//签名字符串
		$signString = $this->topic ."\n".$this->id."\n".$msg->handle."\n".$date;
		//计算签名
		$sign = Util::calSignature($signString,$this->accessSecret);

		$result = Util::request('DELETE', $url, $this->header($sign), null);

		return $result;
	}

	protected function header($sign) {
		return [
			'Signature:'.$sign,
			'AccessKey:'.$this->accessKey,
			'ConsumerID:'.$this->id,
			'Content-Type:text/html;charset=UTF-8',
		];
	}
}