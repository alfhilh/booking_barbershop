<?php
	//Start Session
	session_start();
	//Unset variables of session
	//session_unset();
	unset($_SESSION['username_barbershop_Xw211qAAsq4']);
	//Destroy Session
	//session_destroy();
	header('Location: ../');
	exit();
?>