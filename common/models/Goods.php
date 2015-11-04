<?php

namespace common\models;

use Yii;
use common\models\GoodsCategory;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property string $item
 * @property integer $price
 * @property integer $category_id
 * @property integer $quantity
 * @property string $descr
 * @property integer $status
 */
class Goods extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DESABLE = 0;
    const BEST = 1;

    public $image_file;
    public $new_image;
    public $image_file_extra;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }

    public function behaviors()
    {
        return [
//            'timestamp' => [
//                'class' => 'yii\behaviors\TimestampBehavior',
//                'attributes' => [
//                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
//                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
//                ],
//                'value' => new Expression('NOW()'),
//            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => 'user_id',
            ],

        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item', 'price', 'category_id', 'quantity', 'descr', 'status'], 'required'],
            [['price', 'category_id', 'quantity', 'status', 'best', 'rating', 'brend_id'], 'integer'],
            [['descr', 'image'], 'string'],
            [['item'], 'string', 'max' => 255],
            [['image_file'], 'file', 'extensions' => 'gif, jpg,png'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item' => 'Имя',
            'price' => 'Цена',
            'category_id' => 'Категория товара',
            'quantity' => 'Количество',
            'descr' => 'Описание',
            'status' => 'Статус',
            'image' => 'Картинка',
            'brend_id' => 'Бренд Id',
            'best' => 'Рекомендованный',
            'rating' => 'Рейтинг'
        ];
    }

    /*
     * Вернет несколько последних товаров
     */
    public static function getNewest($q = 6)
    {
        $model = self::find()
            ->where(['status' => self::STATUS_ACTIVE])
            ->orderBy('id DESC')
            ->all();
        if ($model) {
            return $model;
        } else {
            return false;
        }
    }

    /*
   * Вернет рекомендованные товары
   */
    public static function getBest($max)
    {
        $model = self::find()
            ->where(['status' => self::STATUS_ACTIVE, 'best' => self::BEST])
            ->orderBy('id DESC')
            ->limit($max)
            ->all();
        if ($model) {
            return $model;
        } else {
            return false;
        }
    }

    /*
     * Вернет один товар
     */
    public static function getItemById($id)
    {
        $model = self::find()->where(['id' => $id])->one();
        if ($model) {
            return $model;
        } else {
            return false;
        }
    }

    /*
     * Вернет цену товара
     */
    public static function getPriceById($id)
    {

        $model = self::find()->where(['id' => $id])->one();
        if ($model) {
            return $model->price;
        } else {
            return false;
        }
    }

    /*
   * Вернет Имя товара
   */
    public static function getName($id)
    {

        $model = self::find()->where(['id' => $id])->one();
        if ($model) {
            return $model->item;
        } else {
            return false;
        }
    }

    /*
  * Вернет категорию товара
  */
    public static function getCategoryById($id)
    {
        $model = self::find()->where(['id' => $id])->one();
        if ($model) {
            return $model->category_id;
        } else {
            return false;
        }
    }

    /*
  * Вернет категорию товара
  */
    public static function getBrendById($id)
    {
        $model = self::find()->where(['id' => $id])->one();
        if ($model) {
            return $model->brend_id;
        } else {
            return false;
        }
    }

    /*
* Вернет товары этой категории
*/
    public static function getGoodsByCategoriId($id)
    {
        if ($id != 0) {
            $model = self::find()
                ->where(['category_id' => $id, 'status' => self::STATUS_ACTIVE])
                ->all();
        } else {
            $model = self::find()->all();
        }

        if ($model) {
            return $model;
        } else {
            return false;
        }
    }

    /*
* Вернет товары этоГо Бренда
*/
    public static function getGoodsByBrendId($id)
    {
        if ($id != 0) {
            $model = self::find()
                ->where(['brend_id' => $id, 'status' => self::STATUS_ACTIVE])
                ->all();
        } else {
            $model = self::find()->all();
        }

        if ($model) {
            return $model;
        } else {
            return false;
        }
    }

    /*
* Вернет товары этого бренда
*/
    public static function getQuantityOfGoodsByBrand($id)
    {
        if ($id != 0) {
            $model = self::find()
                ->where(['brend_id' => $id, 'status' => self::STATUS_ACTIVE])
                ->all();
        } else {
            $model = self::find()->all();
        }

        if ($model) {
            return $model;
        } else {
            return false;
        }
    }

    /*
* Вернет товары этого пользователя
*/
    public static function getQuantityOfGoodsByUserId()
    {


        $model = self::find()
            ->where(['status' => self::STATUS_ACTIVE, 'user_id' => Yii::$app->user->id])
            ->all();


        if ($model) {
            return count($model);
        } else {
            return false;
        }
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
    public function getCategory()
    {
        return $this->hasOne(GoodsCategory::className(), ['id' => 'category_id']);
    }

/*
 * return vodel goods by price range
 */
    public static function getGoodsByPriceRange($from, $to, $valute){
        $model = self::find()
            ->where(['>', 'price', $from])
            ->AndWhere(['<', 'price', $to])
            ->AndWhere(['status' => self::STATUS_ACTIVE])
            ->all();
        if ($model) {
            return $model;
        } else {
            return false;
        }
    }


}
