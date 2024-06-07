<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $ID
 * @property int $created_by
 * @property string $body
 * @property string $created_at
 * @property string $image
 * @property string $title
 *
 * @property Comment[] $comments
 * @property User $createdBy
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_by', 'body', 'created_at'], 'required'],
            [['created_by'], 'integer'],
            [['body'], 'string'],
            [['created_at'], 'safe'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'created_by' => 'Created By',
            'body' => 'Body',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['post_id' => 'ID']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['ID' => 'created_by']);
    }
    public function getPoster(){
        return $this->hasOne(User::class, ['ID' => 'created_by']);

    }
}
