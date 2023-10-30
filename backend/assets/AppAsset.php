<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $css = [
        'https://use.fontawesome.com/releases/v5.3.1/css/all.css',
        'css/main/app.css',
        'css/main/app-dark.css',
        'css/shared/iconly.css',
        'extensions/sweetalert2/sweetalert2.min.css',
    ];
    public $js = [
        'extensions/sweetalert2/sweetalert2.all.min.js',
        ['js/app.js', 'position' => \yii\web\View::POS_END],
        ['js/custom.js', 'position' => \yii\web\View::POS_END],
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        'yii\bootstrap5\BootstrapPluginAsset'
    ];
}
