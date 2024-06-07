<?php

use yii\bootstrap5\ActiveField;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

?>
<h1><?= $post->title ?></h1>
<div>
<img src="fish.jpg" alt="Italian Trulli">
<?= $post->body ?>
<?php $form = ActiveForm::begin([
    'id' => 'comment-form',
    'action' => ['site/comments', 'post_id' => $post_id], // Adjusted action URL
    'method' => 'post',
]); ?>
<?= $form->field($commentForm, 'post_id')->hiddenInput(['post_id' => $post_id])->label(false) ?>
<?= $form->field($commentForm, 'body')->textarea(['rows' => 4]) ?>



<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
</div>

    

    <?php ActiveForm::end(); ?>
</div>


<h2>Previous comments</h2>
<ul>
<?php 
    if(count($post->comments) == 0): ?>
    <h4>No comments at the moment</h4>

    <?php
        else:
        foreach ($post->comments as $commentItem): ?>
            <h4><?= Html::encode($commentItem->createdBy->username)?><h4>
            <p><?= Html::encode($commentItem->body) ?></p>
            <?php   endforeach;
        endif;
?>
</ul>

