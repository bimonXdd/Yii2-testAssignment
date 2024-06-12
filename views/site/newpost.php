<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\captcha\Captcha;

$this->title = 'newPost';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
            <div class="col-lg-5">

            <?php $form = ActiveForm::begin([
            'id' => 'post-form',
            'method' => 'post',
        ]); ?>
        <?= $form->field($postForm, 'title')->textInput() ?>
        <?= $form->field($postForm, 'body')->textarea(['rows' => 6]) ?>
        <?= $form->field($postForm, 'imageFile')->fileInput() ?>
        <p>max img/video size: 40Mb</p>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'newpost-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>


            </div>
        </div>