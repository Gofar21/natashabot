<?php

use yii\db\Migration;

/**
 * Class m231102_074927_alter_produk_kategori
 */
class m231102_074927_alter_produk_kategori extends Migration
{
    const TABLE_NAME = '{{%produk_kategori}}';
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
