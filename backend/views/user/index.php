<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\search\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

?>
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>User</h3>
                <p class="text-subtitle text-muted">
                    Halaman untuk mengelola User.
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= Url::to(['/']) ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            User
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
                            'template' =>  '{edit}&nbsp;{image}&nbsp;{delete}',
                            'buttons' => [
                                'edit' => function ($url, $model, $key) {
                                    return Html::a(
                                        Html::tag('i', null, [
                                            "class" => "iconly-boldEdit",
                                            "data-bs-toggle" => "tooltip",
                                            "data-bs-placement" => "bottom",
                                            "title" => "Edit",
                                            "data-bs-original-title" => "Edit",
                                            "aria-label" => "Edit"
                                        ]),
                                        [Yii::$app->controller->id . '/update/' . $model->id],
                                        [
                                            "class" => "text-primary btn_modal",
                                            "data-pjax" => "0"
                                        ]
                                    );
                                },
                                'delete' => function ($url, $model, $key) {
                                    return Html::a(
                                        Html::tag('i', null, [
                                            "class" => "iconly-boldDelete",
                                            "data-bs-toggle" => "tooltip",
                                            "data-bs-placement" => "bottom",
                                            "title" => "Delete",
                                            "data-bs-original-title" => "Delete",
                                            "aria-label" => "Delete",
                                        ]),
                                        [Yii::$app->controller->id . '/delete/' . $model->id],
                                        [
                                            "class" => "text-danger btn_delete",
                                            "data-pjax" => "0"
                                        ]
                                    );
                                },
                            ],
                        ],
                        'username',
                        'email',
                        [
                            'attribute' => 'Status',
                            'value' => function ($model) {
                                return $model->getStatus();
                            }
                        ],
                        [
                            'label' => 'Role',
                            'value' => function ($model) {
                                $roles = Yii::$app->authManager->getRolesByUser($model->id);
                                $result = [];
                                foreach ($roles as $role) {
                                    $result[] = $role->description;
                                }
                                return $result ? implode(",", $result) : '-';
                            }
                        ]
                    ],
                ]); ?>

                <?php Pjax::end(); ?>
            </div>
        </div>
    </section>
</div>