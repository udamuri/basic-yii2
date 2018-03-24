<?php

/* @var $this yii\web\View */

$this->title = 'Home';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Transaksi-Ku</h1>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Total Pemasukan</h2>
                <p><b><?=money_format('%i', $pemasukan)?></b></p>
            </div>
            <div class="col-lg-4">
                <h2>Total Pengeluaran</h2>
                <p><b><?=money_format('%i', $pengeluaran)?></b></p>
            </div>
            <div class="col-lg-4">
                <h2>Saldo Saat Ini</h2>
                <p><b><?=money_format('%i', $total)?></b></p>
            </div>
        </div>

    </div>
</div>
