<!DOCTYPE html>
<html lang="en">
<?php
include 'koneksi.php';
$query_mysql = mysqli_query($connect, "SELECT * FROM " . $_POST['Pilih_Data'] . "");
$dataJumlah = [];
$dataItem = [];

//hitung jumlah transaksi
$viewtransaksi = mysqli_query($connect, "SELECT COUNT( DISTINCT ID_TRANSAKSI )  FROM " . $_POST['Pilih_Data'] . "");
$totaltransaksi = mysqli_fetch_array($viewtransaksi);
// $JumlahTransaksi = count($resulttransaksi);
($totaltransaksi[0]);

//looping item sering muncul
while ($data = mysqli_fetch_array($query_mysql)) {
    $view = "SELECT * FROM items WHERE ID_ITEMS = '" . $data['ID_ITEMS'] . "'";
    $result = mysqli_query($connect, $view);
    $items = mysqli_fetch_array($result);
    $dataItem[$data['ID_TRANSAKSI']][] = $items['NAMA_ITEMS'];
    if (!isset($dataJumlah[$items['NAMA_ITEMS']])) {
        $dataJumlah[$items['NAMA_ITEMS']] = 1;
    } else {
        $dataJumlah[$items['NAMA_ITEMS']]++;
    }
}
$dataPatern = [];
arsort($dataJumlah);
?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SKRIPSI FPGROWTH</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SKRIPSI</div>
            </a>

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Data Transaksi -->
            <li class="nav-item">
                <a class="nav-link" href="clstr1.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Data Transaksi</span></a>
            </li>
            <!-- Data Barang -->
            <li class="nav-item">
                <a class="nav-link" href="databarang.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Data Barang</span></a>
            </li>
            <!-- Analisa FP Growth -->
            <li class="nav-item">
                <a class="nav-link" href="analisafpgrowth.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Analisa FG Growth</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Navbar -->
                    <p>Minimum Support : <?php echo $_POST['minimum_support']; ?></p>
                    <p>Minimum Confidence : <?php echo ($_POST['minimum_confidence']); ?><br></p>
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">NURUL FU'AD</span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->

                <div class="container-fluid">
                    <!-- tabel item sering muncul -->
                    <div class="card shadow mb-4" style="color : black;">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Item Sering Muncul</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" style="color : black;" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama Item</th>
                                            <th>Jumlah Item</th>
                                            <th>Nilai Support</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($dataJumlah as $key => $value) :  ?>
                                            <?php $nilaisupitem1 = round($value / $totaltransaksi[0] * 100); ?>

                                            <?php if ($nilaisupitem1 < $_POST['minimum_support']) :; ?>
                                               
                                                <tr style="color: red;">
                                                    <td class="center"><?php echo $key; ?> </td>
                                                    <td class="center"><?php echo $value; ?></td>
                                                    <td class="center"><?php echo "$nilaisupitem1 %"; ?> </td>

                                                </tr>
                                            <?php else : ?>
                                                <?php
                                                $dataSupport[$key] = $value;
                                                foreach ($dataItem as $key2 => $value2) {
                                                    if (array_search($key, $value2) !== false) {
                                                        $dataItemFilterOrder[$key2][] = $key;
                                                    }
                                                }
                                                  $data_item_supp[]=[
                                                    "nama_item"=>$key,
                                                ];
                                                 
                                                ?>
                                                <tr>
                                                    <td class="center"><?php echo $key; ?> </td>
                                                    <td class="center"><?php echo $value; ?> </td>
                                                    <td class="center"><?php echo "$nilaisupitem1 %"; ?> </td>
                                                </tr>
                                            <?php endif ?>
                                        <?php endforeach; ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php 
                    foreach($dataItemFilterOrder as $id => $item){

                        $data_transaksi = mysqli_query($connect, "SELECT * FROM alltransaksi WHERE ID_TRANSAKSI='$id' ");
                       

                        $transaksi[] = mysqli_fetch_array($data_transaksi);
                    }
                    $data_item_all = mysqli_query($connect, "SELECT * FROM items");
                    while($row = mysqli_fetch_assoc($data_item_all)){
                        foreach ($data_item_supp as $items) {
                            if ($row['NAMA_ITEMS'] == $items["nama_item"] ) {
                                $data_item_sup2[]=$row;
                            }
                        }
                    }
                    $first_month = mysqli_fetch_array( mysqli_query($connect, "SELECT Tanggal FROM transaksi ORDER BY Tanggal ASC"))['Tanggal'];
                    $last_month =mysqli_fetch_array( mysqli_query($connect, "SELECT Tanggal FROM transaksi ORDER BY Tanggal DESC"))['Tanggal'];
                    $month=strtotime($first_month);
                    $end = strtotime($last_month);
                    while($month<=$end){
                        $bulan = date('m',$month);
                    foreach($data_item_sup2 as $row_item){
                            $data_rekap_bulan[]=[
                                "nama_barang"=> $row_item['NAMA_ITEMS'],
                                "id_item" => $row_item['ID_ITEMS'],
                                "data_bulan"=>[
                                    "bulan" => date('m',$month),
                                    "jumlah_sewa_barang"=>mysqli_fetch_assoc(mysqli_query($connect, "SELECT SUM(QTY) as QTY FROM alltransaksi WHERE MONTH(Tanggal)= ".$bulan." AND ID_ITEMS='".$row_item['ID_ITEMS']."'"))
                                ],
                            ];
                             
                        }
                        $month=strtotime("+1 month",$month);
                       
                    } 
                    foreach($data_item_sup2 as $item){
                        foreach($data_rekap_bulan as $rekap){
                            if($rekap['id_item'] == $item['ID_ITEMS']){
                                $data_item_rekap[$rekap['id_item']][] = [
                                    "nama_barang"=>$item['NAMA_ITEMS'],
                                    "rekap_bulan"=>$rekap['data_bulan']
                                ];
                            }
                        }
                    } 

                        
                        foreach($data_item_sup2 as $rekap){
                            $data_peramalan = $data_item_rekap[$rekap['ID_ITEMS']];
                            $SaksenSebelum = 0;
                            $SdoubleaksenSebelum = 0;
                            $Ft=0;
                            $alpha=0.5;
                            for($i=0;$i<count($data_peramalan);$i++){
                                if($i==0){
                                    $data[] = [
                                        "id_item" =>$rekap['ID_ITEMS'],
                                        "nama_barang"=>$data_peramalan[$i]['nama_barang'],
                                        "Bulan" => $data_peramalan[$i]['rekap_bulan']['bulan'],
                                        "persewaan" => $data_peramalan[$i]['rekap_bulan']['jumlah_sewa_barang']['QTY'],
                                        "Saksen" => $data_peramalan[$i]['rekap_bulan']['jumlah_sewa_barang']['QTY'],
                                        "Sdobleaksen" => $data_peramalan[$i]['rekap_bulan']['jumlah_sewa_barang']['QTY'],
                                        "At" => $data_peramalan[$i]['rekap_bulan']['jumlah_sewa_barang']['QTY'],
                                        "Bt" => "",
                                        "Ft" => "",
                                        "Error" => ""
                                        ];
                                    $AtSebelum = $data_peramalan[$i]['rekap_bulan']['jumlah_sewa_barang']['QTY'];
                                    $SaksenSebelum = $data_peramalan[$i]['rekap_bulan']['jumlah_sewa_barang']['QTY'];
                                    $SdoubleaksenSebelum = $data_peramalan[$i]['rekap_bulan']['jumlah_sewa_barang']['QTY'];
                                    $Ft = $AtSebelum+0;
                                }else{
                                    $Saksen = ($alpha*$data_peramalan[$i]['rekap_bulan']['jumlah_sewa_barang']['QTY'])+((1-$alpha)*$SaksenSebelum);
                                        $SdoubleAksen = $alpha*$Saksen+(1-$alpha)*$SdoubleaksenSebelum;
                                        $At = (2*$Saksen)-$SdoubleAksen;
                                        $Bt = $alpha*($Saksen-$SdoubleAksen)/(1-$alpha);
                                        if ($Ft!=0) {
                                            $error = $data_peramalan[$i]['rekap_bulan']['jumlah_sewa_barang']['QTY'] - $Ft;
                                        }
                                        $data[]= [
                                            "id_item" =>$rekap['ID_ITEMS'],
                                            "nama_barang"=>$data_peramalan[$i]['nama_barang'],
                                            "Error" => number_format(abs($data_peramalan[$i]['rekap_bulan']['jumlah_sewa_barang']['QTY']-abs($Ft)),4),
                                            
                                            "Bulan" => $data_peramalan[$i]['rekap_bulan']['bulan'],
                                            "persewaan" => $data_peramalan[$i]['rekap_bulan']['jumlah_sewa_barang']['QTY'],
                                            "Saksen" => number_format($Saksen,4),
                                            "Sdobleaksen" => number_format($SdoubleAksen,4),
                                            "At" => number_format($At,4),
                                            "Bt" => number_format($Bt,4),
                                            "Ft" => abs(number_format($Ft,4)),
                                           ];
                                        $Ft = $At + $Bt;
                                        $SaksenSebelum = $Saksen;
                                        $SdoubleaksenSebelum = $SdoubleAksen;
                                        if($data_peramalan[$i]['rekap_bulan']['bulan'] >= 10){
                                           
                                            //$SdoubleAksen = $alpha*$Saksen+(1-$alpha)*$SdoubleaksenSebelum;
                                            //$At = (2*$Saksen)-$SdoubleAksen;
                                            //$Bt = $alpha*($Saksen-$SdoubleAksen)/(1-$alpha);
                                            $Ft = $At + ($Bt*1);
                                            $data[]= [
                                                "id_item" =>$rekap['ID_ITEMS'],
                                                "nama_barang"=>$data_peramalan[$i]['nama_barang'],
                                                "Error" => number_format(abs(0-abs($Ft)),4),
                                                
                                                "Bulan" => $data_peramalan[$i]['rekap_bulan']['bulan'] + 1,
                                                "persewaan" => '?',
                                                "Saksen" => number_format($Saksen,4),
                                                "Sdobleaksen" => number_format($SdoubleAksen,4),
                                                "At" => number_format($At,4),
                                                "Bt" => number_format($Bt,4),
                                                "Ft" => abs(number_format($Ft,4)),
                                           ];
                                           
                                           //$SdoubleAksen = $alpha*$Saksen+(1-$alpha)*$SdoubleaksenSebelum;
                                            //$At = (2*$Saksen)-$SdoubleAksen;
                                            //$Bt = $alpha*($Saksen-$SdoubleAksen)/(1-$alpha);
                                            $Ft = $At + ($Bt*2);
                                            $data[]= [
                                                "id_item" =>$rekap['ID_ITEMS'],
                                                "nama_barang"=>$data_peramalan[$i]['nama_barang'],
                                                "Error" => number_format(abs(0-abs($Ft)),4),
                                                
                                                "Bulan" => $data_peramalan[$i]['rekap_bulan']['bulan'] + 2,
                                                "persewaan" => '?',
                                                "Saksen" => 0,
                                                "Sdobleaksen" => 0,
                                                "At" => 0,
                                                "Bt" => 0,
                                                "Ft" => abs(number_format($Ft,4)),
                                           ];
                                           
                                        }
                                    }
                            }
                            $data_ramal =[
                                "item" => $rekap['ID_ITEMS'],
                                "hasil"=>$data
                            ];
                        }
                     //var_dump($data);
                     //die;
                    ?>
                    
                    <!-- end tabel item sering muncul -->
                    <!-- Tabel mengurutkan data -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data transaksi sesuai prioritas</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" style="color : black;" id="dataTable2" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID Transaksi</th>
                                            <th>Nama Item</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        foreach ($dataItemFilterOrder as $key => $value) : 
                                            // var_dump($dataItemFilterOrder);
                                            ?>
                                            <tr>
                                                <td class="center"><?php echo $key; ?></td>

                                                <td class="center"><?php foreach ($value as $key2 => $value2) : ?>
                                                        <?php echo $value2; ?> <br>
                                                    <?php endforeach; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- mulai data tiap minggu -->
                    <div>
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Tiap Bulan</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" style="color : black;" id="dataTable4" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Bulan </th>
                                            <th>Disewa </th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php foreach($data_item_sup2 as $item){
                                                foreach($data_rekap_bulan as $rekap){
                                                    if($rekap['id_item'] == $item['ID_ITEMS']){?>
                                                       
                                                        <tr>
                                                            <td><?php echo $rekap['nama_barang']; ?></td>
                                                            <td><?php echo $rekap['data_bulan']['bulan']; ?></td>
                                                             <td><?php echo $rekap['data_bulan']['jumlah_sewa_barang']['QTY']; ?></td>
                                                        </tr>
                                                   <?php }
                                                }
                                            } ?>
                                          
                                       
                                       
                                  
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end data tiap minggu -->
                    <!-- mulai asosiasi rule -->
                    <div>
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Asosiasi Rule</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" style="color : black;" id="dataTable4" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Rule</th>
                                            <th>Confidence</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $minValue = min($dataSupport);
                                        foreach ($dataSupport as $key => $value) {
                                            $dataArray[] = $key;

                                            foreach ($dataItemFilterOrder as $value2) {
                                                if (in_array($key, $value2)) {
                                                    foreach ($value2 as $value3) {
                                                        if ((!isset($dataPatern[$key . " => " . $value3]) && ($key != $value3)) && in_array($value3, $dataArray)) {
                                                            $dataPatern[$key . " => " . $value3] = 1;
                                                        } elseif ($key != $value3 && in_array($value3, $dataArray)) {
                                                            $dataPatern[$key . " => " . $value3]++;
                                                        }
                                                    }
                                                }
                                            }
                                            $endOfArray = end($dataPatern);
                                            if ($endOfArray < $minValue) {
                                                array_pop($dataPatern);
                                            }
                                        }
                                        arsort($dataPatern);
                                        // var_dump($_POST['minimum_confidence']);
                                        ?>
                                        <?php foreach ($dataPatern as $key => $value3) : ?>
                                            <?php $rule = (explode(' => ', $key)); ?>

                                            <?php
                                            // var_dump($rule);
                                            $nilaiconf = round($value3 / $dataJumlah[$rule[0]] * 100);
                                            ?>

                                            <?php
                                            if ($nilaiconf > $_POST['minimum_confidence']) :;
                                            ?>
                                                <tr>
                                                    <td class="center"><?php echo $key; ?></td>
                                                    <td class="center"><?php echo "$nilaiconf %"; ?></td>
                                                    <td class="center"><?php echo "Jika Sewa $rule[0] Maka Sewa $rule[1] "; ?></td>
                                                </tr>

                                            <?php endif ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end asosiasi rule-->
                    <?php $dataOutput = []; ?>
                    <?php foreach ($dataPatern as $key => $value3) : ?>
                        <?php $rule = (explode(' => ', $key)); ?>
                        <?php $nilaiconf = round($value3 / $dataJumlah[$rule[0]] * 100); ?>
                        <?php if ($nilaiconf > $_POST['minimum_confidence']) :; ?>

                            <?php foreach ($rule as $index) {
                                if (in_array($index, $dataOutput) != true) {
                                    $dataOutput[] = $index;
                                }
                            }
                            ?>
                        <?php endif ?>
                    <?php endforeach; ?>

                    <?php
                    // looping data transaksi gagal
                    $transaksigagal = mysqli_query($connect, "SELECT * FROM transaksigagal");
                    $queryDataItem = mysqli_query($connect, "SELECT * FROM items");
                    $dataItem = [];
                    $dataTransaksiGagal = [];
                    while ($data = mysqli_fetch_array($queryDataItem)) {
                        $dataItem[$data['ID_ITEMS']] = $data['NAMA_ITEMS'];
                    }
                    while ($data = mysqli_fetch_array($transaksigagal)) {
                        if (!isset($dataTransaksiGagal[$dataItem[$data['ID_ITEMSGAGAL']]])) {
                            $dataTransaksiGagal[$dataItem[$data['ID_ITEMSGAGAL']]] = 1;
                        } else {
                            $dataTransaksiGagal[$dataItem[$data['ID_ITEMSGAGAL']]]++;
                        }
                    }
                    ?>

                    <!--hasil prediksi stok-->
                    <!-- <div>
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Hasil Prediksi gagal</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" style="color : black;" id="dataTable5" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <td class="center">Nama Barang</td>
                                            <td class="center">Jumlah Barang</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div> -->

                    <!--hasil prediksi stok-->
                    <div>
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Hasil Prediksi</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                               <table class="table table-bordered" style="color : black;" id="dataTable5" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Bulan </th>
                                            <th>Disewa </th>
                                            <th>Prediksi</th>
                                            <th>Error</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($data_ramal['hasil'] as $rowHasil): ?>
                                            <tr>
                                                <td><?php echo $rowHasil['nama_barang']; ?></td>
                                                <td><?php echo $rowHasil['Bulan']; ?></td>
                                                <td><?php echo $rowHasil['persewaan']; ?></td>
                                                <td><?php echo ceil((int)$rowHasil['Ft']) ?></td>
                                                <td><?php echo ceil((int)$rowHasil['Error']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>      
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <!--end hasil prediksi stok-->

                    <!-- /.container-fluid -->
                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Skripsi Nurul Fu'ad 2022</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="login.html">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="vendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="js/demo/chart-area-demo.js"></script>
        <script src="js/demo/chart-pie-demo.js"></script>

        <!-- Page level plugins -->
        <script src="vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="js/demo/datatables-demo.js"></script>
        <script type="text/javascript">
            $('#dataTable').DataTable({
                "ordering": false
            });
        </script>
        <script src="js/demo/datatables-demo.js"></script>
        <script type="text/javascript">
            $('#dataTable2').DataTable({
                "ordering": false
            });
        </script>
        <script src="js/demo/datatables-demo.js"></script>
        <script type="text/javascript">
            $('#dataTable4').DataTable({
                "ordering": false
            });
        </script>
        <script src="js/demo/datatables-demo.js"></script>
        <script type="text/javascript">
            $('#dataTable5').DataTable({
                "ordering": false
            });
        </script>


</body>

</html>