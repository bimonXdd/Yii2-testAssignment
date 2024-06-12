<?php
namespace app\controllers;

use app\models\updateuserForm;
use app\models\User;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;


class ManagementController extends Controller
{

    public function actionUsermanagement(){
        

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

        if ($user->delete()) {
            Yii::$app->session->setFlash('success', 'User deleted successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to delete the user.');
        }

        return $this->redirect(['usermanagement']);
    }

    public function actionUpdate($id){
        $user = User::findOne($id);
        $updatedUser = new updateuserForm();
        $isUpdateable = in_array($id, [0]) ? true : false;
        
        if ($user == null) {
            throw new NotFoundHttpException("The requested user does not exist.");
        }
        else if($isUpdateable){
            throw new ForbiddenHttpException("Cant edit guest profile");
        }
        else if ($updatedUser->load(Yii::$app->request->post()) and $isUpdateable){
            Yii::$app->db->createCommand()->update('user', [
                'username' => $updatedUser->username,
                'email' => $updatedUser->email,
            ], 'id = :id', [':id' => $id])->execute();

            Yii::$app->session->setFlash('success', 'User updated successfully.');
            return $this->redirect(['usermanagement']);
        }else{return $this->render('update', [
            'updatedUser' => $updatedUser,
            'user' => $user,
        ]);}

        
    }

}