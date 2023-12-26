<?php

use yii\db\Migration;

/**
 * Class m231226_024828_alter_dialogflow_history_table
 */
class m231226_024828_alter_dialogflow_history_table extends Migration
{
    const TABLE_NAME = '{{%dialogflow_history}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE_NAME, 'text_input', $this->text()->null());
        $this->addColumn(self::TABLE_NAME, 'event_name', $this->text()->null());
        $this->addColumn(self::TABLE_NAME, 'intent_name', $this->text()->null());
        $this->addColumn(self::TABLE_NAME, 'speech', $this->text()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE_NAME, 'text_input');
        $this->dropColumn(self::TABLE_NAME, 'event_name');
        $this->dropColumn(self::TABLE_NAME, 'intent_name');
        $this->dropColumn(self::TABLE_NAME, 'speech');
    }
}
