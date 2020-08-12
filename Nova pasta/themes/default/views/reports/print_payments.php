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
       
                    <div class="date-title">
                        <?php echo lang("date"); ?>
                    </div>
                    <div class="date-value">
                        <?php echo lang("from")." <span id='start_date'>".$start_date."</span> ".lang("to")." <span id='end_date'>".$end_date."</span>"; ?> 
                    </div>
                    <table>
                        <tr>
                            <th><?= lang("date"); ?></th>
                            <th><?= lang("payment_ref"); ?></th>
                            <th><?= lang("sale_no"); ?></th>
                            <th><?= lang("paid_by"); ?></th>
                            <th><?= lang("amount"); ?></th>
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

   
 