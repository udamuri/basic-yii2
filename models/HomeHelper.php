<?php

namespace app\models;

use Yii;
use yii\base\Model;

class HomeHelper extends Model
{
    public function getTransaction($type = 'pemasukan') {
        $query = (new \yii\db\Query())
                    ->select([
                        'sum(tt.transaction_amount) as total_amount',
                    ])
                    ->from('tbl_transactions tt')
                    ->leftJoin('tbl_category tc', 'tc.category_id = tt.category_id')
                    ->where(['tc.category_status'=>$type])
                    ->one();
        
        return $query['total_amount'];
    }
}
