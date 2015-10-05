<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii;

class DefaultController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [

                    [
                        'allow' => true,
                        //'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex() {
        if(Yii::$app->user->isGuest){
            $this->redirect('/shop/login');
        }

        if(Yii::$app->user->identity->role == 10){
              $this->layout='/adminka-admin';
        }else{
            $this->layout='/adminka-admin';
            //vd(Yii::$app->user->identity->role);
            //$this->layout='/adminka-user';
        }

        return $this->render('index');
    }

}
