<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "produk".
 *
 * @property int $id
 * @property string $nama
 * @property float $harga
 * @property int $produk_kategori_id
 *
 * @property ProdukKategori $produkKategori
 */
class Produk extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'harga', 'produk_kategori_id'], 'required'],
            [['harga'], 'number'],
            [['produk_kategori_id'], 'integer'],
            [['nama'], 'string', 'max' => 255],
            [['produk_kategori_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProdukKategori::class, 'targetAttribute' => ['produk_kategori_id' => 'id']],
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
            'harga' => 'Harga',
            'produk_kategori_id' => 'Produk Kategori ID',
        ];
    }

    /**
     * Gets query for [[ProdukKategori]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdukKategori()
    {
        return $this->hasOne(ProdukKategori::class, ['id' => 'produk_kategori_id']);
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
