<?php
/**
 * Created by PhpStorm.
 * User: phil
 * Date: 01/03/17
 * Time: 16:39
 */

namespace AliyunMQ\Util;


class Util
{
	//计算签名
	public static function calSignature($str,$key)
	{
		if(function_exists('hash_hmac'))
		{
			$sign = base64_encode(hash_hmac('sha1',$str,$key,true));
		}
		else
		{
			$blockSize = 64;
			$hashfunc = 'sha1';
			if(strlen($key) > $blockSize)
			{
				$key = pack('H*',$hashfunc($key));
			}
			$key = str_pad($key,$blockSize,chr(0x00));
			$ipad = str_repeat(chr(0x36),$blockSize);
			$opad = str_repeat(chr(0x5c),$blockSize);
			$hmac = pack(
				'H*',$hashfunc(
					($key^$opad).pack(
						'H*',$hashfunc($key^$ipad).$str
					)
				)
			);
			$sign = base64_encode($hmac);
		}
		return $sign;
	}

	public static function request($method, $url, $headers, $body) {
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);//设置HTTP请求类型,此处为POST
		curl_setopt($ch, CURLOPT_URL, $url); //设置HTTP请求的URL
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);//设置HTTP头部内容

		if($body) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);//设置HTTP请求的body
		}

		ob_start();//构造执行环境

		curl_exec($ch);//开始发送HTTP请求

		$result = ob_get_contents();//获取请求应答消息

		ob_end_clean();//清理执行环境

		curl_close($ch);//关闭连接
		return $result;
	}
}