<?php

namespace app\models;

use Yii;
use yii\base\Model;

class CommentForm extends Model
{
    public $body;
    public $post_id;

    public function __construct($post_id = null, $config = [])
    {
        $this->post_id = $post_id;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['body', 'post_id'], 'required'],
            [['body'], 'string'],
            [['post_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'body' => 'Comment',
            'post_id' => 'Post ID',
        ];
    }

    public function createComment()
    {
        $comment = new Comment();
        $user = Yii::$app->user->id;
        if($user == null) $user = 0;
        $comment->created_by = $user;
        $comment->body = $this->body;
        $comment->created_at = date('Y-m-d H:i:s');
        $comment->post_id = $this->post_id;
        $comment->save();
        return true;
    }
}
