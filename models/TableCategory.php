<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_category".
 *
 * @property int $category_id
 * @property string $category_name
 * @property string $category_date
 * @property string $category_status
 */
class TableCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_name', 'category_status'], 'required'],
            [['category_date'], 'safe'],
            [['category_name', 'category_status'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category ID',
            'category_name' => 'Category Name',
            'category_date' => 'Category Date',
            'category_status' => 'Category Status',
        ];
    }
}
