<?php

use yii\db\Migration;

/**
 * Class m231228_163152_fulling_tables
 */
class m231228_163152_fulling_tables extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this -> batchInsert('{{%cars}}', ['name'], [
            ['Трубоукладчики ЧЕТРА'],
            ['Гусеничный кран ЧМЗ'],
            ['Фронтальный погрузчик ЧТЗ'],
            ['Мини экскаватор Bobcat'],
            ['Трубоукладчик Caterpillar'],
            ['Кран гусеничный Hitachi'],
            ['Самосвалы Komatsu'],
            ['Автобетоносмесители Liebherr'],
        ]);

        $this -> batchInsert('{{%operators}}', ['name'], [
            ['Титов Константин Михайлович'],
            ['Фокин Андрей Захарович'],
            ['Антонов Мирон Савельевич'],
            ['Филатов Роман Александрович'],
            ['Коротков Глеб Даниилович'],
            ['Воробьев Евгений Андреевич'],
            ['Ермаков Роман Адамович'],
            ['Белоусов Максим Макарович'],
            ['Корнев Григорий Артёмович'],
            ['Миронов Борис Макарович'],
            ['Наумов Иван Матвеевич'],
            ['Дегтярев Егор Юрьевич'],
        ]);

        $connections = []; // Создаем 20 рандомных связей оператор-машина

        for ($i = 0; $i < 20; $i++) {
            $carId = mt_rand(1, 8);
            $operatorId = mt_rand(1, 12);

            // Проверка на повторение связи
            while (in_array([$carId, $operatorId], $connections)) {
                $carId = mt_rand(1, 8);
                $operatorId = mt_rand(1, 12);
            }

            $connections[] = [$carId, $operatorId];
        }

        $this->batchInsert('{{%operator_car}}', ['car_id', 'operator_id'], $connections);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m231228_163152_fulling_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231228_163152_fulling_tables cannot be reverted.\n";

        return false;
    }
    */
}