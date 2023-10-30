<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pelanggan}}`.
 */
class m231020_020857_create_pelanggan_table extends Migration
{
    const TABLE_NAME = '{{%pelanggan}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'nama' => $this->string()->notNull(),
            'alamat' => $this->string()->notNull(),
            'no_hp' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
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
