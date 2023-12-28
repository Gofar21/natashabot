<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%dialogflow_history}}`.
 */
class m231224_071855_create_dialogflow_history_table extends Migration
{
    const TABLE_NAME = '{{%dialogflow_history}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'insert_id' => $this->string(100)->notNull(),
            'text_payload' => $this->text()->null(),
            'resource' => $this->text()->null(),
            'timestamp' => $this->dateTime()->null(),
            'receive_timestamp' => $this->dateTime()->null(),
            'log_name' => $this->string(300)->null(),
            'trace' => $this->string(100)->null(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
