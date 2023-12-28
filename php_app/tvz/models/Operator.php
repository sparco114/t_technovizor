<?php

namespace app\models;

use yii\db\ActiveRecord;

class Operator extends ActiveRecord
{
    public static function tableName()
    {
        return 'operators';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
        ];
    }
}
