<html>
    <head>
        <meta charset="utf-8">
        <title><?= lang('view_bill2') . " | " . $Settings->site_name; ?></title>
        <base href="<?= base_url() ?>"/>
        <meta http-equiv="cache-control" content="max-age=0"/>
        <meta http-equiv="cache-control" content="no-cache"/>
        <meta http-equiv="expires" content="0"/>
        <meta http-equiv="pragma" content="no-cache"/>
        <link href="<?= $assets ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        
    </head>
    <body class="with-promo-space22">
        <div style="width: 90%; margin: 50px auto;" >
            <table id="SLRData" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <tr class="active">
                        <th class="col-sm-2"><?= lang("date"); ?></th>
                        <th class="col-sm-2"><?= lang("customer"); ?></th>
                        <th class="col-sm-2"><?= lang("prodouct"); ?></th>
                        <th class="col-sm-1"><?= lang("total"); ?></th>
                        <th class="col-sm-1"><?= lang("tax"); ?></th>
                        <th class="col-sm-1"><?= lang("discount"); ?></th>
                        <th class="col-sm-2"><?= lang("grand_total"); ?></th>
                        <th class="col-sm-1"><?= lang("paid"); ?></th>
                        <th class="col-sm-2"><?= lang("balance"); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <!-- <tr>
                        <td colspan="8" class="dataTables_empty"><?= lang('loading_data_from_server'); ?></td>
                    </tr> -->
                    <?php 
                        foreach ($sale_data as $key => $sale_item) {
                            // $sale_item = get_row("sales",array("id"=>$sale['sale_id']));
                            $sales = get_rows("sale_items",array("sale_id"=>$sale_item['id']));
                            $product_str = "";
                            foreach ($sales as $key => $sale) {
                                $product = get_row("products",array("id"=>$sale['product_id']));
                                $product_str .= $product['name'] . "&times". (floor($sale['quantity']))."<br/>";
                            }
                            $product_str = trim($product_str,"<br/>");
                            echo '<tr>';
                            echo '<td>'.$sale_item['date'].'</td>';
                            echo '<td>'.$sale_item['customer_name'].'</td>';
                            echo '<td>'.$product_str.'</td>';
                            echo '<td>'.$sale_item['total'].'</td>';
                            echo '<td>'.$sale_item['product_tax'].'</td>';
                            echo '<td>'.$sale_item['total_discount'].'</td>';
                            echo '<td>'.$sale_item['grand_total'].'</td>';
                            echo '<td>'.$sale_item['paid'].'</td>';
                            echo '<td>'.($sale_item['total_balance']*(-1)).'</td>';
                            
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
     <script src="<?php echo base_url(); ?>themes/default/assets/plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function(){
            // window.print();
        })
    </script>
</html>

   
 