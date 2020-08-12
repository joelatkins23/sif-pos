<?php 
ob_start();
session_start();
	require_once('../../../../config/config.php');
	require_once('../../../../config/crud.php');
	require_once('../../../../config/funcoes.php');	
	$modulo = basename(getcwd());
	$modulonome = ucfirst($modulo);
	

	
/* FUNÇÃO QUE LÊ O QUE JA EXISTE E EXIBE PARA ATUALIZA */
		$categoriaEdit = $_GET['id'];
		$readCatEdit = read('tec_sales',"WHERE id = '$categoriaEdit'");
		if(!$readCatEdit){
	                     echo 'Atualizado';	
		}foreach($readCatEdit as $edit);		
?>
<!-- INICIA CADASTRO  !--> 

	<?php 
		if(isset($_POST['atualizar'])){
			$cad['pacotenome']       	   = utf8_decode($_POST['pacotenome']);
			$cad['fdataentrada']           = utf8_decode($_POST['fdataentrada']);
			$cad['fdatasaida']             = utf8_decode($_POST['fdatasaida']);
			$cad['fadultos']               = utf8_decode($_POST['fadultos']);
			$cad['fcriancas']              = utf8_decode($_POST['fcriancas']);
			$cad['fimposto']               = utf8_decode($_POST['fimposto']);
			$cad['fcomissao']              = utf8_decode($_POST['fcomissao']);
			$cad['ftaxapagseguro']         = utf8_decode($_POST['ftaxapagseguro']);
			$cad['fvendedor']              = utf8_decode($_POST['fvendedor']);
			$cad['pagseguro']              = utf8_decode($_POST['pagseguro']);
			$cad['pagseguroURL']           = $_POST['pagseguroURL'];



			
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


				update('tec_sales',$cad,"id = '$categoriaEdit'");
				
/* INICIA FUNÇÃO PARA UPLOAD */

	if(isset($_POST['atualizar'])){
		
		//INFO IMAGEM
		$file 		= $_FILES['img'];
		$numFile	= count(array_filter($file['name']));
		
		//PASTA
		$folder		= 'uploads/';
		
		//REQUISITOS
		$permite 	= array('image/jpeg', 'image/png');
		$maxSize	= 1024 * 1024 * 5;
		
		//MENSAGENS
		$msg		= array();
		$errorMsg	= array(
			1 => 'O arquivo no upload é maior do que o limite definido em upload_max_filesize no php.ini.',
			2 => 'O arquivo ultrapassa o limite de tamanho em MAX_FILE_SIZE que foi especificado no formulário HTML',
			3 => 'o upload do arquivo foi feito parcialmente',
			4 => 'Não foi feito o upload do arquivo'
		);
		
		if($numFile <= 0)
			echo 'Selecione uma Imagem!';
		else{
			for($i = 0; $i < $numFile; $i++){
				$name 	= $file['name'][$i];
				$type	= $file['type'][$i];
				$size	= $file['size'][$i];
				$error	= $file['error'][$i];
				$tmp	= $file['tmp_name'][$i];
				
				$extensao = @end(explode('.', $name));
				$novoNome = rand().".$extensao";
				
				if($error != 0)
					$msg[] = "<b>$name :</b> ".$errorMsg[$error];
				else if(!in_array($type, $permite))
					$msg[] = "<b>$name :</b> Erro imagem não suportada!";
				else if($size > $maxSize)
					$msg[] = "<b>$name :</b> Erro imagem ultrapassa o limite de 5MB";
				else{
					
					if(move_uploaded_file($tmp, $folder.'/'.$novoNome)){
			
						$msg[] = "<b>$name :</b> Upload Realizado com Sucesso!";
						$cad2['fotopost']            = $novoNome;
						$cad2['destino_galeria']     = $categoriaEdit;
						$cad2['destino_usuario']     = $_GET['Du'];
						$cad2['datacad']             = date('d-m-Y H:i:s');
						create('imagens',$cad2);
					}else{
						$msg[] = "<b>$name :</b> Desculpe! Ocorreu um erro...";
						}
						
				
				}
				
				foreach($msg as $pop)
					echo $pop.'<br>';
			}
		}
	}

/* FINALIZA FUNÇÃO PARA UPLOAD */				
				
				
				
				
$_SESSION['cadastro'] =
 '
<div class="alert alert-success">            
<strong>Pronto!</strong> dados editados com sucesso!
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
    <title>Administração - <?php echo SITENOME; ?> - Editar <?php echo $modulonome; ?> <?php echo'#'.$categoriaEdit; ?></title>
    <link rel="icon" type="image/ico" href="../../favicon.ico"/>
    
    <link href="../../css/stylesheets.css" rel="stylesheet" type="text/css" />
    

</head>
<body>    
    


                            
                            
<form name="formulario" action="" class="formulario" method="post" enctype="multipart/form-data">                            
    
  


<div class="col-md-4"></div>
<div class="col-md-8">
<a href="<?=$edit['pagseguroURL']; ?>"><img src="http://d1ay90kuittjt7.cloudfront.net/wp-content/uploads/2013/07/pagar-agora.png"  title="Clique aqui para pagar via PagSeguro" width="322" height="86"   alt="Pagar Agora"/></a>
</div>
<br /> <br /> <br /> 
<div class="col-md-4"></div>
<div class="col-md-8">
<a href="<?=$edit['pagseguroURL']; ?>"><img src="http://www.hypekids.com.br/media/wysiwyg/pagseguro.gif"  title="Clique aqui para pagar via PagSeguro" width="222"   alt="Pagar Agora"/></a>
</div>












                                    <div class="footer">
                                        <div class="side fr">
                                            <div class="btn-group">                                                
                                           
                                                </form>
                                            </div>
                                        </div>
                                    </div>                                     

    
</body>
<?php
	ob_end_flush();
?>
</html>