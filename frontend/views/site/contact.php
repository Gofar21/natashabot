<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\ContactForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid ">
    
  <div class="row">
    <div class="col-9">

    </div>

    <div class="container" style="border: 2px solid black;">
  <div class="row">
    <div class="col-4 " style ="background-color: #12486B;">
    <div class="Text" ><br>
        <h1 style = "color: white;"><u>Info Kontak</u></h1><br><br>

        <div class="container">
            <div class="row">
                <div class="col-6 col-sm-3">
                <img src="https://cdn-icons-png.flaticon.com/128/3038/3038019.png" class="gambar-silde" style="max-width:80px;"> 
                </div>
                <div class="col-8">
                <p style = "color: white;"><b>Jl. Kaliurang KM.5 No.53, Manggung, Caturtunggal, Kec. Depok, Kabupaten Sleman</b>
             </p><br><br>
                </div>


                <div class="col-6 col-sm-3">
                <img src="https://cdn-icons-png.flaticon.com/128/2913/2913990.png" class="gambar-silde" style="max-width:80px;"> 
                </div>
                <div class="col-8">
                <p style = "color: white;"><br><b>contact@natasha-skin.com</b>
             </p><br><br><br>
                </div>


                <div class="col-6 col-sm-3">
                <img src="https://cdn-icons-png.flaticon.com/128/9946/9946319.png" class="gambar-silde" style="max-width:80px;"> 
                </div>
                <div class="col-8">
                <p style = "color: white;"><br><b>150500</b>
             </p>
                </div>

            </div>
        </div>

       
        
        

    </div>
    </div>
    <div class="col-8">
    <div class="row">
    <p>
        If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
    </p>
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'subject') ?>

                <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div &nbsp; class="col-lg-6">{input}</div></div>',
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    </div>
  </div>
</div>







