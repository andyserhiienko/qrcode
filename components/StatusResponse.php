<?php
namespace app\components;

use Yii;

class StatusResponse
{
    public function handle($code)
    {
        $method = 'handle' . $code;
        return method_exists($this, $method)
            ? $this->$method()
            : $this->handleUnknown($code);
    }

    private function handle200()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->statusCode = 200;

        return [
            'success' => true,
            'message' => 'OK',
        ];
    }

    private function handle400()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->statusCode = 400;
        return [
            'success' => false,
            'error' => 'This URL is not available'
        ];
    }

    private function handle404()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->statusCode = 404;

        return [
            'success' => false,
            'error' => 'Not Found',
        ];
    }

    private function handle500()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->statusCode = 500;
        return [
            'success' => false,
            'error' => 'Something wrong'
        ];
    }

    private function handleUnknown($code)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->statusCode = 502;

        return [
            'success' => false,
            'error' => 'Данный URL недоступен',
        ];
    }    
}