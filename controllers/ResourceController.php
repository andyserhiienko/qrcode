<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class ResourceController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCheck()
    {
        $url = 'https://tenor.com/';
        $code = Yii::$app->externalApi->checkResource($url);
        return Yii::$app->responseHandler->handle($code);
    }
}
