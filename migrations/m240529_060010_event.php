<?php

use yii\db\Migration;

/**
 * Class m240529_060010_event
 */
class m240529_060010_event extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('event', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'date' => $this->date(),
            'description' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240529_060010_event cannot be reverted.\n";

        $this->dropTable('event');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240529_060010_event cannot be reverted.\n";

        return false;
    }
    */
}
