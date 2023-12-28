<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%operator_car}}`.
 */
class m231226_141637_create_operator_car_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%operator_car}}', [
            'id' => $this->primaryKey(),
            'operator_id' => $this->integer()->notNull(),
            'car_id' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('fk-operator_car-operator_id', 'operator_car', 'operator_id', 'operators', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-operator_car-car_id', 'operator_car', 'car_id', 'cars', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%operator_car}}');
    }
}
