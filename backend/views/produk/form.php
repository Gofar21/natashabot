<?php

use common\models\ProdukKategori;
use kartik\file\FileInput;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\web\JsExpression;

/** @var yii\web\View $this */
/** @var common\models\Produk $model */
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
            <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'deskripsi')->textarea(['maxlength' => true]) ?>
            <?= $form->field($model, 'harga')
                ->widget(NumberControl::class, [
                    'maskedInputOptions' => [
                        'suffix' => ' Rupiah',
                        'allowMinus' => false,
                        'groupSeparator' => '.',
                        'radixPoint' => ','
                    ],
                ])  ?>

            <?= $form->field($model, 'produk_kategori_id')
                ->widget(Select2::class, [
                    'data' => ProdukKategori::getOptions(),
                    'options'       => [
                        'prompt' => 'Pilih Kategori Produk',
                    ],
                    'pluginOptions' => [
                        'width' => '100%',
                        'allowClear'            => false,
                        'dropdownParent' => new JsExpression('$("#myform")'),
                    ],
                ]) ?>
            <?= $form->field(
                $model,
                'attachment',
                [
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,
                ]
            )
                ->widget(FileInput::class, [
                    'pluginOptions' => [
                        'showPreview' => false,
                        'showCaption' => true,
                        'showRemove' => true,
                        'showUpload' => false
                    ]
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
<?php ActiveForm::end(); ?>