<?php

use yii\helpers\Html;

$this->title = 'Главная';

?>

<div class="mt-5">
    <div class="text-center">
        <div class="mb-3">
            <p>
                <?= Html::a('Перейти к технике', 
                ['car-list'], 
                ['class' => 'btn btn-lg btn-outline-success']) ?>
            </p>
        </div>
        <div>
            <p>
                <?= Html::a('Перейти к операторам', 
                ['operator-list'], 
                ['class' => 'btn btn-lg btn-outline-success']) ?>
            </p>
        </div>
    </div>
</div>