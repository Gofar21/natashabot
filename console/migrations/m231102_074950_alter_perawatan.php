<?php

use yii\db\Migration;

/**
 * Class m231102_074950_alter_perawatan
 */
class m231102_074950_alter_perawatan extends Migration
{
    const TABLE_NAME = '{{%perawatan}}';
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
