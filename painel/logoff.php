<?php 
	ob_start();
	session_start();
		unset($_SESSION['autUser']);
		header('Location: index');
	ob_end_flush();
?>