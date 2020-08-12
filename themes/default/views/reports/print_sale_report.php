<html>
	<?php function product_name($name)
{
    return character_limiter($name, (isset($Settings->char_per_line) ? ($Settings->char_per_line-8) : 35));
}?>
    <head>
        <meta charset="utf-8">
        <title><?= lang('Relatótio de Vendas') . " | " . $Settings->site_name; ?></title>
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
                background: #dadada;
            }
            p{
                margin: 0px;
                font-size: 14px;
            }
            .data-table{
                width: 100%;
                margin-bottom: 30px;
            }
            .data-table td, .data-table th{
                border-top: 1px solid #ccc;
                border-bottom: 1px solid #ccc;
                height: 30px;

            }
            .th-footer{
                font-weight: bold;
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
                    background: #dadada !important;
                }
  
            }
        </style>
        <div style="width: 90%; margin: 50px auto; " >
            <table style="width: 100%">
                <tr>
                    <td width="50%" style="text-align: left;">
                        <table style="width: 100%;">
                            <tr>
                                <td width="50%" style="text-align: left; padding-right: 20px;">
                                    <img src="<?php echo $assets; ?>images/header/principal2.png" alt="Logotipo"  width="205" height="105" border="0" />
                                </td>
                            </tr>
                        </table>
                       
                        <table>
                            <tr>
                               <td>
                                    <img src="<?php echo $assets."images/icon_print.png"; ?>">
                                </td>
                                <td valign="">
                                    <p style="  padding: 1px 2px;">
                                        <?= $this->Settings->BusinessName; ?>
                                     </p>
                                    <p style="padding: 1px 2px;">
                                         
                                         <?= $this->Settings->AddressDetail; ?> 
                                     </p>
                                    <p style=" padding: 1px 2px;">
                                         
                                        <?= $this->Settings->TaxRegistrationNumber; ?>
                                    </p>
                                    <p style="padding: 1px 2px;">
                                        <?= $this->Settings->phone; ?>
                                    </p>
                                     <p style="padding: 1px 2px;">
                                        <?= $this->Settings->Email; ?>
                                    </p>
                                     <p style="padding: 1px 2px;"><?= $this->Settings->Website; ?></p>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="50%" style="text-align: left; padding-left: 10%; vertical-align: top; padding-top: 15px;">
                      
                    </td>
                </tr>
            </table>

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
                     $seller = get_row("users",array("id"=>$data[$i][0]['created_by']));

?>                      

                    <div class="date-value">
                        <?php echo lang("De").": ".$start_date; ?> &nbsp; &nbsp;
						<?php echo lang("Á")."  &nbsp;:  ".$end_date; ?> &nbsp; &nbsp;
                        <?php echo lang("user")." &nbsp;: ".$seller["username"]; ?>
                    </div>
        <!-- ->select("id, date, customer_name, total, total_tax, total_discount, grand_total, paid, (grand_total-paid) as balance") -->

                <table height="37" class="data-table">
                    <tr>
                        <th class="col-sm-2"><?= lang("customer"); ?></th>
                        <th class="col-sm-1"><?= lang("total"); ?></th>
                        <th class="col-sm-1"><?= lang("tax"); ?></th>
                        <th class="col-sm-1"><?= lang("discount"); ?></th>
                        <th class="col-sm-2"><?= lang("grand_total"); ?></th>
                        <th class="col-sm-1"><?= lang("paid"); ?></th>
                    </tr>
<?php               
                    $total = 0;
                    $total_tax = 0;
                    $total_discount = 0;
                    $grand_total = 0;
                    $total_paid = 0;
                    foreach ($data[$i] as $sale_data) {
                        echo "<tr>";
                        echo "<td>".$sale_data['customer_name']."</td>";
                        echo "<td>".number_format($sale_data['total'],2)."</td>";
                        echo "<td>".number_format($sale_data['total_tax'],2)."</td>";
                        echo "<td>".number_format($sale_data['total_discount'],2)."</td>";
                        echo "<td>".number_format($sale_data['grand_total'],2)."</td>";
                        echo "<td>".number_format($sale_data['paid'],2)."</td>";
                        echo "</tr>";
                        $seller_id = $sale_data['created_by'];

                        $total += $sale_data['total'];
                        $total_tax += $sale_data['total_tax'];
                        $total_discount += $sale_data['total_discount'];
                        $grand_total += $sale_data['grand_total'];
                        $total_paid += $sale_data['paid'];

                    }
                    echo "<tr>";
                    echo "<td class='th-footer'>Total</td>";
                    echo "<td class='th-footer'>".$total."</td>";
                    echo "<td class='th-footer'>".$total_tax."</td>";
                    echo "<td class='th-footer'>".$total_discount."</td>";
                    echo "<td class='th-footer'>".number_format($grand_total,2)."</td>";
                    echo "<td class='th-footer'>".number_format($total_paid,2)."</td>";
                    echo "</tr>"
            ?>

                </table>    
            <?php } ?>

               <!--  <div class="total-wrap">
                    <?php 
                        $seller = get_row("users",array("id"=>$seller_id));
                        echo $seller["username"]; 
                    ?>
                    &nbsp;&nbsp;
                    <b><?php echo lang("total")." ".number_format($total,2); ?>
                </div> -->
           
                    

        </div>
    </body>
     <script src="<?php echo base_url(); ?>themes/default/assets/plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function(){
            window.print();
        })
    </script>
</html>

   
 