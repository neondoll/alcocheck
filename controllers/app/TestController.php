<?php

namespace app\controllers\app;

use yii\web\Controller;

class TestController extends Controller
{
    public function actionIndex(): string
    {
        return $this->render('index');
    }
}