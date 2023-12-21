<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use common\widgets\Alert;
use kartik\editors\assets\CodemirrorAsset;
use kartik\editors\assets\SummernoteBs5Asset;
use kartik\number\NumberControlAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;
use yii\web\View;

AppAsset::register($this);
// SummernoteBs5Asset::register($this);
// CodemirrorAsset::register($this);
// NumberControlAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="<?= Url::to(['/images/natasha-gold.png']) ?>">
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <div id="app">
        <?= $this->render('_sidebar') ?>

        <div id="main" class="layout-navbar">
            <?= $this->render('_header') ?>
            <div id="main-content">
                <?= $content ?>
                <?= $this->render('_footer') ?>
            </div>
        </div>
    </div>

    <!-- Begin Default Form Modal -->
    <div class="modal fade modal-blur" id="form-modal" role="dialog" aria-labelledby="myModalLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content form-modal-content scroll">

            </div>
        </div>
    </div>
    <!-- Begin Default Modal Small for alert -->
    <div class="modal fade modal-blur" id="form-modal-sm" role="dialog" aria-labelledby="form-modal-sm" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content form-modal-content scroll">

            </div>
        </div>
    </div>

    <!-- Begin Default Modal Large for alert -->
    <div class="modal fade modal-blur" id="form-modal-lg" role="dialog" aria-labelledby="form-modal-lg" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content form-modal-content scroll">

            </div>
        </div>
    </div>

    <!-- Begin Default Delete Confirmation -->
    <div class="modal fade modal-blur" id="delete-modal" role="dialog" aria-labelledby="myModalLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content form-modal-content scroll">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-primary"></div>
                <div class="modal-body text-center py-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 9v2m0 4v.01"></path>
                        <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75"></path>
                    </svg>

                    <h3>Delete Data</h3>
                    <div class="text-muted">Are You Sure?</div>
                </div>
                <div class="modal-footer">
                    <div class="w-100">
                        <div class="row">
                            <div class="col">
                                <a href="#" class="btn w-100" data-bs-dismiss="modal">Cancel</a>
                            </div>
                            <div class="col">
                                <a href="#" class="btn btn-danger w-100" id="btn-delete-data-modal">Delete Data</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $this->endBody() ?>

    <?php
    if ($pesan = Yii::$app->session->getAllFlashes()) {
        foreach ($pesan as $key => $message) {
            echo "
                <script>
                $key(\"$message\");       
                </script>";
        }
    }
    ?>
</body>

</html>
<?php $this->endPage();
