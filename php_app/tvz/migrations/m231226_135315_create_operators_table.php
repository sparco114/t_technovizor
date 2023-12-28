<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%operators}}`.
 */
class m231226_135315_create_operators_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%operators}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%operators}}');
    }
}
