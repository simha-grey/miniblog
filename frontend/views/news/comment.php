<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'Комментирование новости';
$request = Yii::$app->request;
$thread_id = $request->get('thread_id');
$parent_id = $request->get('parent_id');
?>
<h1>Комментируем новость</h1>
<?= $this->render('_form', [
    'model' => $model,
    'thread_id' => $thread_id,
    'parent_id' => $parent_id,
    'author' => Yii::$app->user->id
]) ?>