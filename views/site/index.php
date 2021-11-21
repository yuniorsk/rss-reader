<?php
/* @var $this yii\web\View */
/* @var $searchForm \app\models\forms\SearchForm */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $models \app\models\FeedItem[] */

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <h1 class="my-5">My RSS feed</h1>

    <?= Html::beginForm(Url::current(['SearchForm' => null, 'page' => null]), 'get', ['class' => 'form-inline']) ?>
        <?= Html::activeTextInput($searchForm, 'title', [
            'class' => 'form-control mb-2 mr-sm-2',
            'placeholder' => 'Search title...'
        ]) ?>
        <?= Html::activeDropDownList($searchForm, 'feedId', $searchForm->getFeedListOptions(), [
            'class' => 'form-control mb-2 mr-sm-2',
            'prompt' => 'Select feed',
        ]) ?>
        <button type="submit" class="btn btn-primary mb-2 mr-sm-2">Search</button>
        <a href="<?= Url::current(['SearchForm' => null, 'page' => null]) ?>" class="btn btn-light mb-2">Reset</a>
    <?= Html::endForm() ?>

    <?php foreach($models as $model): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="card-subtitle text-muted"><?= Html::encode($model->userFeed->user_title) ?></h6>
                <h5 class="card-title">
                    <a href="<?= Html::encode($model->url) ?>" target="_blank" rel="noopener" class="text-dark"><?= Html::encode($model->title) ?></a>
                </h5>
                <p class="card-text"><small class="text-muted"><?= Yii::$app->formatter->asDate($model->published_at) ?></small></p>
                <p class="card-text"><?= Html::encode(StringHelper::truncate($model->summary, 500)) ?></p>
                <a href="<?= Html::encode($model->url) ?>" target="_blank" rel="noopener" class="card-link">Read more</a>
            </div>
        </div>
    <?php endforeach; ?>

    <?= \yii\bootstrap4\LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
</div>
