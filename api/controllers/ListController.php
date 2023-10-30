<?php

namespace api\controllers;

use api\models\Endpoint;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;

class ListController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        $result = [];

        $result[] = new Endpoint('perawatan');
        $result[] = new Endpoint('produk_kategori');
        $result[] = new Endpoint('produk');
        return $result;
    }
}
