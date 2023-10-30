<?php

use common\models\User;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User $model */
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
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'confirm_password')->passwordInput() ?>
            <?= $form->field($model, 'status')
                ->widget(Select2::class, [
                    'data' => [
                        9 => 'Inactive',
                        10 => 'Active'
                    ],
                    'options'       => [
                        'prompt' => 'Pilih Status',
                    ],
                    'hideSearch' => true,
                    'pluginOptions' => [
                        'allowClear'            => false,
                        'dropdownParent' => new JsExpression('$("#myform")'),
                    ],
                ]) ?>
            <?= $form->field($model, 'role')
                ->widget(Select2::class, [
                    'data' => User::getRolesOptions(),
                    'options'       => [
                        'prompt' => 'Pilih Role',
                    ],
                    'hideSearch' => true,
                    'pluginOptions' => [
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
<?php ActiveForm::end(); ?>