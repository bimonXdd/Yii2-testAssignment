<?php
namespace app\controllers;

use app\models\User;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use Yii;
use yii\web\NotFoundHttpException;

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
        if ($user == null) {
            throw new NotFoundHttpException("The requested user does not exist.");
        }
        else if ($user->load(Yii::$app->request->post())){
            Yii::$app->db->createCommand()->update('user', [
                'username' => $user->username,
                'email' => 'updatedemail@example.com',
            ], 'id = :id', [':id' => $id])->execute();

            Yii::$app->session->setFlash('success', 'User updated successfully.');
            return $this->redirect(['usermanagement']);
        }

    

        return $this->render('update', [
            'model' => $user,
        ]);
    }

}