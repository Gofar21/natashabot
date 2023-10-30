<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reservasi".
 *
 * @property int $id
 * @property int $pelanggan_id
 * @property string $tanggal
 * @property string $waktu
 * @property int $perawatan_id
 * @property int $klinik_id
 * @property int $dokter_id
 *
 * @property Dokter $dokter
 * @property Klinik $klinik
 * @property Pelanggan $pelanggan
 * @property Perawatan $perawatan
 */
class Reservasi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reservasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pelanggan_id', 'tanggal', 'waktu', 'perawatan_id', 'klinik_id', 'dokter_id'], 'required'],
            [['pelanggan_id', 'perawatan_id', 'klinik_id', 'dokter_id'], 'integer'],
            [['tanggal', 'waktu'], 'safe'],
            [['pelanggan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pelanggan::class, 'targetAttribute' => ['pelanggan_id' => 'id']],
            [['perawatan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perawatan::class, 'targetAttribute' => ['perawatan_id' => 'id']],
            [['klinik_id'], 'exist', 'skipOnError' => true, 'targetClass' => Klinik::class, 'targetAttribute' => ['klinik_id' => 'id']],
            [['dokter_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dokter::class, 'targetAttribute' => ['dokter_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pelanggan_id' => 'Pelanggan ID',
            'tanggal' => 'Tanggal',
            'waktu' => 'Waktu',
            'perawatan_id' => 'Perawatan ID',
            'klinik_id' => 'Klinik ID',
            'dokter_id' => 'Dokter ID',
        ];
    }

    /**
     * Gets query for [[Dokter]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDokter()
    {
        return $this->hasOne(Dokter::class, ['id' => 'dokter_id']);
    }

    /**
     * Gets query for [[Klinik]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKlinik()
    {
        return $this->hasOne(Klinik::class, ['id' => 'klinik_id']);
    }

    /**
     * Gets query for [[Pelanggan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPelanggan()
    {
        return $this->hasOne(Pelanggan::class, ['id' => 'pelanggan_id']);
    }

    /**
     * Gets query for [[Perawatan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerawatan()
    {
        return $this->hasOne(Perawatan::class, ['id' => 'perawatan_id']);
    }
}
