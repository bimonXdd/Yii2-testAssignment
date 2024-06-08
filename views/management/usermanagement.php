<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-management">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'], 

            'id', 
            'username', 
            'email:email', 

            [
                'class' => 'yii\grid\ActionColumn', // Action column with view, update, delete buttons
                'template' => '{view} {update} {delete}', 
            ],
        ],
    ]); ?>
</div>
