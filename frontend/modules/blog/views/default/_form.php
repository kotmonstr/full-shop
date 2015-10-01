<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use yii\helpers\Url;
use frontend\assets\AppAsset;

$this->registerJsFile('/eshop/js/upload-image-blog.js',['depends'=> \frontend\assets\ShopAsset::className()]);
?>


<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

<?= $form->field($model, 'image')->hiddenInput(['maxlength' => 255])->label('') ?>

<div class="form-group">
    <?= Html::button('Выбрать фото', ['class'=>'btn btn-success','onclick'=>'$("#blog-file").click()']) ?>
</div>
<div class="form-group image_target">
    <?php if ($model->image): ?>
        <img src="/upload/blog/<?= $model->image ?>" height="200" width="200" alt="">
    <?php endif; ?>
</div>




<?= $form->field($model,
    'content')->widget(Widget::className(), [
    'settings' => [
        'lang' => 'ru',
        'minHeight' => 400,
        'pastePlainText' => true,
        'buttonSource' => true,
        'focus' => true,
        'imageUpload' => Url::to(['/blog/upload']),
        'imageManagerJson' => Url::to(['/blog/uploaded']),
        'plugins' => [
            'clips',
            'fullscreen',
            'imagemanager',

        ]
    ]
]) ?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>






<?php
$form = ActiveForm::begin([
            'action' => ['/image/submit'],
            'options' => ['enctype' => 'multipart/form-data'],
            'id' => 'form-send-file']);
?>
<?= $form->field($model, 'file')->fileInput(['class' => 'send-file','onchange'=>'QuickUploadImage()']) ?>

<?= Html::Button('Загрузить', ['class' => 'btn btn-success send-file-submit', 'onclick' => 'sendfile()']) ?>
<?php ActiveForm::end(); ?>

<style>
    #form-send-file{
        display:none;
    }
    .btn-upload{
        background-color: #087B6E;
        padding: 7px;
        border-radius: 3px;
        position: absolute;
        right: 154px;
        top: 200px;
        color: #fff;
        cursor: pointer;
        z-index: 999999;
    }
</style>