<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reservasi}}`.
 */
class m231020_021200_create_reservasi_table extends Migration
{
    const TABLE_NAME = '{{%reservasi}}';
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
            'pelanggan_id' => $this->integer()->notNull(),
            'tanggal' => $this->date()->notNull(),
            'waktu' => $this->time()->notNull(),
            'perawatan_id' => $this->integer()->notNull(),
            'klinik_id' => $this->integer()->notNull(),
            'dokter_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey(
            'reservasi_ibfk_1',
            self::TABLE_NAME,
            'pelanggan_id',
            'pelanggan',
            'id',
            'NO ACTION',
            'CASCADE'
        );

        $this->addForeignKey(
            'reservasi_ibfk_2',
            self::TABLE_NAME,
            'perawatan_id',
            'perawatan',
            'id',
            'NO ACTION',
            'CASCADE'
        );

        $this->addForeignKey(
            'reservasi_ibfk_3',
            self::TABLE_NAME,
            'klinik_id',
            'klinik',
            'id',
            'NO ACTION',
            'CASCADE'
        );

        $this->addForeignKey(
            'reservasi_ibfk_4',
            self::TABLE_NAME,
            'dokter_id',
            'dokter',
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
        $this->dropForeignKey('reservasi_ibfk_1', self::TABLE_NAME);
        $this->dropForeignKey('reservasi_ibfk_2', self::TABLE_NAME);
        $this->dropForeignKey('reservasi_ibfk_3', self::TABLE_NAME);
        $this->dropForeignKey('reservasi_ibfk_4', self::TABLE_NAME);
        $this->dropTable(self::TABLE_NAME);
    }
}
