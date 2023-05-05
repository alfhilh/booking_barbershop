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

            <!-- BOOKING APPOINTMENT SECTION -->
			<section class="booking_section">
				<div class="container">

					<?php
			            if(isset($_POST['submit_book_appointment_form']) && $_SERVER['REQUEST_METHOD'] === 'POST')
			            {
			            	// Selected SERVICES

			                $selected_services = $_POST['selected_services'];

			                // Selected EMPLOYEE

			                // $selected_employee = $_POST['selected_employee'];

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
								<div id="calendar_loading">
									<img src="Design/images/ajax_loader_gif.gif" style="display: block;margin-left: auto;margin-right: auto;">
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