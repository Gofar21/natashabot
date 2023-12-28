<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Dialogflow History</h3>
                <p class="text-subtitle text-muted">
                    Halaman untuk mengelola Data Produk.
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= Url::to(['/']) ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Dialogflow History
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <?= Html::a(
                    'Tambah',
                    ['create'],
                    ['class' => 'btn btn-primary btn_modal']
                ) ?>
            </div>
            <div class="card-body">
                <?php Pjax::begin(); ?>
                <?php echo $this->render('_search', ['model' => $searchModel]);
                ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => '{summary}<div class="table-responsive">{items}</div>{pager}',
                    'pager' => [
                        'class' => 'yii\bootstrap5\LinkPager'
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Action',
                            'options' => ["style" => "width:85px;"],
                            'contentOptions' => ["style" => "padding-left:12px;text-align:left;white-space:nowrap;", "class" => "action"],
                            'template' =>  '{detail}',
                            'buttons' => [
                                'detail' => function ($url, $model, $key) {
                                    return Html::a(
                                        Html::tag('i', null, [
                                            "class" => "fa fa-eye",
                                            "data-bs-toggle" => "tooltip",
                                            "data-bs-placement" => "bottom",
                                            "title" => "Detail",
                                            "data-bs-original-title" => "Detail",
                                            "aria-label" => "Detail"
                                        ]),
                                        [Yii::$app->controller->id . '/view', 'trace' => $model->trace],
                                        [
                                            "class" => "text-primary",
                                            "data-pjax" => "0"
                                        ]
                                    );
                                },
                            ]
                        ],
                        [
                            'attribute' => 'tanggal',
                            'format' => 'date'
                        ],
                        'trace',
                        'jumlah'
                    ],
                ]); ?>

                <?php Pjax::end(); ?>
            </div>
        </div>
    </section>
</div>