<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\components\Constants;
use yii\widgets\ActiveForm;

$this->title = 'Transaksi';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-4 col-sm-12 col-xs-12">
        <a href="<?=Yii::$app->homeUrl;?>site/tambah-transaksi" class="btn btn-primary">Tambah</a>
    </div>
    <div class="col-md-8 col-sm-12 col-xs-12">
        <form  id="searchform" class="input-group"  action="<?=Yii::$app->homeUrl;?>site/transaksi"  method="GET" > 
            <div class="row">
                <div class="col-md-5">
                    <input type="text" name="startdate" class="form-control" value="<?=$startdate?>" placeholder="start {2018-01-01}">
                </div>
                <div class="col-md-5">
                    <input type="text" name="enddate" class="form-control" value="<?=$enddate?>" placeholder="end {2018-01-07}" >
                </div>
                <div class="col-md-2">
                    <button class="btn btn-default" type="submit">Go!</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <hr class="row-header">
    </div>
</div>


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr class="bg-primary">
                  <td width="3%">No.</td>
                  <td>Nama Kategory</td>
                  <td>Tanggal Transaksi</td>
                  <td>Pemasukan</td>
                  <td>Pengeluaran</td>
              </tr>
            </thead>
            <tbody>
            <?php
                $start = (int)$offset * (int)$page;
                foreach ($models as $value) {
                    $start++;
                    $btn_class = 'btn-warning';
                    $btn_text = 'OFF';
                    if($value['category_status'] == '1')
                    {
                      $btn_class = 'btn-primary';
                      $btn_text = 'ON';
                    }
                    $pemasukan = 0;
                    $pengeluaran = 0;
                    if($value['category_status'] === 'pemasukan') {
                        $pemasukan = money_format('%i', $value['transaction_amount']);
                    } else {
                        $pengeluaran = money_format('%i', $value['transaction_amount']);
                    }
                    echo '<tr>
                        <td>'.$start.'</td>
                        <td>'.$value['category_name'].'</td>
                        <td>'.$value['transaction_date'].'</td>
                        <td align="right">'.$pemasukan.'</td>
                        <td align="right">'.$pengeluaran.'</td>
                    <tr>';
                }
            ?>
            </tbody>
          </table>
      </div>
    </div>
</div> 

<div class="row">
    <div class="col-md-12">
        <div class="text-center">
          <?php
              //display pagination
              echo LinkPager::widget([
                  'pagination' => $pages,
              ]);
          ?>
        </div>
    </div>
</div>     
