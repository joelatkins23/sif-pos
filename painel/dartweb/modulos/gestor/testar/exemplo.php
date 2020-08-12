<?php

  

  //URL onde o arquivo PHP vai ficar

  $url_galeria = "http://www.claudianet.com.br/painel/dartweb/modulos/galeria/testar/exemplo.php";


 //URL onde o arquivo PHP vai ficar

  $pasta_fotos = "uploads";

  

  //Início da função

  

  $fotos = array();

  

  //Loop que percorre a pasta das imagens e armazena o nome de todos os arquivos

  foreach(glob($pasta_fotos . '/{*_p.jpg,*_p.gif}', GLOB_BRACE) as $image) { 

  

  $fotos[] = $image;

  

  }

  

  //Verifica se deve exibir a lista ou uma foto

  if ($_GET["image"] == "") {

  

  //Faz o loop pelo folder de imagens

  for($i=0; $i < count($fotos); $i++) { 

  

  //Cria cada uma das thumbs dentro de uma <div> com link para a imagem grande

  echo "<div class='thumb'>";

  echo "<a href='" . $url_galeria . "?image=" . $i . "'>";

  echo "<img src='" . $fotos[$i] . "'>";

  echo "</a>";

  echo "</div>";

  

  }


 } else {

  

  //Guarda o nome da imagem para montar o link da imagem grande

  $foto_g = explode("_p", $fotos[$_GET["image"]]);

  

  //Configura os links de próxima e anterior

  if ( $_GET["image"] == 0 ) { $anterior = ""; } else { $anterior = $_GET["image"] - 1; }

  if ( $_GET["image"] == count($fotos)-1 ) { $proxima = ""; } else { $proxima = $_GET["image"] + 1; }

  

  //Quando solicitada uma imagem em particular, monta a <div> e insere a imagem grande de acordo com o link

  echo "<div>";

  echo "<a href='" . $url_galeria . "?image=" . $proxima . "'>";

  echo "<img src='" . $foto_g[0] . "_g" . $foto_g[1] . "'>";

  echo "</a>";

  echo "<p><a href='" . $url_galeria . "?image=" . $anterior . "'>Foto anterior</a> | <a href='" . $url_galeria . "'>Voltar para a galeria</a> | <a href='" . $url_galeria . "?image=" . $proxima . "'>Próxima foto</a></p>";

  echo "</div>";

  

  }


?>