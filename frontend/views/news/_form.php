<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
?>
<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(['id' => 'news-form']); ?>

        <?= $form->field($model, 'title')->textInput(['autofocus' => true])->label('Заглавие') ?>

        <?= $form->field($model, 'body')->textarea(['rows' => '6'])->label('Текст') ?>

        <?php
        if(!empty($model->image)){
            echo Html::img('@web/images/'.$model->image, ['alt' => $model->title,'width'=>'180px']);
        }
        ?>

        <?= $form->field($model, 'image')->fileInput(['accept' => '.png,.jpg,.jpeg'])->label('Изображение') ?>

        <?= $form->field($model, 'comments')->checkbox()->label('Включить каменты') ?>

        <?= $form->field($model, 'thread_id')->hiddenInput(['value'=> $thread_id])->label(false)?>

        <?= $form->field($model, 'parent_id')->hiddenInput(['value'=> $parent_id])->label(false)?>

        <?= $form->field($model, 'author')->hiddenInput(['value'=> $author])->label(false)?>
        <?php
        if(!empty($id)){
            echo $form->field($model, 'id')->hiddenInput(['value'=> $id])->label(false);
        }
        ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'save']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>