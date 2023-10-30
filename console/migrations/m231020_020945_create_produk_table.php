<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%produk}}`.
 */
class m231020_020945_create_produk_table extends Migration
{
    const TABLE_NAME = '{{%produk}}';
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
            'harga' => $this->decimal(20, 2)->notNull(),
            'produk_kategori_id' => $this->integer()->notNull(),
        ], $tableOptions);


        $this->addForeignKey(
            'produk_ibfk_1',
            self::TABLE_NAME,
            'produk_kategori_id',
            'produk_kategori',
            'id',
            'NO ACTION',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('produk_ibfk_1', self::TABLE_NAME);
        $this->dropTable(self::TABLE_NAME);
    }
}
