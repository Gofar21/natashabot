<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\search\ProdukSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="produk-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row align-items-end">
        <div class="col-lg-3 col-md-6 col-sm-12">
            <?= $form->field($model, 'keyword')->textInput([
                'placeholder' => 'search'
            ])
                ->label(false) ?>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="mb-3">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                <?= Html::button(
                    'Reset',
                    [
                        'class' => 'btn btn-warning',
                        'type' => 'button',
                        'id' => 'button-reset'
                    ]
                ) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>