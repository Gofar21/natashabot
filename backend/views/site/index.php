<?php

/** @var yii\web\View $this */

$this->registerJsFile("https://code.highcharts.com/highcharts.js");
$this->registerJsFile("https://code.highcharts.com//modules/series-label.js");
$this->registerJsFile("https://code.highcharts.com/modules/exporting.js");
$this->registerJsFile("https://code.highcharts.com/modules/export-data.js");
$this->registerJsFile("https://code.highcharts.com/modules/accessibility.js");

?>
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Dashboard</h3>
                <p class="text-subtitle text-muted">
                    Halaman untuk melihat Statistik.
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">
                            Dashboard
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="row">
        <?= $this->render("intent", ['data' => $per_intent]) ?>
        <?= $this->render("harian", ['data' => $per_hari, 'range' => $range_tanggal]) ?>

    </section>
</div>