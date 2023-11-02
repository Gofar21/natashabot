<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "promo".
 *
 * @property int $id
 * @property string $nama
 */
class Promo extends \yii\db\ActiveRecord
{
    public $attachment;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'promo';
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

    public function upload()
    {
        if (!empty($this->attachment)) {
            $filename = time() . '_' . $this->id . '_' . $this->attachment->baseName . '.' . $this->attachment->extension;
            $this->attachment->saveAs(Yii::$app->params['folder_upload']['promo'] . $filename);
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
                    ['/promo/detail/' . $model->id],
                    true
                );
        };
        $fields['url_file'] = function ($model) {
            return Yii::$app
                ->urlFrontend
                ->createAbsoluteUrl(
                    ['/image/view/promo/' . $model->file_upload],
                    true
                );
        };
        return $fields;
    }
}
