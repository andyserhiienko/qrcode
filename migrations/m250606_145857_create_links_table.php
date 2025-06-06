<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%links}}`.
 */
class m250606_145857_create_links_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%links}}',[
            'id' => $this->primaryKey(),
            'full' => $this->string(185)->notNull(),
            'short' => $this->string(10)->notNull()->unique(),
            'qr' => $this->string(35)->notNull(),
            'md5' => $this->string(35)->notNull()
        ]);

        $this->createIndex('idx-links-short-md','{{%links}}','short',true);
        $this->createIndex('idx-links-short-md5','{{%links}}',['short','md5']);
        $this->createIndex('idx-links-md5', '{{%links}}', 'md5');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%links}}');
    }
}
