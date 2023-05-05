<?php
    ob_start();
    session_start();

    //Page Title
    $pageTitle = 'Profile';

    //Includes
    include 'connect.php';
    include 'Includes/functions/functions.php'; 
    include 'Includes/templates/header.php';

    //Extra JS FILES
    echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>";

    //Check If user is already logged in
    if(isset($_SESSION['username_barbershop_Xw211qAAsq4']) && isset($_SESSION['password_barbershop_Xw211qAAsq4']))
    {
?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
    
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Profile</h1>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-download fa-sm text-white-50"></i>
                    Generate Report
                </a>
            </div>

            <?php
                $do = '';

                if(isset($_GET['do']) && in_array($_GET['do'], array('Add','Edit')))
                {
                    $do = htmlspecialchars($_GET['do']);
                }
                else
                {
                    $do = 'Manage';
                }

                if($do == 'Manage')
                {
                    $stmt = $con->prepare("SELECT * FROM pelanggan p where p.id_pelanggan = '" . $_SESSION['admin_id_barbershop_Xw211qAAsq4'] . "' ");
                    $stmt->execute();
                    $rows_profile = $stmt->fetchAll(); 

                    ?>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Profile</h6>
                            </div>
                            <div class="card-body">

                                <!-- Employees Table -->
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Phone Number</th>
                                                <th scope="col">alamat</th>
                                                <th scope="col">tanggal lahir</th>
                                                <th scope="col">password</th>
                                                <th scope="col">Manage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                foreach($rows_profile as $profile)
                                                {
                                                    echo "<tr>";
                                                        echo "<td>";
                                                            echo $profile['nama'];
                                                        echo "</td>";
                                                        echo "<td>";
                                                            echo $profile['email'];
                                                        echo "</td>";
                                                        echo "<td>";
                                                            echo $profile['nomor_hp'];
                                                        echo "</td>";
                                                        echo "<td>";
                                                            echo $profile['alamat'];
                                                        echo "</td>";
                                                        echo "<td>";
                                                            echo $profile['tanggal_lahir'];
                                                        echo "</td>";
                                                        echo "<td>";
                                                            echo $profile['password'];
                                                        echo "</td>";
                                                        echo "<td>";
                                                    ?>
                                                        <ul class="list-inline m-0">

                                                            <!-- EDIT BUTTON -->

                                                            <li class="list-inline-item" data-toggle="tooltip" title="">
                                                                <button class="btn btn-success btn-sm rounded-0">
                                                                    <a href="edit_profile.php?do=Edit&id_pelanggan=<?php echo $profile['id_pelanggan']; ?>" style="color: white;">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    <?php
                                                    echo "</td>";
                                                    echo "</tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php
                }
                elseif($do == 'Edit')
                {
                    if(isset($_GET['id_pelanggan'])){
                    $id_pelanggan = $_GET['id_pelanggan'];
                    }

                    if($id_pelanggan)
                    {
                        $stmt = $con->prepare("Select * from pelanggan where id_pelanggan = ?");
                        $stmt->execute(array($id_pelanggan));
                        $profile = $stmt->fetch();
                        $count = $stmt->rowCount();

                        if($count > 0)
                        {
                            ?>
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Edit Profile</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="edit_profile.php?do=Edit&id_pelanggan=<?php echo $id_pelanggan; ?>">
                                        <!-- Employee ID -->
                                        <input type="hidden" name="id_pelanggan" value="<?php echo $profile['id_pelanggan'];?>">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="profile_name">nama</label>
                                                    <input type="text" class="form-control" value="<?php echo $profile['nama'] ?>" placeholder="nama" name="profile_name">
                                                    <?php
                                                        $flag_edit_profile_form = 0;
                                                        if(isset($_POST['edit_profile_sbmt']))
                                                        {
                                                            if(empty(test_input($_POST['profile_name'])))
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
                                                    <label for="profile_email">Email</label>
                                                    <input type="text" class="form-control" value="<?php echo $profile['email'] ?>" placeholder="Email" name="profile_email">
                                                    <?php
                                                        if(isset($_POST['edit_profile_sbmt']))
                                                        {
                                                            if(empty(test_input($_POST['profile_email'])))
                                                            {
                                                                ?>
                                                                    <div class="invalid-feedback" style="display: block;">
                                                                        membutuhkan email baru.
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
                                                    <label for="profile_phone">Nomor HP</label>
                                                    <input type="text" class="form-control" value="<?php echo $profile['nomor_hp'] ?>"  placeholder="nomor_hp" name="profile_phone">
                                                    <?php
                                                        if(isset($_POST['edit_profile_sbmt']))
                                                        {
                                                            if(empty(test_input($_POST['profile_phone'])))
                                                            {
                                                                ?>
                                                                    <div class="invalid-feedback" style="display: block;">
                                                                        membutuhkan nomor hp baru.
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
                                                    <label for="profile_alamat">alamat</label>
                                                    <input type="text" class="form-control" value="<?php echo $profile['alamat'] ?>" placeholder="alamat" name="profile_alamat">
                                                    <?php
                                                        if(isset($_POST['edit_profile_sbmt']))
                                                        {
                                                            if(empty(test_input($_POST['profile_alamat'])))
                                                            {
                                                                ?>
                                                                    <div class="invalid-feedback" style="display: block;">
                                                                        membutuhkan alamat baru.
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
                                                    <label for="profile_tanggal_lahir">tanggal_lahir</label>
                                                    <input type="datetime" class="form-control" value="<?php echo $profile['tanggal_lahir'] ?>" placeholder="tanggal_lahir" name="profile_tanggal_lahir">
                                                    <?php
                                                        if(isset($_POST['edit_profile_sbmt']))
                                                        {
                                                            if(empty(test_input($_POST['profile_tanggal_lahir'])))
                                                            {
                                                                ?>
                                                                    <div class="invalid-feedback" style="display: block;">
                                                                        membutuhkan tanggal lahir baru.
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
                                                    <label for="profile_password">password</label>
                                                    <input type="password" class="form-control" value="<?php echo $profile['password'] ?>" placeholder="password" name="profile_password">
                                                    <?php
                                                        if(isset($_POST['edit_profile_sbmt']))
                                                        {
                                                            if(empty(test_input($_POST['profile_password'])))
                                                            {
                                                                ?>
                                                                    <div class="invalid-feedback" style="display: block;">
                                                                        membutuhkan password baru.
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
                                            Edit profile
                                        </button>
                                    </form>
                                    <?php
                                        /*** EDIT profile ***/
                                        if(isset($_POST['edit_profile_sbmt']) && $_SERVER['REQUEST_METHOD'] == 'POST' && $flag_edit_profile_form == 0)
                                        {
                                            $profile_name = test_input($_POST['profile_name']);
                                            $profile_email = test_input($_POST['profile_email']);
                                            $profile_phone = test_input($_POST['profile_phone']);
                                            $profile_alamat = test_input($_POST['profile_alamat']);
                                            $profile_tanggal_lahir = test_input($_POST['profile_tanggal_lahir']);
                                            $profile_password = test_input($_POST['profile_password']);
                                            $id_pelanggan = $_POST['id_pelanggan'];

                                            try
                                            {
                                                $stmt = $con->prepare("update pelanggan set nama = ?, email = ?, password = ?, alamat = ?, tanggal_lahir = ?, nomor_hp = ? where id_pelanggan = ? ");
                                                $stmt->execute(array($profile_name,$profile_email,$profile_password,$profile_alamat,$profile_tanggal_lahir,$profile_phone,$id_pelanggan));
                                                
                                                ?> 
                                                    <!-- SUCCESS MESSAGE -->

                                                    <script type="text/javascript">
                                                        swal(" data pelanggan telah diupdate","data pelanggan sukses diupdate", "sukses").then((value) => 
                                                        {
                                                            window.location.replace("edit_profile.php");
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
                            header('Location: edit_profile.php');
                            exit();
                        }
                    }
                    else
                    {
                        header('Location: edit_profile.php');
                        exit();
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