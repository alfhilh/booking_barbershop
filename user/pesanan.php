<?php 
    session_start();
    date_default_timezone_set('Asia/Jakarta');
    //Check If user is already logged in
    if(isset($_SESSION['username_barbershop_Xw211qAAsq4']) && isset($_SESSION['password_barbershop_Xw211qAAsq4']))
    {
        //Page Title
        $pageTitle = 'Dashboard';

        //Includes
        include 'connect.php';
        include 'Includes/functions/functions.php'; 
        include 'Includes/templates/header.php';

        echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>";

        function build_calendar($month, $year) {                        
                        
                         // Create array containing abbreviations of days of week.
                         $daysOfWeek = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');

                         // What is the first day of the month in question?
                         $firstDayOfMonth = mktime(0,0,0,$month,1,$year);

                         // How many days does this month contain?
                         $numberDays = date('t',$firstDayOfMonth);

                         // Retrieve some information about the first day of the
                         // month in question.
                         $dateComponents = getdate($firstDayOfMonth);

                         // What is the name of the month in question?
                         $monthName = $dateComponents['month'];

                         // What is the index value (0-6) of the first day of the
                         // month in question.
                         $dayOfWeek = $dateComponents['wday'];

                         // Create the table tag opener and day headers
                         
                        $datetoday = date('Y-m-d');
                        
                        
                        
                        $calendar = "<table class='table table-bordered'>";
                        $calendar .= "<center><h2>$monthName $year</h2>";
                        $calendar.= "<a class='btn btn-xs btn-primary' href='?month=".date('m', mktime(0, 0, 0, $month-1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month-1, 1, $year))."'>Previous Month</a> ";
                        
                        $calendar.= " <a class='btn btn-xs btn-primary' href='?month=".date('m')."&year=".date('Y')."'>Current Month</a> ";
                        
                        $calendar.= "<a class='btn btn-xs btn-primary' href='?month=".date('m', mktime(0, 0, 0, $month+1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month+1, 1, $year))."'>Next Month</a></center><br>";
                        
                        
                            
                          $calendar .= "<tr>";

                         // Create the calendar headers

                         foreach($daysOfWeek as $day) {
                              $calendar .= "<th  class='header'>$day</th>";
                         } 

                         // Create the rest of the calendar

                         // Initiate the day counter, starting with the 1st.

                         $currentDay = 1;

                         $calendar .= "</tr><tr>";

                         // The variable $dayOfWeek is used to
                         // ensure that the calendar
                         // display consists of exactly 7 columns.

                         if ($dayOfWeek > 0) { 
                             for($k=0;$k<$dayOfWeek;$k++){
                                    $calendar .= "<td  class='empty'></td>"; 

                             }
                         }
                        
                         
                         $month = str_pad($month, 2, "0", STR_PAD_LEFT);
                      
                         while ($currentDay <= $numberDays) {

                              // Seventh column (Saturday) reached. Start a new row.

                              if ($dayOfWeek == 7) {

                                   $dayOfWeek = 0;
                                   $calendar .= "</tr><tr>";

                              }
                              
                              $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
                              $date = "$year-$month-$currentDayRel";
                              
                                $dayname = strtolower(date('l', strtotime($date)));
                                $eventNum = 0;
                                $today = $date==date('Y-m-d')? "today" : "";

                                $mysqli = mysqli_connect('localhost', 'root', '', 'barbershop-coba');
                                $query="SELECT start_time FROM booking WHERE start_time BETWEEN '".$date." 08:00:00' AND '".$date." 22:00:00';";
                                $result = mysqli_query($mysqli, $query);
                                $row = mysqli_num_rows($result);  

                             if($date<=date('Y-m-d')){
                                 $calendar.="<td><h4>$currentDay</h4> <button class='btn btn-danger btn-xs'>N/A</button>";
                             }elseif($row == 12){
                                $calendar.="<td><h4>$currentDay</h4> <button class='btn btn-danger btn-xs'>Full</button>";
                             }elseif($row > 0){
                                $calendar.="<td class='$today'><h4>$currentDay</h4> <a href='pesanan.php?do=Book&date=".$date."' class='btn btn-warning btn-xs'> Book</a>";
                             }else{
                                $calendar.="<td class='$today'><h4>$currentDay</h4> <a href='pesanan.php?do=Book&date=".$date."' class='btn btn-success btn-xs'>Book</a>";
                             }
                                
  
                                
                              $calendar .="</td>";
                              // Increment counters
                     
                              $currentDay++;
                              $dayOfWeek++;

                         }
                         
                         

                         // Complete the row of the last week in month, if necessary

                         if ($dayOfWeek != 7) { 
                         
                              $remainingDays = 7 - $dayOfWeek;
                                for($l=0;$l<$remainingDays;$l++){
                                    $calendar .= "<td class='empty'></td>"; 

                             }

                         }
                         
                         $calendar .= "</tr>";

                         $calendar .= "</table>";

                         echo $calendar;

                    }
                        
                    ?>

                    <style>
       @media only screen and (max-width: 760px),
        (min-device-width: 802px) and (max-device-width: 1020px) {

            /* Force table to not be like tables anymore */
            table, thead, tbody, th, td, tr {
                display: block;

            }
            
            

            .empty {
                display: none;
            }

            /* Hide table headers (but not display: none;, for accessibility) */
            th {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                border: 1px solid #ccc;
            }

            td {
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
            }



            /*
        Label the data
        */
            td:nth-of-type(1):before {
                content: "Sunday";
            }
            td:nth-of-type(2):before {
                content: "Monday";
            }
            td:nth-of-type(3):before {
                content: "Tuesday";
            }
            td:nth-of-type(4):before {
                content: "Wednesday";
            }
            td:nth-of-type(5):before {
                content: "Thursday";
            }
            td:nth-of-type(6):before {
                content: "Friday";
            }
            td:nth-of-type(7):before {
                content: "Saturday";
            }


        }

        /* Smartphones (portrait and landscape) ----------- */

        @media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
            body {
                padding: 0;
                margin: 0;
            }
        }

        /* iPads (portrait and landscape) ----------- */

        @media only screen and (min-device-width: 802px) and (max-device-width: 1020px) {
            body {
                width: 495px;
            }
        }

        @media (min-width:641px) {
            table {
                table-layout: fixed;
            }
            td {
                width: 33%;
            }
        }
        
        .row{
            margin-top: 5px;
        }
        
        .today{
            background:yellow;
        }
        
    </style>
        <!-- Begin Page Content -->
        <div class="container-fluid">
    
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Pesanan Baru</h1>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-download fa-sm text-white-50"></i>
                    Generate Report
                </a>
            </div>
            <?php
                $do = '';

                if(isset($_GET['do']) && in_array($_GET['do'], array('Book','Booking')))
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
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <?php
                                 $dateComponents = getdate();
                                 if(isset($_GET['month']) && isset($_GET['year'])){
                                     $month = $_GET['month'];                
                                     $year = $_GET['year'];
                                 }else{
                                     $month = $dateComponents['mon'];                
                                     $year = $dateComponents['year'];
                                 }
                                echo build_calendar($month,$year);
                            ?>
                        </div>
                    </div>
                <?php
                }
                elseif($do == 'Book')
                {
                        if(isset($_GET['date'])){
                            $date = $_GET['date'];
                        }

                        $duration = 60;
                        $cleanup = 0;
                        $start = "09:00";
                        $end = "21:00";

                        function timeslots($duration, $cleanup, $start, $end){
                            $start = new DateTime($start);
                            $end = new DateTime($end);
                            $interval = new DateInterval("PT".$duration."M");
                            $cleanupInterval = new DateInterval("PT".$cleanup."M");
                            $slots = array();
                            
                            for($intStart = $start; $intStart<$end; $intStart->add($interval)->add($cleanupInterval)){
                                $endPeriod = clone $intStart;
                                $endPeriod->add($interval);
                                if($endPeriod>$end){
                                    break;
                                }
                                
                                $slots[] = $intStart->format("H:i");
                                
                            }
                            
                            return $slots;
                        }?>
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="container">
                                <h1 class="text-center">Book for Date: <?php echo date('m/d/Y', strtotime($date)); ?></h1><hr>
                                <div class="row">
                                   <div class="col-md-12">
                                       <?php echo(isset($msg))?$msg:""; ?>
                                   </div>
                                    <?php $timeslots = timeslots($duration, $cleanup, $start, $end); 
                                        foreach($timeslots as $ts){
                                    ?>
                                    <div class="col-md-2">
                                        <div class="form-group">

                                        </div>
                                        <div class="form-group">
                                            <?php
                                            $tanggal=$_GET['date'];
                                            $book=$ts;
                                            $booktime = strtotime($tanggal.' '.$book);
                                            $cektgl= date('Y-m-d H:i:s', $booktime);
                                            $stmt = $con->prepare("Select start_time from Booking where start_time = '" . $cektgl . "' ");
                                            $stmt->execute();
                                            $row = $stmt->fetch();
                                            $count = $stmt->rowCount();
                                            ?>
                                           <?php if($count>0){ ?>
                                           <button class="btn btn-danger">
                                               <a href="#" style="color: white;"><?php echo $ts; ?>
                                                </a>
                                           </button>
                                           <?php }else{ ?>
                                           <button id="book" class="btn btn-success book" data-timeslot="<?php echo $ts; ?>">
                                                <a href="pesanan.php?do=Booking&booktime=<?php echo $booktime; ?>" style="color: white;"><?php echo $ts; ?>
                                                </a>
                                           </button>
                                           <?php }  ?> 
                                        </div>
                                    </div>                                   
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }elseif ($do == 'Booking') 
                {            
                if(isset($_GET['booktime'])){
                    $booktime = $_GET['booktime'];
                    $minutes = 60;
                    $bookendtime = strtotime("+".$minutes." minutes", $booktime);
                    if($booktime)
                    {
                        $stmt = $con->prepare("SELECT * FROM pelanggan p where p.id_pelanggan = '" . $_SESSION['admin_id_barbershop_Xw211qAAsq4'] . "' ");
                        $stmt->execute(array('id_pelanggan'));
                        $profile = $stmt->fetch();
                        $count = $stmt->rowCount();

                        $skmk = $con->prepare("SELECT * FROM layanan ");
                        $skmk->execute();
                        $rows_layanan = $skmk->fetchAll(); 
                        if($count > 0)
                        {
                    ?>
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">pesanan</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="pesanan.php?do=Booking&booktime=<?php echo $booktime; ?>">
                                        <!-- id pelanggan -->
                                        <input type="hidden" name="id_pelanggan" value="<?php echo $profile['id_pelanggan'];?>">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="book_name">nama</label>
                                                    <input readonly type="text" class="form-control" value="<?php echo $profile['nama'] ?>" placeholder="nama" name="book_name">
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
                                                      <select id="book_layanan" class="form-control" name="book_layanan" >
                                                        <?php
                                                        foreach($rows_layanan as $layanan){

                                                            $id = $layanan['id_layanan'];
                                                            $name = $layanan['nama_layanan']; 
                                                            echo '<option value="'.$id.'">'.$name.'</option>';
                                                        }
                                                        ?>
                                                      </select>
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
                                                    <label for="book_start_time">Start time</label>
                                                    <input readonly type="DateTime" class="form-control" value="<?php echo date('Y-m-d H:i:s', $booktime)?>"  placeholder="nomor_hp" name="book_start_time">
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
                                                    <label for="book_end_time">end time</label>
                                                    <input readonly type="DateTime" class="form-control" value="<?php echo date('Y-m-d H:i:s', $bookendtime); ?>" placeholder="end time" name="book_end_time">
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
                                            $book_name = test_input($_POST['book_name']);
                                            $book_layanan = test_input($_POST['book_layanan']);
                                            $book_start_time = test_input($_POST['book_start_time']);
                                            $book_end_time = test_input($_POST['book_end_time']);
                                            $id_pelanggan = $_POST['id_pelanggan'];

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
                                                $result = $con->prepare("SELECT MAX(id_booking) as kaka FROM booking");
                                                $result->execute(array());
                                                $row = $result->fetch();
                                                $lastid = autonumber($row['kaka'],1,4);
                                                echo $lastid;
                                                $id_booking = $lastid;

                                            try
                                            {
                                                $stmt=$con->prepare("insert into booking (id_booking,id_layanan,id_pelanggan,start_time,end_time) values(?,?,?,?,?) ");
                                                $stmt->execute(array($id_booking,$book_layanan,$id_pelanggan,$book_start_time,$book_end_time));
                                                
                                                ?> 
                                                    <!-- SUCCESS MESSAGE -->

                                                    <script type="text/javascript">
                                                        swal(" Booking berhasil","Booking berhasil", "sukses").then((value) => 
                                                        {
                                                            window.location.replace("riwayat.php");
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
                        else
                        {
                            header('Location: pesanan.php');
                            exit();
                        }
                    }
                    else
                    {
                        header('Location: pesanan.php');
                        exit();
                    }

                            ?>    
                <?php
                }
                }
                ?>           
        </div>
<?php 
        
    }
    else
    {
        header('Location: login.php');
        exit();
    }

?>