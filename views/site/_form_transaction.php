<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\TableCategory;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <?php $form = ActiveForm::begin([
            'id' => $form_id,
        ]); 
            if($form_id === 'form-transaction-category')
            {
                $model->category_id = $_model['category_id'] ;
            }

        ?>
        
        <?php
            $dataList = ArrayHelper::map(TableCategory::find()->all(), 'category_id', 'category_name');
            echo $form->field($model, 'category_id')->dropDownList($dataList);
        ?>
        
        <?= $form->field($model, 'transaction_amount')->textInput(); ?>
        
        <?= $form->field($model, 'transaction_desc')->textArea(); ?>
        
        <div class="form-group">
            <?= Html::submitButton($button, ['class' => 'btn btn-primary', 'name' => 'category-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>   
    </div>
</div>