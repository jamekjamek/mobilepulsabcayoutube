<!-- Main Content -->
<div class="page-wrapper">
    <div class="container-fluid">

        <!-- Title -->
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark"><?= $title; ?></h5>
            </div>
            <!-- Breadcrumb -->
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="index.html">Dashboard</a></li>
                    <li class="active"><span><?= $title; ?>e</span></li>
                </ol>
            </div>
            <!-- /Breadcrumb -->
        </div>
        <!-- /Title -->

        <!-- INFORMASI SALSO -->
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box bg-red">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                            <span class="weight-500 uppercase-font txt-light block font-13">SALDO</span>
                                            <span class="txt-light block counter">
                                                <?= "Rp ." . number_format($saldo, 2, ',', '.'); ?>
                                            </span>
                                        </div>
                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                            <i class="zmdi zmdi-male-female txt-light data-right-rep-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box bg-blue">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                            <span class="weight-500 uppercase-font txt-light block">SALDO MASUK BULAN INI</span>
                                            <span class="txt-light block counter"><?= "Rp ." . number_format($danamasuk, 2, ',', '.'); ?></span>
                                        </div>
                                        <div class="col-xs-6 text-center  pl-0 pr-0 pt-25  data-wrap-right">
                                            <div id="sparkline_4" style="width: 100px; overflow: hidden; margin: 0px auto;"><canvas style="display: inline-block; width: 115px; height: 50px; vertical-align: top;" width="115" height="50"></canvas></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /INFORMASI SALDO -->

        <!-- CEK MUTASI -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">CEK MUTASI REKENING</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="form-wrap">
                                <form class="form-inline" method="GET" action="">
                                    <div class="form-group mr-15">
                                        <label class="control-label mr-10" for="start_date">Tanggal Awal</label>
                                        <input type="date" class="form-control" id="start_date" name="startDate" required>
                                    </div>
                                    <div class="form-group mr-15">
                                        <label class="control-label mr-10" for="end_date">Tanggal Akhir</label>
                                        <input type="date" class="form-control" id="end_date" name="endDate" required>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-anim"><i class="icon-rocket"></i><span class="btn-text">CARI</span></button>
                                </form>
                            </div>
                        </div>
                    </div>


                    <?= $this->session->flashdata('error'); ?>
                </div>
            </div>

            <div class="col-sm-12">


            </div>
        </div>
        <!-- /CEK MUTASI -->



        <!-- INFORMASI MUTASI -->
        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-default card-view panel-refresh">
                    <div class="refresh-container">
                        <div class="la-anim-1"></div>
                    </div>
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">DATA MUTASI REKENING</h6>
                        </div>
                        <div class="pull-right">
                            <a href="#" class="pull-left inline-block refresh mr-15">
                                <i class="zmdi zmdi-replay"></i>
                            </a>
                            <a href="#" class="pull-left inline-block full-screen mr-15">
                                <i class="zmdi zmdi-fullscreen"></i>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body row pa-0">
                            <div class="table-wrap">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>TANGGAL</th>
                                                <th>BRANCH CODE</th>
                                                <th>TIPE TRANSAKSI</th>
                                                <th>TOTAL</th>
                                                <th>NAMA TRANSAKSI</th>
                                                <th>TRAILER</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php foreach ($statements as $mutasi) : ?>
                                                <tr>
                                                    <td><span class="txt-dark weight-500"><?= $mutasi->TransactionDate; ?></span></td>
                                                    <td><?= $mutasi->BranchCode; ?></td>
                                                    <td><span class="txt-dark weight-500"><?= $mutasi->TransactionType; ?></span></td>
                                                    <td>
                                                        <span class="txt-dark weight-500"><?= "Rp ." . number_format($mutasi->TransactionAmount, 2, ',', '.'); ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="txt-dark"><?= $mutasi->TransactionName; ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="txt-dark"><?= $mutasi->Trailer; ?></span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /INFORMASI MUTASI -->



        <!-- Footer -->
        <footer class="footer container-fluid pl-30 pr-30">
            <div class="row">
                <div class="col-sm-12">
                    <p>2017 &copy; Hound. Pampered by Hencework</p>
                </div>
            </div>
        </footer>
        <!-- /Footer -->
    </div>
</div>
<!-- /Main Content -->