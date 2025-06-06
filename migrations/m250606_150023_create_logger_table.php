<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%logger}}`.
 */
class m250606_150023_create_logger_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%logger}}',[
            'id' => $this->primaryKey(),
            'ip' => $this->string(18)->notNull(),
            'id_link' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-logger-ip','{{%logger}}','ip');
        
        $this->addForeignKey(
            'fk-logger-id_link',
            '{{%logger}}',
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
        $this->dropForeignKey('fk-logger-id_link','{{%logger}}');
        $this->dropTable('{{%logger}}');
    }
}
