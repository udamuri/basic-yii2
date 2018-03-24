<?php

use yii\db\Migration;

/**
 * Class m180324_020412_tbl_transactions
 */
class m180324_020412_tbl_transactions extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('tbl_transactions', [
            'transaction_id' => $this->primaryKey(15),
            'category_id' => $this->integer(11)->notNull(),
            'transaction_desc' => $this->string(255)->notNull(),
            'transaction_date' => $this->dateTime(),
            'transaction_amount' => $this->integer(15)->notNull()
        ], $tableOptions);
        
        $this->createIndex('transaction_id', 'tbl_transactions', 'transaction_id', false );
    }   

    public function down()
    {
       $this->dropTable('tbl_transactions');
    }
}
