<?php

use yii\db\Migration;

/**
 * Class m231224_102939_alter_dialogflow_history_table
 */
class m231224_102939_alter_dialogflow_history_table extends Migration
{
    const TABLE_NAME = '{{%dialogflow_history}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE_NAME, 'language', $this->string(50)->null());
        $this->addColumn(self::TABLE_NAME, 'labels_type', $this->string(250)->null());
        $this->addColumn(self::TABLE_NAME, 'labels_request_id', $this->string(250)->null());
        $this->addColumn(self::TABLE_NAME, 'labels_protocol', $this->string(250)->null());
        $this->addColumn(self::TABLE_NAME, 'severity', $this->string(250)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE_NAME, 'language');
        $this->dropColumn(self::TABLE_NAME, 'labels_type');
        $this->dropColumn(self::TABLE_NAME, 'labels_request_id');
        $this->dropColumn(self::TABLE_NAME, 'labels_protocol');
        $this->dropColumn(self::TABLE_NAME, 'severity');
    }
}
