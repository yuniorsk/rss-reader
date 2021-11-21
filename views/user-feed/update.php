<?php
/* @var $this \yii\web\View */
/* @var $model \app\models\UserFeed */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = 'Update feed';
?>

<div class="update-feed">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to update feed:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-update-feed']); ?>

            <?= $form->field($model->source, 'url')->textInput(['disabled' => true]) ?>

            <?= $form->field($model, 'user_title')->textInput(['autofocus' => true])->label('Title') ?>

            <div class="form-group">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
