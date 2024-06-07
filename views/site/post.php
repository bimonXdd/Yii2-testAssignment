<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;
?>
<h1>Posts</h1>
<ul>
<?php foreach ($posts as $post): ?>
    <li>
        <?= Html::encode("{$post->title} ({$post->created_by})") ?>:
        <?= $post->body ?>
        <?= $post->created_at ?>


        <div class="form-group">
                <div>
                    <?=
                    Html::a('Send Info', Url::to(['site/comments', 'post_id' => $post->ID]), [
                            'class' => 'btn btn-primary',
                            ]); ?>
                </div>
            </div>
    
<?php endforeach; ?>
</ul>

<?= LinkPager::widget(['pagination' => $pagination]) ?>