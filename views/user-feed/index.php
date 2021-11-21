<?php
/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

use yii\helpers\Html;

$this->title = 'My feeds';
?>

<h1><?= Html::encode($this->title) ?></h1>
<p>Here you can manage your RSS feeds.</p>

<?= \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'user_title',
            'label' => 'Title',
        ],
        [
            'attribute' => 'source.url',
            'label' => 'Url',
            'format' => 'url',
        ],
        'created_at:datetime',
        ['class' => 'yii\grid\ActionColumn', 'template'=>'{update} {delete}'],
    ],
]) ?>
