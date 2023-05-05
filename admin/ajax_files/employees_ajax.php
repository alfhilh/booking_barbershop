<?php include '../connect.php'; ?>
<?php include '../Includes/functions/functions.php'; ?>


<?php
	

	if(isset($_POST['do']) && $_POST['do'] == "Delete")
	{
		$id_pelanggan = $_POST['id_pelanggan'];

        $stmt = $con->prepare("DELETE from pelanggan where id_pelanggan = ?");
        $stmt->execute(array($id_pelanggan));    
	}
	
?>