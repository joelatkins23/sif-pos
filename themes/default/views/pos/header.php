 <aside class="main-sidebar">
                <section class="sidebar">
                    <ul class="sidebar-menu">
                        <li class="header"><?= lang('mian_navigation'); ?></li>

                        <li id="mm_welcome"><a href="<?= site_url(); ?>"><i class="fa fa-dashboard"></i> <span><?= lang('dashboard'); ?></span></a></li>
                        <li class="treeview mm_pos">
                            <a href="#">
                                <i class="fa fa-th"></i>
                                <span><?php echo  lang('Pos'); ?></span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li id="pos1">
                                    <a href="<?php echo  site_url('pos'); ?>"><i class="fa fa-circle-o"></i> <span><?php echo  lang('pos'); ?></span></a>
                                </li>
                              
                                 <li id="cash_sale">
                                    <a href="<?php echo  site_url('pos/cash_sale'); ?>"><i class="fa fa-circle-o"></i> <span><?php echo  lang('cash_sale'); ?></span></a>
                                </li>
                                <!-- <li id="invoice">
                                    <a href="<?php echo  site_url('pos/invoice'); ?>"><i class="fa fa-circle-o"></i> <span><?php echo  lang('invoice'); ?></span></a>
                                </li>
                                <li id="pro_forma">
                                    <a href="<?php echo  site_url('pos/pro_forma'); ?>"><i class="fa fa-circle-o"></i> <span><?php echo  lang('pro-forma'); ?></span></a>
                                </li> -->
                            </ul>
                           <!--  <a href="<?php echo  site_url('pos'); ?>"><i class="fa fa-th"></i> <span><?php echo  lang('pos'); ?></span></a> -->
                        </li>


                        <?php if ($Admin) { ?>
                            <li class="treeview" id="mm_products">
                                <a href="#">
                                    <i class="fa fa-barcode"></i>
                                    <span><?= lang('products'); ?></span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li id="products_index"><a href="<?= site_url('products'); ?>"><i class="fa fa-circle-o"></i> <?= lang('list_products'); ?></a></li>
                                    <li id="products_itens"><a href="<?= site_url('products/itens'); ?>"><i class="fa fa-circle-o"></i> Listar Subitem</a></li>
                                    <li id="products_add"><a href="<?= site_url('products/add'); ?>"><i class="fa fa-circle-o"></i> <?= lang('add_product'); ?></a></li>
                                    <li id="products_add_itens"><a href="<?= site_url('products/add_itens'); ?>"><i class="fa fa-circle-o"></i> Adicionar Item Produto</a></li>
                                    <li id="products_import_csv"><a href="<?= site_url('products/import'); ?>"><i class="fa fa-circle-o"></i> <?= lang('import_products'); ?></a></li>
                                    <li id="products_print_barcodes"><a onclick="window.open('<?= site_url('products/print_barcodes'); ?>', 'pos_popup', 'width=900,height=600,menubar=yes,scrollbars=yes,status=no,resizable=yes,screenx=0,screeny=0'); return false;"
                                                                        href="#"><i class="fa fa-circle-o"></i> <?= lang('print_barcodes'); ?></a></li>
                                    <li id="products_print_labels"><a onclick="window.open('<?= site_url('products/print_labels'); ?>', 'pos_popup', 'width=900,height=600,menubar=yes,scrollbars=yes,status=no,resizable=yes,screenx=0,screeny=0'); return false;"
                                                                      href="#"><i class="fa fa-circle-o"></i> <?= lang('print_labels'); ?></a></li>
                                </ul>
                            </li>
                            <li class="treeview" id="mm_categories">
                                <a href="#">
                                    <i class="fa fa-folder"></i>
                                    <span><?= lang('categories'); ?></span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li id="categories_index"><a href="<?= site_url('categories'); ?>"><i class="fa fa-circle-o"></i> <?= lang('list_categories'); ?></a></li>
                                    <li id="categories_add"><a href="<?= site_url('categories/add'); ?>"><i class="fa fa-circle-o"></i> <?= lang('add_category'); ?></a></li>
                                    <li id="categories_import"><a href="<?= site_url('categories/import'); ?>"><i class="fa fa-circle-o"></i> <?= lang('import_categories'); ?></a></li>
                                </ul>
                            </li>
                            <li class="treeview" id="mm_sales">
                                <a href="#">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span><?= lang('sales'); ?></span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li id="sales_index"><a href="<?= site_url('sales'); ?>"><i class="fa fa-circle-o"></i> <?= lang('list_sales'); ?></a></li>
                                    <li id="sales_opened"><a href="<?= site_url('sales/opened'); ?>"><i class="fa fa-circle-o"></i> <?= lang('list_opened_bills'); ?></a></li>
                                </ul>
                            </li>
                            <li class="treeview mm_purchases">
                                <a href="#">
                                    <i class="fa fa-plus"></i>
                                    <span><?= lang('purchases'); ?></span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li id="purchases_index"><a href="<?= site_url('purchases'); ?>"><i class="fa fa-circle-o"></i> <?= lang('list_purchases'); ?></a></li>
                                    <li id="purchases_add"><a href="<?= site_url('purchases/add'); ?>"><i class="fa fa-circle-o"></i> <?= lang('add_purchase'); ?></a></li>
                                    <li class="divider"></li>
                                    <li id="purchases_expenses"><a href="<?= site_url('purchases/expenses'); ?>"><i class="fa fa-circle-o"></i> <?= lang('list_expenses'); ?></a></li>
                                    <li id="purchases_add_expense"><a href="<?= site_url('purchases/add_expense'); ?>"><i class="fa fa-circle-o"></i> <?= lang('add_expense'); ?></a></li>
                                </ul>
                            </li>
                            <li class="treeview" id="mm_gift_cards">
                                <a href="#">
                                    <i class="fa fa-credit-card"></i>
                                    <span><?= lang('gift_cards'); ?></span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li id="gift_cards_index"><a href="<?= site_url('gift_cards'); ?>"><i class="fa fa-circle-o"></i> <?= lang('list_gift_cards'); ?></a></li>
                                    <li id="gift_cards_add"><a href="<?= site_url('gift_cards/add'); ?>"><i class="fa fa-circle-o"></i> <?= lang('add_gift_card'); ?></a></li>
                                </ul>
                            </li>

                            <li class="treeview mm_auth mm_customers mm_suppliers">
                                <a href="#">
                                    <i class="fa fa-users"></i>
                                    <span><?= lang('people'); ?></span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li id="auth_users"><a href="<?= site_url('users'); ?>"><i class="fa fa-circle-o"></i> <?= lang('list_users'); ?></a></li>
                                    <li id="auth_add"><a href="<?= site_url('users/add'); ?>"><i class="fa fa-circle-o"></i> <?= lang('add_user'); ?></a></li>
                                    <li class="divider"></li>
                                    <li id="customers_index"><a href="<?= site_url('customers'); ?>"><i class="fa fa-circle-o"></i> <?= lang('list_customers'); ?></a></li>
                                    <li id="customers_add"><a href="<?= site_url('customers/add'); ?>"><i class="fa fa-circle-o"></i> <?= lang('add_customer'); ?></a></li>
                                    <li class="divider"></li>
                                    <li id="suppliers_index"><a href="<?= site_url('suppliers'); ?>"><i class="fa fa-circle-o"></i> <?= lang('list_suppliers'); ?></a></li>
                                    <li id="suppliers_add"><a href="<?= site_url('suppliers/add'); ?>"><i class="fa fa-circle-o"></i> <?= lang('add_supplier'); ?></a></li>
                                </ul>
                            </li>

                            <li class="treeview" id="mm_settings">
                                <a href="#">
                                    <i class="fa fa-cogs"></i>
                                    <span><?= lang('settings'); ?></span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li id="settings_index"><a href="<?= site_url('settings'); ?>"><i class="fa fa-circle-o"></i> <?= lang('settings'); ?></a></li>
                                    <li id="settings_xsd"><a href="<?php echo  site_url('settings/saf_xsd'); ?>"><i class="fa fa-circle-o"></i> <?php echo  lang('SAF-AO XSD'); ?></a></li>

                                    <li id="settings_mesa"><a href="<?= site_url('settings/mesa'); ?>"><i class="fa fa-bars"></i> Mesas</a></li>
                                    <li id="settings_backups"><a href="<?= site_url('settings/backups'); ?>"><i class="fa fa-circle-o"></i> <?= lang('backups'); ?></a></li>
                                    <li id="settings_updates"><a href="<?= site_url('settings/updates'); ?>"><i class="fa fa-circle-o"></i> <?= lang('updates'); ?></a></li>
                                </ul>
                            </li>
                            <li class="treeview" id="mm_reports">
                                <a href="#">
                                    <i class="fa fa-bar-chart-o"></i>
                                    <span><?= lang('reports'); ?></span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li id="reports_daily_sales"><a href="<?= site_url('reports/daily_sales'); ?>"><i class="fa fa-circle-o"></i> <?= lang('daily_sales'); ?></a></li>
                                    <li id="reports_monthly_sales"><a href="<?= site_url('reports/monthly_sales'); ?>"><i class="fa fa-circle-o"></i> <?= lang('monthly_sales'); ?></a></li>
                                    <li id="reports_index"><a href="<?= site_url('reports'); ?>"><i class="fa fa-circle-o"></i> <?= lang('sales_report'); ?></a></li>
                                    <li class="divider"></li>
                                    <li id="reports_payments"><a href="<?= site_url('reports/payments'); ?>"><i class="fa fa-circle-o"></i> <?= lang('payments_report'); ?></a></li>
                                    <li class="divider"></li>
                                    <li id="reports_registers"><a href="<?= site_url('reports/registers'); ?>"><i class="fa fa-circle-o"></i> <?= lang('registers_report'); ?></a></li>
                                    <li class="divider"></li>
                                    <li id="reports_top_products"><a href="<?= site_url('reports/top_products'); ?>"><i class="fa fa-circle-o"></i> <?= lang('top_products'); ?></a></li>
                                    <li id="reports_products"><a href="<?= site_url('reports/products'); ?>"><i class="fa fa-circle-o"></i> <?= lang('products_report'); ?></a></li>
                                </ul>
                            </li>
                        <?php } else { ?>
                            <li id="mm_products"><a href="<?= site_url('products'); ?>"><i class="fa fa-barcode"></i> <span><?= lang('products'); ?></span></a></li>
                            <li id="mm_categories"><a href="<?= site_url('categories'); ?>"><i class="fa fa-folder-open"></i> <span><?= lang('categories'); ?></span></a></li>
                            <li class="treeview" id="mm_sales">
                                <a href="#">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span><?= lang('sales'); ?></span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li id="sales_index"><a href="<?= site_url('sales'); ?>"><i class="fa fa-circle-o"></i> <?= lang('list_sales'); ?></a></li>
                                    <li id="sales_opened"><a href="<?= site_url('sales/opened'); ?>"><i class="fa fa-circle-o"></i> <?= lang('list_opened_bills'); ?></a></li>
                                </ul>
                            </li>
                            <li class="treeview mm_purchases">
                                <a href="#">
                                    <i class="fa fa-plus"></i>
                                    <span><?= lang('expenses'); ?></span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li id="purchases_expenses"><a href="<?= site_url('purchases/expenses'); ?>"><i class="fa fa-circle-o"></i> <?= lang('list_expenses'); ?></a></li>
                                    <li id="purchases_add_expense"><a href="<?= site_url('purchases/add_expense'); ?>"><i class="fa fa-circle-o"></i> <?= lang('add_expense'); ?></a></li>
                                </ul>
                            </li>
                            <li class="treeview" id="mm_gift_cards">
                                <a href="#">
                                    <i class="fa fa-credit-card"></i>
                                    <span><?= lang('gift_cards'); ?></span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li id="gift_cards_index"><a href="<?= site_url('gift_cards'); ?>"><i class="fa fa-circle-o"></i> <?= lang('list_gift_cards'); ?></a></li>
                                    <li id="gift_cards_add"><a href="<?= site_url('gift_cards/add'); ?>"><i class="fa fa-circle-o"></i> <?= lang('add_gift_card'); ?></a></li>
                                </ul>
                            </li>
                            <li class="treeview" id="mm_customers">
                                <a href="#">
                                    <i class="fa fa-users"></i>
                                    <span><?= lang('customers'); ?></span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li id="customers_index"><a href="<?= site_url('customers'); ?>"><i class="fa fa-circle-o"></i> <?= lang('list_customers'); ?></a></li>
                                    <li id="customers_add"><a href="<?= site_url('customers/add'); ?>"><i class="fa fa-circle-o"></i> <?= lang('add_customer'); ?></a></li>
                                </ul>
                            </li>
                            <li class="treeview mm_suppliers">
                                <a href="#">
                                    <i class="fa fa-users"></i>
                                    <span><?= lang('suppliers'); ?></span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li id="suppliers_index"><a href="<?= site_url('suppliers'); ?>"><i class="fa fa-circle-o"></i> <?= lang('list_suppliers'); ?></a></li>
                                    <li id="suppliers_add"><a href="<?= site_url('suppliers/add'); ?>"><i class="fa fa-circle-o"></i> <?= lang('add_supplier'); ?></a></li>
                                </ul>
                            </li>
                        <?php } ?>
                    </ul>
                </section>
            </aside>