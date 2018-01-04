<?php
/* @var $this yii\web\View */

$this->title = 'Редактирование новости';
$request = Yii::$app->request;
$id = $request->get('id');
?>
    <h1>Редактируем новость</h1>
<?= $this->render('_form', [
    'model' => $model,
    'id' => $id,
    'thread_id' => $model->thread_id,
    'parent_id' => $model->parent_id,
    'author' => Yii::$app->user->id
]) ?>