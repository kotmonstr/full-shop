<?php
namespace console\controllers;
use common\models\Email;

class EmailController extends \yii\console\Controller {

    public function actionIndex() {
        $model = new Email;
        $model->email = 'test';
        $model->save();
    }

}
