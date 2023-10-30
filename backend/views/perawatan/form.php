<?php

use kartik\number\NumberControl;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Perawatan $model */
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

            <?= $form->field($model, 'harga')
                ->widget(NumberControl::class, [
                    'maskedInputOptions' => [
                        'suffix' => ' Rupiah',
                        'allowMinus' => false,
                        'groupSeparator' => '.',
                        'radixPoint' => ','
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
<?php ActiveForm::end(); ?>