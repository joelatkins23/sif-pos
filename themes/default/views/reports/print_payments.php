<html>
    <head>
        <meta charset="utf-8">
        <title><?= lang('payment') . " | " . $Settings->site_name; ?></title>
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
				text-align:center;
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
        <div style="width: 90%; margin: 50px auto;" >
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
       
                    <div class="date-title">
                        <?php echo "Listagem de Pagamentos Diários" ?>
                    </div>
                    <div class="date-value">
                       <?php echo lang("date"); ?> : <?php echo lang("from")." <span id='start_date'>".$start_date."</span> ".lang("to")." <span id='end_date'>".$end_date."</span>"; ?> 
                    </div>
                    <table width="412"  height="37" class="data-table">
                        <tr>
                            <th><?= lang("date"); ?></th>
                            <th><?= lang("payment_ref"); ?></th>
                            <th align="left"><?= lang("sale_no"); ?></th>
                            <th align="left"><?= lang("paid_by"); ?></th>
                            <th align="left"><?= lang("amount"); ?></th>
                        </tr>
                    <?php
                    $total = 0;
                    foreach ($payments as $key => $payment) {
                        $seller_id = $payment['created_by'];

                        if($start_date == "") $start_date = $payment['date'];
                        if($end_date == "") $end_date = $payment['date'];
                        if(strtotime($start_date)>strtotime($payment['date']))
                            $start_date = $payment['date'];
                        
                        if(strtotime($end_date) < strtotime($payment['date']))
                            $end_date = $payment['date'];
                        
                        echo "<tr>";
                        echo "<td>".$payment['date']."</td>";
                        echo "<td>".$payment['reference']."</td>";
                        echo "<td>".$payment['InvoiceNo']."</td>";
                        echo "<td>".$payment['paid_by']."</td>";
                        echo "<td>".number_format($payment['amount'],2)."</td>";
                        echo "</tr>";
                        $total += $payment['amount'];
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
            </div>
        </div>
    </body>
     <script src="<?php echo base_url(); ?>themes/default/assets/plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function(){
            $("#start_date").html("<?php echo $start_date; ?>");
            $("#end_date").html("<?php echo $end_date; ?>");
            window.print();
        })
    </script>
</html>

   
 