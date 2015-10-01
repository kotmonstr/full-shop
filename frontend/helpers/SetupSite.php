<?php
namespace frontend\helpers;

use Yii;
use common\models\Setup;
use common\models\Exchange;

class SetupSite
{
//public $countPostOnPage;

    public static function getParam($param)
    {
        $param = Setup::find()->where(['param_name'=>$param])->one();
        if($param){
            return $param->param_value;
        }else{
            return false;
        }

    }
/*
 *   'USD' => $USD,
    'UKR' => $UKR,
    'EUR' => $EUR,
 */
    public static function getCurs($valute)
    {
        $param = Setup::find()->where(['param_name'=>$valute . date("d-m-Y",time())])->one();
        if($param){
            return $param->param_value;
        }else{
            $rates = new Exchange(time());
            $curs = $rates->GetRate($valute);
            // Обновить курс
            $model = new Setup();
            $model->param_name = (string)$valute . date("d-m-Y",time());
            $model->param_value = (string)$curs;
            //$model->validate();
            //vd($model->getErrors());
            $model->save();
            return $curs;
        }

    }
}