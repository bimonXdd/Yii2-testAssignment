<?php
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\LinkPager;
use yii\helpers\Url;
use yii\web\View;
?>
<?php
    $this->registerCssFile('@web/css/custom.css');
?>
<h1>Posts</h1>
<ul class="posts">
<?php foreach ($posts as $post): ?>

    <div class="post">
            <div class = "post-title">
                <?=Html::a($post->title, Url::to(['site/comments', 'post_id' => $post->ID]), [
                    'class' => 'post-title-text',]); ?>
            </div>

            
        

            <div class="post-info">
            <p class="created_by"><?= Html::encode("{$post->createdBy->username}") ?></p>
            <p class="created_at"><?= $post->created_at ?></p>
            
            </div>
            
            <div class = "post-body">
                <?= StringHelper::truncateWords(Html::encode($post->body),40) ?>
            </div>

        <?php  
        //if user is anadmin
        if(Yii::$app->user->getId() == 1):  ?>    
            <?= Html::beginForm(['site/delete-post', 'id' => $post->ID], 'post', ['class' => 'delete-form']) ?>
            <?= Html::submitButton('Delete', ['class' => 'btn btn-danger', 'data-confirm' => 'Are you sure you want to delete this post?']) ?>
            <?= Html::endForm();
        endif; ?>
            
            
        
    </div>
    
<?php endforeach; ?>
</ul>

<?= LinkPager::widget(['pagination' => $pagination]) ?>