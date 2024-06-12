<?php

namespace app\models;

use yii\base\Model;

class updateuserForm extends Model{
    public $username;
    public $password;
    public $email;



    public function rules(){
        return [

            [["username","password","email"],"required"],
            [["email"],"email"],
        ];
    }

}