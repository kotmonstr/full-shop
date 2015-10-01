<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "setup".
 *
 * @property integer $id
 * @property string $param_name
 * @property string $param_value
 */
class Setup extends \yii\db\ActiveRecord
{
    // Валюта
    const RUB = 1;
    const DOLLAR = 2;
    const UAN = 3;

    // Язык
    const RU = 1;
    const EN = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['param_name'], 'string', 'max' => 50],
            [['param_value'], 'string', 'max' => 255],
            [['user_id'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'param_name' => 'Param Name',
            'param_value' => 'Param Value',
        ];
    }

    // return currency
    public static function changeCurrencyTo($cur)
    {
        $indef = Yii::$app->user->id ? (string)Yii::$app->user->id : (string)Yii::$app->session->id;
        //vd($indef);
        $model = self::find()->where(['user_id' => $indef, 'param_name' => 'currency'])->one();
        //vd($model);
        if ($model) {

            // сравнить и изменить
            if ($model->param_value != $cur) {
                $model->param_value = $cur;
                $model->updateAttributes(['param_value']);
                return $model->param_value;
            } else {
                return self::RUB;
            }

        } else {
            //vd(4);
            $_model = new self();
            $_model->param_name = 'currency';
            $_model->param_value = $cur;
            $_model->user_id = $indef;
            //vd(yii::$app->user->id);
            //$_model->validate();
            //vd($_model->getErrors());
            $_model->save();
            return $cur;

        }
    }
      // return lang
    public static function changeLangTo($lang)
    {

        $indef = isset(Yii::$app->user->id) ? Yii::$app->user->id : Yii::$app->session->id;
        //vd($indef);
        $model = self::find()->where(['user_id' => $indef, 'param_name' => 'lang', 'param_value' => [self::RU, self::EN]])->one();
        //vd($model);
        if ($model) {

            // сравнить и изменить
            if ($model->param_value != $lang) {
                $model->param_value = $lang;
                $model->updateAttributes(['param_value']);
                return $model->param_value;
            } else {
                return self::RU;
            }

        } else {
            //vd(4);
            $_model = new Setup();
            $_model->param_name = 'lang';
            $_model->param_value = (string)$lang;
            $_model->user_id = (string)$indef;
            //vd(yii::$app->user->id);
            //$_model->validate();
            //vd($_model->getErrors());
            $_model->save();
            return $lang;

        }
    }

// return вернет текущую валюту
    public static function getCurrCurency()
    {
        $indef = Yii::$app->user->id ? Yii::$app->user->id : Yii::$app->session->id;
        $model = self::find()->where(['user_id' => $indef, 'param_name' => 'currency', 'param_value' => [self::RUB, self::DOLLAR, self::UAN]])->one();
        if ($model) {
            switch ($model->param_value) {
                case 1:
                    return  'RUB';

                case 2:
                    return 'DOLLAR';

                case 3:
                    return 'UAN';

            }
        } else {
            return 'RUB';
        }

    }


    // return вернет текущий язык
    public static function getCurrLang()
    {
        $indef = Yii::$app->user->id ? Yii::$app->user->id : Yii::$app->session->id;
        $model = self::find()->where(['user_id' => $indef, 'param_name' => 'lang', 'param_value' => [self::RU, self::EN]])->one();
        if ($model) {
            switch ($model->param_value) {
                case 1:
                    return 'RU';
                case 2:
                    return 'EN';
            }
        } else {
            return 'RU';
        }
    }
       // return вернет текущий язык
    public static function getAndSetCurrLang()
    {
        $indef = Yii::$app->user->id ? Yii::$app->user->id : Yii::$app->session->id;
        $model = self::find()->where(['user_id' => $indef, 'param_name' => 'lang', 'param_value' => [self::RU, self::EN]])->one();
        if ($model) {
            switch ($model->param_value) {
                case 1:
                    //Yii::$app->language = 'ru-RU';
                    return 'en_US';

                case 2:
                    //Yii::$app->language = 'en_US';
                    return 'ru-RU';
            }
        } else {
            //Yii::$app->language = 'ru-RU';
            return 'ru-RU';

        }

    }

}
