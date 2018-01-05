<?php

use yii\db\Migration;

/**
 * Handles the creation of table `news`.
 */
class m180105_164841_create_news_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'title' => $this->string(200)->notNull(),
            'body' => $this->string(1000)->notNull(),
            'image' => $this->string(400),
            'thread_id' => $this->integer()->notNull(),
            'parent_id' => $this->integer()->notNull(),
            'comments' => $this->smallInteger()->notNull()->defaultValue(0),
            'author' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('news');
    }
}
