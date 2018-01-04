<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'Мой блог';
?>
   <h1>Мой блог</h1>
    <?php
        if($news) {
            foreach($news as $news_1){
                show_comment($comments_structure,$news_1->id,0);
            }
        }
    ?>
<?= Html::a('Новая новость', ['/news/create'], ['class'=>'btn btn-success'])?>
<?php
function show_comment($comments_structure,$id,$level){
    if(!empty($comments_structure[$id]['comment']))
        $comment_1=$comments_structure[$id]['comment'];
    if(isset($comment_1->title)){
        ?>
        <div class="row">
            <div class="col-md-6 col-md-offset-<?= $level<6 ? $level : 6 ?>">
                <div class="row bg-info">
                    <div class="col-md-4" style="word-wrap: break-word;"><p><?= $comment_1->title ?></p></div>
                    <div class="col-md-4"><p><?= $comment_1->user->username ?></p></div>
                    <div class="col-md-4"><p><?= Yii::$app->formatter->asDatetime($comment_1->created_at, 'long')?></p></div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <?= Html::img('@web/images/'.$comment_1->image, ['alt' => $comment_1->title,'width'=>'180px']) ?>
                    </div>
                    <div class="col-md-8">
                        <p style="word-wrap: break-word;"><?= $comment_1->body ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <?php
                        if(!Yii::$app->user->isGuest && Yii::$app->user->identity->username == $comment_1->user->username) {
                            echo Html::a('Редактировать', ['/news/edit', 'id' => $comment_1->id], ['class' => 'text-primary']);
                            echo Html::a('Удалить', ['/news/delete', 'id' => $comment_1->id], ['class' => 'text-danger','style'=>'margin:10px;']);
                        }elseif(!Yii::$app->user->isGuest && $comment_1->comments) {
                            echo Html::a('Комментировать',
                                ['/news/comment',
                                    'parent_id' => $comment_1->id,
                                    'thread_id' => $comment_1->thread_id==0 ? $comment_1->id : $comment_1->thread_id],
                                ['class' => 'text-primary']
                            );
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if(!empty( $comments_structure[$id]['child']))
            foreach($comments_structure[$id]['child'] as $com2)
                show_comment($comments_structure,$com2,$level+1);
    }
}
?>