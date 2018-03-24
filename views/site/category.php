<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\components\Constants;
use yii\widgets\ActiveForm;

$this->title = 'Kategori';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-8 col-sm-12 col-xs-12">
        <a href="<?=Yii::$app->homeUrl;?>site/tambah-kategori" class="btn btn-primary">Tambah</a>
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12">
        <form  id="searchform" class="input-group"  action="<?=Yii::$app->homeUrl;?>site/kategori"  method="GET" > 
            <input type="text" name="search" class="form-control" value="<?=$search;?>" placeholder="Search for...">
            <span class="input-group-btn">
                <button class="btn btn-default" type="submit">Go!</button>
            </span>
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
                  <td>Kategori</td>
                  <td>Status</td>
                  <td width="13%">Action</td>
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
                    echo '<tr>
                        <td>'.$start.'</td>
                        <td>'.$value['category_name'].'</td>
                        <td>'.$value['category_status'].'</td>
                        <td align="center">
                          <a class="btn btn-danger btn-xs delete_category" title="Delete" href="'.Yii::$app->homeUrl.'site/hapus-kategori/'.$value['category_id'].'" data-id="'.$value['category_id'].'">Hapus</i></a>
                          <a class="btn btn-success btn-xs" title="Update" href="'.Yii::$app->homeUrl.'site/ganti-kategori/'.$value['category_id'].'" data-id="'.$value['category_id'].'">Ubah</a>
                        </td>
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
