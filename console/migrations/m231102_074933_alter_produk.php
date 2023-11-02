<?php

use yii\db\Migration;

/**
 * Class m231102_074933_alter_produk
 */
class m231102_074933_alter_produk extends Migration
{
    const TABLE_NAME = '{{%produk}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE_NAME, 'file_upload', $this->string(500)->notNull());
        $this->addColumn(self::TABLE_NAME, 'deskripsi', $this->string(500)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE_NAME, 'file_upload');
        $this->dropColumn(self::TABLE_NAME, 'deskripsi');
    }
}
