<?php
namespace frontend\components;

use common\models\Setup;
use yii\base\Widget;


class SetupWidget extends Widget
{

    public function init()
    {
        parent::init();
          $countPostOnPage = Setup::find()->where(['param_name'=>'countPostOnPage'])->one();
    }

    public function run()
    {
        $c = $this->a + $this->b;
        return $this->render('first',['c' => $c]);
    }
}

