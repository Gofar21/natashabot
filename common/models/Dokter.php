<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dokter".
 *
 * @property int $id
 * @property string $nama
 * @property string $alamat
 * @property string $no_hp
 *
 * @property Reservasi[] $reservasis
 */
class Dokter extends \yii\db\ActiveRecord
{
    public $attachment;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dokter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'alamat', 'no_hp'], 'required'],
            [['nama', 'alamat', 'no_hp'], 'string', 'max' => 255],
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
            'alamat' => 'Alamat',
            'no_hp' => 'No Hp',
        ];
    }

    /**
     * Gets query for [[Reservasis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReservasis()
    {
        return $this->hasMany(Reservasi::class, ['dokter_id' => 'id']);
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
            $this->attachment->saveAs(Yii::$app->params['folder_upload']['dokter'] . $filename);
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
                    ['/dokter/detail/' . $model->id],
                    true
                );
        };
        $fields['url_file'] = function ($model) {
            return Yii::$app
                ->urlFrontend
                ->createAbsoluteUrl(
                    ['/image/view/dokter/' . $model->file_upload],
                    true
                );
        };
        return $fields;
    }
}
