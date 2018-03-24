<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\TableCategory;

/**
 * Category form
 */

class CategoryForm extends Model
{
    public $category_name;
    public $category_status;
 
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [		

            ['category_name', 'required'],
            ['category_name', 'filter', 'filter' => 'trim'],
            ['category_name', 'string', 'max' => 100],
            
            ['category_status', 'required'],
            ['category_status', 'filter', 'filter' => 'trim'],
            ['category_status', 'validatestatus']
        ];
    }
    
    public function validatestatus($attribute, $params, $validator)
    {
        if (!in_array($this->$attribute, ['pemasukan', 'pengeluaran'])) {
            $this->addError($attribute, 'Pilihan status hanya "pemasukan" atau "pengeluaran".');
        }
    }

    public function create()
    {
        if ($this->validate()) {
        
            $create = new TableCategory();
            $create->category_name = strip_tags($this->category_name);
            $create->category_status = strip_tags($this->category_status);
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
            $update = TableCategory::findOne($id);
            $update->category_name = strip_tags($this->category_name);
            $update->category_status = strip_tags($this->category_status);
            if ($update->save(false)) {
                 return true;
            }
        }

        return null;
    }
	
    public function delete($id)
    {

        $delete = TableCategory::findOne($id);
        if($delete)
        {
            return $delete->delete();
        }

        return null;  
    }

    public function getCategory($id)
    {
        $arrData = [];
        $get = TableCategory::findOne($id);
        if($get)
        {
            $arrData = [
                'category_id'=>$get['category_id'],
                'category_name'=>$get['category_name'],
                'category_status'=>$get['category_status'],
            ];
            return $arrData;
        }

        return null;
    }

    public function setStatus($id)
    {
        $set = TableCategory::findOne($id);

        if($set)
        {
            if($set->category_status == 1)
            {
                $set->category_status = 0;
            }
            else
            {
                $set->category_status = 1 ;
            }
            $set->save(false);
            return $set->category_status;
        }

        return false;
    }
    
	/**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Kategori ID',
            'category_name' => 'Kategori',
            'category_status' => 'Status'
        ];
    }
	
}