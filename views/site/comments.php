<?php


use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->registerCssFile('@web/css/commentSection.css');
?>

<h1 class="post-title"><?= $post->title ?></h1>
<div>

<div>
    <?php
    $webRoot = Yii::getAlias('@web');
    $filePath = $webRoot . '/' . $post->image;
    
    if (in_array($fileType, ['image/jpeg', 'image/png'])) {
        echo Html::img($filePath, ['alt' => '', 'class' => 'image-video']);
    } else if ($fileType == 'video/mp4') {
        echo Html::tag('video', Html::tag('source', '', [
            'src' => $filePath,
            'type' => 'video/mp4',
        ]), [
            'controls' => true,
            'class' => 'image-video'
        ]);
    }
     
    ?>
    
</div>



<?= $post->body ?>
<?php $form = ActiveForm::begin([
    'id' => 'comment-form',
    'action' => ['site/comments', 'post_id' => $post_id], // Adjusted action URL
    'method' => 'post',
]); ?>
<?= $form->field($commentForm, 'post_id')->hiddenInput(['post_id' => $post_id])->label(false) ?>
<?= $form->field($commentForm, 'body')->textarea(['rows' => 4])->label('<h3>Leave a comment:</h3>') ?>

<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
</div>

    <?php ActiveForm::end(); ?>
</div>




<h4>Previous comments</h4>
<ul>
<?php 
    if(count($post->comments) == 0): ?>
    <h4 class="comment">No comments at the moment</h4>
    
    <?php
        else:

        foreach ($post->comments as $commentItem): ?>
        <div class="comment-form">
            <div class="comment">
                <p class="created_by"><?= Html::encode($commentItem->createdBy->username)?><p>
                <p><?= Html::encode($commentItem->body) ?></p>
            </div>

            <?php  
            //if user is anadmin
            if(Yii::$app->user->getId() == 1):  ?>    
                <?= Html::beginForm(['site/delete-comment', 'id' => $commentItem->ID], 'post', ['class' => 'delete-form']) ?>
                <?= Html::submitButton('Delete', ['class' => 'btn btn-danger', 'data-confirm' => 'Are you sure you want to delete this comment?']) ?>
                <?= Html::endForm();
            endif; ?>
        </div>
        
        <?php   endforeach;

    endif;
?>
</ul>

