<div class="col-6">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div id="container-intent"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    dataIntent = [
        <?php
        if (!empty($data)) {
            foreach ($data as $dt) {
        ?> {
                    name: "<?= str_replace('"', "'", $dt['intent_name']) ?>",
                    y: <?= $dt['jumlah'] ?>
                },
        <?php
            }
        }
        ?>
    ];
</script>
<?php

use yii\web\View;

$this->registerJS(<<<JS
    Highcharts.chart('container-intent', {
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Top 10 Intent'
        },
        tooltip: {
            valueSuffix: '%'
        },
        subtitle: {
            text:
            '30 hari terakhir'
        },
        plotOptions: {
            series: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: [{
                    enabled: true,
                    distance: 20
                }, {
                    enabled: true,
                    distance: -40,
                    format: '{point.percentage:.1f}%',
                    style: {
                        fontSize: '1.2em',
                        textOutline: 'none',
                        opacity: 0.7
                    },
                    filter: {
                        operator: '>',
                        property: 'percentage',
                        value: 10
                    }
                }]
            }
        },
        series: [
            {
                name: 'Percentage',
                colorByPoint: true,
                data: dataIntent
            }
        ]
    });

JS, View::POS_READY);
?>