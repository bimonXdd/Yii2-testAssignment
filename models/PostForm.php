<?php
namespace app\models;

use Yii;
use yii\base\Model;

class PostForm extends Model
{
    public $body;
    public $title;

    public function rules()
    {
        return [
            [['title', 'body'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['body'], 'string'],
        ];
    }

    public function createPost()
    {
        $post = new Post();
        $user = Yii::$app->user->id;
        if ($user === null) {
            $user = 0;
        }

        $post->created_by = $user;
        $post->body = $this->body; // Use the body from the form
        $post->created_at = date('Y-m-d H:i:s');
        $post->title = $this->title;
        $post->image = 'img';

        return $post->save();
    }
}
