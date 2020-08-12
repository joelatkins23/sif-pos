<?php
ob_start();
session_start();
	require_once('../../../../config/config.php');
	require_once('../../../../config/crud.php');
	require_once('../../../../config/funcoes.php');	
	$modulo = basename(getcwd());
	$modulonome = ucfirst($modulo);
	
	if(!$_SESSION['autUser']){
		header('Location: http://www.dartweb.com.br/painel');
		}
		
/*DELETA USUÁRIOS*/
		$meuid = $_SESSION['autUser']['nome'];
		if(!empty($_GET['deletaID'])){
			$deletaId = $_GET['deletaID'];	
			$deletaUsuarios = read('recrutadores',"WHERE cod = '$deletaId'");
			if(!$deletaUsuarios){
				echo '<div class="msgError">Desculpe, o usuário não existe!</div>'.'<br>';
			}else{
				foreach($deletaUsuarios as $deletaUser){
					if($deletaUser['id'] == $meuid){
						echo '<div class="msgError">Você não pode deletar o seu perfil</div>'.'<br>';	
					}else{
						$deletaAvatar = read('recrutadores',"WHERE cod = '$deletaId'");
						}delete('recrutadores',"cod = '$deletaId'");
$_SESSION['cadastro'] =
 '
<div class="alert alert-danger">            
<strong>Certo!</strong> Já deletamos
<button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
';
				header('Location: listar');
					
				}	
			}
		}
			
?>

<!DOCTYPE html>
<html lang="en">
<head>        
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />    
    <!--[if gt IE 8]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />        
    <![endif]-->                
    <title>Administração - <?php echo SITENOME; ?> - Gerenciar <?php echo $modulonome; ?></title>
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
    
    <script type='text/javascript' src='../../js/datatables/jquery.dataTables.min.js'></script>
    <script type='text/javascript' src='../../js/scrollup/jquery.scrollUp.min.js'></script>

    <script type='text/javascript' src='../../js/plugins.js'></script>    
    <script type='text/javascript' src='../../js/actions.js'></script>
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
                            <h1>Painel DARTWEB</h1>
                            <ul class="breadcrumb">
                                <li><a href="#">In&iacute;cio</a></li>
                                <li><a href="#">Administrativos</a></li>
                                <li class="active"><?php echo $modulonome; ?></li>
                            </ul>
                        </div>
                        
                 
                    </div>                                                                    
                    
                    <div class="container">
                        
                        <div class="row">
                            <div class="col-md-12"></div>
                        </div>
                        <div class="row">
<?php
if(!empty($_SESSION['cadastro'])){
echo $_SESSION['cadastro'];
unset($_SESSION['cadastro']);  }else;
?>
<div class="col-md-12">
                                
                                <div class="block">
                                    <div class="head">
                                        <h2>Gerenciar <?php echo $modulonome; ?></h2>
                                        <ul class="buttons">
                                            <li><a href="#" class="block_loading"><span class="i-cycle"></span></a></li>
                                            <li><a href="#" class="block_toggle"><span class="i-arrow-down-3"></span></a></li>
                                            <li><a href="#" class="block_remove"><span class="i-cancel-2"></span></a></li>
                                        </ul>                                        
                                    </div>
                                    <div class="content np table-sorting">
                                        
                                        <table cellpadding="0" cellspacing="0" width="100%" class="sortc">
                                            <thead>
                                                <tr>
                                                    <th width="3%">Cod</th> 
                                                    <th width="44%">Link</th>
                                                    <th width="10%">Nome</th>    
                                                    <th width="2%">Telefone</th>    
                                                    <th width="10%">Cadastro</th> 
                                                    <th width="10%"></th> 
                                                    
                                    
                                                </tr>
                                            </thead>
                                            <tbody>
<?php   
		$leitura = read('recrutadores',"WHERE cod");      
		if($leitura) {
        foreach($leitura as $mostra):
		echo '<tr>';	
		echo '<td>'.$mostra['cod'].'</td>';	
		echo '<td>http://www.equipeg12.com.br/'.$mostra['usuario'].'</td>';	
		echo '<td>'.utf8_encode($mostra['nome']).'</td>';	
		echo '<td>'.utf8_encode($mostra['telefone']).'</td>';
		echo '<td>'.utf8_encode($mostra['linkcadastro']).'</td>';
		echo '<td>';
		//echo '<a href="editar?id='.$mostra['cod'].'" title="Editar"><button class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></button></a>';
		echo '<a href="?deletaID='.$mostra['cod'].'" title="Deletar?"><button class="btn btn-danger"><span class="glyphicon glyphicon-remove glyphicon glyphicon-white"></span></button></a>';
		echo '</td>';		
		echo '</tr>';			
	    endforeach;
		}else{
			echo'Não temos cadastro ainda!';
			}
?>                              
                                            </tbody>
                                        </table>                                        
                                        
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