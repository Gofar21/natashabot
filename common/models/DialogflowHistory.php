<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dialogflow_history".
 *
 * @property int $id
 * @property string $insert_id
 * @property string|null $text_payload
 * @property string|null $resource
 * @property string|null $timestamp
 * @property string|null $receive_timestamp
 * @property string|null $log_name
 * @property string|null $trace
 * @property string|null $language
 * @property string|null $labels_type
 * @property string|null $labels_request_id
 * @property string|null $labels_protocol
 * @property string|null $severity
 * @property string|null $text_input
 * @property string|null $event_name
 * @property string|null $intent_name
 * @property string|null $speech
 */
class DialogflowHistory extends \yii\db\ActiveRecord
{
    public $jumlah;
    public $tanggal;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dialogflow_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['insert_id'], 'required'],
            [[
                'text_payload', 'resource', 'text_input',
                'event_name', 'intent_name', 'speech'
            ], 'string'],
            [['timestamp', 'receive_timestamp'], 'safe'],
            [['insert_id', 'trace'], 'string', 'max' => 100],
            [['log_name'], 'string', 'max' => 300],
            [['language'], 'string', 'max' => 50],
            [['labels_type', 'labels_request_id', 'labels_protocol', 'severity'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'insert_id' => 'Insert ID',
            'text_payload' => 'Text Payload',
            'resource' => 'Resource',
            'timestamp' => 'Timestamp',
            'receive_timestamp' => 'Receive Timestamp',
            'log_name' => 'Log Name',
            'trace' => 'Trace',
            'language' => 'Language',
            'labels_type' => 'Labels Type',
            'labels_request_id' => 'Labels Request ID',
            'labels_protocol' => 'Labels Protocol',
            'severity' => 'Severity',
        ];
    }

    private function getInformasiRequest()
    {
        preg_match('~\{(?:[^{}]|(?R))*\}~', $this->text_payload, $match);
        $obj = json_decode($match[0], true);
        if (!empty($obj)) {
            foreach ($obj as $objVal) {
                $objChild = json_decode($objVal, true);

                if (isset($objChild['text']['textInputs'])) {
                    $textInputs = $objChild['text']['textInputs'];
                    $this->text_input = "";
                    foreach ($textInputs as $textInput) {
                        $this->text_input .= $textInput['text'];
                    }
                } elseif (isset($objChild['event']['name'])) {
                    $this->event_name = $objChild['event']['name'];
                }
            }
        }
    }

    private function createMetadataResponse($array)
    {
        $result = [];
        $lastIndex = null;
        foreach ($array as $value) {
            if (str_contains($value, ":")) {
                $lastIndex = str_replace(":", "", $value);
                $result[$lastIndex] = "";
            } elseif ($lastIndex !== null && !in_array($value, ["{", "}"])) {
                if (!empty($result[$lastIndex])) {
                    $result[$lastIndex] .= " ";
                }
                $result[$lastIndex] .= str_replace("\"", "", $value);
            }
        }
        if (array_key_exists("intent_name", $result)) {
            $this->intent_name = $result['intent_name'];
        }
    }

    public function createJSON($array)
    {
        $result = [];
        $lastIndex = null;
        $array = array_slice($array, 2, count($array) - 2);
        // print_r($array);
        foreach ($array as $key => $value) {
            if (str_contains($value, ":") || (isset($array[$key + 1]) && $array[$key + 1] == "{")) {
                $lastIndex = str_replace(":", "", $value);
                if (!isset($result[$lastIndex])) {
                    $result[$lastIndex] = "";
                }
            } elseif ($lastIndex !== null && !in_array($value, ["{", "}"])) {
                if (!empty($result[$lastIndex])) {
                    $result[$lastIndex] .= " ";
                }
                $result[$lastIndex] .= str_replace("\"", "", $value);
            }
        }
        return $result;
    }

    private function createFulfillmentResponse($array)
    {
        $array = array_values($array);
        $result = $this->createJSON($array);
        if (array_key_exists("speech", $result)) {
            $this->speech = $result['speech'];
        }
    }

    private function getArrayChild($array)
    {
        $open = 0;
        $close = 0;
        $result = [];
        foreach ($array as $value) {
            $result[] = $value;
            if ($value == "{") {
                $open++;
            } elseif ($value == "}") {
                $close++;
            }

            if ($open == $close && $open > 0) {
                break;
            }
        }
        return $result;
    }

    private function getInformasiResponse()
    {
        $textPayload = str_replace(["\n"], [" "], $this->text_payload);
        $textPayload = str_replace(["Dialogflow Response :"], [""], $textPayload);
        $awal = explode(" ", $textPayload);
        $arrayPayload = array_filter($awal);
        $arrayPayload = array_values($arrayPayload);
        $metadataKey = array_search("metadata", $arrayPayload);
        $fulfillmentkey = array_search("fulfillment", $arrayPayload);
        $metadataArray = array_slice($arrayPayload, $metadataKey, $fulfillmentkey - $metadataKey);
        $this->createMetadataResponse($metadataArray);
        $fulfillmentArray = $this->getArrayChild(array_slice($arrayPayload, $fulfillmentkey));
        $this->createFulfillmentResponse($fulfillmentArray);
        // $this->createPayloadResponse($fulfillmentArray);
    }

    private function createPayloadResponse()
    {
        echo "<pre>";
        $string = str_replace("Dialogflow Response :", "", $this->text_payload);
        $string = preg_replace('/(\w+)(?=\s?\{)/', '"$1":', $string);
        $string = preg_replace('/(\w+)(?=\s?\:)/', '"$1"', $string);
        // $string = preg_replace('/((\r?\n)|(\r\n?))()/', ',$1', $string);

        $lines = preg_split("/((\r?\n)|(\r\n?))/", $string);
        $result = "";
        foreach ($lines as $key => $line) {
            $lineString = trim($line);
            if ($key > 0 && substr($result, -1) != "{" && substr($lineString, 0, 1) != "}" && !empty($lineString)) {
                $result .= ",";
            }
            $result .= $lineString;
        }
        $result = "{" . $result . "}";
        echo "<pre>";
        echo $result;
        print_r(json_decode($result));
        exit();
    }

    public function extractInformasi()
    {
        if ($this->labels_type == "dialogflow_request") {
            $this->getInformasiRequest();
        } elseif ($this->labels_type == "dialogflow_response") {
            $this->getInformasiResponse();
        }
    }



    public function afterFind()
    {
        if ($this->labels_type == "dialogflow_request") {
            $this->getInformasiRequest();
        } elseif ($this->labels_type == "dialogflow_response") {
            $this->getInformasiResponse();
        }
        $this->save();
    }
}
