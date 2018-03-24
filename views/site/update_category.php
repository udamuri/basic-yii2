<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
//use yii\helpers\ArrayHelper;

$this->title = 'Ubah';
$this->params['breadcrumbs'][] = [
    'label' =>'Kategori',
    'url' => Yii::$app->homeUrl.'kategori'
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <?= $this->render('_form_category', [
            'model' => $model,
            '_model' => $_model,
            'form_id' => 'form-update-category',
            'button' => 'Rubah',
        ]) ?>
    </div>
</div>