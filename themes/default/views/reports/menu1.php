
<div id="wrapper"><nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Navegar</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar">
                 
                    </span>
                </button>
                <a class="navbar-brand" href="index.php">SIF ON</a>
                <?php 
$mes = date ("m");
$data = date ("Y-m-d");
$hora = date ("H:i:s");

$data1    = implode('-',array_reverse(explode('/',$data)));


?>
            </div>
            <div style="color: white;
padding: 15px 50px 5px 50px;
float: right;
font-size: 16px;"> Online <?php echo $data ?> &nbsp; <a href="sair.php" class="btn btn-danger square-btn-adjust">Logout<i class="online"></i></a> </div>
            
  <div   style="color: white;
padding: 15px 50px 23px 50px;
float: left;
font-size: 16px;">Desenvolvido pela <a href="http://www.mactsystem.info" target="_blank">Mactsystem</a> -    Licenciado ao :
  <?php $sql = mysql_query("SELECT * FROM tb_parametros ")
 
   or die(mysql_error());
   $contar_vendas = mysql_num_rows( $sql );
   $i = 0;
   while($resultado_clientes = mysql_fetch_array($sql)){
	  echo $linha1    =$resultado_clientes ['linha2'];
	
	  }
	  ?>  &nbsp;  </div>
        </nav> 
<nav class="navbar-default navbar-side">
            <div class="sidebar-collapse">
             
                    <div class="media">
                        <a class="pull-left has-notif avatar" >
                            
                            <i class="online"></i>
                        </a>
                      
                </div>
                   
                        
              
            </ul>
                <ul class="nav" id="main-menu">
				
                    <img src="dist/img/<?php echo $user_logado ?>.jpg" alt="User Image" width="101" height="100" class="img-circle">
                  <li> <a href="index3.php" class="active-menu"><i class="fa fa-fw fa-dashboard fa-2x"></i> Dashboard</a> </li>
                  <div class="media1">
                      <h4 class=""><span class="label"><?php echo $nome_logado ?></span></h4>
                  </div>
                  <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-user fa-2x"></i> Cadastros <i class="fa fa-fw fa-caret-down"></i></a>
                       <ul id="#demo" class="nav nav-second-level">
                             <li>
                                <a href="lista_clientes.php">Clientes</a>
                            </li>
                           
                     <li>
                                <a href="lista_produtos.php">Produtos</a>
                    </li>
                    
                    
                    
                    
                    <li>
                                <a href="lista_user.php">Utilizadores</a>
                    </li>
                    </ul>
                  </li>
                  <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#demo1"><i class="fa fa-fw fa-money fa-2x"></i> Gestão Financeira<i class="fa fa-fw fa-caret-down "></i></a>
                      <ul id="#demo1" class="nav nav-second-level">
                            
                            <li>
                              <?php   
		     
        if ($nivel_logado >=10)  {   
        echo  ' <a href="lista_saidas_caixa.php">Saida de Caixa</a>'; }
        else { echo '';
		}
?>  
                            </li>
                           
                          
                            
                            
                    </ul>
                  </li>
                  <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#pagamento"><i class="fa fa-fw fa-random fa-2x"></i> Gestão de Stock<i class="fa fa-fw fa-caret-down"></i></a>
                       <ul id="#pagamento" class="nav nav-second-level">
                             <li>
                            <a href="select_existencia.php" target="_blanck">Existencias</a>
                            </li>
                             <li>
                            <a href="lista_compras.php" target="_blanck">Compras</a>
                            </li>
                             <li>
                            <a href="lista_trans.php" target="_blanck">Tranferencia de Armazem</a>
                            </li>
                          
                          
                          
                           
                            
                    </ul>
                  </li>
                   
                  <li><a href="javascript:;" data-toggle="collapse" data-target="#listagens"><i class="glyphicon glyphicon-log-in fa-2x"></i>  Gestão de Vendas<i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="#listagens" class="nav nav-second-level">
                    <li>
                     <?php   
		     
        if ($nivel_logado >=10)  {   
        echo  '  <a href="add_faturas.php"target="_blank">Facturas</a>'; }
        else { echo '';
		}
?>             
                      </li> 
                      
                     
                            
                            <li>
                                <a href="index.php/pos/" target="_blank">Vendas POS </a>
                            </li>
                           
                          
                            <li>
                                <a href="add_proformas.php" target="_blank">Pro-Formas</a>
                            </li>
                              
                             <li>
                             <?php   
		     
        if ($nivel_logado >=10)  {   
        echo  ' <a href="add_recibos.php" target="_blank">Recibos</a>'; }
        else { echo '';
		}
?>          
                            </li>
                            <li>
                               <?php   
		     
        if ($nivel_logado >=10)  {   
        echo  ' <a href="select_movimentos.php">Listagem de Movimentos</a>'; }
        else { echo '';
		}
?>  
                            </li>
                           
                            
                    </ul>
                  </li>
                  <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#listagens"><i class="fa fa-fw fa-list-alt fa-2x"></i> Listagens<i class="fa fa-fw fa-caret-down"></i></a>
                       <ul id="#listagens" class="nav nav-second-level">
                           
                            
                           
                           
                            <li>
                                <a href="select_faturas.php">Facturas</a>
                            </li>
                           
                             
                            <li>
                                <a href="select_resumo.php">Listagens POS Resumo</a>
                            </li>
                             <li>
                                <a href="select_pos1.php">Lista Vendas/Produtos</a>
                            </li>
                            
                            <li>
                                <a href="select_proformas.php">Pro-Forma</a>
                            </li>
                            <li>
                                <a href="select_recibo.php">Recibos</a>
                            </li>
                            <li>
                                <a href="select_extrato.php">Extracto Clientes</a>
                            </li>
                             <li>
                                <a href="select_calculo.php">Falha de Calculos</a>
                            </li>
                           
                            
                        
                            
                            
                    </ul>
                  </li>
                    <li>
                      <a href="javascript:;" data-toggle="collapse" data-target="#estatisticas"><i class="fa fa-fw fa-dashboard fa-2x"></i> Estatísticas<i class="fa fa-fw fa-caret-down"></i></a>
                       <ul id="#estatisticas" class="nav nav-second-level">
                       <li>
                                <a href="select_margem.php">Margem de Vendas</a>
                            </li>
                           
                         
                            
                            
                      </ul>
                   </li>
                  <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#parametros"><i class="fa fa-fw fa-cogs fa-2x"></i> Parámetros<i class="fa fa-fw fa-caret-down"></i></a> 
                  
                  <ul id="#parametros" class="nav nav-second-level">
                            
                        <li>
                                <a href="select_elimina.php">Manuntenção de Vendas</a>
                            </li>  
                             
                                <li>
                             <?php   
		     
        if ($nivel_logado >=999)  {   
        echo  ' <a href="editar_empresa.php" target="_blank">Editar Empresa</a>'; }
        else { echo '';
		}
?>          
                            </li>  
                       
                            
                    </ul>
              </ul>
               
  </div>
            
</nav> 
