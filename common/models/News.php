<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;


/**
 * News model
 *
 * @property integer $id
 * @property string $title
 * @property string $body
 * @property string $image
 * @property string $author
 * @property integer $thread_id
 * @property integer $parent_id
 * @property integer $created_at
 * @property integer $comments
 */
class News extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'author']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['title', 'string', 'length' => [10, 200]],
            ['body', 'string', 'length' => [10, 1000]],
            ['comments', 'boolean'],
            ['thread_id', 'integer'],
            ['parent_id', 'integer'],
            ['author','integer'],
            ['id','integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }


    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }


}
