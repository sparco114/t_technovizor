<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\base\Model;

class Car extends ActiveRecord
{
    public static function tableName()
    {
        return 'cars';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }
}
