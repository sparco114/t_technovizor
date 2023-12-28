<?php

namespace app\controllers;

use yii\web\Controller;

class SiteController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCarList()
    {
        return $this->render('car-list');
    }

    public function actionOperatorList()
    {
        return $this->render('operator-list');
    }

    public function actionCarView()
    {
        return $this->render('car-view');
    }

    public function actionOperatorView()
    {
        return $this->render('operator-view');
    }
}