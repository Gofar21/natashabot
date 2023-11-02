<?php

namespace frontend\controllers;

use Gumlet\ImageResize;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class ImageController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
        ];
    }

    protected function getImage($path, $filename)
    {
        if (file_exists(Yii::$app->params['folder_upload'][$path] . $filename)) {
            $image = new ImageResize(Yii::$app->params['folder_upload'][$path] . $filename);
        } else {
            $image = new ImageResize(Yii::getAlias('@frontend') . "/web/images/default.png");
        }

        return $image;
    }

    public function actionResize($width = 150, $height = 150, $path = '', $fileName = '')
    {
        $image = $this->getImage($path, $fileName);
        $image->crop($width, $height, true);
        $image->output(null, 100);
    }

    public function actionView($path = 'produk', $fileName = 'default.jpg')
    {
        $image = $this->getImage($path, $fileName);
        $image->output(null, 100);
    }

    public function actionDownload($path = '', $fileName = '')
    {
        header('Content-disposition: attachment; filename="' . $fileName . '"');
        $image = $this->getImage($path, $fileName);
        $image->output(null, 100);
    }
}
