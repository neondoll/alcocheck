<?php

/* @var $content string */

/* @var $this View */

use app\assets\AppAsset;
use app\widgets\Alert;
use app\widgets\NavBar;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\web\View;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>

    <div class="wrap">
        <?php
        NavBar::begin([
            'brandImage' => '/img/light-logo.svg',
            'brandLabel' => Yii::$app->name,
            'brandUrl' => 'https://xn--80apneeq.xn--p1ai/',
            'options' => [
                'class' => 'navbar-expand-lg navbar-dark bg-dark'
            ]
        ]);
        echo Nav::widget([
            'items' => [
                Yii::$app->user->can('root') ? (['label' => 'Адммин панель', 'url' => ['/admin']]) : (''),
                ['label' => 'Инструкция', 'url' => ['/manual']]
            ],
            'options' => [
                'class' => 'navbar-nav ml-auto'
            ]
        ]);
        echo Nav::widget([
            'items' => [
                Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
                ) : (
                    '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        'Выйти (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn nav-link']
                    )
                    . Html::endForm()
                    . '</li>'
                )
            ],
            'options' => [
                'class' => 'navbar-nav '
            ]
        ]);
        NavBar::end();
        ?>

        <div id="wrap" class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []
            ]) ?>
            <?= Alert::widget() ?>

            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container mt-2">
            <p class="text-center">ИАС "Мониторинг"</p>
        </div>
    </footer>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>