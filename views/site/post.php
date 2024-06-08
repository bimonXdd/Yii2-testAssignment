<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;
?>
<h1>Posts</h1>
<ul>
<?php foreach ($posts as $post): ?>
    
    <div class="form-group">
        <div>
            <?=Html::a($post->title, Url::to(['site/comments', 'post_id' => $post->ID]), [
                'class' => 'btn btn-primary',]); ?>
        </div>
    </div>

    
        <?= Html::encode("{$post->createdBy->username}") ?>:
        <?= $post->created_at ?>
        <?= $post->body ?>

<?php endforeach; ?>
</ul>

<?= LinkPager::widget(['pagination' => $pagination]) ?>