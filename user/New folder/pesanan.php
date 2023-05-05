<!-- PHP INCLUDES -->
<?php
    session_start();

     //Page Title
    $pageTitle = 'Pesanan Baru';

    //Includes
    include "connect.php";
    include "Includes/functions/functions.php";
    include "Includes/templates/header.php";

    //Check If user is already logged in
    if(isset($_SESSION['username_barbershop_Xw211qAAsq4']) && isset($_SESSION['password_barbershop_Xw211qAAsq4']))
    {
?>
		<style type="text/css">
            
            .calendar_tab
            {
                background: white;
                margin-top: 5px;
                width: 100%;
                position: relative;
                box-shadow: rgba(60, 66, 87, 0.04) 0px 0px 5px 0px, rgba(0, 0, 0, 0.04) 0px 0px 10px 0px;
                overflow: hidden;
                border-radius: 4px;
            }

            .appointment_day
            {
                width: 15%;
                text-align: center;
                display: flex;
                color: rgb(151, 151, 151);
                font-weight: 700;
                -webkit-box-align: center;
                align-items: center;
                -webkit-box-pack: center;
                justify-content: center;
                font-size: 14px;
                line-height: 1.5;
            }

            .appointments_days
            {
                border-top-left-radius: 4px;
                border-top-right-radius: 4px;
                display: flex;
                height: 60px;
                position: relative;
                -webkit-box-pack: justify;
                justify-content: space-between;
                padding: 10px;
                border-bottom: 1px solid rgb(229, 229, 229);
            }

            .available_booking_hours
            {
                display: flex;
                -webkit-box-pack: justify;
                justify-content: space-between;
                padding: 10px;
                border-radius: 4px;
            }

            .available_booking_hour:hover
            {
                font-weight: 700;
            }

            .available_booking_hour
            {
                font-size: 14px;
                padding-top:25px;
                line-height: 1.3;
                cursor: pointer;
            }


            input[type="radio"] 
            {
                display: none;
            }

            input[type="radio"]:checked + label 
            {
                font-weight: 700;
            }

            .available_booking_hours_colum
            {
                width: 15%;
                text-align: center;
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

            <div class="card shadow mb-4">
                            <div class="card-body">
                            	<!-- BOOKING APPOINTMENT SECTION -->
			<section class="booking_section">
				<div class="container">

					<?php
			            if(isset($_POST['submit_book_appointment_form']) && $_SERVER['REQUEST_METHOD'] === 'POST')
			            {
			            	// Selected SERVICES

			                $selected_services = $_POST['selected_services'];

			                // Selected EMPLOYEE

			                $selected_employee = $_POST['selected_employee'];

			                // Selected DATE+TIME

			                $selected_date_time = explode(' ', $_POST['desired_date_time']);

			                $date_selected = $selected_date_time[0];
			                $start_time = $date_selected." ".$selected_date_time[1];
			                $end_time = $date_selected." ".$selected_date_time[2];


			                //Client Details

			                //$client_first_name = test_input($_POST['client_first_name']);
			                //$client_last_name = test_input($_POST['client_last_name']);
			                //$client_phone_number = test_input($_POST['client_phone_number']);
			                //$client_email = test_input($_POST['client_email']);

			                $con->beginTransaction();

			                try
			                {

			                    $stmtgetCurrentAppointmentID = $con->prepare("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'barbershop' AND TABLE_NAME = 'appointments'");
			            
			                    $stmtgetCurrentAppointmentID->execute();
			                    $appointment_id = $stmtgetCurrentAppointmentID->fetch();
			                    
			                    $stmt_appointment = $con->prepare("insert into appointments(date_created, client_id, employee_id, start_time, end_time_expected ) values(?, ?, ?, ?, ?)");
			                    $stmt_appointment->execute(array(Date("Y-m-d H:i"),$client_id[0],$selected_employee,$start_time,$end_time));

			                    foreach($selected_services as $service)
			                    {
			                        $stmt = $con->prepare("insert into services_booked(appointment_id, service_id) values(?, ?)");
			                        $stmt->execute(array($appointment_id[0],$service));
			                    }
			                    
			                    echo "<div class = 'alert alert-success'>";
			                        echo "Great! Your appointment has been created successfully.";
			                    echo "</div>";

			                    $con->commit();
			                }
			                catch(Exception $e)
			                {
			                    $con->rollBack();
			                    echo "<div class = 'alert alert-danger'>"; 
			                        echo $e->getMessage();
			                    echo "</div>";
			                }
			            }

			        ?>

					<!-- RESERVATION FORM -->

					<form method="post" id="pesanan" action="pesanan.php">
					
						<!-- SELECT SERVICE -->

						<div class="select_services_div tab_reservation" id="layanan">

							<!-- ALERT MESSAGE -->

							<div class="alert alert-danger" role="alert" style="display: none">
								tolong pilih 1 layanan!
							</div>

							<div class="text_header">
								<span>
									1. pilih layanan
								</span>
							</div>

								<!-- SERVICES TAB -->
							
							<div class="items_tab">
			        			<?php
			        				$stmt = $con->prepare("Select * from layanan");
			                    	$stmt->execute();
			                    	$rows = $stmt->fetchAll();

			                    	foreach($rows as $row)
			                    	{
			                        	echo "<div class='itemListElement'>";
			                            	echo "<div class = 'item_details'>";
			                                	echo "<div>";
			                                    	echo $row['nama_layanan'];
			                                	echo "</div>";
			                                	echo "<div class = 'item_select_part'>";
			                                		echo "<span class = 'service_duration_field'>";
			                                    		echo $row['durasi']." min";
			                                    	echo "</span>";
			                                    	echo "<div class = 'service_price_field'>";
			    										echo "<span style = 'font-weight: bold;'>";
			                                    			echo $row['harga_layanan']."$";
			                                    		echo "</span>";
			                                    	echo "</div>";
			                                    ?>
			                                    	<div class="select_item_bttn">
			                                    		<div class="btn-group-toggle" data-toggle="buttons">
															<label class="service_label item_label btn btn-secondary">
																<input type="checkbox"  name="selected_services[]" value="<?php echo $row['id_layanan'] ?>" autocomplete="off">Select
															</label>
														</div>
			                                    	</div>
			                                    <?php
			                                	echo "</div>";
			                            	echo "</div>";
			                        	echo "</div>";
			                    	}
			            		?>
			    			</div>
						</div>


						<!-- SELECT DATE TIME -->

						<div class="select_date_time_div tab_reservation" id="calendar_tab">

							<!-- ALERT MESSAGE -->
							
					        <div class="alert alert-danger" role="alert" style="display: none">
					          Please, select time!
					        </div>

							<div class="text_header">
								<span>
									2. Choice of Date and Time
								</span>
							</div>
							
							<div class="calendar_tab" style="overflow-x: auto;overflow-y: visible;" id="calendar_tab_in">
								<div class="calendar_slots" style="min-width: 600px;">

							            <!-- NEXT 10 DAYS -->

							            <div class="appointments_days">
							                <?php
							                    
							                    $appointment_date = date('Y-m-d');

							                    for($i = 0; $i < 10; $i++)
							                    {
							                        $appointment_date = date('Y-m-d', strtotime($appointment_date . ' +1 day'));
							                        echo "<div class = 'appointment_day'>";
							                            echo date('D', strtotime($appointment_date));
							                            echo "<br>";
							                            echo date('d', strtotime($appointment_date))." ".date('M', strtotime($appointment_date));
							                        echo "</div>";
							                    } 
							                ?>
							            </div>

							            <!-- DAY HOURS -->

							            <div class = 'available_booking_hours'>
							                <?php

							                    //SELECTED SERVICES
									            $desired_services = $_POST['selected_services'];
									            
							                    //SELECTED EMPLOYEE
									           //$selected_employee = $_POST['selected_employee'];

							            		//Services Duration - End time expected
									            $sum_duration = 0;
									            
							                    foreach($desired_services as $service)
									            {
									                
									                $stmtServices = $con->prepare("select durasi from layanan where id_layanan = ?");
									                $stmtServices->execute(array($service));
									                $rowS =  $stmtServices->fetch();
									                $sum_duration += $rowS['durasi'];
									                
									            }
							            
							            
									            $sum_duration = date('H:i',mktime(0,$sum_duration));
									            $secs = strtotime($sum_duration)-strtotime("00:00:00");


							                    $open_time = date('H:i',mktime(9,0,0));

							                    $close_time = date('H:i',mktime(22,0,0));

							                    $start = $open_time;

							                    $secs = strtotime($sum_duration)-strtotime("00:00:00");
							                    $result = date("H:i:s",strtotime($start)+$secs);


							                    $appointment_date = date('Y-m-d');

							                    for($i = 0; $i < 10; $i++)
							                    {
							                        echo "<div class='available_booking_hours_colum'>";

							                            $appointment_date = date('Y-m-d', strtotime($appointment_date . ' +1 day'));
							                            $start = $open_time;
							                            $secs = strtotime($sum_duration)-strtotime("00:00:00");
							                            $result = date("H:i:s",strtotime($start)+$secs);

							                            $day_id = date('w',strtotime($appointment_date));
							                            
							                            while($start >= $open_time && $result <= $close_time)
							                            {
							                                //Check If there are no intersecting appointments with the current one
							                                    $stmt = $con->prepare("
							                                        Select * 
							                                        from booking 
							                                        where
							                                            date(start_time) = ?
							                                            and
							                                            (   
							                                                time(start_time) between ? and ?
							                                                or
							                                                time(end_time) between ? and ?
							                                            )
							                                    ");
							                                    
							                                    $stmt->execute(array($appointment_date,$start,$result,$start,$result));
							                                    $rows = $stmt->fetchAll();

							                                if($stmt_emp->rowCount() != 0)
							                                {

							                                    //Check If there are no intersecting appointments with the current one
							                                    $stmt = $con->prepare("
							                                        Select * 
							                                        from booking 
							                                        where
							                                            date(start_time) = ?
							                                            and
							                                            (   
							                                                time(start_time) between ? and ?
							                                                or
							                                                time(end_time) between ? and ?
							                                            )
							                                    ");
							                                    
							                                    $stmt->execute(array($appointment_date,$start,$result,$start,$result));
							                                    $rows = $stmt->fetchAll();
							                        
							                                    if($stmt->rowCount() != 0)
							                                    {
							                                        //Show blank cell
							                                    }
							                                    else
							                                    {
							                                        ?>
							                                            <input type="radio" id="<?php echo $appointment_date." ".$start; ?>" name="desired_date_time" value="<?php echo $appointment_date." ".$start." ".$result; ?>">
							                                            <label class="available_booking_hour" for="<?php echo $appointment_date." ".$start; ?>"><?php echo $start; ?></label>
							                                        <?php
							                                    }
							                                }
							                                else
							                                {
							                                    //Show Blank cell
							                                }
							                                

							                                $start = strtotime("+15 minutes", strtotime($start));
							                                $start =  date('H:i', $start);

							                                $secs = strtotime($sum_duration)-strtotime("00:00:00");
							                                $result = date("H:i",strtotime($start)+$secs);
							                            }

							                        echo "</div>";
							                    }
							                ?>
							            </div>
							        </div>
								</div>
							</div>
						</div>
			          	<button type="submit" name="submit_book_appointment_form" >Submit</button>
					</form>
				</div>
			</section>
        </div>
  
<?php 
        
    }
    else
    {
        header('Location: login.php');
        exit();
    }

?>