<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => '<img src="https://natasha-skin.com/wp-content/uploads/2023/11/NATASHA-LOGO.png" style=" width:159px;" alt="..." >',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-light bg-light fixed-top',
        ],
    ]);
    $menuItems = [
        // ['label' => 'Test', 'url' => ['/site/test']],
        ['label' => 'Home', 'url' => ['/site']],
        ['label' => 'About', 'url' => ['/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
        ['label' => 'produk', 'url' => ['/site/produk']],
        ['label' => 'perawatan', 'url' => ['/perawatan']],

    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
    }
    ?>

    <?= $content ?>
    <style>
        df-messenger {
            --df-messenger-bot-message: #878fac;
            --df-messenger-button-titlebar-color: #df9b56;
            --df-messenger-chat-background-color: #fafafa;
            --df-messenger-font-color: white;
            --df-messenger-send-icon: #878fac;
            --df-messenger-user-message: #479b3d;
        }
    </style>
    <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
    <df-messenger intent="WELCOME" chat-title="Natasha" agent-id="27d0d0a2-f569-401a-9207-3f7ba539d670" language-code="id">

    </df-messenger>

    <footer class="footer mt-auto py-3 text-muted">
        <div class="container">
            <p class="float-start">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
            <p class="float-end"><?= Yii::powered() ?></p>
        </div>
    </footer>


<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
