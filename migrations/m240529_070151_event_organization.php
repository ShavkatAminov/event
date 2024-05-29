<?php

use yii\db\Migration;

/**
 * Class m240529_070151_event_organization
 */
class m240529_070151_event_organization extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('event_organization', [
            'id' => $this->primaryKey(),
            'event_id' => $this->integer(),
            'organization_id' => $this->integer(),
        ]);

        $this->createIndex('event_organization_1', 'event_organization', 'event_id');
        $this->addForeignKey('fk_event_organization_event', 'event_organization', 'event_id', 'event', 'id');

        $this->createIndex('event_organization_2', 'event_organization', 'organization_id');
        $this->addForeignKey('fk_event_organization_id', 'event_organization', 'organization_id', 'organization', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240529_070151_event_organization cannot be reverted.\n";

        $this->dropForeignKey('fk_event_organization_event', 'event_organization');
        $this->dropIndex('event_organization_1', 'event_organization');

        $this->dropForeignKey('fk_event_organization_organization', 'event_organization');
        $this->dropIndex('event_organization_2', 'event_organization');


        $this->dropTable('event_organization');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240529_070151_event_organization cannot be reverted.\n";

        return false;
    }
    */
}
