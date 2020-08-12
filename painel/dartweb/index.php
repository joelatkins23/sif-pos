<?php
ob_start();
session_start();
	require_once('../../config/config.php');
	require_once('../../config/crud.php');
	require_once('../../config/funcoes.php');	
	
	if(!$_SESSION['autUser']){
		header('Location: '.PAINELLOGIN);
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
    <title>Administração - <?php echo SITENOME; ?> - Painel</title>
    <link rel="icon" type="image/ico" href="favicon.ico"/>
    
    <link href="css/stylesheets.css" rel="stylesheet" type="text/css" />        
    
    <!--[if lte IE 7]>        
        <script type='text/javascript' src='js/other/lte-ie7.js'></script>
    <![endif]-->    
    
    <script type='text/javascript' src='js/jquery/jquery.min.js'></script>
    <script type='text/javascript' src='js/jquery/jquery-ui-1.10.3.custom.min.js'></script>
    <script type='text/javascript' src='js/jquery/jquery-migrate.min.js'></script>
    <script type='text/javascript' src='js/jquery/globalize.js'></script>
    
    <script type='text/javascript' src='js/bootstrap/bootstrap.min.js'></script>
    <script type='text/javascript' src='js/cookies/jquery.cookies.2.2.0.min.js'></script>
    
    <script type='text/javascript' src='js/mcustomscrollbar/jquery.mCustomScrollbar.concat.min.js'></script>
    <script type='text/javascript' src='js/charts/excanvas.min.js'></script>    
    <script type='text/javascript' src='js/charts/jquery.flot.js'></script>    
    <script type='text/javascript' src='js/charts/jquery.flot.stack.js'></script>    
    <script type='text/javascript' src='js/charts/jquery.flot.pie.js'></script>
    <script type='text/javascript' src='js/charts/jquery.flot.resize.js'></script>    
    
    <script type='text/javascript' src='js/morris/raphael-min.js'></script>
    <script type='text/javascript' src='js/morris/morris.min.js'></script>    
    
    <script type='text/javascript' src='js/sparklines/jquery.sparkline.min.js'></script>    

    <script type='text/javascript' src='js/scrollup/jquery.scrollUp.min.js'></script>
    
    <script type='text/javascript' src='js/plugins.js'></script>    
    <script type='text/javascript' src='js/actions.js'></script>
    <script type='text/javascript' src='js/charts.js'></script>    
</head>
<body>    
    
    <div id="wrapper">
        
        <div id="header">
            
            <div class="wrap">
                
                <a href="<?php echo PAINEL; ?>index.php" class="logo"></a>
                
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
                                <li><a href="<?php echo PAINELLOGIN ?>/logoff.php"><span class="i-locked"></span> Trancar</a></li>
                                <li><a href="<?php echo PAINELLOGIN ?>/logoff.php"><span class="i-forward"></span> Sair</a></li>
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
echo '<img width="50" height="50" src="'.PAINEL.'/img/examples/users/dmitry_m.jpg"/>';
}
?>
                    </div>
                    <div class="info">
                        <div class="name">
                            <a href="#"><?php echo $_SESSION['autUser']['nome']; ?></a>
                        </div>
                        <div class="buttons">
                            
                            <a href="#"><span class="i-chat"></span> Mensagens</a>
                            <a href="<?php echo PAINELLOGIN ?>/logoff.php" class="fr"><span class="i-forward"></span> Sair</a>

                        </div>
                    </div>
                </div>

  <?php include("inc/menu.php"); ?>

            </div>

            <div id="content">                        
                <div class="wrap">
                    
                    <div class="head">
                        <div class="info"> <br />
                            <h1>Bem vindo(a) ao painel de controle </h1>
                            <ul class="breadcrumb">
                                <li><a href="#"><?php echo SITENOME; ?> | <?php echo LINKSEMHTTP; ?> </a></li>
                            </ul>
                        </div>
                        
                                                               
                    
                    <div class="container">
                        
<div class="row">
<div class="col-md-12">

                   
           
         <?php if($_SESSION['autUser']['nivel'] == '1'){ ?>
         
         
 <div class="block">
<div class="head">
<h2>Suporte</h2>                                        
<ul class="buttons">
<li><a href="#" class="block_loading"><span class="i-cycle"></span></a></li>
<li><a href="#" class="block_toggle"><span class="i-arrow-down-3"></span></a></li>
<li><a href="#" class="block_remove"><span class="i-cancel-2"></span></a></li>
</ul>                                        
<div class="side fr">
<span class="label label-success">+2</span>
</div>                                        
</div>
<div class="content messages npr"> <span style=" background-color:#4c6e93; color:#FFF; font-size:11px; padding-left:10px; padding-right:10px;text-align:center; padding-top:2px; padding-bottom:2px;">Consulte se você tem novas mensagens </span>
<div class="scroll" style="height: 250px;">

<?php 
DEFINE('SERVIDORSUPORTE', MAILHOST); 
DEFINE('PORTASUPORTE', MAILPORT);
DEFINE('USUARIOSUPORTE', SUPORTEMAILUSER);
DEFINE('SENHASUPORTE', MAILPASS);
$mail_box = imap_open("{" . SERVIDORSUPORTE . ":" . PORTASUPORTE . "/pop3/novalidate-cert}INBOX", USUARIOSUPORTE, SENHASUPORTE);
if ($mail_box) {
$total_de_mensagens = imap_num_msg($mail_box);
if ($total_de_mensagens > 0) {
for ($mensagem = 1; $mensagem <= $total_de_mensagens; $mensagem++) {
$body_1 = ( imap_fetchbody($mail_box, $mensagem, 1) );
echo '
<div class="item">
<div class="info">
<a href="#" class="name"></a> <span class="muted"></span>
<div class="text">
'.$body_1.'
</div>
</div>
<hr />

';
            
          
           

        }
    }
    imap_close($mail_box);
}

?>







</div>
</div>
<form name="enviar" method="post" action="modulos/suporte/enviarMsg.php">
<div class="footer">
<div class="side npb">
<textarea name="msg" class="form-control" placeholder="Digite sua mensagem para abrir uma chamado..."></textarea>                                                                                       
</div>
<div id="umsg"> </div>
<div class="side fr npt">
<input type="hidden" name="userMail" value="<?php echo $_SESSION['autUser']['nome']; ?>">
<input type="hidden" name="userEndEmail" value="<?php echo SUPORTEMAILUSER; ?>">
<input type="hidden" name="userPainelEmail" value="<?php echo PAINEL; ?>">
<input type="hidden" name="userPainelNomeEmail" value="<?php echo SITENOME; ?>">
<input type="hidden" name="userPainelFotoPostEmail" value="<?php echo PAINEL.'/php/uploads/usuarios/'.$fotoDoUser; ?>">
<button class="btn btn-primary">Enviar</button>  
</form>                                       
</div>
</div>
</div>        
                             
                        
                        
                     <?php }else; ?>   
                        
                        
                        
               
            
        </div>
      </div>
    </div>
    
</body>
<?php
	ob_end_flush();
?>
</html>