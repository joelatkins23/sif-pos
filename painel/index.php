<?php
ob_start();
session_start();
	require_once('../config/config.php');
	require_once('../config/crud.php');
	require_once('../config/funcoes.php');	
?>
<!DOCTYPE html>
<!--[if lte IE 8]>              <html class="ie8 no-js" lang="en">     <![endif]-->
<!--[if IE 9]>					<html class="ie9 no-js" lang="en-US">  <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="not-ie no-js" lang="en">  <!--<![endif]-->
	<head>
		<!-- Google Web Fonts
		================================================== -->
		<link href='http://fonts.googleapis.com/css?family=Roboto:300,300italic,400,500,700%7cCourgette%7cRaleway:400,700,500%7cCourgette%7cLato:700' rel='stylesheet' type='text/css'>

		<!-- Basic Page Needs
		================================================== -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<title>Administração v<?php echo VERSAO; ?> - <?php echo SITENOME; ?></title>	

		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Mobile Specific Metas
		================================================== -->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

		<!-- CSS
		================================================== -->
		<link rel="stylesheet" href="css/tmm_form_wizard_style_demo.css" />
		<link rel="stylesheet" href="css/grid.css" />
		<link rel="stylesheet" href="css/tmm_form_wizard_layout.css" />
		<link rel="stylesheet" href="css/fontello.css" />

	</head>
	<body style=" margin-top:15%;">


		<!-- - - - - - - - - - - - - Content - - - - - - - - - - - - -  -->


		<div id="content"  >

			<div class="form-container" style=" height:150px;" >

				<div id="tmm-form-wizard" class="container substrate" style=" height:250px;">

	


					<div class="row" >

						<div class="col-xs-12"  >

							<div class="form-header">
								
								<div class="form-title form-icon title-icon-lock">
									Painel - <b><?php echo SITENOME; ?></b>
								</div>
				
								
							</div><!--/ .form-header-->

						</div>

					</div><!--/ .row-->

                                        <form action="autorizacao" method="post">

						<div class="form-wizard" >

							<div class="row" >
								
								<div class="col-md-8 col-sm-7" >

<fieldset class="input-block">
<label for="email">E-mail</label>
<input type="text" id="email" class="form-icon form-icon-mail" placeholder="Digite seu email" name="recebeLogin" required />
<div class="tooltip">
<p>
<b>Entre com seu email de administração foi cadastrado para o gerenciamento do conteúdo</b>

</p>
<spanVocê pode cadastrar novos emails na são [usuarios] do seu painel</span> 
</div><!--/ .tooltip-->
</fieldset><!--/ .input-email-->


<fieldset class="input-block">
<label for="password">Senha</label>
<input name="recebeSenha" type="password" id="password" placeholder="Senha" required />

</fieldset><!--/ .input-password-->

									

												<div class="next">
								<button class="button button" type="submit" ><span>Entrar</span></button>
								
							</div>			

								</div>
								
							</div><!--/ .row-->
							
						</div><!--/ .form-wizard-->


						
	

					</form><!--/ form-->

				</div><!--/ .container-->
		
			</div><!--/ .form-container-->

		</div><!--/ #content-->


		<!-- - - - - - - - - - - - end Content - - - - - - - - - - - - - -->

		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>

		<!--[if lt IE 9]>
				<script src="js/respond.min.js"></script>
		<![endif]-->
		
		<script src="js/tmm_form_wizard_custom.js"></script>
	</body>
</html>