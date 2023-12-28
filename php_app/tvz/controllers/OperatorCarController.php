<?php

namespace app\controllers;

use yii\rest\ActiveController;
use app\models\OperatorCar;
use yii\data\ActiveDataProvider;

class OperatorCarController extends ActiveController
{
    public $modelClass = 'app\models\OperatorCar';


    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['view'], $actions['update']);
        return $actions;
    }

    public function actionIndex($carId = null, $operatorId = null)
    {
        $query = OperatorCar::find();

        if ($carId !== null) {
            $query->andWhere(['car_id' => $carId]);
        }

        if ($operatorId !== null) {
            $query->andWhere(['operator_id' => $operatorId]);
        }

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }

}