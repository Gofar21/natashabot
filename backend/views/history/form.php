<?php

use kartik\date\DatePicker;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

?>
<?php $form = ActiveForm::begin([
    'id' => 'myform',
    'enableAjaxValidation' => true,
]); ?>
<div class="modal-header">
    <h5 class="modal-title">Form Dialogflow History</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    <div class="modal-status bg-primary"></div>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-lg-12">
            <?= $form->field($model, 'tanggal_awal')
                ->widget(DatePicker::class, [
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-MM-dd',
                    ],
                    'convertFormat' => true,
                    'removeButton' => false,
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                ]) ?>
            <?= $form->field($model, 'tanggal_akhir')
                ->widget(DatePicker::class, [
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-MM-dd',
                    ],
                    'convertFormat' => true,
                    'removeButton' => false,
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
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