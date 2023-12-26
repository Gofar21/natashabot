<?php

namespace common\components;

use common\models\DialogflowHistory;
use Google\Cloud\Logging\LoggingClient;
use Yii;
use yii\base\Component;

class GoogleLoggingApiData extends Component
{
    public static function getLog($awal, $akhir)
    {
        $logging = new LoggingClient([
            // 'projectId' => 'sw-skincare',
            'keyFile' => json_decode(
                file_get_contents(
                    Yii::getAlias('@common') . '/config/sw-skincare-3987d60f9a13.json'
                ),
                true
            )
        ]);

        $result = [];

        // List log entries from a specific log.
        $entriesRequest = $logging->entries([
            'filter' => 'logName = "projects/sw-skincare/logs/dialogflow_agent" ' .
                'labels.type="dialogflow_request" ' .
                'timestamp>="' . $awal . '" ' .
                'timestamp<="' . $akhir . '" '
        ]);

        foreach ($entriesRequest as $entry) {
            // $textPayload = $entry->info()['textPayload'];
            // $textPayload = str_replace("Dialogflow Request : ", "", $textPayload);
            // echo "<pre>";
            // var_dump($entry->info());
            // // print_r(json_decode($textPayload));
            // echo "</pre><br>";
            $result[] = $entry->info();
        }

        $entriesResponse = $logging->entries([
            'filter' => 'logName = "projects/sw-skincare/logs/dialogflow_agent" ' .
                'labels.type="dialogflow_response" ' .
                'timestamp>="' . $awal . '" ' .
                'timestamp<="' . $akhir . '" '
        ]);

        foreach ($entriesResponse as $entry) {
            // $textPayload = $entry->info()['textPayload'];
            // $textPayload = str_replace("Dialogflow Request : ", "", $textPayload);
            // echo "<pre>";
            // var_dump($entry->info());
            // exit();
            // // print_r(json_decode($textPayload));
            // echo "</pre><br>";
            $result[] = $entry->info();
        }

        return $result;
    }

    public static function saveLog($entry)
    {
        $data = DialogflowHistory::find()
            ->where([
                'insert_id' => $entry['insertId']
            ])
            ->one();
        if (empty($data)) {
            $data = new DialogflowHistory;
            $data->insert_id = $entry['insertId'] ?? null;
        }
        $data->timestamp = $entry['timestamp'] ?
            date("Y-m-d H:i:s", strtotime(str_replace(["T", "Z"], [" ", ""], $entry['timestamp']))) :
            null;
        $data->receive_timestamp = $entry['receiveTimestamp'] ?
            date("Y-m-d H:i:s", strtotime(str_replace(["T", "Z"], [" ", ""], $entry['receiveTimestamp']))) :
            null;
        $data->trace = $entry['trace'] ?? null;
        $data->text_payload = $entry['textPayload'] ?? null;
        $data->severity = $entry['severity'] ?? null;
        $data->log_name = $entry['logName'] ?? null;
        $data->language = $entry['language'] ?? null;
        $data->resource = $entry['resource'] ? json_encode($entry['resource']) : null;
        $data->extractInformasi();

        if (isset($entry['labels'])) {
            $data->labels_type = $entry['labels']['type'] ?? null;
            $data->labels_protocol = $entry['labels']['protocol'] ?? null;
            $data->labels_request_id = $entry['labels']['request_id'] ?? null;
        }
        if (!$data->save()) {
            echo "<pre>";
            print_r($data->getErrors());

            exit();
        }
        return true;
    }

    public static function ImportLog($awal, $akhir)
    {
        $entries = self::getLog($awal, $akhir);
        if (!empty($entries)) {
            foreach ($entries as $entry) {
                self::saveLog($entry);
            }
        }
        return true;
    }
}
