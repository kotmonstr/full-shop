<?php

namespace app\modules\patch\controllers;

use yii\web\Controller;
use common\models\NewsletterForm;
use Yii;
use common\models\Email;
use yii\filters\VerbFilter;
use common\models\EmailSearch;
use yii\filters\AccessControl;
use yii\mail\BaseMailer;

class DefaultController extends Controller
{


    public function actionIndex()
    {

        return $this->render('index');


    }
}