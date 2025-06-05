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
        $body = Yii::$app->request->getBodyParams();
        $model = new \app\models\CheckUrlForm();
        $model->load(Yii::$app->request->getBodyParams(),'');

        if($model->validate()){
            $code = Yii::$app->externalApi->checkResource($model->url);

            if($code == 200){
                $hash = md5($model->url);
                
            }

            return Yii::$app->responseHandler->handle($code);
        }else{
            return Yii::$app->responseHandler->handle(400);
        }     
    }

}
