<?php 
	session_start();

	//Check If user is already logged in
	if(isset($_SESSION['username_barbershop_Xw211qAAsq4']) && isset($_SESSION['password_barbershop_Xw211qAAsq4']))
	{
        //Page Title
        $pageTitle = 'validasi';

        //Includes
        include 'connect.php';
        include 'Includes/functions/functions.php'; 
        include 'Includes/templates/header.php';
        echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>";

?>
	<!-- Begin Page Content -->
	<div class="container-fluid">
		
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">validasi</h1>
			<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
				<i class="fas fa-download fa-sm text-white-50"></i>
				Generate Report
			</a>
		</div>
        <?php
                $do = '';

                if(isset($_GET['do']) && in_array($_GET['do'], array('Validasi','Edit')))
                {
                    $do = htmlspecialchars($_GET['do']);
                }
                else
                {
                    $do = 'Manage';
                }

                if($do == 'Manage')
                {
        ?>
        <!-- Appointment Tables -->
        <div class="card shadow mb-4">
            <div class="card-header tab" style="padding: 0px !important;background: #36b9cc!important">
                <button class="tablinks active" onclick="openTab(event, 'Upcoming')">
                    validasi
                </button>
                <button class="tablinks" onclick="openTab(event, 'vali')">
                    edit validasi
                </button>
                <button class="tablinks" onclick="openTab(event, 'All')">
                    Riwayat validasi
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered tabcontent" id="Upcoming" style="display:table" width="100%" cellspacing="0">
                        <thead>
                                <tr>
                                    <th>
                                        Nama
                                    </th>
                                    <th>
                                        Layanan
                                    </th>
                                    <th>
                                        Harga
                                    </th>
                                    <th>
                                        Start Time
                                    </th>
                                    <th>
                                        End Time 
                                    </th>
                                    <th>
                                        Manage
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    $stmt = $con->prepare("SELECT * 
                                                    FROM booking a , pelanggan c
                                                    where c.email = '" . $_SESSION['username_barbershop_Xw211qAAsq4'] . "'
                                                    and a.id_pelanggan = c.id_pelanggan
                                                    and start_time >= now()
                                                    order by start_time;
                                                    ");
                                    $stmt->execute(array(date('Y-m-d H:i:s')));
                                    $rows = $stmt->fetchAll();
                                    $count = $stmt->rowCount();
                                    
                                    

                                    if($count == 0)
                                    {

                                        echo "<tr>";
                                            echo "<td colspan='5' style='text-align:center;'>";
                                                echo "List of your upcoming bookings will be presented here";
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                    else
                                    {
                                        foreach($rows as $row)
                                        {
                                            echo "<tr>";
                                                echo "<td>";
                                                    echo $row['nama'];
                                                echo "</td>";
                                                echo "<td>";
                                                    $stmtServices = $con->prepare("SELECT nama_layanan
                                                            from layanan s, booking b
                                                            where s.id_layanan = b.id_layanan
                                                            and id_booking = ?");
                                                    $stmtServices->execute(array($row['id_booking']));
                                                    $rowsServices = $stmtServices->fetchAll();
                                                    foreach($rowsServices as $rowsService)
                                                    {
                                                        echo " ".$rowsService['nama_layanan'];
                                                        if (next($rowsServices)==true)  echo " <br> ";
                                                    }
                                                echo "</td>";
                                                echo "<td>";
                                                    $stmtServices = $con->prepare("SELECT harga_layanan
                                                            from layanan s, booking b
                                                            where s.id_layanan = b.id_layanan
                                                            and id_booking = ?");
                                                    $stmtServices->execute(array($row['id_booking']));
                                                    $rowsServices = $stmtServices->fetchAll();
                                                    foreach($rowsServices as $rowsService)
                                                    {
                                                        echo " ".$rowsService['harga_layanan'];
                                                        if (next($rowsServices)==true)  echo " <br> ";
                                                    }                                                    
                                                echo "</td>";
                                                echo "<td>";
                                                    echo $row['start_time'];
                                            
                                                echo "</td>";
                                                echo "<td>";
                                                        echo $row['end_time'];
                                                echo "</td>";
    
                                                echo "<td>";
                                                ?>                                                   
                                                <ul class="list-inline m-0">

                                                            <!-- EDIT BUTTON -->

                                                            <li class="list-inline-item" data-toggle="tooltip" title="validasi">
                                                                <button class="btn btn-success btn-sm rounded-0">
                                                                    <a href="validasi.php?do=Validasi&id_booking=<?php echo $row['id_booking']; ?>" style="color: white;">
                                                                        Upload bukti
                                                                    </a>
                                                                </button>
                                                            </li>
                                                </ul>
                                                    <?php
                                                echo "</td>";

                                            echo "</tr>";
                                        }
                                    }

                                ?>

                            </tbody>
                    </table>
                    <table class="table table-bordered tabcontent" id="vali" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>
                                    client
                                </th>
                                <th>
                                    layanan
                                </th>
                                <th>
                                    harga
                                </th>
                                <th>
                                    Start Time
                                </th>
                                <th>
                                    End Time
                                </th>
                                <th>
                                    jenis
                                </th>
                                <th>
                                    manage
                                </th>                              
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                                $stmt = $con->prepare("SELECT * 
                                                FROM booking a , pelanggan c, bayar b
                                                where a.id_pelanggan = c.id_pelanggan and b.id_booking=a.id_booking and c.email = '" . $_SESSION['username_barbershop_Xw211qAAsq4'] . "'
                                                order by start_time;
                                                ");
                                $stmt->execute(array());
                                $rows = $stmt->fetchAll();
                                $count = $stmt->rowCount();

                                if($count == 0)
                                {

                                    echo "<tr>";
                                        echo "<td colspan='5' style='text-align:center;'>";
                                            echo "List of your all bookings will be presented here";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                else
                                {

                                    foreach($rows as $row)
                                    {
                                        echo "<tr>";
                                            echo "<td>";
                                                echo $row['nama'];
                                                
                                            echo "</td>";
                                            echo "<td>";
                                                $stmtServices = $con->prepare("SELECT nama_layanan
                                                        from layanan s, booking sb
                                                        where s.id_layanan = sb.id_layanan
                                                        and id_booking = ?");
                                                $stmtServices->execute(array($row['id_booking']));
                                                $rowsServices = $stmtServices->fetchAll();
                                                foreach($rowsServices as $rowsService)
                                                {
                                                    echo $rowsService['nama_layanan'];
                                                    if (next($rowsServices)==true)  echo " + ";
                                                }
                                            echo "</td>";
                                            echo "<td>";
                                                    $stmtServices = $con->prepare("SELECT harga_layanan
                                                            from layanan s, booking b
                                                            where s.id_layanan = b.id_layanan
                                                            and id_booking = ?");
                                                    $stmtServices->execute(array($row['id_booking']));
                                                    $rowsServices = $stmtServices->fetchAll();
                                                    foreach($rowsServices as $rowsService)
                                                    {
                                                        echo " ".$rowsService['harga_layanan'];
                                                        if (next($rowsServices)==true)  echo " <br> ";
                                                    }                                                
                                            echo "</td>";
                                            echo "<td>";
                                                echo $row['start_time'];
                                            echo "</td>";
                                            echo "<td>";
                                                echo $row['end_time'];
                                            echo "</td>";
                                            echo "<td>";
                                                echo $row['jenis_bayar'];
                                            echo "</td>";
                                            echo "<td>";
                                                ?>                                                   
                                                <ul class="list-inline m-0">

                                                            <!-- EDIT BUTTON -->

                                                            <li class="list-inline-item" data-toggle="tooltip" title="Edit">
                                                                <button class="btn btn-success btn-sm rounded-0">
                                                                    <a href="validasi.php?do=Edit&id_bayar=<?php echo $row['id_bayar']; ?>" style="color: white;">
                                                                        Edit
                                                                    </a>
                                                                </button>
                                                            </li>
                                                </ul>
                                                    <?php
                                                echo "</td>";                                      
                                        echo "</tr>";
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                    <table class="table table-bordered tabcontent" id="All" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>
                                    client
                                </th>
                                <th>
                                    layanan
                                </th>
                                <th>
                                    harga
                                </th>
                                <th>
                                    Start Time
                                </th>
                                <th>
                                    End Time
                                </th>
                                <th>
                                    jenis
                                </th>
                                <th>
                                    status
                                </th>
                                <th>
                                    pemvalidasi
                                </th>                                
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                                $stmt = $con->prepare("SELECT * 
                                                FROM booking a , pelanggan c, bayar b, transaksi t, admin n
                                                where a.id_pelanggan = c.id_pelanggan and b.id_booking=a.id_booking and t.id_bayar=b.id_bayar and t.id_admin=n.id_admin and c.email = '" . $_SESSION['username_barbershop_Xw211qAAsq4'] . "'
                                                order by start_time;
                                                ");
                                $stmt->execute(array());
                                $rows = $stmt->fetchAll();
                                $count = $stmt->rowCount();

                                if($count == 0)
                                {

                                    echo "<tr>";
                                        echo "<td colspan='5' style='text-align:center;'>";
                                            echo "List of your all bookings will be presented here";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                else
                                {

                                    foreach($rows as $row)
                                    {
                                        echo "<tr>";
                                            echo "<td>";
                                                echo $row['nama'];
                                                
                                            echo "</td>";
                                            echo "<td>";
                                                $stmtServices = $con->prepare("SELECT nama_layanan
                                                        from layanan s, booking sb
                                                        where s.id_layanan = sb.id_layanan
                                                        and id_booking = ?");
                                                $stmtServices->execute(array($row['id_booking']));
                                                $rowsServices = $stmtServices->fetchAll();
                                                foreach($rowsServices as $rowsService)
                                                {
                                                    echo $rowsService['nama_layanan'];
                                                    if (next($rowsServices)==true)  echo " + ";
                                                }
                                            echo "</td>";
                                            echo "<td>";
                                                    $stmtServices = $con->prepare("SELECT harga_layanan
                                                            from layanan s, booking b
                                                            where s.id_layanan = b.id_layanan
                                                            and id_booking = ?");
                                                    $stmtServices->execute(array($row['id_booking']));
                                                    $rowsServices = $stmtServices->fetchAll();
                                                    foreach($rowsServices as $rowsService)
                                                    {
                                                        echo " ".$rowsService['harga_layanan'];
                                                        if (next($rowsServices)==true)  echo " <br> ";
                                                    }                                                
                                            echo "</td>";
                                            echo "<td>";
                                                echo $row['start_time'];
                                            echo "</td>";
                                            echo "<td>";
                                                echo $row['end_time'];
                                            echo "</td>";
                                            echo "<td>";
                                                echo $row['jenis_bayar'];
                                            echo "</td>";
                                            echo "<td>";
                                                echo $row['status'];
                                            echo "</td>";
                                            echo "<td>";
                                                echo $row['nama_admin'];
                                            echo "</td>";                                        
                                        echo "</tr>";
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
                }elseif($do == 'Validasi')
                {
                    if(isset($_GET['id_booking'])){
                        $id_booking=$_GET['id_booking'];

                        $stmt = $con->prepare("SELECT * FROM booking b,pelanggan p, layanan l where b.id_booking = '" . $id_booking . "' and b.id_pelanggan=p.id_pelanggan and b.id_layanan=l.id_layanan");
                        $stmt->execute(array('id_booking'));
                        $booki = $stmt->fetch();
                        ?>
                        <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary"></h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="validasi.php?do=Validasi&id_booking=<?php echo $id_booking; ?>">
                                        <!-- id booking -->
                                        <input type="hidden" name="id_booking" value="<?php echo $booki['id_booking'];?>">
                                        <input type="hidden" name="id_pelanggan" value="<?php echo $booki['id_pelanggan'];?>">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="book_name">nama</label>
                                                    <input readonly type="text" class="form-control" value="<?php echo $booki['nama'] ?>" placeholder="nama" name="book_name">
                                                    <?php
                                                        $flag_edit_profile_form = 0;
                                                        if(isset($_POST['edit_profile_sbmt']))
                                                        {
                                                            if(empty(test_input($_POST['book_name'])))
                                                            {
                                                                ?>
                                                                    <div class="invalid-feedback" style="display: block;">
                                                                        membutuhkan nama baru.
                                                                    </div>
                                                                <?php

                                                                $flag_edit_profile_form = 1;
                                                            }
                                                        }
                                                    ?>                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="book_layanan">layanan</label>
                                                    <input readonly type="text" class="form-control" value="<?php echo $booki['nama_layanan'] ?>" placeholder="nama" name="book_layanan">
                                                    <?php
                                                        if(isset($_POST['edit_profile_sbmt']))
                                                        {
                                                            if(empty(test_input($_POST['book_layanan'])))
                                                            {
                                                                ?>
                                                                    <div class="invalid-feedback" style="display: block;">
                                                                        pilih layanan baru.
                                                                    </div>
                                                                <?php

                                                                $flag_edit_profile_form = 1;
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="book_jenis">jenis bayar</label>
                                                    <select id="book_jenis" class="form-control" name="book_jenis" >
                                                        <option value="Ditempat">ditempat</option>';
                                                    </select>
                                                    <?php
                                                        if(isset($_POST['edit_profile_sbmt']))
                                                        {
                                                            if(empty(test_input($_POST['book_jenis'])))
                                                            {
                                                                ?>
                                                                    <div class="invalid-feedback" style="display: block;">
                                                                        
                                                                    </div>
                                                                <?php

                                                                $flag_edit_profile_form = 1;
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    <label for="book_jumlah">jumlah</label>
                                                    <input readonly type="text" class="form-control" value="<?php echo $booki['harga_layanan'] ?>" placeholder="nama" name="book_jumlah">
                                                    <?php
                                                        if(isset($_POST['edit_profile_sbmt']))
                                                        {
                                                            if(empty(test_input($_POST['book_jumlah'])))
                                                            {
                                                                ?>
                                                                    <div class="invalid-feedback" style="display: block;">
                                                                        
                                                                    </div>
                                                                <?php

                                                                $flag_edit_profile_form = 1;
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    <label for="book_keterangan">keterangan</label>
                                                    <input type="text" class="form-control"  placeholder="keterangan" name="book_keterangan">
                                                    <?php
                                                        if(isset($_POST['edit_profile_sbmt']))
                                                        {
                                                            if(empty(test_input($_POST['book_keterangan'])))
                                                            {
                                                                ?>
                                                                    <div class="invalid-feedback" style="display: block;">
                                                                        
                                                                    </div>
                                                                <?php

                                                                $flag_edit_profile_form = 1;
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    <label for="book_start_time">start time</label>
                                                    <input readonly type="DateTime" class="form-control" value="<?php echo date($booki['start_time']); ?>" placeholder="start  time" name="book_start_time">
                                                    <?php
                                                        if(isset($_POST['edit_profile_sbmt']))
                                                        {
                                                            if(empty(test_input($_POST['book_start_time'])))
                                                            {
                                                                ?>
                                                                    <div class="invalid-feedback" style="display: block;">
                                                                        
                                                                    </div>
                                                                <?php

                                                                $flag_edit_profile_form = 1;
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    <label for="book_start_time">end time</label>
                                                    <input readonly type="DateTime" class="form-control" value="<?php echo date($booki['end_time']); ?>" placeholder="end time" name="book_end_time">
                                                    <?php
                                                        if(isset($_POST['edit_profile_sbmt']))
                                                        {
                                                            if(empty(test_input($_POST['book_end_time'])))
                                                            {
                                                                ?>
                                                                    <div class="invalid-feedback" style="display: block;">
                                                                        
                                                                    </div>
                                                                <?php

                                                                $flag_edit_profile_form = 1;
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- SUBMIT BUTTON -->
                                        <button type="submit" name="edit_profile_sbmt" class="btn btn-primary">
                                            Submit
                                        </button>
                                    </form>
                                    <?php
                                        /*** EDIT profile ***/
                                        if(isset($_POST['edit_profile_sbmt']) && $_SERVER['REQUEST_METHOD'] == 'POST' && $flag_edit_profile_form == 0)
                                        {
                                            $book_jenis = test_input($_POST['book_jenis']);
                                            //$book_file = test_input($_POST['book_file']);
                                            $book_keterangan = test_input($_POST['book_keterangan']);
                                            $book_jumlah = test_input($_POST['book_jumlah']);



                                            function autonumber($id_terakhir, $panjang_kode, $panjang_angka) {
 
                                                // mengambil nilai kode ex: KNS0015 hasil KNS
                                                $kode = substr($id_terakhir, 0, $panjang_kode);
                                             
                                                // mengambil nilai angka
                                                $angka = substr($id_terakhir, $panjang_kode, $panjang_angka);
                                             
                                                // menambahkan nilai angka dengan 1
                                                $angka_baru = str_repeat("0", $panjang_angka - strlen($angka+1)).($angka+1);
                                             
                                                // menggabungkan kode dengan nilang angka baru
                                                $id_baru = $kode.$angka_baru;
                                             
                                                return $id_baru;
                                            }
                                               //function mendapatkan id terakhir atau id_max mobil
                                                $result = $con->prepare("SELECT MAX(id_bayar) as kaka FROM bayar");
                                                $result->execute(array());
                                                $row = $result->fetch();
                                                $lastid = autonumber($row['kaka'],1,4);
                                                echo $lastid;
                                                $id_bayar = $lastid;
                                                echo $id_booking;

                                            try
                                            {
                                                $stmt=$con->prepare("insert into bayar (id_bayar,id_booking,jenis_bayar,jumlah,keterangan) values(?,?,?,?,?) ");
                                                $stmt->execute(array($id_bayar,$id_booking,$book_jenis,$book_jumlah,$book_keterangan));
                                                
                                                ?> 
                                                    <!-- SUCCESS MESSAGE -->

                                                    <script type="text/javascript">
                                                        swal(" validasi berhasil","Silahkan tunggu info dari admin", "sukses").then((value) => 
                                                        {
                                                            window.location.replace("validasi.php");
                                                        });
                                                    </script>

                                                <?php

                                            }
                                            catch(Exception $e)
                                            {
                                                echo "<div class = 'alert alert-danger' style='margin:10px 0px;'>";
                                                    echo 'Error occurred: ' .$e->getMessage();
                                                echo "</div>";
                                            }
                                            
                                        }
                                    ?>
                                </div>
                            </div>
                            <?php
                    }   
                }elseif($do == 'Edit')
                {
                    if(isset($_GET['id_bayar'])){
                        $id_bayar=$_GET['id_bayar'];

                        $stmt = $con->prepare("SELECT * FROM bayar a,booking b,pelanggan p, layanan l where a.id_bayar = '" . $id_bayar . "' and b.id_pelanggan=p.id_pelanggan and a.id_booking=b.id_booking and b.id_layanan=l.id_layanan");
                        $stmt->execute(array('id_bayar'));
                        $booki = $stmt->fetch();
                        ?>
                        <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary"></h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="validasi.php?do=Edit&id_bayar=<?php echo $id_bayar; ?>">
                                        <!-- id booking -->
                                        <input type="hidden" name="id_booking" value="<?php echo $booki['id_booking'];?>">
                                        <input type="hidden" name="id_pelanggan" value="<?php echo $booki['id_pelanggan'];?>"><input type="hidden" name="id_bayar" value="<?php echo $booki['id_bayar'];?>">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="book_name">nama</label>
                                                    <input readonly type="text" class="form-control" value="<?php echo $booki['nama'] ?>" placeholder="nama" name="book_name">
                                                    <?php
                                                        $flag_edit_profile_form = 0;
                                                        if(isset($_POST['edit_profile_sbmt']))
                                                        {
                                                            if(empty(test_input($_POST['book_name'])))
                                                            {
                                                                ?>
                                                                    <div class="invalid-feedback" style="display: block;">
                                                                        membutuhkan nama baru.
                                                                    </div>
                                                                <?php

                                                                $flag_edit_profile_form = 1;
                                                            }
                                                        }
                                                    ?>                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="book_layanan">layanan</label>
                                                    <input readonly type="text" class="form-control" value="<?php echo $booki['nama_layanan'] ?>" placeholder="nama" name="book_layanan">
                                                    <?php
                                                        if(isset($_POST['edit_profile_sbmt']))
                                                        {
                                                            if(empty(test_input($_POST['book_layanan'])))
                                                            {
                                                                ?>
                                                                    <div class="invalid-feedback" style="display: block;">
                                                                        pilih layanan baru.
                                                                    </div>
                                                                <?php

                                                                $flag_edit_profile_form = 1;
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="book_jenis">jenis bayar</label>
                                                    <input type="text" class="form-control" value="<?php echo $booki['jenis_bayar'] ?>" placeholder="bca/gopay/ovo/ditempat" name="book_jenis">
                                                    <?php
                                                        if(isset($_POST['edit_profile_sbmt']))
                                                        {
                                                            if(empty(test_input($_POST['book_jenis'])))
                                                            {
                                                                ?>
                                                                    <div class="invalid-feedback" style="display: block;">
                                                                        
                                                                    </div>
                                                                <?php

                                                                $flag_edit_profile_form = 1;
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    <label for="book_jumlah">jumlah</label>
                                                    <input type="text" class="form-control" value="<?php echo $booki['jumlah'] ?>" placeholder="jumlah tf" name="book_jumlah">
                                                    <?php
                                                        if(isset($_POST['edit_profile_sbmt']))
                                                        {
                                                            if(empty(test_input($_POST['book_jumlah'])))
                                                            {
                                                                ?>
                                                                    <div class="invalid-feedback" style="display: block;">
                                                                        
                                                                    </div>
                                                                <?php

                                                                $flag_edit_profile_form = 1;
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    <label for="book_keterangan">keterangan</label>
                                                    <input type="text" class="form-control" value="<?php echo $booki['keterangan'] ?>" placeholder="keterangan" name="book_keterangan">
                                                    <?php
                                                        if(isset($_POST['edit_profile_sbmt']))
                                                        {
                                                            if(empty(test_input($_POST['book_keterangan'])))
                                                            {
                                                                ?>
                                                                    <div class="invalid-feedback" style="display: block;">
                                                                        
                                                                    </div>
                                                                <?php

                                                                $flag_edit_profile_form = 1;
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    <label for="book_start_time">start time</label>
                                                    <input readonly type="DateTime" class="form-control" value="<?php echo date($booki['start_time']); ?>" placeholder="start  time" name="book_start_time">
                                                    <?php
                                                        if(isset($_POST['edit_profile_sbmt']))
                                                        {
                                                            if(empty(test_input($_POST['book_start_time'])))
                                                            {
                                                                ?>
                                                                    <div class="invalid-feedback" style="display: block;">
                                                                        
                                                                    </div>
                                                                <?php

                                                                $flag_edit_profile_form = 1;
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    <label for="book_start_time">end time</label>
                                                    <input readonly type="DateTime" class="form-control" value="<?php echo date($booki['end_time']); ?>" placeholder="end time" name="book_end_time">
                                                    <?php
                                                        if(isset($_POST['edit_profile_sbmt']))
                                                        {
                                                            if(empty(test_input($_POST['book_end_time'])))
                                                            {
                                                                ?>
                                                                    <div class="invalid-feedback" style="display: block;">
                                                                        
                                                                    </div>
                                                                <?php

                                                                $flag_edit_profile_form = 1;
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- SUBMIT BUTTON -->
                                        <button type="submit" name="edit_profile_sbmt" class="btn btn-primary">
                                            Submit
                                        </button>
                                    </form>
                                    <?php
                                        /*** EDIT profile ***/
                                        if(isset($_POST['edit_profile_sbmt']) && $_SERVER['REQUEST_METHOD'] == 'POST' && $flag_edit_profile_form == 0)
                                        {
                                            $book_jenis = test_input($_POST['book_jenis']);
                                            //$book_file = test_input($_POST['book_file']);
                                            $book_keterangan = test_input($_POST['book_keterangan']);
                                            $book_jumlah = test_input($_POST['book_jumlah']);

                                            $book_id=$booki['id_bayar'];


                                            try
                                            {
                                                $stmt = $con->prepare("update bayar set jenis_bayar = ?, jumlah = ?, keterangan = ? where id_bayar = ? ");
                                                $stmt->execute(array($book_jenis,$book_jumlah,$book_keterangan,$book_id));
                                                
                                                ?> 
                                                    <!-- SUCCESS MESSAGE -->

                                                    <script type="text/javascript">
                                                        swal(" edit berhasil","Edit validasi", "sukses").then((value) => 
                                                        {
                                                            window.location.replace("validasi.php");
                                                        });
                                                    </script>

                                                <?php

                                            }
                                            catch(Exception $e)
                                            {
                                                echo "<div class = 'alert alert-danger' style='margin:10px 0px;'>";
                                                    echo 'Error occurred: ' .$e->getMessage();
                                                echo "</div>";
                                            }
                                            
                                        }
                                    ?>
                                </div>
                            </div>
                            <?php
                    }   
                }
        ?>
		
	</div>


<?php
        
		//Include Footer
		include 'Includes/templates/footer.php';
	}
	else
    {
    	header('Location: login.php');
        exit();
    }

?>
