<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\CommentForm;
use app\models\Comment;
use app\models\Post;
use app\models\PostForm;
use app\models\SignupForm;
use app\models\User;
use yii\data\Pagination;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionPost(){
        $query = Post::find();
        $pagination = new Pagination([
            'defaultPageSize' => 6,
            'totalCount' => $query->count(),
        ]);
        $posts = $query->orderBy('created_at')
        ->offset($pagination->offset)
        ->limit($pagination->limit)
        ->all(); 

        return $this->render('post',[
            'posts' => $posts,
            'pagination' => $pagination,]);
        }

       
        public function actionComments($post_id){
            $post = Post::findOne($post_id);
            $commentForm = new CommentForm($post->ID);

        
            if ($commentForm->load(Yii::$app->request->post()) && $commentForm->createComment()) {        
                return $this->refresh();;
            }
            else{
                return $this->render('comments', [
                'post' => $post,
                'commentForm' => $commentForm,
                'post_id' => $post->ID
            ]);}
        
        }
        public function actionNewpost(){
            $postForm = new PostForm();

            if ($postForm->load(Yii::$app->request->post()) && $postForm->createPost()) {
                return $this->redirect(['post']); // Ensure the redirect target is correct
            } else {
                return $this->render('newpost', ['postForm' => $postForm]);
            }
        }
        public function actionSignup(){
            $SignupForm = new SignupForm();
            if ($SignupForm->load(Yii::$app->request->post()) && $SignupForm->signup()) {
                return $this->redirect(['login','model'=> $SignupForm]);
            }else{
                return $this->render('signup', ['model'=>$SignupForm]);
            }
        }
}
