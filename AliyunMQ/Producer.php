<?php
/**
 * Created by PhpStorm.
 * User: phil
 * Date: 01/03/17
 * Time: 16:02
 */

namespace AliyunMQ;

use AliyunMQ\Model\MsgPushRes;
use AliyunMQ\Model\PushMsgModel;
use AliyunMQ\Util\Util;

class Producer
{
	protected $topic;
	protected $url;
	protected $accessKey;
	protected $accessSecret;
	protected $id; // 生产者id

	public function __construct($producerId, $topic, $url, $accessKey, $accessSecret)
	{
		$this->topic = $topic;
		$this->url = $url;
		$this->accessKey = $accessKey;
		$this->accessSecret = $accessSecret;
		$this->id = $producerId;
	}

	/**
	 * 推送消息
	 * @param PushMsgModel $msg
	 * @param int $retryTimes 失败后重试次数
	 * @return MsgPushRes
	 */
	public function push(PushMsgModel $msg, $retryTimes = 0) {
		$time = time() * 1000;
		$signString = implode("\n", [$this->topic, $this->id, md5($msg->body), $time]);
		$sign = Util::calSignature($signString, $this->accessSecret);

		$headers = [
			'Signature:' . $sign, // 签名
			'AccessKey:' . $this->accessKey, // 密钥
			'ProducerID:' . $this->id, // 生产者id
			'Content-Type:text/html;charset=UTF-8',//构造HTTP请求头部内容类型标记
		];
		$url = $this->url . '/message/?topic=' . $this->topic . '&time=' . $time . '&tag=' . $msg->tag . '&key=' . $msg->key;

		$model = new MsgPushRes();
		do {
			$res = Util::request('POST', $url, $headers, $msg->body);
			$data = json_decode($res, true);
			$model->msgId = $data['msgId'];
			$model->sendStatus = $data['sendStatus'];
			$retryTimes--;
		} while(!$model->ok() && $retryTimes >= 0); // 失败后重试

		return $model;
	}
}