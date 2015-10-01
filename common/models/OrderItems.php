<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_items".
 *
 * @property integer $id
 * @property integer $order_id
 * @property string $ip
 * @property integer $goods_id
 * @property integer $quantity
 * @property integer $price
 * @property integer $category_id
 * @property integer $brend_id
 *
 * @property Order $order
 * @property Goods $category
 * @property Brend $brend
 * @property Goods $goods
 */
class OrderItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'ip', 'goods_id', 'quantity', 'price', 'category_id'], 'required'],
            [['order_id', 'goods_id', 'quantity', 'price', 'category_id', 'brend_id'], 'integer'],
            [['ip'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'ip' => 'Ip',
            'goods_id' => 'Goods ID',
            'quantity' => 'Quantity',
            'price' => 'Price',
            'category_id' => 'Category ID',
            'brend_id' => 'Brend ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Goods::className(), ['category_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrend()
    {
        return $this->hasOne(Brend::className(), ['id' => 'brend_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoods()
    {
        return $this->hasOne(Goods::className(), ['id' => 'goods_id']);
    }

    // Добавление товаров в заказ
    public static function Add($model,$order_id,$created_at){
        //vd($model);
        $arrResult=[];
        $i=0;
        foreach($model as $good){
            $i++;
            $model = new self;
            $model->order_id = $order_id;
            $model->ip = Yii::$app->session->id;
            $model->goods_id = $good->goods_id;
            $model->quantity = $good->quantity;
            $model->price = $good->price;
            $model->category_id = $good->category_id;
            $model->brend_id = $good->brend_id;
            $model->created_at = $created_at;
            $model->save();

            $arrResult[$i]['created_at']=$created_at;
            $arrResult[$i]['good_id'] = $model->goods_id;
            $arrResult[$i]['quantity'] = $model->quantity;
            $arrResult[$i]['price'] = $model->price;

        }
        return $arrResult;
    }
}
