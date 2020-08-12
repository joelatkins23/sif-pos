<?php 
	
//FUNÇÃO PARA CADASTRO NO BANCO DE DADOS: CREATE
	function create($tabela, array $dados){
		$campos = implode(", ",array_keys($dados));
		$values = "'".implode("','", array_values($dados))."'";
		$createQR = "INSERT INTO {$tabela} ($campos) VALUES ($values)";
		$exQuery  = mysql_query($createQR) or die (mysql_error());
		
		if($exQuery){
			return true;	
		}
	}
	
//FUNÇÃO PARA LEITURA NO BANCO DE DADOS: READ
	function read($tabela, $cond = NULL){
		$readQR = "SELECT * FROM {$tabela} {$cond}";
		$execQR = mysql_query($readQR) or die (mysql_error());
		$camposQR = mysql_num_fields($execQR);
		for($y = 0; $y < $camposQR; $y++){
			$names[$y]= mysql_field_name($execQR,$y);
		}for($x = 0; $resultado = mysql_fetch_assoc($execQR); $x++){
			for($i = 0; $i < $camposQR; $i++){
				$res[$x][$names[$i]] = $resultado[$names[$i]];
			}	
		}
		return $res;
}

//FUNÇÃO PARA ATUALIZAR NO BANCO DE DADOS: UPDATE

	function update($tabela, array $campos, $where){
		foreach($campos as $keys => $valor)	{
			$dados[] = "$keys = '$valor'";	
		}
		
		$dados = implode(", ",$dados);
		$updateQR = "UPDATE {$tabela} SET $dados WHERE {$where}";
		$exeQR    = mysql_query($updateQR) or die (mysql_error()); 
		
		if($exeQR){
			return true;
		}
	}
	
//FUNÇÃO PARA DELETAR NO BANCO DE DADOS: DELETE

	function delete($tabela, $where){
		$deleteQR = "DELETE FROM {$tabela} WHERE {$where}";
		$deleteEX = mysql_query($deleteQR) or die (mysql_error());
	}

























?>