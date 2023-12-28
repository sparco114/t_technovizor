<?php

namespace app\models;

use yii\db\ActiveRecord;

class OperatorCar extends ActiveRecord
{
    public static function tableName()
    {
        return 'operator_car';
    }

    public function rules()
    {
        return [
            [['operator_id', 'car_id'], 'required'],
            [['operator_id'], 'exist', 'targetClass' => Operator::class, 'targetAttribute' => 'id'],
            [['car_id'], 'exist', 'targetClass' => Car::class, 'targetAttribute' => 'id'],
            [['operator_id', 'car_id'], 'unique', 'targetAttribute' => ['operator_id', 'car_id']],
        ];
    }

    public function getCar()
    {
        return $this->hasOne(Car::class, ['id' => 'car_id']);
    }

    public function getOperator()
    {
        return $this->hasOne(Operator::class, ['id' => 'operator_id']);
    }

    public function fields()
    {
        $fields['id'] = 'id';
        $fields['operator'] = 'operator';
        $fields['car'] = 'car';
        return $fields;
    }
}
