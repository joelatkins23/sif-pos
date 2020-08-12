<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?= lang('Fecho Diaário') . " | " . $Settings->site_name; ?></title>
        <base href="<?= base_url() ?>"/> 
        <meta http-equiv="cache-control" content="max-age=0"/>
        <meta http-equiv="cache-control" content="no-cache"/>
        <meta http-equiv="expires" content="0"/>
        <meta http-equiv="pragma" content="no-cache"/>
        <link rel="shortcut icon" href="<?= $assets ?>images/icon.png"/>
        <link href="<?= $assets ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
      
        <style type="text/css" media="all">
            body { color: #000; }
            #wrapper { max-width: 780px; margin: 0 auto; padding-top: 20px; }
            .btn { border-radius: 0; margin-bottom: 5px; }
            .table { border-radius: 3px; border:1px solid #ddd; }
         
            .table th, .table td { vertical-align: middle !important; }
            h3 { margin: 5px 0; }
            .cancelado {
                    display: block;
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    z-index: -1;
                    opacity : 0.1;
                    
                }
            @media print {
                .no-print { display: none; }
                /* #wrapper { max-width: 780px; width: 100%; min-width: 250px; margin: 0 auto; } */
            }
        </style>
        
    </head>
    <body >
        <div id="wrapper" >
            <div class="cancelado">
                <img src="<?php echo $assets; ?>images/header/principal2.png" alt="Logotipo"  width="500" class="img-responsive" border="0" />
            </div>
            <div  style="al" id="receipt-data">
                <div class="text-left">
                    <div id="">
                        <img src="images/header/principal2.png" alt="Logo" width="150"  class="img-responsive" border="0">  
                        <br>
                        <?= $Settings->CompanyName; ?>
                        <br>
                        <?= $Settings->TaxRegistrationNumber; ?>
                        <br>
                        <?= $Settings->AddressDetail; ?>
                        <br>
                        <?= $Settings->phone;; ?>
                        
                        <br>      
                    </div>
                </div>
                <div class="row" style="margin-top:10px;">
                    <div class="col-md-12">
                        <table class="table table-bordered" width="90%">
                            <thead>
                                <tr>
                                    <th  class="text-center"><?= lang("name"); ?></th>
                                    <th class="text-center"><?= lang("code"); ?></th>
                                    <th class="text-center" ><?= lang("sold"); ?></th>
                                    <th class="text-center"><?= lang("tax"); ?></th>
                                    <th class="text-center"><?= lang("cost"); ?></th>
                                    <th class="text-center"><?= lang("income"); ?></th>
                                    <th class="text-center" ><?= lang("profit"); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $total_cost=0;
                                    $total_income=0;
                                    $total_profit=0;
                                ?>
                                <?php foreach($alldata as $key=>$arr){ 
                                    $total_cost= $total_cost+$arr->cost;
                                    $total_income= $total_income+$arr->income;
                                    $total_profit= $total_profit+$arr->profit;
                                    ?>
                                    
                                    <tr>
                                        <td style="width:20%"><?php echo $arr->name ?></td>
                                        <td  class="text-right" style="width:10%"><?php echo $arr->code ?></td>
                                        <td class="text-right" style="width:10%"><?php echo $arr->sold ?></td>
                                        <td class="text-right" style="width:15%"><?php echo $arr->tax ?></td>
                                        <td class="text-right" style="width:15%"><?php echo $arr->cost ?></td>
                                        <td class="text-right" style="width:15%"><?php echo $arr->income ?></td>
                                        <td class="text-right" style="width:15%"><?php echo $arr->profit ?></td>
                                    </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
                <div class="row" style="margin-top:20px;">
                    <div class="col-md-12">
                        <table class="table table-bordered" style="width: 30%;float: right;">
                            <tr>
                                <th width="50%">Total <?= lang("income"); ?>:</th>
                                <td width="50%" class="text-right"><?php echo $total_income; ?></td>
                            </tr>
                            <tr>
                                <th>Total <?= lang("cost"); ?>:</th>
                                <td class="text-right"><?php echo $total_cost; ?></td>
                            </tr>
                            <tr>
                                <th>Total <?= lang("profit"); ?>:</th>
                                <td class="text-right"><?php echo $total_profit; ?></td>
                            </tr>
                        </table>
                    </div>                    
                </div>
            </div>
        </div>
    </body>
    <script src="<?php echo base_url(); ?>themes/default/assets/plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function(){
            window.print();
        })
    </script>
</html>