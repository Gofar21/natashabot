<?php

namespace backend\models;

use common\components\GoogleLoggingApiData;
use yii\base\Model;

class DialogflowHistoryForm extends Model
{
    public $tanggal_awal;
    public $tanggal_akhir;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal_awal', 'tanggal_akhir'], 'required'],
            [['tanggal_awal', 'tanggal_akhir'], 'safe'],
        ];
    }

    public function saveData()
    {
        return GoogleLoggingApiData::ImportLog($this->tanggal_awal, $this->tanggal_akhir);
    }
}
