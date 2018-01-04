<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'Создание новости';
$thread_id = 0;
$parent_id = 0;
?>
<h1>Новая новость</h1>
<?= $this->render('_form', [
    'model' => $model,
    'thread_id' => $thread_id,
    'parent_id' => $parent_id,
    'author' => Yii::$app->user->id
]) ?>