<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
//use yii\helpers\ArrayHelper;

$this->title = 'Rubah';
$this->params['breadcrumbs'][] = [
    'label' =>'Transaksi',
    'url' => Yii::$app->homeUrl.'site/transaksi'
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <?= $this->render('_form_transaction', [
            'model' => $model,
            '_model' => $_model,
            'form_id' => 'form-update-transaction',
            'button' => 'Rubah',
        ]) ?>
    </div>
</div>