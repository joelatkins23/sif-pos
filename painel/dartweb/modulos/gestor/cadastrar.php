<?php
ob_start();
session_start();
	require_once('../../../../config/config.php');
	require_once('../../../../config/crud.php');
	require_once('../../../../config/funcoes.php');	
	require_once('../../../../admin/js/funcoes.php');	
	$modulo = basename(getcwd());
	$modulonome = ucfirst($modulo);
	
	if(!$_SESSION['autUser']){
		header('Location: http://www.dartweb.com.br/painel');
		}
?>
<!-- INICIA CADASTRO !-->

	<?php 
		if(isset($_POST['cadastrar'])){
			$cad['usuario']   	    = utf8_decode($_POST['usuario']);
			$cad['nome']   	            = utf8_decode($_POST['nome']);
			$cad['telefone']   	    = utf8_decode($_POST['telefone']);
			$cad['email']   	    = utf8_decode($_POST['email']);
			$cad['linkcadastro']   	    = utf8_decode($_POST['linkcadastro']);
		



			$cad['datacad']            = date('d-m-Y H:i:s');
			
			if($_POST['excluir1']){$cad['fotopost'] = "";}else;
			
			if(in_array('-',$cad)){
				echo '<div class="msgError">Todos os campos são obrigatórios!</div><br />';
			}else{
/* INICIA FUNÇÃO PARA UPLOAD */
if(!empty($_FILES['fotopost']['tmp_name'])){
$imagem = $_FILES['fotopost']; /* AQUI O NOME DO FROM FILE DO FORMULARIO */
$pasta = 'uploads/'; /* AQUI UM DIRETORIO VALIDO */
$tmp = $imagem['tmp_name']; /* AQUI O NOME TEMPORARIO DA IMAGEM */
$ext = substr($imagem['name'],-3);

$GeraIMGAmigavel = $_POST['nome'].' r'.mt_rand();
$nome = url($GeraIMGAmigavel).'.'.$ext; /* AQUI E A CIMA MODIFICA O NOME PARA UM ÚNICO */
$cad['fotopost'] = $nome;
uploadImg ($tmp, $nome, '540', $pasta); /* FAZ O UPLOAD COM O NOVO NOME E O TAMANHO IDEAL*/ 
}
/* FINALIZA FUNÇÃO PARA UPLOAD */			
			
			create('recrutadores',$cad);
			$id_galeria	        = mysql_insert_id();
			
			$GeraURLAmigavel = $_POST['cidade'].' p'.$id_galeria;
			$atu['nomeURL']   	   = url($GeraURLAmigavel);
			update('recrutadores',$atu,"cod = '$id_galeria'");
			

				
$_SESSION['cadastro'] =
 '
<div class="alert alert-success">            
<strong>Parabéns!</strong> Sua empresa foi cadastrada com sucesso!
<button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
';
				header('Location: listar');
			    unset($cad);
				
			  }
		}elseif(!empty($_SESSION['cadastro'])){
			echo $_SESSION['cadastro'];
			unset($_SESSION['cadastro']);
		}
	?>
<!-- FINALIZA CADASTRO !-->
<!DOCTYPE html>
<html lang="en">
<head>        
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />    
    <!--[if gt IE 8]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />        
    <![endif]-->                
    <title>Administração - <?php echo SITENOME; ?> - Cadastrar <?php echo $modulonome; ?></title>
    <link rel="icon" type="image/ico" href="../../favicon.ico"/>
    
    <link href="../../css/stylesheets.css" rel="stylesheet" type="text/css" />
    
    <!--[if lte IE 7]>
        <script type='text/javascript' src='js/other/lte-ie7.js'></script>
    <![endif]-->    
    
    <script type='text/javascript' src='../../js/jquery/jquery.min.js'></script>
    <script type='text/javascript' src='../../js/jquery/jquery-ui-1.10.3.custom.min.js'></script>
    <script type='text/javascript' src='../../js/jquery/jquery-migrate.min.js'></script>
    <script type='text/javascript' src='../../js/jquery/globalize.js'></script>
    
    <script type='text/javascript' src='../../js/bootstrap/bootstrap.min.js'></script>
    <script type='text/javascript' src='../../js/cookies/jquery.cookies.2.2.0.min.js'></script>
    
    <script type='text/javascript' src='../../js/nicedit/nicEdit.js'></script>
    <script type='text/javascript' src='../../js/cleditor/jquery.cleditor.min.js'></script>
    
    <script type='text/javascript' src='../../js/scrollup/jquery.scrollUp.min.js'></script>
    
    <script type='text/javascript' src='../../js/plugins.js'></script>    
    <script type='text/javascript' src='../../js/actions.js'></script>
    
	<script type="text/javascript">
	document.getElementById("termos").setCustomValidity("Voce precisa aceitar os termos de uso para continuar");
	</script>
    
</head>
<body>    
    
    <div id="wrapper">
        
        <div id="header">
            
            <div class="wrap">
                
                 <a href="<?php echo PAINEL; ?>/index" class="logo"></a>
                
                <div class="buttons fl">
                    <div class="item">
                        <a href="#" class="btn btn-primary btn-sm c_layout">
                            <span class="i-layout-8"></span>                            
                        </a>
                    </div>
                    <div class="item">
                        <a href="#" class="btn btn-primary btn-sm c_screen">
                            <span class="i-stretch"></span>                            
                        </a>
                    </div>                    
                </div>
                
                <div class="buttons">
                    <div class="item">
                        <a href="#" class="btn btn-primary btn-sm">
                            <span class="i-cog"></span>
                        </a>
                        <div class="popup">
                            <div class="head">
                                <h2>Defini&ccedil;&otilde;es</h2>
                            </div>
                            <div class="content np">      
                                <div class="row">
                                    <div class="controls-row">
                                        <div class="col-md-3">Temas:</div>
                                        <div class="col-md-9 themes">
                                            <a href="#" class="default tip" data-theme="" title="Default"></a>
                                            <a href="#" class="dark tip" data-theme="themeDark" title="Dark"></a>
                                            <a href="#" class="simple tip" data-theme="themeSimple" title="Simple"></a>
                                            <div class="help-block">On click theme will changed and saved settings</div>
                                        </div>
                                    </div>               
                                    <div class="controls-row">
                                        <div class="col-md-3">Backgrounds:</div>
                                        <div class="col-md-9 backgrounds">
                                            <a href="#" class="default tip" data-theme="" title="Default"></a>                                            
                                            <a href="#" class="b_bcrosshatch" data-back="b_bcrosshatch"></a>
                                            <a href="#" class="b_crosshatch" data-back="b_crosshatch"></a>
                                            <a href="#" class="b_cube" data-back="b_cube"></a>
                                            <a href="#" class="b_dots" data-back="b_dots"></a>
                                            <a href="#" class="b_grid" data-back="b_grid"></a>
                                            <a href="#" class="b_hline" data-back="b_hline"></a>
                                            <a href="#" class="b_simple" data-back="b_simple"></a>
                                            <a href="#" class="b_vline" data-back="b_vline"></a>
                                            <div class="help-block">On click background will changed and saved settings</div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="footer">
                                <div class="side fr">
                                    <button class="btn btn-primary popup-close">Fechar</button>
                                </div>                                
                            </div>
                        </div>                        
                    </div>
                    <div class="item">
                        <a href="#" class="btn btn-primary btn-sm">
                            <span class="i-chat"></span>
                        </a>
                        <div class="popup">
                            <div class="head">
                                <h2>Mensagens</h2>
                            </div>
                            <div class="content npb messages minify" id="messages"></div>
                            <div class="footer">
                                <div class="side fl">
                                    <button class="btn btn-link">Ver todas</button>
                                </div>
                                <div class="side fr">
                                    <button class="btn btn-primary popup-close">Fechar</button>
                                </div>                                
                            </div>
                        </div>                        
                    </div>
                    <div class="item">                        
                        <div class="btn-group">                        
                            <a href="#" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                                <span class="i-forward"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><span class="i-profile"></span> Perfil</a></li>
                                <li><a href="#"><span class="i-tools"></span> Controles</a></li>                                
                                <li><a href="#"><span class="i-locked"></span> Trancar</a></li>
                                <li><a href="../../../logoff"><span class="i-forward"></span> Sair</a></li>
                            </ul> 
                        </div>
                    </div>
                    
                </div>
                
            </div>
            
        </div>
        
        <div id="layout">
        
            <div id="sidebar">

                <div class="user">
                    <div class="pic">
<?php
$fotoDoUser = $_SESSION['autUser']['fotopost'];
if($fotoDoUser) {
echo '<img width="50" height="50" src="'.PAINEL.'/php/uploads/usuarios/'.$fotoDoUser.'"/>';
}else{
echo '<img width="50" height="50" src="../../img/examples/users/dmitry_m.jpg"/>';
}
?>
                    </div>
                    <div class="info">
                        <div class="name">
                            <a href="#"><?php echo $_SESSION['autUser']['nome']; ?></a>
                        </div>
                        <div class="buttons">
                            
                            <a href="#"><span class="i-chat"></span> Mensagens</a>
                            <a href="../../../logoff" class="fr"><span class="i-forward"></span> Sair</a>
                        </div>
                    </div>
                </div>

  <?php include("../../inc/menu.php"); ?>

            </div>

            <div id="content">                         
                <div class="wrap">
                    
                    <div class="head">
                        <div class="info">
                            <h1>Minha Conta</h1>
                            <ul class="breadcrumb">
                                <li><a href="#">In&iacute;cio</a></li>
                                <li><a href="#">Administrativos</a></li>
                                <li class="active">Produtos</li>
                            </ul>
                        </div>
                        
                        <div class="search">
                            <form action="" method="post">
                                <input type="text" class="form-control" placeholder="search..."/>                                
                                <button type="submit"><span class="i-calendar"></span></button>
                                <button type="submit"><span class="i-magnifier"></span></button>
                            </form>
                        </div>                        
                    </div>                                                                    
                    
                    <div class="container">
                                                
                        <div class="row"> 
                            <div class="col-md-12">
<form name="formulario" action="" class="formulario" method="post" enctype="multipart/form-data">                            
    
                           
<div class="block">
<div class="head">                                        
<h2>Imagem Principal</h2>
<div class="side fr">

</div>
</div>        
<div class="content np">


<div class="col-md-8" style=" float:left; margin-left:10px; width:252px; <?php if(!empty($edit['fotopost'])) { echo 'height:146px';}else; ?>">
<p class="np nm"><strong></strong>
<?php if(!empty($edit['fotopost'])) { echo '
<span style=" font-size:10px;">(</span>
<input style=" font-size:11px; color:#C00;" type="checkbox" name="excluir1" id="checkbox" value="excluir">
<label style=" font-size:11px; color:#C00;" for="checkbox">Excluir </label>
<span style=" font-size:10px;">)</span> </p>
';}else; ?>
 <?php
if(!empty($edit['fotopost'])) { echo '<img src="http://elloraacessorios.com.br/inc/img?w=129&h=76&q=80&end=painel/dartweb/modulos/galeria/uploads/'.$edit['fotopost'].'" height="80" h/> </p>';} ?>
<input type="file" name="fotopost" />
</div> 


</div>
<div class="footer">
<div class="side fr">

</div>
</div>                                     
</div> 
                            
                            

                         
                            
                            
                            
                        
 
                        
                            
                            
                            
                            
                            
                            <div class="block"> <!-- ABRE BLOCO!-->
                             <div class="head">
                                        <h2>Informações</h2>

                            </div>






                                                                    
                                      

<div class="controls-row">
<div class="col-md-4">Usuario:</div>
<div class="col-md-8"><input type="text" class="form-control" name="usuario" value="<?php echo utf8_encode($edit['usuario']);?>"/></div>
</div> 



<div class="controls-row">
<div class="col-md-4">Nome:</div>
<div class="col-md-8"><input type="text" class="form-control" name="nome" value="<?php echo utf8_encode($edit['nome']);?>"/></div>
</div> 

<div class="controls-row">
<div class="col-md-4">Telefone:</div>
<div class="col-md-8"><input type="text" class="form-control" name="telefone" value="<?php echo utf8_encode($edit['telefone']);?>"/></div>
</div> 

<div class="controls-row">
<div class="col-md-4">Email:</div>
<div class="col-md-8"><input type="text" class="form-control" name="email" value="<?php echo utf8_encode($edit['email']);?>"/></div>
</div> 



<div class="controls-row">
<div class="col-md-4">Link de Cadastro:</div>
<div class="col-md-8"><input type="text" class="form-control" name="linkcadastro" value="<?php echo utf8_encode($edit['linkcadastro']);?>"/></div>
</div> 














                            </div> <!-- FECHA BLOCO!-->
                            




                            
                                <div class="block">
                                    <div class="head">                                        
                                        <h2></h2>
                                        <div class="side fr">
                                            
                                        </div>
                                    </div>                
                                    <div class="content np">
                                 

                                    </div> 
                                    <div class="footer">
                                        <div class="side fr">
                                            <div class="btn-group">                                                
                                                <button class="btn btn-primary" type="submit" name="cadastrar">Cadastrar </button>
                                                </form>
                                    </div>                                  
                                </div>
                                
                                
                                
                                
                                
                                
                            </div>
                           
                        </div>
                        
                    
            </div>
           
        </div> 
            </div> 
            
        </div>

    </div>
    
</body>
<?php
	ob_end_flush();
?>
</html>