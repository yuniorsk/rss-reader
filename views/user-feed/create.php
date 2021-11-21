<?php
/* @var $this \yii\web\View */
/* @var $model \app\models\forms\AddFeedForm */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = 'Add new feed';
?>

<div class="create-feed">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to add feed:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-create-feed']); ?>

            <?= $form->field($model, 'url')->textInput(['autofocus' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

