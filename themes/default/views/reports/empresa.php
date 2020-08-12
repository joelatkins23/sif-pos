<?php
	  // include_once ("segura.php");
	 
	  $user_logado = $_SESSION['userID'];
		 
?>
<?php


  $sql_vendas = mysql_query("SELECT * FROM tb_parametros ")
   or die(mysql_error());
	  $contar_reserva = mysql_num_rows( $sql_vendas);
	  $i = 0;
	  while ($resultado = mysql_fetch_array($sql_vendas, MYSQL_ASSOC)){
		  $id_aluno      = $resultado ['id_p'];
		  $logo_aluno    = $resultado ['logo'];
		  $nome_aluno    = $resultado ['linha1'];
		  $nif           = $resultado ['linha2'];
		  $rua           = $resultado ['linha3'];
		  $telefone      = $resultado ['linha4'];
		  $email         = $resultado ['linha5'];
		  $linha6        = $resultado ['linha6'];
		 
		  
		  
	}	 ?>
<div id="asd">
	<!-- <div id=""><img src="<?php echo $logo_aluno?>" alt="Logotipo"  width="104" height="86" border="0" />  -->
    
    <!-- </div> -->
</div>