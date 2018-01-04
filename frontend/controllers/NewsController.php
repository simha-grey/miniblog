<?php
namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use common\models\News;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class NewsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'update','delete','comment'],
                'rules' => [
                    [
                        'actions' => ['index','create', 'update','delete','comment'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'create' => ['post'],
//                ],
//            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new News();
        if ($model->load(Yii::$app->request->post())) {
            $dir=Yii::getAlias('@webroot');
            $f = UploadedFile::getInstance($model, 'image');
            if(!empty($f)){
                $new_file = uniqid().'_'.$f->name;
                $f->saveAs($dir.'/images/'.$new_file);
                $model->image=$new_file;
            }

            $model->author = Yii::$app->user->id;
            $model->thread_id = 0;
            $model->parent_id = 0;
            $model->save();
            return $this->redirect(['news/index']);
        }else
            return $this->render('create', [
                'model' => $model,
            ]);

    }

    public function actionComment()
    {
        $model = new News();
        if ($model->load(Yii::$app->request->post())) {
            $dir=Yii::getAlias('@webroot');
            $f = UploadedFile::getInstance($model, 'image');
            if(!empty($f)) {
                $new_file = uniqid() . '_' . $f->name;
                $f->saveAs($dir . '/images/' . $new_file);
                $model->image = $new_file;
            }
            /*
             * parent_id thread_id Will come via POST
             * */
            $model->author = Yii::$app->user->id;
            $model->save();
            return $this->redirect(['news/index']);

        }else {
            $request = Yii::$app->request;
            $thread_id = $request->get('thread_id');
            $parent_id = $request->get('parent_id');
            return $this->render('comment', [
                'model' => $model,
                'thread_id' => $thread_id,
                'parent_id' => $parent_id,
            ]);
        }

    }

    public function actionEdit()
    {
        $request = Yii::$app->request;
        $id = $request->get('id');
        $old = News::find()
        ->where(['id' => $id])
        ->one();
        $dir=Yii::getAlias('@webroot');
        @unlink($dir . '/images/' . $old->image);

       // $model = new News();
        if ($old->load(Yii::$app->request->post())) {

            $f = UploadedFile::getInstance($old, 'image');
            if(!empty($f)) {
                $new_file = uniqid() . '_' . $f->name;
                $f->saveAs($dir . '/images/' . $new_file);
                $old->image = $new_file;
            }

            $old->update();
            return $this->redirect(['news/index']);

        }else {
            return $this->render('edit', [
                'model' => $old,
            ]);
        }
    }

    public function actionDelete()
    {
        $request = Yii::$app->request;
        $id = $request->get('id');
        $old = News::find()
            ->where(['id' => $id])
            ->one();
        //TODO should delete thread beneath
        $old->delete();
        return $this->redirect(['news/index']);
    }

    public function actionIndex()
    {
        $comments_structure=[];
        if(isset(Yii::$app->user->id)) {
            $news = News::find()->
                where(['author' => Yii::$app->user->id])->
                orderBy(['created_at' => SORT_ASC])
                ->all();

            foreach($news as $news_1){
                $comments_structure[0]['child'][]=$news_1->id;
                $comments_structure[$news_1->id]['child']=[];
                $comments_structure[$news_1->id]['comment']=$news_1;
                $comments = News::find()->
                where(['thread_id' => $news_1->id])->
                orderBy(['created_at' => SORT_ASC])
                    ->all();

                foreach($comments as $comment_1){
                    if(!empty($comment_1->parent_id)){
                        $comments_structure[$comment_1->parent_id]['child'][]=$comment_1->id;
                        $comments_structure[$comment_1->id]['comment']=$comment_1;
                    }
                }
            }
        }

        return $this->render('index', [
            'news' => $news,
            'comments_structure' => $comments_structure,
        ]);
    }
}
