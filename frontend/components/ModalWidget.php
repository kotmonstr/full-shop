<?php
namespace frontend\components;

use yii\base\Widget;

class ModalWidget extends Widget
{


    public function init()
    {
        parent::init();

    }

    public function run()
    {

        return $this->render('modal');
    }
}