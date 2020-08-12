<?php
ob_start();
session_start();
	require_once('../config/config.php');
	require_once('../config/crud.php');
	require_once('../config/funcoes.php');	
	
	if(!empty($_SESSION['autUser'])){
		header('Location: dartweb/');
		}
?>


            
        <?php   

			if($_POST['recebeLogin']){
				$login['email'] = mysql_real_escape_string($_POST['recebeLogin']);
				$login['senha'] = mysql_real_escape_string($_POST['recebeSenha']);
				
				if(!$login['email'] || !email($login['email'])){
					echo '<div class="msgerror">Desculpe o e-mail é invalido!</div>';	
				}elseif(strlen($login['senha']) < 5 || strlen($login['senha']) > 10){
					echo ' <div class="msgerror">Desculpe a senha deve ter entre 5 a 10 caracteres</div>';	
				}else{
					$autEmail = $login['email'];
					$autSenha = md5($login['senha']);	
					$leitura = read('usuarios',"WHERE email = '$autEmail'");
					if($leitura){
						foreach($leitura as $autUser);	
						if($autEmail == $autUser['email'] && $autSenha == $autUser['senha']){
							if($autUser['nivel'] == '1' || $autUser['nivel'] == '2'){
								$_SESSION['autUser'] = $autUser;	
								header('Location: '.$_SERVER['PHP_SELF'].'');
							}elseif($autUser['nivel'] == '3'){
							        $_SESSION['autUser'] = $autUser;	
								header('Location: http://mapolconstrutora.com.br/perfil');
							}else{
								echo '<div class="msgerror">Seu nível está errado!</div>';
								header('Location: '.$_SERVER['PHP_SELF'].'');
							}	
						}else{
							echo '<div class="msgerror">Sua senha está errada!</div>';	
						}
					}else{
						echo '<div class="msgerror">O e-mail informado é invalido!</div>';
					}
				}

			}
		
		?>

<?php
	ob_end_flush();
?>