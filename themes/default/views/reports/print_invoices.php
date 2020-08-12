<html>
    <head>
        <meta charset="utf-8">
        <title><?= lang('invoice_report') . " | " . $Settings->site_name; ?></title>
        <base href="<?= base_url() ?>"/>
        <meta http-equiv="cache-control" content="max-age=0"/>
        <meta http-equiv="cache-control" content="no-cache"/>
        <meta http-equiv="expires" content="0"/>
        <meta http-equiv="pragma" content="no-cache"/>
        <link href="<?= $assets ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        
    </head>

    <body class="with-promo-space22">
    <style type="text/css">
            .date-title{
                background-color: #ccc;
                font-weight: 700;
                padding: 10px;
                font-size: 18px;
                margin-top: 30px;
            }
            .date-value{
                padding: 10px 0px;
                font-size: 16px;
                font-weight: 700;
            }
            table{
                width: 100%;

            }
            th{
                background-color: #e4e2e2;
                border: 1px solid #ccc;
                padding: 10px;
            }
            td{
                border: 1px solid #ccc;
                padding: 10px;
            }
            .total-wrap{
                text-align: right;
                padding: 20px;
                font-size: 20px;
                margin-bottom: 20px;
            }
            @media print{
                .date-title{
					text-align:center;
                    background-color: #ccc !important;
                    font-weight: 700;
                    padding: 10px;
                    font-size: 18px;
                    margin-top: 30px;
					
                }
                .date-value{
                    padding: 10px 0px;
                    font-size: 16px;
                    font-weight: 700;
                }
                table{
                    width: 100%;

                }
                th{
                    background-color: #e4e2e2 !important;
                    border: 1px solid #ccc;
                    padding: 10px;
                }
                td{
                    border: 1px solid #ccc;
                    padding: 10px;
                }
                .total-wrap{
                    text-align: right;
                    padding: 20px;
                    font-size: 20px;
                    margin-bottom: 20px;
                } 
            }
        </style>
        <div style="width: 90%; margin: 50px auto;" >
          <?php 
                $seller = "";
                $no = 0;
                $data = array();
                $start_date1 = date("Y-m-d H:i:s");
                $end_date1 = "";

                foreach ($sale_data as $key => $sale) {
                    if($seller != $sale['created_by']){
                        $no++;
                        $seller = $sale['created_by'];
                    }
                    $data[$no][] = $sale;
                    if($start_date1 >= $sale['date']) $start_date1 = $sale['date'];
                    if($end_date1 <= $sale['date']) $end_date1 = $sale['date'];
                }
                if($start_date == NULL) $start_date = $start_date1;
                if($end_date == NULL) $end_date = $end_date1;

                for($i = 1; $i<= $no; $i++){
                    $total = 0;
                    if(count($data[$i]) == 0) continue;
                    // print_r($data[$i]);
?>
          <?= $Settings->CompanyName; ?>
          <div class="date-title"> Listagem de Productos / Facturas</div>
          <div class="date-value"> <?php echo lang("De").": ".$start_date; ?> <br>
            <?php echo lang("Á")."  &nbsp;:  ".$end_date; ?> </div>
          
                    <table>
                        <tr>
                            <th ><?php echo lang("code"); ?></th>
                            <th ><?php echo lang("product"); ?></th>
                            <th ><?php echo lang("quantity"); ?></th>
                            <th ><?php echo lang("tax"); ?></th>
                            <th ><?php echo lang("sub_total"); ?></th>
                        </tr>
<?php               
                    $product_data = array();

                    foreach ($data[$i] as $sale_data) {
						
                        $seller_id = $sale_data['created_by'];	
						
                        $sale_items = get_rows("sale_items",array("sale_id"=>$sale_data['id']));
                        // print_r($sale_items);
						
                        foreach ($sale_items as $sale_item) {
                            $product = get_row("products",array("id"=>$sale_item['product_id']));
                            if($this->input->post("products") && !in_array($product['id'],$this->input->post("products"))) continue;
                            if(empty($product_data[$product['name']]["count"])) {
                                $product_data[$product['name']]["count"] = $sale_item['quantity'];
                                $product_data[$product['name']]["subtotal"] = $sale_item['subtotal'];
                                $product_data[$product['name']]['tax'] = $sale_item['item_tax'];

                            } else {
                                $product_data[$product['name']]["count"] += $sale_item['quantity'];
                                $product_data[$product['name']]["subtotal"] += $sale_item['subtotal'];
                                $product_data[$product['name']]['tax'] += $sale_item['item_tax'];

                            }
                            $product_data[$product['name']]['code'] = $product['code'];
                            // if($product_name != $product['name']){
                            //     if($product_name != ""){
                            //         echo "<tr>";
                            //         echo "<td>".$product['code']."</td>";
                            //         echo "<td>".$product_name."</td>";
                            //         echo "<td>".$product_count."</td>";
                            //         echo "<td>".$subtotal."</td>";
                            //         echo "</tr>";
                            //     }
                            //     $product_name = $product['name'];
                            //     $subtotal = 0;
                            //     $product_count = 0;
                            // }
                            $total += $sale_item['subtotal'];
                            $total_tax += $sale_item['item_tax']*1;
                            // $product_count += $sale_item['quantity'];
                            // $subtotal += $sale_item['subtotal']*1;
                        }
                    }
                    foreach ($product_data as $key => $product) {
                        echo "<tr>";
                        echo "<td>".$product['code']."</td>";
                        echo "<td>".$key."</td>";
                        echo "<td>".floor($product['count'])."</td>";
                        echo "<td>".number_format($product['tax'],2)."</td>";
                        echo "<td>".number_format($product['subtotal'],2)."</td>";
                        echo "</tr>";
                    }
            ?>
            </table>    
            <div class="total-wrap">
                <?php 
                    $seller = get_row("users",array("id"=>$seller_id));
                    echo $seller["username"]; 
                ?>
                &nbsp;&nbsp;
                <b><?php echo lang("total")." ".number_format($total,2); ?>
                <br/>
                <b><?php echo lang("tax_total")." ".number_format($total_tax,2); ?>

            </div>
            <?php
                }
             ?>
                    

    </div>
    </body>
     <script src="<?php echo base_url(); ?>themes/default/assets/plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function(){
            window.print();
        })
    </script>
</html>

   
 