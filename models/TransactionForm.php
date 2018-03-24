<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\TableTransactions;
use app\models\TableCategory;

/**
 * Category form
 */

class TransactionForm extends Model
{
    public $category_id;
    public $transaction_desc;
    public $transaction_amount;
 
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [		

            ['category_id', 'required'],
            ['category_id', 'filter', 'filter' => 'trim'],
            ['category_id', 'validatecategoryid'],
            
            ['transaction_desc', 'required'],
            ['transaction_desc', 'filter', 'filter' => 'trim'],
            ['transaction_desc', 'string', 'max'=>255],
            
            ['transaction_amount', 'required'],
            ['transaction_amount', 'integer']
        ];
    }
    
    public function validatecategoryid($attribute, $params, $validator)
    {
        $check = TableCategory::findOne(['category_id'=>$this->$attribute]);
        if (!$check) {
            $this->addError($attribute, 'kategori tidak ditemukan');
        }
    }

    public function create()
    {
        if ($this->validate()) {
        
            $create = new TableTransactions();
            $create->category_id = $this->category_id;
            $create->transaction_amount = $this->transaction_amount;
            $create->transaction_desc = strip_tags($this->transaction_desc);
            $create->transaction_date = date('Y-m-d H:i:s');
            if ($create->save(false)) {
                 return true;
            }
        }

        return null;
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function update($id)
    {
        if ($this->validate()) {
            $update = TableTransactions::findOne($id);
            $update->transaction_amount = $this->transaction_amount;
            $update->transaction_desc = strip_tags($this->transaction_desc);
            if ($update->save(false)) {
                 return true;
            }
        }

        return null;
    }
	
    public function getTransaction($id)
    {
        $arrData = [];
        $get = TableTransactions::findOne($id);
        if($get)
        {
            $arrData = [
                'transaction_id'=>$get['transaction_id'],
                'category_id'=>$get['category_id'],
                'transaction_desc'=>$get['transaction_desc'],
                'transaction_date'=>$get['transaction_date'],
                'transaction_amount'=>$get['transaction_amount'],
            ];
            return $arrData;
        }

        return null;
    }
    
    public function isValidDateTime($date)
    {    
        if (false === strtotime($date)) { 
            return false;
        }
        return true;
    } 
    
	/**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'transaction_id' => 'ID',
            'category_id' => 'kategori',
            'transaction_desc' => 'Deskripsi',
            'transaction_date' => 'Date',
            'transaction_amount' => 'Nominal',
        ];
    }
	
}