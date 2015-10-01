<?php

namespace app\modules\shop;

use Yii;
use common\models\Setup;


class Module extends \yii\base\Module
{

    public $controllerNamespace = 'app\modules\shop\controllers';

    public function init()
    {

        parent::init();
        Yii::$app->language = Setup::getAndSetCurrLang();


    }

    // Вернет картинку товара если есть иначе дефаультную
    public static function getGoodImage($image = null)
    {
        //vd(Yii::getAlias('@frontend') . '/web/upload/goods-crop/' . $image);
        if ($image && file_exists(Yii::getAlias('@frontend') . '/web/upload/goods/' . $image)) {
            return '/upload/goods/' . $image;
        } else {
            return '/img-custom/no_photo.jpg';
        }
    }
       // Вернет картинку стфтьи если есть иначе дефаультную
    public static function getBlogImage($image = null)
    {
        //vd(Yii::getAlias('@frontend') . '/web/upload/goods-crop/' . $image);
        if ($image && file_exists(Yii::getAlias('@frontend') . '/web/upload/blog/' . $image)) {
            return '/upload/blog/' . $image;
        } else {
            return '/img-custom/no_photo.jpg';
        }
    }

      // Вернет дополнительную картинку товара если есть иначе дефаультную
    public static function getGoodImageExtra($image = null)
    {
        //vd(Yii::getAlias('@frontend') . '/web/upload/goods-extra' . $image);
        if ($image && file_exists(Yii::getAlias('@frontend') . '/web/upload/goods-extra/' . $image)) {
            return '/upload/goods-extra/' . $image;
        } else {
            return '/img-custom/no_photo.jpg';
        }
    }

    // вернет url
    public function GetPath(){
        $moduleName = Yii::$app->controller->module->id;
        $controllerName = Yii::$app->controller->id;
        $actionName = Yii::$app->controller->action->id;
        $PATH = $moduleName .'/'. $controllerName .'/'. $actionName;
        return $PATH;

    }

}
