<?php
	session_start();

	// IF THE USER HAS ALREADY LOGGED IN
	if(isset($_SESSION['username_barbershop_Xw211qAAsq4']) && isset($_SESSION['password_barbershop_Xw211qAAsq4']))
	{
		header('Location: pesanan.php');
		exit();
	}
	// ELSE
	$pageTitle = 'Barber Login';
	include 'connect.php';
	include 'Includes/functions/functions.php';
	echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>";

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Barber User Register</title>
		<!-- FONTS FILE -->
		<link href="Design/fonts/css/all.min.css" rel="stylesheet" type="text/css">

		<!-- Nunito FONT FAMILY FILE -->
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

		<!-- CSS FILES -->
		<link href="Design/css/sb-admin-2.min.css" rel="stylesheet">
		<link href="Design/css/main.css" rel="stylesheet">
	</head>
	<body>
		<div class="login">
			<form class="login-container validate-form" name="login-form" method="POST" action="register.php" onsubmit="return validateLogInForm()">
				<span class="login100-form-title p-b-32">
					Barber User register
				</span>

				<!-- PHP SCRIPT WHEN SUBMIT -->

				<?php

					if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signin-button']))
					{
						$nama = test_input($_POST['nama']);
						$email = test_input($_POST['email']);
						$password = test_input($_POST['password']);
						$Alamat = test_input($_POST['Alamat']);
						$tanggal_lahir = test_input($_POST['tanggal_lahir']);
						$no_hp = test_input($_POST['no_hp']);


						//Check if User Exist In database

						$stmt = $con->prepare("Select id_pelanggan, nama, email from pelanggan where nama=? and email = ?");
						$stmt->execute(array($nama,$email));
						$row = $stmt->fetch();
						$count = $stmt->rowCount();

						// Check if count > 0 which mean that the database contain a record about this username

						if($count > 0)
						{
							?> 

                                    <script type="text/javascript">
                                            swal("email sudah ada","silahkan login dengan email tersebut", "gagal").then((value) => 
                                            {
                                                window.location.replace("login.php");
                                            });
                                    </script>

                            <?php
						}
						else
						{
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
                                               //function mendapatkan id terakhir 
                                                $result = $con->prepare("SELECT MAX(id_pelanggan) as kaka FROM pelanggan");
                                                $result->execute(array());
                                                $row = $result->fetch();
                                                $lastid = autonumber($row['kaka'],1,4);
                                                $id_pelanggan = $lastid;

                                    try
                                    {
                                        $stmt = $con->prepare("insert into pelanggan(id_pelanggan,nama,email,password,alamat,tanggal_lahir,nomor_hp) values(?,?,?,?,?,?,?) ");
                                        $stmt->execute(array($id_pelanggan,$nama,$email,$password,$Alamat,$tanggal_lahir,$no_hp));
                                        
                                        ?> 
                                            <!-- SUCCESS MESSAGE -->

                                            <script type="text/javascript">
                                                swal("register berhasil","Silahkan login", "success").then((value) => 
                                                {
                                                    window.location.replace("login.php");
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
							?>
							<?php
						}
					}
				?>
				<div class="form-input">
					<span class="txt1">Nama</span>
					<input type="text" name="nama" class = "form-control" oninput = "getElementById('required_nama').style.display = 'none'" autocomplete="off">
					<span class="invalid-feedback" id="required_nama">Nama is required!</span>
				</div>
				<div class="form-input">
					<span class="txt1">Email</span>
					<input type="text" name="email" class = "form-control" oninput = "getElementById('required_email').style.display = 'none'" autocomplete="off">
					<span class="invalid-feedback" id="required_email">Email is required!</span>
				</div>
				<div class="form-input">
					<span class="txt1">Password</span>
					<input type="password" name="password" class="form-control" oninput = "getElementById('required_password').style.display = 'none'" autocomplete="new-password">
					<span class="invalid-feedback" id="required_password">Password is required!</span>
				</div>								
				<div class="form-input">
					<span class="txt1">Alamat</span>
					<input type="text" name="Alamat" class = "form-control" oninput = "getElementById('required_Alamat').style.display = 'none'" autocomplete="off">
					<span class="invalid-feedback" id="required_Alamat">Alamat is required!</span>
				</div>
				<div class="form-input">
					<span class="txt1">Tanggal Lahir</span>
					<input type="date" name="tanggal_lahir" class = "form-control" oninput = "getElementById('required_tanggal_lahir').style.display = 'none'" autocomplete="off">
					<span class="invalid-feedback" id="required_lahir">Tanggal lahir is required!</span>
				</div>
				<div class="form-input">
					<span class="txt1">no HP</span>
					<input type="text" name="no_hp" class = "form-control" oninput = "getElementById('required_no_hp').style.display = 'none'" autocomplete="off">
					<span class="invalid-feedback" id="required_no_hp">No HP is required!</span>
				</div>								

				<p>
					<button type="submit" name="signin-button" >Register</button>
				</p>

				<!-- FORGOT YOUR PASSWORD LINK -->

				<span class="forgotPW">have account?,  <a href="Login.php">Login now.</a></span> 
			</form>
		</div>
		
		<!-- Footer -->
		<footer class="sticky-footer bg-white">
			<div class="container my-auto">

			</div>
	  	</footer>
		<!-- End of Footer -->

		<!-- INCLUDE JS SCRIPTS -->
		<script src="Design/js/jquery.min.js"></script>
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
		<script src="Design/js/bootstrap.bundle.min.js"></script>
		<script src="Design/js/sb-admin-2.min.js"></script>
		<script src="Design/js/main.js"></script>
	</body>
</html>