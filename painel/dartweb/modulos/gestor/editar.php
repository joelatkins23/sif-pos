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
				header('Location: feito.php');
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
    
  


<div class="col-md-4">Nome do Pacote:</div>
<div class="col-md-8"><input type="text" class="form-control" name="pacotenome" value="<?php echo utf8_encode($edit['pacotenome']);?>"/></div>



<div class="col-md-4">Data de Entrada:</div>
<div class="col-md-8"><input type="text" class="form-control" name="fdataentrada" value="<?php echo utf8_encode($edit['fdataentrada']);?>"/></div>


<div class="col-md-4">Data de Saida:</div>
<div class="col-md-8"><input type="text" class="form-control" name="fdatasaida" value="<?php echo utf8_encode($edit['fdatasaida']);?>"/></div>



<div class="col-md-4">Nº de Adultos:</div>
<div class="col-md-8"><input type="text" class="form-control" name="fadultos" value="<?php echo utf8_encode($edit['fadultos']);?>"/></div>



<div class="col-md-4">Nº de Crianças:</div>
<div class="col-md-8"><input type="text" class="form-control" name="fcriancas" value="<?php echo utf8_encode($edit['fcriancas']);?>"/></div>



<div class="col-md-4">Imposto da Prefeitura (4%):</div>
<div class="col-md-8"><input type="text" class="form-control" name="fimposto" value="<?php echo utf8_encode($edit['fimposto']);?>"/></div>



<div class="col-md-4">Comissão da Agência:</div>
<div class="col-md-8"><input type="text" class="form-control" name="fcomissao" value="<?php echo utf8_encode($edit['fcomissao']);?>"/></div>



<div class="col-md-4">Taxa PagSEguro:</div>
<div class="col-md-8"><input type="text" class="form-control" name="ftaxapagseguro" value="<?php echo utf8_encode($edit['ftaxapagseguro']);?>"/></div>



<div class="col-md-4">Vendedor:</div>
<div class="col-md-8"><input type="text" class="form-control" name="fvendedor" value="<?php echo utf8_encode($edit['fvendedor']);?>"/></div>




<div class="col-md-4">Mostrar Botão PagSeguro:</div>
<div class="col-md-8">
<?php if($edit['pagseguro'] == 'sim'){
echo '<input type="checkbox" name="pagseguro" value="sim" checked="checked">';
}elseif($edit['pagseguro'] == ''){
echo '<input type="checkbox" name="pagseguro" value="sim">';
}else;


$linkPag = "https://pagseguro.uol.com.br/v2/checkout/payment.html?receiverEmail=turismoemnobres@hotmail.com&senderName=".$edit['customer_name']."&senderEmail=".$senderEmail."&currency=BRL&itemId1=".$edit['id']."&itemDescription1=Pedido: ".$edit['id']."&itemAmount1=".$edit['paid']."&senderAreaCode=".$_POST['ddd']."&senderPhone=".$_POST['celular']."&senderCPF=".$cpfIdentificado1000."&itemQuantity1=1&reference=".$id_pedido."&shippingAddressStreet=".$_POST['endereco']."&shippingAddressNumber=".$_POST['numero']."&shippingAddressComplement=".$_POST['complemento']."&shippingAddressDistrict=".$_POST['bairro']."&shippingAddressPostalCode=".$_POST['cep']."&shippingAddressCity=".$cidadeIdentificado1000."&shippingAddressState=".$estadoSiglaIdentificado1000."&itemShippingCost1=".trim($_SESSION['totalFrete'])."&shippingAddressCountry=BRA";

?>

</div>

<input type="hidden" name="pagseguroURL" value="<?php echo $linkPag; ?>">











                                    <div class="footer">
                                        <div class="side fr">
                                            <div class="btn-group">                                                
                                                <button class="btn btn-primary" type="submit" name="atualizar">Atualizar </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>                                     

    
</body>
<?php
	ob_end_flush();
?>
</html>