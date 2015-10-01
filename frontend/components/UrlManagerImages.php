<?php
namespace frontend\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class UrlManagerImages extends Component
{
    public function createUrl($url)
    {
        if($url =='defaultUser')
        {
            return  Yii::$app->params['staticDomen'].'/img/default_avatar.jpg';
        }
    }

}