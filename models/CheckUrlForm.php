<?php

namespace app\models;

use yii\base\Model;
use app\validators\UrlStructureValidator;

class CheckUrlForm extends Model
{
    public $url;

    public function rules()
    {
        return [
            [['url'], 'required'],
            ['url', UrlStructureValidator::class],
        ];
    }
}