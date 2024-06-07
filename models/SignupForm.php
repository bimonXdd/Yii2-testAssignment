<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SignupForm extends Model{
    public $username;
    public $password;
    public $passwordAgain;
    public $email;



    public function rules(){
        return [

            [["username","password","passwordAgain","email"],"required"],
            [["email"],"email"],
            [["passwordAgain"],'compare', 'compareAttribute'=>"password"]
        ];
    }

    public function Signup(){
        $user = new User();
        $user->username = $this->username;
        $user->password = $this->password;
        //Yii::$app->security->generatePasswordHash($this->password);
        $user->email = $this->email;
        $user->authkey = Yii::$app->security->generateRandomString();
        $user->token = Yii::$app->security->generateRandomString();
        return $user->save();


    }
}
