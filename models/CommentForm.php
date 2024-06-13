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
            [['body'], 'string'],
            [['post_id'], 'integer'],
        ];
    }

    public function createComment()
    {
        $comment = new Comment();
        $user = Yii::$app->user->id;           //if no user, set user to guest
        if($user == null) $user = 1;
        $comment->created_by = $user;
        $comment->body = $this->body;
        $comment->created_at = date('Y-m-d H:i:s');
        $comment->post_id = $this->post_id;
        return $comment->save();;
    }
}
