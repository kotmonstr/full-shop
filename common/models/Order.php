<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property string $ip
 * @property integer $status
 * @property integer $created_at
 * @property integer $country_id
 * @property integer $city_id
 * @property integer $post_index
 * @property string $first_name
 * @property string $second_name
 * @property string $ser_name
 * @property integer $payment_type
 * @property string $telephone
 */
class Order extends \yii\db\ActiveRecord
{


    public static function tableName()
    {
        return 'order';
    }


    public function rules()
    {
        return [
            [['ip', 'status', 'created_at', 'city_id', 'payment_type' ], 'required'],
            [['status', 'created_at', 'country_id', 'city_id', 'post_index', 'payment_type','recall'], 'integer'],
            [['ip', 'telephone','street','login','password','comment'], 'string', 'max' => 255],
            [['first_name', 'second_name', 'ser_name'], 'string', 'max' => 100],
            [['first_name'], 'required','message'=>'Заполните "Имя"'],
            [['second_name'], 'required','message'=>'Заполните "Фамилия"'],
            [['ser_name'], 'required','message'=>'Заполните "Отчество"'],
            [['street'], 'required','message'=>'Заполните "Улица"'],
            [['telephone'], 'required','message'=>'Заполните "Телефон"'],


            //[['country_id'], 'compare', 'compareValue' => 1, 'operator' => '>='],
            [['country_id'], 'required','message'=>'Заполните "Город"'],

        ];
    }
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['submit'] = ['city_id','country_id', 'payment_type','telephone','first_name','second_name','ser_name','street','login','recall','password'];
        return $scenarios;
    }



public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'status' => '1-выполняется, 0 - выполнен',
            'created_at' => 'Created At',
            'country_id' => 'Country ID',
            'city_id' => 'City ID',
            'post_index' => 'Post Index',
            'first_name' => 'Имя',
            'second_name' => 'Фамилия',
            'ser_name' => 'Отчество',
            'payment_type' => 'Payment Type',
            'telephone' => 'Контактный телефон',
            'recall'=>'Перезвонить мне'
        ];
    }

    public static function getAllByLogin($login){
        $model = self::find()->where(['login'=>$login])->all();
        if($model){
            return  $model;
        }else{
            return false;
        }
    }
   public static function getOrderById($id){
        $model = self::find()->where(['id'=>$id])->one();
        if($model){
            return  $model;
        }else{
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(OrderStatus::className(), ['id' => 'status']);
    }

}
