<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_transactions".
 *
 * @property int $transaction_id
 * @property int $category_id
 * @property string $transaction_desc
 * @property string $transaction_date
 * @property int $transaction_amount
 */
class TableTransactions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_transactions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'transaction_desc', 'transaction_amount'], 'required'],
            [['category_id', 'transaction_amount'], 'integer'],
            [['transaction_date'], 'safe'],
            [['transaction_desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'transaction_id' => 'Transaction ID',
            'category_id' => 'Category ID',
            'transaction_desc' => 'Transaction Desc',
            'transaction_date' => 'Transaction Date',
            'transaction_amount' => 'Transaction Amount',
        ];
    }
}
