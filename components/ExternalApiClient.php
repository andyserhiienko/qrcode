<?php
namespace app\components;

use Yii;

class ExternalApiClient{
	
	public static function checkResource($url)
	{
		$out = false;

		if($url){
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 7);
			curl_exec($ch);

			$out = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
		}

		return $out;
	}

}