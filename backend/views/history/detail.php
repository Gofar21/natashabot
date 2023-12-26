<?php

use Ahc\Json\Fixer;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Dialogflow History</h3>
                <p class="text-subtitle text-muted">
                    Halaman untuk mengelola Data Produk.
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= Url::to(['/']) ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Dialogflow History
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive table-striped">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Timestamp</th>
                                        <th>Request id</th>
                                        <th>Payload</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($data)) {
                                        foreach ($data as $key => $value) {
                                    ?>
                                            <tr>
                                                <td><?= $key + 1 ?></td>
                                                <td><?= $value->timestamp ?></td>
                                                <td><?= $value->labels_request_id ?></td>
                                                <td>

                                                    <?php
                                                    if ($value->labels_type == "dialogflow_request") {
                                                        if (!empty($value->text_input)) {
                                                    ?>
                                                            <h6>Input Text:</h6>
                                                            <p><?= $value->text_input ?></p>
                                                        <?php
                                                        } elseif (!empty($value->event_name)) {
                                                        ?>
                                                            <h6>Event :</h6>
                                                            <p><?= $value->event_name ?></p>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <h6>Raw Payload :</h6>
                                                            <pre><?= $value->text_payload  ?></pre>
                                                            <?php
                                                        }
                                                    } elseif ($value->labels_type == "dialogflow_response") {
                                                        if (!empty($value->intent_name) || !empty($value->speech)) {
                                                            if (!empty($value->intent_name)) {
                                                            ?>
                                                                <h6>Intent :</h6>
                                                                <p><?= $value->intent_name ?></p>
                                                            <?php
                                                            }
                                                            if (!empty($value->speech)) {
                                                            ?>
                                                                <h6>Speech :</h6>
                                                                <p><?= str_replace("\\n", "<br>", $value->speech)  ?></p>
                                                            <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <h6>Raw Payload :</h6>
                                                            <pre><?= $value->text_payload  ?></pre>
                                                        <?php
                                                        }
                                                        ?>
                                                    <?php
                                                    }

                                                    ?>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>