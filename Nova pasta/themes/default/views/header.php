<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo  $page_title.' | '.$Settings->site_name; ?></title>
    <link rel="shortcut icon" href="<?php echo  $assets ?>images/icon.png"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="<?php echo  $assets ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo  $assets ?>plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo  $assets ?>plugins/iCheck/square/green.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo  $assets ?>plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo  $assets ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo  $assets ?>plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo  $assets ?>plugins/redactor/redactor.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo  $assets ?>dist/css/jquery-ui.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo  $assets ?>dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo  $assets ?>dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo  $assets ?>dist/css/custom.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo  $assets ?>plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
</head>
<body class="skin-green fixed sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <a href="<?php echo  site_url(); ?>" class="logo">
            <span class="logo-mini">SIF POS</span>
            <span class="logo-lg"><?php echo  $Settings->site_name == 'PDV' ? '<b>PDV</b>' : '<img src="'.base_url('uploads/'.$Settings->logo).'" alt="'.$Settings->site_name.'" width=200 height=45 />'; ?></span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Navegação</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <ul class="nav navbar-nav pull-left">
                <li class="dropdown hidden-xs">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="<?php echo  $assets; ?>images/<?php echo  $Settings->language; ?>.png" alt="<?php echo  $Settings->language; ?>"></a>
                    <ul class="dropdown-menu">
                        <?php $scanned_lang_dir = array_map(function ($path) { return basename($path); }, glob(APPPATH . 'language/*', GLOB_ONLYDIR)); foreach ($scanned_lang_dir as $entry) { ?>
                            <li><a href="<?php echo  site_url('pos/language/' . $entry); ?>"><img
                                        src="<?php echo  $assets; ?>images/<?php echo  $entry; ?>.png"
                                        class="language-img"> &nbsp;&nbsp;<?php echo  ucwords($entry); ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
            <iframeframe border="0" scrolling="no" ></iframe>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="hidden-xs hidden-sm"><a href="#" >Mactoscohen, lda</a></li>
                    <li class="hidden-xs"><a href="<?php echo  site_url(); ?>"><i class="fa fa-dashboard"></i></a></li>
                    <?php if($Admin) { ?>
                    <li class="hidden-xs"><a href="<?php echo  site_url('settings'); ?>"><i class="fa fa-cogs"></i></a></li>
                    <?php } ?>
                    <li><a href="<?php echo  site_url('pos/view_bill'); ?>" target="_blank"><i class="fa fa-file-text-o"></i></a></li>
                    <li><a href="<?php echo  site_url('pos'); ?>"><i class="fa fa-th"></i></a></li>
                    <?php if($Admin && $qty_alert_num) { ?>
                    <li>
                        <a href="<?php echo  site_url('reports/alerts'); ?>">
                            <i class="fa fa-bullhorn"></i>
                            <span class="label label-warning"><?php echo  $qty_alert_num; ?></span>
                        </a>
                    </li>
                    <?php } ?>
                    <?php if($suspended_sales) { ?>
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning"><?php echo sizeof($suspended_sales);?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header"><?php echo lang('recent_suspended_sales');?></li>
                            <li>
                                <ul class="menu">
                                    <li>
                                    <?php  foreach ($suspended_sales as $ss) { echo '<a href="'.site_url('pos/?hold='.$ss->id).'" class="load_suspended">'.$this->tec->hrld($ss->date).' ('.$ss->customer_name.')<br><strong>'.$ss->hold_ref.'</strong></a>'; } ?>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="<?php echo  site_url('sales/opened'); ?>"><?php echo  lang('view_all'); ?></a></li>
                        </ul>
                    </li>
                    <?php } ?>
                    <li class="dropdown user user-menu" style="padding-right:5px;">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php echo  base_url('uploads/avatars/thumbs/'.($this->session->userdata('avatar') ? $this->session->userdata('avatar') : $this->session->userdata('gender').'.png')) ?>" class="user-image" alt="Avatar" />
                            <span class="hidden-xs"><?php echo  $this->session->userdata('first_name').' '.$this->session->userdata('last_name'); ?></span>
                        </a>
                        <ul class="dropdown-menu" style="padding-right:3px;">
                            <li class="user-header">
                                <img src="<?php echo  base_url('uploads/avatars/'.($this->session->userdata('avatar') ? $this->session->userdata('avatar') : $this->session->userdata('gender').'.png')) ?>" class="img-circle" alt="Avatar" />
                                <p>
                                    <?php echo  $this->session->userdata('email'); ?>
                                    <small><?php echo  lang('member_since').' '.$this->session->userdata('created_on'); ?></small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="<?php echo  site_url('users/profile/'.$this->session->userdata('user_id')); ?>" class="btn btn-default btn-flat">Perfil</a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?php echo  site_url('logout'); ?>" class="btn btn-default btn-flat">Sair</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu">
                <!-- <li class="header"><?php echo  lang('mian_navigation'); ?></li> -->

                <li class="mm_welcome"><a href="<?php echo  site_url(); ?>"><i class="fa fa-dashboard"></i> <span><?php echo  lang('dashboard'); ?></span></a></li>
                <li class="treeview mm_pos">
                    <a href="#">
                        <i class="fa fa-th"></i>
                        <span><?php echo  lang('Gestão de Vendas'); ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="pos1">
                            <a href="<?php echo  site_url('pos'); ?>"><i class="fa fa-circle-o"></i> <span><?php echo  lang('pos'); ?></span></a>
                        </li>
                      
                         <li id="cash_sale">
                            <a href="<?php echo  site_url('pos/cash_sale'); ?>"><i class="fa fa-circle-o"></i> <span><?php echo  lang('invoice'); ?></span></a>
                        </li>
                       <!--  <li id="invoice">
                            <a href="<?php echo  site_url('pos/invoice'); ?>"><i class="fa fa-circle-o"></i> <span><?php echo  lang('invoice'); ?></span></a>
                        </li>
                        <li id="pro_forma">
                            <a href="<?php echo  site_url('pos/pro_forma'); ?>"><i class="fa fa-circle-o"></i> <span><?php echo  lang('pro-forma'); ?></span></a>
                        </li> -->
                    
					
                        <li id="gift_cards_index"><a href="<?php echo  site_url('gift_cards'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('list_gift_cards'); ?></a></li>
                        <li id="gift_cards_add"><a href="<?php echo  site_url('gift_cards/add'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('add_gift_card'); ?></a></li>
                    </ul>
                   <!--  <a href="<?php echo  site_url('pos'); ?>"><i class="fa fa-th"></i> <span><?php echo  lang('pos'); ?></span></a> -->
                </li>


                <?php if($Admin) { ?>
                <li class="treeview mm_products">
                    <a href="#">
                        <i class="fa fa-barcode"></i>
                        <span><?php echo  lang('products'); ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="products_index"><a href="<?php echo  site_url('products'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('list_products'); ?></a></li>
                        
                                                            <li id="products_itens"><a href="<?php echo  site_url('products/itens'); ?>"><i class="fa fa-circle-o"></i> Listar Subitem</a></li>

                        <li id="products_add"><a href="<?php echo  site_url('products/add'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('add_product'); ?></a></li>
                        <li id="products_add_itens"><a href="<?php echo  site_url('products/add_itens'); ?>"><i class="fa fa-circle-o"></i> Adicionar Item Produto</a></li>
                        <li id="products_import"><a href="<?php echo  site_url('products/import'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('import_products'); ?></a></li>
                        <li id="products_print_barcodes"><a onclick="window.open('<?php echo  site_url('products/print_barcodes'); ?>', 'pos_popup', 'width=900,height=600,menubar=yes,scrollbars=yes,status=no,resizable=yes,screenx=0,screeny=0'); return false;"
                                        href="#"><i class="fa fa-circle-o"></i> <?php echo  lang('print_barcodes'); ?></a></li>
                        <li id="products_print_labels"><a onclick="window.open('<?php echo  site_url('products/print_labels'); ?>', 'pos_popup', 'width=900,height=600,menubar=yes,scrollbars=yes,status=no,resizable=yes,screenx=0,screeny=0'); return false;"
                                        href="#"><i class="fa fa-circle-o"></i> <?php echo  lang('print_labels'); ?></a></li>
                    </ul>
                </li>
                <li class="treeview mm_categories">
                    <a href="#">
                        <i class="fa fa-folder"></i>
                        <span><?php echo  lang('categories'); ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="categories_index"><a href="<?php echo  site_url('categories'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('list_categories'); ?></a></li>
                        <li id="categories_add"><a href="<?php echo  site_url('categories/add'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('add_category'); ?></a></li>
                        <li id="categories_import"><a href="<?php echo  site_url('categories/import'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('import_categories'); ?></a></li>
                    </ul>
                </li>
                <li class="treeview mm_sales">
                    <a href="#">
                        <i class="fa fa-shopping-cart"></i>
                        <span><?php echo  lang('list_sales'); ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="sales_index"><a href="<?php echo  site_url('sales'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('list_sales'); ?></a></li>
                        <li id="sales_index" class="<?php if($this->router->fetch_method() == "pro_forma") echo "active"; ?>"><a href="<?php echo  site_url('sales/pro_forma'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('pro_forma_list'); ?></a></li>

                        <li id="invoice_lists" class="<?php if($this->router->fetch_method() == "invoice_lists") echo "active"; ?>"><a href="<?php echo  site_url('sales/invoice_lists'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('invoice_lists'); ?></a></li>
                        <li id="sales_opened"><a href="<?php echo  site_url('sales/opened'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('list_opened_bills'); ?></a></li>
                    </ul>
                </li>
                <li class="treeview mm_purchases">
                    <a href="#">
                        <i class="fa fa-plus"></i>
                        <span><?php echo  lang('purchases'); ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="purchases_index"><a href="<?php echo  site_url('purchases'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('list_purchases'); ?></a></li>
                        <li id="purchases_add"><a href="<?php echo  site_url('purchases/add'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('add_purchase'); ?></a></li>
                        <li class="divider"></li>
                        <li id="purchases_expenses"><a href="<?php echo  site_url('purchases/expenses'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('list_expenses'); ?></a></li>
                        <li id="purchases_add_expense"><a href="<?php echo  site_url('purchases/add_expense'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('add_expense'); ?></a></li>
                    </ul>
                </li>
               

                <li class="treeview mm_auth mm_customers mm_suppliers">
                    <a href="#">
                        <i class="fa fa-users"></i>
                        <span><?php echo  lang('people'); ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="auth_users"><a href="<?php echo  site_url('users'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('list_users'); ?></a></li>
                        <li id="auth_add"><a href="<?php echo  site_url('users/add'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('add_user'); ?></a></li>
                        <li class="divider"></li>
                        <li id="customers_index"><a href="<?php echo  site_url('customers'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('list_customers'); ?></a></li>
                        <li id="customers_add"><a href="<?php echo  site_url('customers/add'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('add_customer'); ?></a></li>
                        <li class="divider"></li>
                        <li id="suppliers_index"><a href="<?php echo  site_url('suppliers'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('list_suppliers'); ?></a></li>
                        <li id="suppliers_add"><a href="<?php echo  site_url('suppliers/add'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('add_supplier'); ?></a></li>
                    </ul>
                </li>

                <li class="treeview mm_settings">
                    <a href="#">
                        <i class="fa fa-cogs"></i>
                        <span><?php echo  lang('settings'); ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
						<?php 
                            if($this->Super_admin){
                        ?>
                        <li id="settings_index"><a href="<?php echo  site_url('settings'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('settings'); ?></a></li>
                        
                        <li id="settings_xsd" class="<?php if($this->router->fetch_method() == "generate_licence") echo "active"; ?>"><a href="<?php echo  site_url('settings/generate_licence'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('generate_licence'); ?></a></li>

                        <li id="settings_public" class="<?php if($this->router->fetch_method() == "sign_keys") echo "active"; ?>"><a href="<?php echo  site_url('settings/sign_keys'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('sign_keys'); ?></a></li>

                        <?php                                 
                            }
                        ?>
                        <li id="settings_xsd" class="<?php if($this->router->fetch_method() == "saf_xsd") echo "active"; ?>"><a href="<?php echo  site_url('settings/saf_xsd'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('SAF-AO XSD'); ?></a></li>

                        <li id="settings_mesa"><a href="<?php echo  site_url('settings/mesa'); ?>"><i class="fa fa-bars"></i> Mesas</a></li>
                        <li id="settings_backups"><a href="<?php echo  site_url('settings/backups'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('backups'); ?></a></li>
                        <li id="settings_updates"><a href="<?php echo  site_url('settings/updates'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('updates'); ?></a></li>
                    </ul>
                </li>
                <li class="treeview mm_reports">
                    <a href="#">
                        <i class="fa fa-bar-chart-o"></i>
                        <span><?php echo  lang('reports'); ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                    
                        <li id="reports_daily_sales"><a href="<?php echo  site_url('reports/daily_sales'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('daily_sales'); ?></a></li>
                        <li id="reports_monthly_sales"><a href="<?php echo  site_url('reports/monthly_sales'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('monthly_sales'); ?></a></li>
                        <li id="reports_index"><a href="<?php echo  site_url('reports'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('sales_report'); ?></a></li>

                        <li id="reports_invoice" class="<?php if($this->router->fetch_method() == "invoices") echo "active"; ?>"><a href="<?php echo  site_url('reports/invoices'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('invoice_report'); ?></a></li>

                        <li class="divider"></li>
                        <li id="reports_payments"><a href="<?php echo  site_url('reports/payments'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('payments_report'); ?></a></li>
                        <li class="divider"></li>
                        <li id="reports_registers"><a href="<?php echo  site_url('reports/registers'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('registers_report'); ?></a></li>
                        
                        <li id="reports_top_products"><a href="<?php echo  site_url('reports/top_products'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('top_products'); ?></a></li>
                        <li id="reports_products"><a href="<?php echo  site_url('reports/products'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('products_report'); ?></a></li>
                    </ul>
                </li>
                <?php } else { ?>
                <li class="mm_products"><a href="<?php echo  site_url('products'); ?>"><i class="fa fa-barcode"></i> <span><?php echo  lang('products'); ?></span></a></li>
                <li class="mm_categories"><a href="<?php echo  site_url('categories'); ?>"><i class="fa fa-folder-open"></i> <span><?php echo  lang('categories'); ?></span></a></li>
                <li class="treeview mm_sales">
                    <a href="#">
                        <i class="fa fa-shopping-cart"></i>
                        <span><?php echo  lang('sales'); ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="sales_index"><a href="<?php echo  site_url('sales'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('list_sales'); ?></a></li>
                        <li id="sales_opened"><a href="<?php echo  site_url('sales/opened'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('list_opened_bills'); ?></a></li>
                    </ul>
                </li>
                <li class="treeview mm_purchases">
                    <a href="#">
                        <i class="fa fa-plus"></i>
                        <span><?php echo  lang('expenses'); ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="purchases_expenses"><a href="<?php echo  site_url('purchases/expenses'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('list_expenses'); ?></a></li>
                        <li id="purchases_add_expense"><a href="<?php echo  site_url('purchases/add_expense'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('add_expense'); ?></a></li>
                    </ul>
                </li>
                <li class="treeview mm_gift_cards">
                    <a href="#">
                        <i class="fa fa-credit-card"></i>
                        <span><?php echo  lang('gift_cards'); ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="gift_cards_index"><a href="<?php echo  site_url('gift_cards'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('list_gift_cards'); ?></a></li>
                        <li id="gift_cards_add"><a href="<?php echo  site_url('gift_cards/add'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('add_gift_card'); ?></a></li>
                    </ul>
                </li>
                <li class="treeview mm_customers">
                    <a href="#">
                        <i class="fa fa-users"></i>
                        <span><?php echo  lang('customers'); ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="customers_index"><a href="<?php echo  site_url('customers'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('list_customers'); ?></a></li>
                        <li id="customers_add"><a href="<?php echo  site_url('customers/add'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('add_customer'); ?></a></li>
                    </ul>
                </li>
                <li class="treeview mm_suppliers">
                    <a href="#">
                        <i class="fa fa-users"></i>
                        <span><?php echo  lang('suppliers'); ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="suppliers_index"><a href="<?php echo  site_url('suppliers'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('list_suppliers'); ?></a></li>
                        <li id="suppliers_add"><a href="<?php echo  site_url('suppliers/add'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('add_supplier'); ?></a></li>
                    </ul>
                </li>
                <?php } ?>
            </ul>
        </section>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <h1><?php echo  $page_title; ?></h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo  site_url(); ?>"><i class="fa fa-dashboard"></i> <?php echo  lang('home'); ?></a></li>
                <?php  foreach ($bc as $b) { if ($b['link'] === '#') { echo '<li class="active">' . $b['page'] . '</li>'; } else { echo '<li><a href="' . $b['link'] . '">' . $b['page'] . '</a></li>'; } } ?>
            </ol>
        </section>

        <div class="col-lg-12 alerts">
            <div id="custom-alerts" style="display:none;">
                <div class="alert alert-dismissable">
                    <div class="custom-msg"></div>
                </div>
            </div>
            <?php if($error) { ?>
            <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <h4><i class="icon fa fa-ban"></i> <?php echo  lang('error'); ?></h4>
                <?php echo  $error; ?>
            </div>
            <?php } if($warning) { ?>
            <div class="alert alert-warning alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <h4><i class="icon fa fa-warning"></i> <?php echo  lang('warning'); ?></h4>
                <?php echo  $warning; ?>
            </div>
            <?php } if($message) { ?>
            <div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <h4>	<i class="icon fa fa-check"></i> <?php echo  lang('Success'); ?></h4>
                <?php echo  $message; ?>
            </div>
            <?php } ?>
        </div>