                <ul style="margin-top:60px;" class="navigation">
                  <!-- INICIA MENU ADMINISTRAÇÃO !-->
                  <?php if($_SESSION['autUser']['nivel'] == '1'){ ?>
                    <li class="active">
                        <a href="<?php echo PAINEL; ?>modulos/configuracoes/editar">Configurações Gerais</a>
                    </li>
                  <?php }else; ?>  
                    <li class="active">
                        <a href="<?php echo LINK; ?>" target="_blank">Ver a Loja</a>
                    </li>
                     <li class="active">
                        <a href="<?php echo PAINEL; ?>modulos/usuarios/editar?id=<?php echo base64_encode($_SESSION['autUser']['id']); ?>">Ver/Editar meu perfil </a>
                    </li>
                    
                     <?php if($_SESSION['autUser']['nivel'] == '1'){ ?>
                     <li class="openable">
                        <a href="#">Usuarios</a>
                        <ul>
                            <li>
                                <a href="<?php echo PAINEL; ?>modulos/usuarios/listar">Gerenciar</a>
                            </li>            
                            <li>
                                <a href="<?php echo PAINEL; ?>modulos/usuarios/cadastrar">Cadastrar</a>
                            </li>                                       
                        </ul>
                    </li> 

                      <li class="openable">
                        <a href="#">Recrutadores</a>
                        <ul>
                            <li>
                                <a href="<?php echo PAINEL; ?>modulos/recrutadores/cadastrar">Cadastrar</a>
                            </li>            
                            <li>
                                <a href="<?php echo PAINEL; ?>modulos/recrutadores/listar">Gerenciar</a>
                            </li>            
                        </ul>
                    </li>   
          <!--           
                      <li class="openable">
                        <a href="#">Inscrições</a>
                        <ul>
                            <li>
                                <a href="<?php echo PAINEL; ?>modulos/inscricoes/listar">Gerenciar</a>
                            </li>            
                                   
                        </ul>
                    </li>                    
			
			

                 
                   <li class="openable">
                        <a href="#">Categorias de Banners</a>
                        <ul>
                            <li>
                                <a href="<?php echo PAINEL; ?>modulos/categorias-banners/listar">Gerenciar</a>
                            </li>            
                            <li>
                                <a href="<?php echo PAINEL; ?>modulos/categorias-banners/cadastrar">Cadastrar</a>
                            </li>                                       
                        </ul>
                    </li> 
                   <li class="openable">
                        <a href="#">Banners</a>
                        <ul>
                            <li>
                                <a href="<?php echo PAINEL; ?>modulos/banners/listar">Gerenciar</a>
                            </li>            
                            <li>
                                <a href="<?php echo PAINEL; ?>modulos/banners/cadastrar">Cadastrar</a>
                            </li>                                       
                        </ul>
                    </li> 
                    



<li class="openable">
<a href="#">Categorias de Menus</a>
<ul>
<li>
<a href="<?php echo PAINEL; ?>modulos/categorias-menus/listar">Gerenciar</a>
</li>            
<li>
<a href="<?php echo PAINEL; ?>modulos/categorias-menus/cadastrar">Cadastrar</a>
</li>                                       
</ul>
</li> 

<li class="openable">
<a href="#">Menus</a>
<ul>
<li>
<a href="<?php echo PAINEL; ?>modulos/menus/listar">Gerenciar</a>
</li>            
<li>
<a href="<?php echo PAINEL; ?>modulos/menus/cadastrar">Cadastrar</a>
</li>                                       
</ul>
</li> 


<li class="openable">
<a href="#">Marcas</a>
<ul>
<li>
<a href="<?php echo PAINEL; ?>modulos/marcas/listar">Gerenciar</a>
</li>            
<li>
<a href="<?php echo PAINEL; ?>modulos/marcas/cadastrar">Cadastrar</a>
</li>                                       
</ul>
</li> 


<li class="openable">
<a href="#">Produtos</a>
<ul>
<li>
<a href="<?php echo PAINEL; ?>modulos/produtos/listar">Gerenciar</a>
</li>            
<li>
<a href="<?php echo PAINEL; ?>modulos/produtos/cadastrar">Cadastrar</a>
</li>                                       
</ul>
</li> 
<?php }else; ?>  
<li class="openable">
<a href="#">Pedidos e Compras</a>
<ul>
<li>
<a href="<?php echo PAINEL; ?>modulos/financeiro/listar">Gerenciar</a>
</li>            
                                  
</ul>
</li> 
!-->
<?php if($_SESSION['autUser']['nivel'] == '1'){ ?>
                    
        <!--               
<li class="openable">
<a href="#">Cupom de Desconto</a>
<ul>
<li>
<a href="<?php echo PAINEL; ?>modulos/cupom/listar">Gerenciar</a>
</li>            
<li>
<a href="<?php echo PAINEL; ?>modulos/cupom/cadastrar">Cadastrar</a>
</li>                                       
</ul>
</li>    

<li class="openable">
<a href="#">Newsletters</a>
<ul>
<li>
<a href="<?php echo PAINEL; ?>modulos/newsletter/listar?v=emailorganico">Lista de emails organica</a>
</li>            
<li>
<a href="<?php echo PAINEL; ?>modulos/newsletter/listar?v=emailcliente">Lista de emails clientes</a>
</li>    
<li>
<a href="<?php echo PAINEL; ?>modulos/newsletter/listar?v=celularcliente">Lista de celulares clientes</a>
</li>                                       
</ul>
</li>                
					

                    
<li class="openable">
<a href="#">Sobre a Loja</a>
<ul>
<li>
<a href="<?php echo PAINEL; ?>modulos/sobre/editar?id=1">Editar</a>
</li>                                              
</ul>
</li>                     
                                      
          -->            
<li>
<a href="<?php echo PAINEL; ?>modulos/google/AuthUser">Controle de Visitas</a>
</li> 		
<?php }else; ?>  		
                  <!-- FINALIZA MENU ADMINISTRAÇÃO "-->  
                     
                </ul>