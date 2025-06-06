<?php

namespace app\validators;

use yii\validators\Validator;


class UrlStructureValidator extends Validator
{
	public function validateAttribute($model,$attribute)
	{
		$url = $model->$attribute;

		if(mb_strlen($url) > 185){
			$this->addError($model,$attribute,'Недопустимый размер');
			return;
		}

		if(!filter_var($url,FILTER_VALIDATE_URL)){
			$this->addError($model,$attribute,'URL имеет некорректный формат');
			return;
		}

		$parts = parse_url($url);

		if(!isset($parts['scheme']) || !in_array($parts['scheme'],['http','https'])){
			$this->addError($model,$attribute,'Схема должна быть http или https');
			return;
		}

		if(!isset($parts['host'])){
			$this->addError($model,$attribute,'URL должен содержать домен.');
			return;
		}

		$hostParts = explode('.',$parts['host']);
		if(count($hostParts) > 3){
			$this->addError($model,$attribute,'Домен должен иметь структуру resource.domain или resource.subdomain.domain');
			return;
		}
	}
}