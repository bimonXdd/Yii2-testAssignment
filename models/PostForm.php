<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;


class PostForm extends Model
{
    public $body;
    public $title;

    public $imageFile;

    public function rules()
    {
        return [
            [['title', 'body'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['body'], 'string'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, mp4', 'maxSize' => 1024*1024*50],
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
        if ($this->imageFile instanceof UploadedFile) {
            if ($this->upload()) {
                $post->image = 'uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
            } else {
                $post->image = null; // or handle the upload error
            }
        }
        return $post->save();
    }

    public function upload()
    {
        if ($this->validate()) {
            $uploadPath = Yii::getAlias('@webroot/uploads/');
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $fileName = $this->imageFile->baseName;
            $filePath = $uploadPath . $fileName . '.' . $this->imageFile->extension;
            return $this->imageFile->saveAs($filePath);
        } else {
            return false;
        }
    }
}
