<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "blog_comments".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property integer $blog_id
 * @property string $author_name
 * @property string $text
 * @property integer $created_at
 * @property string $email
 * @property string $city
 *
 * @property BlogComments $parent
 * @property BlogComments[] $blogComments
 * @property Blog $blog
 */
class BlogComments extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    //ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],

        ];

    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog_comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['blog_id', 'author_name', 'text'], 'required'],
            [['parent_id', 'blog_id', 'created_at'], 'integer'],
            [['text'], 'string'],
            [['author_name', 'city'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogComments::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['blog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Blog::className(), 'targetAttribute' => ['blog_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'blog_id' => 'Blog ID',
            'author_name' => 'Вше имя',
            'text' => 'Вше сообщение',
            'created_at' => 'Created At',
            'email' => 'Email',
            'city' => 'Ваш город',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(BlogComments::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogComments()
    {
        return $this->hasMany(BlogComments::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlog()
    {
        return $this->hasOne(Blog::className(), ['id' => 'blog_id']);
    }

    /*
     *  Вернет все коментарии этого поста
     */

    public static function getComentsByBlogId($id)
    {
        $model = self::find()->where(['blog_id' => $id])->orderBy('created_at DESC')->all();
        if ($model) {
            return $model;
        } else {
            return false;
        }
    }
}
