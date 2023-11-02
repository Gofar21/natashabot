<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "produk_kategori".
 *
 * @property int $id
 * @property string $nama
 *
 * @property Produk[] $produks
 */
class ProdukKategori extends \yii\db\ActiveRecord
{
    public $attachment;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produk_kategori';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['nama'], 'string', 'max' => 255],
            [['file_upload', 'deskripsi'], 'string', 'max' => 500],
            [['attachment'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
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
        ];
    }

    /**
     * Gets query for [[Produks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduks()
    {
        return $this->hasMany(Produk::class, ['produk_kategori_id' => 'id']);
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
            $this->attachment->saveAs(Yii::$app->params['folder_upload']['produk_kategori'] . $filename);
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
                    ['/produk_kategori/detail/' . $model->id],
                    true
                );
        };
        $fields['url_file'] = function ($model) {
            return Yii::$app
                ->urlFrontend
                ->createAbsoluteUrl(
                    ['/image/view/produk_kategori/' . $model->file_upload],
                    true
                );
        };
        return $fields;
    }
}
