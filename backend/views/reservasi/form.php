<?php

use common\models\Dokter;
use common\models\Klinik;
use common\models\Pelanggan;
use common\models\Perawatan;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\web\JsExpression;

/** @var yii\web\View $this */
/** @var common\models\Reservasi $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin([
    'id' => 'myform',
    'enableAjaxValidation' => true,
]); ?>
<div class="modal-header">
    <h5 class="modal-title">Form Pembicara</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    <div class="modal-status bg-primary"></div>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-lg-12">
            <?= $form->field($model, 'pelanggan_id')
                ->widget(Select2::class, [
                    'data' => Pelanggan::getOptions(),
                    'options'       => [
                        'prompt' => 'Pilih Pelanggan',
                    ],
                    'pluginOptions' => [
                        'width' => '100%',
                        'allowClear'            => false,
                        'dropdownParent' => new JsExpression('$("#myform")'),
                    ],
                ]) ?>

            <?= $form->field($model, 'tanggal')->textInput() ?>

            <?= $form->field($model, 'waktu')->textInput() ?>

            <?= $form->field($model, 'perawatan_id')
                ->widget(Select2::class, [
                    'data' => Perawatan::getOptions(),
                    'options'       => [
                        'prompt' => 'Pilih Perawatan',
                    ],
                    'pluginOptions' => [
                        'width' => '100%',
                        'allowClear'            => false,
                        'dropdownParent' => new JsExpression('$("#myform")'),
                    ],
                ]) ?>

            <?= $form->field($model, 'klinik_id')
                ->widget(Select2::class, [
                    'data' => Klinik::getOptions(),
                    'options'       => [
                        'prompt' => 'Pilih Klinik',
                    ],
                    'pluginOptions' => [
                        'width' => '100%',
                        'allowClear'            => false,
                        'dropdownParent' => new JsExpression('$("#myform")'),
                    ],
                ]) ?>

            <?= $form->field($model, 'dokter_id')
                ->widget(Select2::class, [
                    'data' => Dokter::getOptions(),
                    'options'       => [
                        'prompt' => 'Pilih Dokter',
                    ],
                    'pluginOptions' => [
                        'width' => '100%',
                        'allowClear'            => false,
                        'dropdownParent' => new JsExpression('$("#myform")'),
                    ],
                ]) ?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <?= Html::button("Simpan", [
        'type' => 'submit',
        'class' => 'btn btn-primary'
    ]);
    ?>
</div>