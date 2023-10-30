<?php

Yii::$container->set('yii\grid\CheckboxColumn', [
    'header' => '<input type="checkbox" class="checkall">',
    'contentOptions' => [
        "style" => "width:10px;text-align:center;"
    ],
]);

Yii::$container->set('yii\grid\SerialColumn', [
    'options' => [
        "style" => "width:85px;"
    ],
    'header' => 'No',
]);

Yii::$container->set('yii\grid\ActionColumn', [
    'header' => 'Action',
    'options' => [
        "style" => "width:100px;"
    ],
    'contentOptions' => [
        "style" => "padding-left:12px;text-align:left;white-space:nowrap;", "class" => "action"
    ],
]);

Yii::$container->set('yii\bootstrap5\ActiveForm', [
    'id' => 'myform',
    'options' => [
        'enctype' => 'multipart/form-data',
        'data-pjax' => '0',
    ],
    'enableClientValidation' => false,
    'enableAjaxValidation' => true,
    'validateOnChange' => false,
    'validateOnBlur' => false,
]);
