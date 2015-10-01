<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "goods_photos".
 *
 * @property integer $id
 * @property integer $good_id
 * @property string $name
 *
 * @property Goods $good
 */
class GoodsPhotos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_photos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['good_id', 'name'], 'required'],
            [['good_id'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'good_id' => 'Good ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGood()
    {
        return $this->hasOne(Goods::className(), ['id' => 'good_id']);
    }

    /*
     * return all photos
     */

    public static function getItemsByGoodId($good_id){
        $model = self::find()->where(['good_id'=>$good_id])->all();
        if($model){
            return $model;
        }else{
            return false;
        }
    }
}
