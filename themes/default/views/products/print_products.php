<html>
    <head>
        <meta charset="utf-8">
        <title><?= lang('Stock') . " | " . $Settings->site_name; ?></title>
        <base href="<?= base_url() ?>"/>
        <meta http-equiv="cache-control" content="max-age=0"/>
        <meta http-equiv="cache-control" content="no-cache"/>
        <meta http-equiv="expires" content="0"/>
        <meta http-equiv="pragma" content="no-cache"/>
        <link href="<?= $assets ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <?php 
		?>
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
                border: 1px solid #000000;
               
            }
            .total-wrap{
                text-align: right;
                padding: 20px;
                font-size: 20px;
                margin-bottom: 20px;
            }
            @media print{
                .date-title{
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
                   
                }
                .total-wrap{
                    text-align: right;
                    padding: 20px;
                    font-size: 20px;
                    margin-bottom: 20px;
                } 
            }
        </style>
		<?php include ("empresa.php") ?>
        <div style="width: 90%; margin: 50px auto;" >
       
                   <div class="emp-wrap">
                
					
               <b> <?= $this->Settings->CompanyName; ?>
                <br>
                <?= $this->Settings->TaxRegistrationNumber; ?>
                <br>
                <?= $this->Settings->AddressDetail; ?>
                <br>
                <?= $this->Settings->phone;; ?></b>
                
                <p>
			
					
            </div> 
                    <table>
                        <tr>
                            <th class="col-xs-1"><?= lang("code"); ?></th>
                            <th><?= lang("name"); ?></th>
                            <th class="col-xs-1"><?= lang("type"); ?></th>
                            <th class="col-xs-1"><?= lang("category"); ?></th>
                            <th class="col-xs-1"><?= lang("quantity"); ?></th>
                            <th class="col-xs-1"><?= lang("tax"); ?></th>
                            <th class="col-xs-1"><?= lang("cost"); ?></th>
                            <th class="col-xs-1"><?= lang("price"); ?></th>
							<th class="col-xs-1"><?= lang("subtotal"); ?></th>
							<th class="col-xs-1">Físico</th>
                        </tr>
                    <?php
                    $total = 0;
                    foreach ($products as $key => $product) {
                        echo "<tr>";
                        echo "<td>".$product['code']."</td>";
                        echo "<td>".$product['name']."</td>";
                        echo "<td>".$product['type']."</td>";
                        echo "<td>".$product['category_name']."</td>";
                        echo "<td>".$product['quantity']."</td>";
                        echo "<td>".number_format($product['tax'],2)."</td>";
                        echo "<td>".number_format($product['cost'],2)."</td>";
                        echo "<td>".number_format($product['price'],2)."</td>";
						echo "<td>".number_format($product['price']*$product['quantity'],2)."</td>";
						echo "<td></td>";
                        echo "</tr>";
                        $produtc_cost += $product['cost']*$product['quantity'];
                        $produtc_price += $product['price']*$product['quantity'];
                    }
            ?>
            </table>    
             <div class="total-wrap">
                <?php 
                    $seller = get_row("users",array("id"=>$seller_id));
                    echo $seller["username"]; 
                ?>
                &nbsp;&nbsp;
                <b><?php echo lang("Total Custo")." : ".number_format($produtc_cost,2); ?>
					<br>
				<b><?php echo lang("Total Preço")." : ".number_format($produtc_price,2); ?>
            </div> 
        </div>
    </body>
     <script src="<?php echo base_url(); ?>themes/default/assets/plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function(){
            // $("#start_date").html("<?php echo $start_date; ?>");
            // $("#end_date").html("<?php echo $end_date; ?>");
            window.print();
        })
    </script>
</html>

   
 