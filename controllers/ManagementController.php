<?php
namespace app\controllers;

use app\models\updateuserForm;
use app\models\User;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use app\models\Post;
use app\models\Comment;

//Controller for user management (PS REQUIRES TO BE LOGGED AS ADMIN)
//methods: update, delete

class ManagementController extends Controller
{


    
    public function actionUsermanagement(){
        if(Yii::$app->user->isGuest){
            throw new ForbiddenHttpException('Register or log in to make a new post.');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'username' => SORT_DESC,
                ],
            ],
        ]);


        return $this->render("usermanagement",['dataProvider' =>$dataProvider]);
    }


    public function actionDelete($id){
        $user = User::findOne($id);
        if ($user === null) {
            throw new NotFoundHttpException("The requested user does not exist.");
        }

        //delete all the users comments-posts 
        $posts = Post::find()->where(['created_by'=>$id])->all();
        foreach($posts as $post){
            $comments = Comment::find()->where(['post_id'=> $post->ID])->all();
            foreach ($comments as $comment) {
                $comment->delete();
            }
            $post->delete();
        }

        if ($user->delete()) {Yii::$app->session->setFlash('success', 'User deleted successfully.');}
         else {Yii::$app->session->setFlash('error', 'Failed to delete the user.');}

        return $this->redirect(['usermanagement']);
    }


    //Query the database and rewrite the user based on the form
    public function actionUpdate($id){
        $user = User::findOne($id);
        $updatedUser = new updateuserForm();
    
        if ($user === null) {
            throw new NotFoundHttpException("The requested user does not exist.");
        }
    
        $isUpdateable = in_array($id, [1]) ? true : false;
        if ($isUpdateable) {
            throw new ForbiddenHttpException("Cannot edit guest profile.");
        }
    
        if ($updatedUser->load(Yii::$app->request->post()) && $updatedUser->validate()) {
            Yii::$app->db->createCommand()->update('user', [
                'username' => $updatedUser->username,
                'email' => $updatedUser->email,
                'password' => $updatedUser->password,
            ], 'id = :id', [':id' => $id])->execute();
    
            Yii::$app->session->setFlash('success', 'User updated successfully.');
            return $this->redirect(['usermanagement']);
        }
    
        return $this->render('update', [
            'updatedUser' => $updatedUser,
            'user' => $user,
        ]);
    }

}