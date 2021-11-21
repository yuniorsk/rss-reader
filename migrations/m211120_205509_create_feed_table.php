<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rss_feed}}`.
 */
class m211120_205509_create_feed_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%feed}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string()->notNull()->unique(),
            'title' => $this->string()->null(),
            'created_at' => $this->timestamp()->null(),
            'imported_at' => $this->timestamp()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%feed}}');
    }
}
