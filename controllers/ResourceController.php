<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\OpenSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

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
        $model = new \app\models\CheckUrlForm();
        $model->load(Yii::$app->request->getBodyParams(),'');

        if($model->validate()){
            $code = Yii::$app->externalApi->checkResource($model->url);

            if($code == 200){
                $md5 = md5($model->url);
                $row = (new \yii\db\Query())
                    ->select(['short','qr'])
                    ->from('links')
                    ->where(['md5'=>$md5])
                    ->one();

                if(!$row){
                    $path = Yii::$app->shortUrlManager->pathToFileDirectory();
                    $hash = Yii::$app->shortUrlManager->hash();
                    $fullFilePath = $path . '/' . $hash . '.png';
                    $shortLink = Yii::$app->shortUrlManager->shortLink($hash);
                    $relativePathOfQR = Yii::$app->shortUrlManager->relativePath($fullFilePath);

                    $builder = new Builder(
                        writer: new PngWriter(),
                        writerOptions: [],
                        validateResult: false,
                        data: $shortLink, 
                        encoding: new Encoding('UTF-8'),
                        errorCorrectionLevel: ErrorCorrectionLevel::High,
                        size: 270,
                        margin: 10
                    );

                    $qr = $builder->build();

                    if(Yii::$app->shortUrlManager->saveToDirectory($fullFilePath,$qr->getString()) === false){
                        return Yii::$app->responseHandler->handle(500);
                    }

                    Yii::$app->db->createCommand()
                        ->insert('links',[
                            'full' => $model->url,
                            'short' => $hash,
                            'md5' => $md5,
                            'qr' => $relativePathOfQR,
                        ])
                        ->execute();

                    $lasid = Yii::$app->db->getLastInsertID();

                    Yii::$app->db->createCommand()
                        ->insert('counter',[
                            'id_link' => $lasid
                        ])
                        ->execute();
                }else{
                    $shortLink = Yii::$app->shortUrlManager->shortLink($row['short']);
                    $relativePathOfQR = $row['qr'];
                }

                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                Yii::$app->response->statusCode = 200;
                    
                return [
                    'success' => true,
                    'data' => ['qr'=>$relativePathOfQR,'link'=>$shortLink],
                ];                
            }

            return Yii::$app->responseHandler->handle($code);
        }else{
            return Yii::$app->responseHandler->handle(400);
        }     
    }

}
