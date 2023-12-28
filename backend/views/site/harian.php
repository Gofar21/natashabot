<div class="col-6">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div id="container-hari"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    dataHarian = [{
        name: 'Session Aktif',
        data: [
            <?php
            if (!empty($data)) {
                foreach ($data as $dt) {
            ?>
                    <?= $dt ?>,
            <?php
                }
            }
            ?>
        ]
    }, ]
    dataTanggal = [
        <?php
        if (!empty($range)) {
            foreach ($range as $r) {
        ?> '<?= $r ?>',
        <?php
            }
        }
        ?>
    ]
</script>
<?php

use yii\web\View;

$this->registerJS(<<<JS
    Highcharts.chart('container-hari', {

        title: {
            text: 'Jumlah Session Aktif Perhari',
        },

        subtitle: {
            text: '30 hari terakhir',
        },

        yAxis: {
            title: {
                text: 'Jumlah Session Aktif'
            }
        },


        xAxis: {
            categories: dataTanggal,
            accessibility: {
                description: 'Tanggal'
        }
    },
        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
            }
        },

        series: dataHarian,

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }

    });

JS, View::POS_READY);
?>