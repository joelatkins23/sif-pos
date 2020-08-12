<?php
 error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED); 
     $_SG ['conServer']     = true; // Conectar servidor
	 $_SG ['abreSessao']    = true; // Abre a sessao
	 $_SG ['caseSensitive'] = false; // T diferente de t
	 $_SG ['validarSempre'] = true; // Pedir sempre Pass quando recarregar pagina
     $_SG ['server']   = 'localhost';
	 $_SG ['user']     = 'root';
	 $_SG ['password'] = '';
	 $_SG ['db']       = 'pdv';
     $_SG ['paginaLogin'] = 'login.php';
	 $_SG ['tabela'] = 'tb_user';

	 if ($_SG['conServer'] == true) {$_SG['link'] = mysql_connect($_SG['server'], $_SG['user'], $_SG['password']) or die ("MySQL: Nao Foi Possivel Conectar ao Sevidor [".$_SG['server']."].");
mysql_select_db ($_SG['db'],$_SG['link']) or die ("MySQL: Nao Foi Possivel Conectar a Base de Dados [".$_SG['db']."]");

	
 
}

?>
