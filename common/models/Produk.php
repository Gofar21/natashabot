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
    public $attachment;
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
            [['file_upload', 'deskripsi'], 'string', 'max' => 500],
            [['attachment'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
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

    public function upload()
    {
        if (!empty($this->attachment)) {
            $filename = time() . '_' . $this->id . '_' . $this->attachment->baseName . '.' . $this->attachment->extension;
            $this->attachment->saveAs(Yii::$app->params['folder_upload']['produk'] . $filename);
            $this->file_upload = $filename;
            return $this->save(false);
        } else {
            return true;
        }
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['url_redirect'] = function ($model) {
            return Yii::$app
                ->urlFrontend
                ->createAbsoluteUrl(
                    ['/produk/detail/' . $model->id],
                    true
                );
        };
        $fields['url_file'] = function ($model) {
            return Yii::$app
                ->urlFrontend
                ->createAbsoluteUrl(
                    ['/image/view/produk/' . $model->file_upload],
                    true
                );
        };
        return $fields;
    }
}
