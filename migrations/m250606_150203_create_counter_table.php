<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%counter}}`.
 */
class m250606_150203_create_counter_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%counter}}', [
            'id' => $this->primaryKey(),
            'count' => $this->integer()->notNull()->defaultValue(0),
            'id_link' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-counter-id_link',
            '{{%counter}}',
            'id_link',
            '{{%links}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-counter-id_link','{{%counter}}');
        $this->dropTable('{{%counter}}');
    }
}
