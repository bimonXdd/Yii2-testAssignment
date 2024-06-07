<?php

use yii\bootstrap5\ActiveField;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

?>
<h1>comments</h1>
<div>
<?php $form = ActiveForm::begin([
    'id' => 'comment-form',
    'action' => ['site/comments', 'post_id' => $post_id], // Adjusted action URL
    'method' => 'post',
]); ?>

<?= $form->field($commentForm, 'post_id')->hiddenInput(['post_id' => $post_id])->label(false) ?>
<?= $form->field($commentForm, 'body')->textarea(['rows' => 6]) ?>



<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
</div>

    

    <?php ActiveForm::end(); ?>
</div>


<h2>Comments</h2>
<ul>
<?php foreach ($post->comments as $commentItem): ?>
    <p><?= Html::encode($commentItem->body) ?></p>
<?php endforeach; ?>
</ul>

