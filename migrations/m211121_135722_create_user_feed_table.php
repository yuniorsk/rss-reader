<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_feed}}`.
 */
class m211121_135722_create_user_feed_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_feed}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'feed_id' => $this->integer()->notNull(),
            'user_title' => $this->string(),
            'created_at' => $this->timestamp()->null(),
            'updated_at' => $this->timestamp()->null(),
        ]);

        $this->createIndex('user_id_feed_id', '{{%user_feed}}', ['user_id', 'feed_id'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_feed}}');
    }
}
