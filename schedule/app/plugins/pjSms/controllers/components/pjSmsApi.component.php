<?php
class pjSmsApi
{
	private $apiKey;
	
	private $number;
	
	private $text;
	
	private $type = "";
	
	private $url = 'http://www.phpjabbers.com/web-sms/api/send.php';
	
	public function send()
	{
		$pjHttp = new pjHttp();
		
		$type = $this->type;
		$text = strip_tags($this->text);
		$text = htmlspecialchars_decode($text, ENT_QUOTES);
		$text = substr($text, 0, 160);
		if (in_array($type, array('unicode', 'longunicode')))
		{
			if ($type == 'unicode' && pjMultibyte::strlen($text) > 70) {
				$type = 'longunicode';
			}
			$text = self::toUnicode($text);
		}
		
		$params = http_build_query(array(
			'number' => $this->number,
			'message' => $text,
			'key' => $this->apiKey,
			'type' => $type
		));
		
		return $pjHttp->request($this->url ."?". $params)->getResponse();
	}
	
	public function setApiKey($str)
	{
		$this->apiKey = $str;
		return $this;
	}
	
	public function setNumber($str)
	{
		$this->number = $str;
		return $this;
	}
	
	public function setText($str)
	{
		$this->text = $str;
		return $this;
	}

	public function setType($str)
	{
		$this->type = $str;
		return $this;
	}

	static public function toUnicode($str)
	{
		$string = html_entity_decode($str, ENT_QUOTES, pjMultibyte::detect_encoding($str));
		$string = pjMultibyte::convert_encoding($string, 'UCS-2');
		$result = "";
		$iCnt = strlen($string);
		for ($i = 0; $i < $iCnt; $i++)
		{
			$result .= strtoupper(bin2hex($string[$i]));
		}

		return $result;
	}
}
?>