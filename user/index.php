<?php 
    session_start();

    //Check If user is already logged in
    if(isset($_SESSION['username_barbershop_Xw211qAAsq4']) && isset($_SESSION['password_barbershop_Xw211qAAsq4']))
    {
        //Page Title
        $pageTitle = 'Dashboard';

        //Includes
        include 'connect.php';
        include 'Includes/functions/functions.php'; 
        include 'Includes/templates/header.php';

?>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i>
                Generate Report
            </a>
        </div>

        <!-- Appointment Tables -->
        <div class="card shadow mb-4">
            <div class="card-header tab" style="padding: 0px !important;background: #36b9cc!important">
                <button class="tablinks active" onclick="openTab(event, 'Upcoming')">
                    Upcoming Bookings
                </button>
                <button class="tablinks" onclick="openTab(event, 'All')">
                    All Bookings
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

                                            
                                                    ?>
                                                    

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
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                                $stmt = $con->prepare("SELECT * 
                                                FROM booking a , pelanggan c
                                                where a.id_pelanggan = c.id_pelanggan and c.email = '" . $_SESSION['username_barbershop_Xw211qAAsq4'] . "'
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
                                        echo "</tr>";
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
