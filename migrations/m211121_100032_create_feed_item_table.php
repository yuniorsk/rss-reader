<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%feed_item}}`.
 */
class m211121_100032_create_feed_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%feed_item}}', [
            'id' => $this->primaryKey(),
            'feed_id' => $this->integer()->notNull(),
            'uid' => $this->string()->notNull(),
            'url' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),
            'author' => $this->string()->null(),
            'summary' => $this->text()->null()->append('COLLATE "utf8mb4_unicode_ci"'),
            'published_at' => $this->timestamp()->null(),
            'created_at' => $this->timestamp()->null(),
            'updated_at' => $this->timestamp()->null(),
        ]);

        $this->createIndex('feed_id_uid', '{{%feed_item}}', ['feed_id', 'uid'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%feed_item}}');
    }
}
