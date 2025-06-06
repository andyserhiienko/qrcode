<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class LetsController extends Controller
{
    public function actionGo(string $hash)
    {
        $row = (new \yii\db\Query())
            ->select(['id','full'])
            ->from('links')
            ->where(['short'=>$hash])
            ->one();        
        
        if($row !== false){
            Yii::$app->db->createCommand()
                ->insert('logger',[
                    'ip' => Yii::$app->request->userIP,
                    'id_link' => $row['id']
                ])
                ->execute();

            Yii::$app->db->createCommand()
                ->update('counter',
                    ['count' => new \yii\db\Expression('count + 1')],
                    ['id_link' => $row['id']]
                )
                ->execute();

            return $this->redirect($row['full']);
        }
        
        return Yii::$app->responseHandler->handle(404);
    }
}
