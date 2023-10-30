<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "pelanggan".
 *
 * @property int $id
 * @property string $nama
 * @property string $alamat
 * @property string $no_hp
 * @property string $email
 *
 * @property Reservasi[] $reservasis
 */
class Pelanggan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pelanggan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'alamat', 'no_hp', 'email'], 'required'],
            [['nama', 'alamat', 'no_hp', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'alamat' => 'Alamat',
            'no_hp' => 'No Hp',
            'email' => 'Email',
        ];
    }

    /**
     * Gets query for [[Reservasis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReservasis()
    {
        return $this->hasMany(Reservasi::class, ['pelanggan_id' => 'id']);
    }

    public static function getDataList($filter)
    {
        $query = self::find()
            ->select(['id', 'nama'])
            ->orderBy('nama');
        if ($filter) {
            $query->where($filter);
        }
        return $query->all();
    }

    public static function getOptions($filter = null)
    {
        return ArrayHelper::map(self::getDataList($filter), 'id', 'nama');
    }
}
