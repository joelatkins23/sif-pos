<?php 
ob_start();
session_start();
	require_once('../../../../../config/config.php');
	require_once('../../../../../config/crud.php');
	require_once('../../../../../config/funcoes.php');	
	require_once('../../../../../admin/js/funcoes.php');
?> 


<!DOCTYPE html>
<html lang="pr-br">
<head>
<meta charset="utf-8">
<title>Upload Multiplo com PHP</title>
</head>

<body>
	
	<?php include "upload.php"; ?>
	
	<form action="" method="post" enctype="multipart/form-data">
		
		<input type="file" name="img[]" multiple>
		<input type="submit" name="upload" value="Upload">
		
	</form>
	
</body>
</html>