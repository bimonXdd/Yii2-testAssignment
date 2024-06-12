<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Update User: ' . $user->username;
$this->params['breadcrumbs'][] = ['label' => 'User Management', 'url' => ['usermanagement']];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($updatedUser, 'username')->textInput(['maxlength' => true]) ?>
    <?= $form->field($updatedUser, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($updatedUser, 'password')->passwordInput(['maxlength' => false]) ?> 

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>