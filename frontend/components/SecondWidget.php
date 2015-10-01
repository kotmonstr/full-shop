<?php
namespace frontend\components;

use yii\base\Widget;

class SecondWidget extends Widget
{


    public function init()
    {
        parent::init();
        ob_start();

    }

    public function run()
    {
        $content = ob_get_clean();
        //vd($content);
        return $this->render('second',['content'=> '****'.$content.'+++']);
    }
}