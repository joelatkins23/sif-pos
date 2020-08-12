<?php

include "QRCodeGenerator.class.php";

function product_name($name)
{
    return character_limiter($name, (isset($Settings->char_per_line) ? ($Settings->char_per_line-8) : 35));
}

if ($modal) {
    echo '<div class="modal-dialog no-modal-header"><div class="modal-content"><div class="modal-body"><button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i></button>';
} else { ?>
    <!doctype html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Invoice</title>
        <base href="<?= base_url() ?>"/>
        <meta http-equiv="cache-control" content="max-age=0"/>
        <meta http-equiv="cache-control" content="no-cache"/>
        <meta http-equiv="expires" content="0"/>
        <meta http-equiv="pragma" content="no-cache"/>
        <link rel="shortcut icon" href="<?= $assets ?>images/icon.png"/>
        <link href="<?= $assets ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= $assets ?>plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />

        <!-- <link href="../../../../estilo.css" rel="stylesheet" type="text/css" />
        <link href="../../../../css/print.css" rel="stylesheet" type="text/css" />  
         -->
        <style>
            @page {
              size: A4;
              margin: 5mm;
            }
            @media print {
              html, body {
                width: 210mm !important;
                height: 297mm !important;
              }
              /* ... the rest of the rules ... */
            }



        </style>
        <style type="text/css" media="all">
            body { color: #000; }
            #wrapper { max-width: 780px; margin: 0 auto; padding-top: 20px; }
            .btn { border-radius: 0; margin-bottom: 5px; }
            .table { border-radius: 3px; }
            .table th { background: #f5f5f5; }
            .table th, .table td { vertical-align: middle !important; }
            h3 { margin: 5px 0; }
            .print_color{
                    color: #63c6bf !important;
                }
                .td-color{
                    background: #63c6bf !important;
                    color: white !important;
                    background-color: #63c6bf !important;
                    color: white !important;
                    width: 100%;
                    padding: 0px;
                    margin: 0px;
                    font-size: 18px;
                    padding: 5px 10px;
                }
                .tr-footer td{
                    font-weight: bold;
                }
                .print-spec{
                    min-height: 150px;
                }
            .print_header{
                position: relative !important;
            }

            @media print {
                .no-print { display: none; }
               
                .print_header{
                   
                }
                #wrapper { max-width: 780px; width: 100%; min-width: 250px; margin: 0 auto; }
                .print_color{
                    color: #63c6bf !important;
                }
                .print_color font{
                    color: #63c6bf !important;
                }
                .td-color{
                    background-color: #63c6bf !important;
                    color: white !important;
                    width: 100%;
                    padding: 0px;
                    margin: 0px;
                    font-size: 18px;
                    padding: 5px 0px;
                    padding-left: 5px !important;
                }
                .td-color font{
                    background-color: #63c6bf !important;
                    color: white !important;
                    width: 100%;
                    padding: 0px;
                    margin: 0px;
                    font-size: 18px;
                     padding: 5px 0px;
                    padding-left: 5px !important;
                }
              
            }
            p{
                margin: 0px;
            }

            .page-number:after {
                counter-increment: page;
                content: counter(page);

            }
            .total_table th{
                height: 50px;
                vertical-align: top;
                font-size: 16px;
            }
        </style>
    </head>

    <body>

<?php } ?>
<div id="wrapper" >

    <div id="receiptData" width="270px" height="" border="0"  cellpadding="12" cellspacing="5" class="resultado">
    <div class="no-print">
        <?php if ($message) { ?>
            <div class="alert alert-success">
                <a  href="<?= site_url('cash_sale'); ?>" class="btn btn-success"> <i class="glyphicon glyphicon-plus"></i> Voltar</a><button data-dismiss="alert" class="close" type="button">×</button>
                <?= is_array($message) ? print_r($message, true) : $message; ?>
            </div>
        <?php } ?>
    </div>
    <div  id="receipt-data">
        <div class="text-center" style="font-size: 12px;">
            <table style="width: 100%" class="print_header">
                <tr>
                    <td width="50%" style="text-align: left;">
                        <table style="width: 100%;">
                            <tr>
                                <td width="50%" style="text-align: left; padding-right: 20px;">
                                    <img src="<?php echo $assets; ?>images/header/principal2.PNG" alt="Logotipo"  width="205" height="105" border="0" />
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" style="padding-left: 5px;">
                                  <p style="font-size: 14px; font-weight: bold;"><p style="font-size: 14px; font-weight: bold;">
                                  <!--   <?= $Settings->CompanyName; ?> -->
                                    </p>
									
                                </td>
                            </tr>
                
                        </table>
                       
                        <table>
                            <tr>
                              <td>
                                    <img src="<?php echo $assets."/images/icon_print.png"; ?>">
                                </td>
                                <td valign="bottom">
									
                                    <p style="  padding: 1px 2px;">
                                        <?= $Settings->BusinessName; ?>
                                     </p>
                                    <p style="padding: 1px 2px;">
                                         
                                         <?= $Settings->AddressDetail; ?> 
                                     </p>
                                    <p style=" padding: 1px 2px;">
                                         
                                        <?= $Settings->TaxRegistrationNumber; ?>
                                    </p>
                                    <p style="padding: 1px 2px;">
                                        <?= $Settings->phone; ?>
                                    </p>
                                     <p style="padding: 1px 2px;">
                                        <?= $Settings->Email; ?>
                                    </p>
                                     <p style="padding: 1px 2px;"><?= $Settings->Website; ?></p>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="50%" style="text-align: left; padding-left: 10%; vertical-align: top; padding-top: 15px;">
                      <h2><p style="text-align: left; color: red !important; padding: 0px;"><span style="text-align: left; color: red !important; ">
                        <?php 
                                if($inv->InvoiceStatus == "A") echo lang("canceled");
                            ?>
                      </span></p>
                      </h2> 
                      <p class="print_color"  style="font-size: 36px;  text-align: left; ">
                            <?php
                                switch ($inv->InvoiceType) {
                                    case 'FR':
                                        echo lang("invoice_receipt");
                                        break;

                                    case 'FT':
                                        echo lang("invoice");
                                        break;
                                    
                                    case 'FP':
                                        echo lang("pro-forma");
                                        break;

                                    case 'VD':
                                        echo lang("cash_sale");
                                        break;
                                    default:
                                        # code...
                                        break;
                                }
                            ?>
                      </p>
                       
                        <p style="font-size: 16px;">
                           <b> <?= $inv->InvoiceNo;?></b>
                        </p>
                        <p style="font-weight: bold; padding-top: 12px; margin-top: 70px;"> 
                            <?= lang("dear_sir") ?> 
                        </p>
                        <p>
                            <?php    echo  $customer->name;?>
                        </p>
                        </p>
                        <p>
                             <?php  echo '<b style="font-size: 12px ">NIF: </b> ';echo $customer->cf1;?>
                      </p>
                        <p>
                            <?php  echo '<b style="font-size: 12px ">Morada: </b> ';echo $customer->endereco; ?>
                            
                        </p>
				<p>
                            <?php  echo $customer->estado; ?>
                            
                      </p>
                    </td>
                </tr>
            </table>
                 <!-- <?php include ("./empresa.php") ?> -->
            <table style="width: 100%; margin: 25px 0px;">
                <tr style="border-bottom: 1px solid black;">
                    <td style="width: 40%; text-align: left;">
                        <?php 
                            echo lang("issuance_date").": <b>".$this->tec->hrld($inv->date)."</b>";
                        ?>
                    </td>

                    <td style="width: 40%; text-align: left;">
                        <?php 
                            $date1 = date("d-m-Y H:i:s", strtotime( date( "Y-m-d H:i:s", strtotime( $inv->date ) ) . "+1 month" ) );

                            echo lang("expiration_date").": <b>".$date1."</b>";
                        ?>
                    </td>
                    <td style="text-align: right;">
                        <span id="print_order">
                            <?php
                                if($this->session->userdata("invoice_status") == "reprint") echo "ORIGINAL";
                                else echo "ORIGINAL";
                            ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;">
                        <span class="page-number">Pag. 1/</span>
                    </td>
                </tr>
            </table>
            <div class="print-spec">
                <table width="98%" height="45" class="table table-striped table-condensed" style="margin-top: 5px;">
                    <thead>
                        <tr>
                            <th class="print_color text-left"width="5%" ><?=lang('code');?></th>
                            <th class="print_color text-center" width="70%"><?=lang('description');?></th>
                            <th class="print_color text-right"width="9%"><?=lang('quantity');?></th>
                            <th class="print_color text-right"width="15%"><?=lang('P.Unit');?></th>
                            <th class="print_color text-right"width="10%"><?=lang('order_tax');?></th>
                            <th class="print_color text-right"width="9%"><?=lang('discount');?></th>
                            <th class="print_color text-right" width="10%"><?=lang('subtotal');?> </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $tax_summary = array();
                    foreach ($rows as $row) {
                        $item_infos = get_rows("tec_producs_list",array("product"=>$row->product_id));
                        $item_code = "";
                        foreach ($item_infos as $key => $item_info) {
                            $item_code .= "<br/>".$item_info['name'];
                        }
                        echo '<tr><td  style="font-size: 10px " align="left">' . product_name($row->product_code). '</td>';
                        if($item_code  != "")
                            echo '<td  style="font-size: 10px" width="70%"  align="left">'  . $row->product_name . $item_code.' </td>';
                        else 
                            echo '<td  style="font-size: 10px" width="70%"  align="left">'  .$row->product_name .  ' </td>';

                        echo '<td style="font-size: 10px" class="text-right">' . $this->tec->formatNumber($row->quantity) . '</td>';
                        echo '<td style="font-size: 10px" class="text-right">';

                        // if ($inv->total_discount != 0) {
                            $price_with_discount = $row->net_unit_price + $this->tec->formatDecimal($row->item_discount / $row->quantity);
                            $pr_tax = $row->tax_method ?
                            $this->tec->formatDecimal((($price_with_discount) * $row->tax) / 100) :
                            $this->tec->formatDecimal((($price_with_discount) * $row->tax) / (100 + $row->tax));
                            if($row->net_unit_price != $price_with_discount+$pr_tax)
                                echo '<del> ' . $this->tec->formatMoney(($price_with_discount+$pr_tax)) . '</del> ';
                        // }

                        echo $this->tec->formatMoney($row->net_unit_price) . '</td>';
                        echo '<td style="font-size: 10px" class="text-right">' . $this->tec->formatNumber($row->item_tax) . '</td>';
                        echo '<td style="font-size: 10px" class="text-right">' . $this->tec->formatNumber($row->item_discount) . '</td>';

                        echo '<td style="font-size: 10px" class="text-right">' . $this->tec->formatMoney($row->subtotal) . '</td></tr>'; 
                    }
              
                    ?>

                    </tbody>
                 
                </table>
            </div>
		   
            <table style="width: 100%; margin-top: 40px;">
                <tr style="border-bottom: 1px solid #ccc;">
                    <td colspan="3" style="text-align: left; font-size: 9px;"><?php echo lang("transport"); ?></td>
                </tr>
                <tr style="    border-bottom: 1px solid #ccc;"> 
                    <td style="width: 35%; vertical-align: top; text-align: center;">
                        <span style="text-align: left; font-size: 9px; display: inline-block; padding-top: 1px;">
                            <b><?php echo lang("ship_from"); ?></b>
                            <br/> 
                           <!--  <?= lang("BuildingNumber")." : ".$Settings->BuildingNumber ?>
                            <br/> -->
                           <!-- <?= $Settings->StreetName ?>
                            <br/>-->
                           <!-- <?= $Settings->AddressDetail ?>
                            <br/>-->
                            <?= $Settings->City ?>
                          <!--   <br/>
                            <?= $Settings->PostalCode ?> -->
                            <br/>
                            <?php echo $inv->date;  ?>

                        </span>
                    </td>
                    <td style="vertical-align: top; text-align: center;">
                    </td>
                    <td style="width: 35%; vertical-align: top; text-align: center;">
                        <span style="text-align: left; font-size: 9px; display: inline-block; padding-top: 1px;">

                            <b><?php echo lang("ship_to"); ?></b>
                            <br/> 
                           <!--  <?= lang("BuildingNumber")." : ".$Settings->BuildingNumber ?>
                            <br/> -->
                           <!--  <?= $customer->bairro ?>
                            <br/>-->
                            <?= $customer->cidade ?>
                            <br/>
                           <!--  <?= $customer->province ?>
                            <br/>
                            <?= $Settings->PostalCode ?> 
                            <br/>-->
                            <?php echo $inv->date;  ?>
                        </span>
                    </td>
                </tr>
            </table>
            <table style="width: 100%; margin-top: 10px;">
                <tr valign="top">
                    <td style="width: 60%; font-size: 10px;">
                        <table width="100%">
                            <tr valign="top" style="border-bottom: 1px solid black; background-color: #e4e3e3 !important;">
                                <td colspan="5" style="text-align: left; font-size: 9px;">
                                    <?php echo lang("tax_summary"); ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="10%" style="text-transform: uppercase; font-size: 9px;">
                                    <?= lang("tax_code"); ?>
                                </td>
                                <td width="10%" style="text-transform: uppercase; font-size: 9px">
                                    <?= lang("rate"); ?>
                                </td>
                                <td width="25%" style="text-transform: uppercase; font-size: 9px">
                                    <?= lang("incidence"); ?>
                                </td>
                                <td width="20%" style="text-transform: uppercase; font-size: 9px">
                                    <?= lang("tax"); ?>
                                </td>
                                <td style="text-transform: uppercase; font-size: 9px">
                                    <?= lang("tax_reason"); ?>
                                </td>
                            </tr>
                            <?php
							   $this->db->order_by('id', 'asc');
                                $sale_items = get_rows("tec_sale_items",array("sale_id"=>$inv->id));
                                $no = 0;
                                foreach ($sale_items as $key => $sale_item) {
                                    $product_info = get_row("tec_products",array("id"=>$sale_item['product_id']));
                                    if($product_info['tax_id']*1 == 0) continue;
                                    if($no>0) continue;
                                    $no++;
                                    $tax_info = get_row("tec_tax",array("id"=>$product_info['tax_id']));
                                    echo "<tr>";
                                    echo '<td>'.$tax_info['tax_code'].'</td>';
                                    echo '<td>'.$tax_info['tax'].'(%)</td>';
                                    echo '<td>'.$inv->total.'</td>';
                                    echo '<td>'.$inv->product_tax.'</td>';
                                    // if($tax_info['tax_code'] == "ISE")
                                        echo '<td style="font-size:10px;">'.$tax_info['reason'].'</td>';
                                    // else
                                        // echo "<td></td>"; 

                                    echo "</tr>";
                                }
                            ?>
                        </table>
                      <table width="100%" style="margin-top: 1px;">
                            <tr style="border-bottom: 1px solid black; background-color: #e4e3e3 !important;">
                                <td   style="text-align: left; font-size: 9px; text-transform: uppercase;">
                                    <?php echo lang("payment_details"); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                            <?php
            // print_r($payments)
                            if ($payments) {
                                echo '<table class="table table-striped table-condensed"><tbody>';
                                foreach ($payments as $payment) {
                                    echo '<tr class="tr-footer">';
                                    if ($payment->paid_by == 'cash' && $payment->pos_paid) {
                                        echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                                        echo '<td>' . lang("amount") . ': ' . $this->tec->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . '</td>';
                                        echo '<td>' . lang("change") . ': ' . ($payment->pos_balance > 0 ? $this->tec->formatMoney($payment->pos_balance) : 0) . '</td>';
                                    }
                                    if ($payment->paid_by == 'CC'  && $payment->pos_paid) {
                                        echo '<td>' . lang("paid_by") . ': ' . Multicaixa . '</td>';
                                        echo '<td>' . lang("amount") . ': ' . $this->tec->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . '</td>';
                                         echo '<td>' . lang("change") . ': ' . ($payment->pos_balance > 0 ? $this->tec->formatMoney($payment->pos_balance) : 0) . '</td>';
                                         
                                    }
                                    if ($payment->paid_by == 'Cheque' && $payment->cheque_no) {
                                        echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                                        echo '<td>' . lang("amount") . ': ' . $this->tec->formatMoney($payment->pos_paid) . '</td>';
                                        echo '<td>' . lang("cheque_no") . ': ' . $payment->cheque_no . '</td>';
                                    }
                                    if ($payment->paid_by == 'gift_card' && $payment->pos_paid) {
                                        echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                                        echo '<td>' . lang("no") . ': ' . $payment->gc_no . '</td>';
                                        echo '<td>' . lang("amount") . ': ' . $this->tec->formatMoney($payment->pos_paid) . '</td>';
                                        echo '<td>' . lang("balance") . ': ' . ($payment->pos_balance > 0 ? $this->tec->formatMoney($payment->pos_balance) : 0) . '</td>';
                                    }
                                    if ($payment->paid_by == 'other' && $payment->amount) {
                                        echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                                        echo '<td>' . lang("amount") . ': ' . $this->tec->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . '</td>';
                                        echo $payment->note ? '</tr><td colspan="2">' . lang("payment_note") . ': ' . $payment->note . '</td>' : '';
                                    }
                                    echo '</tr>';
                                }
                                echo '</tbody></table>';
                                
                                $ex1 = new QRCodeGenerator('http://www.nfe.fazenda.gov.br/portal/consulta.aspx?tipoConsulta=completa&tipoConteudo=XbSeqxE8pl8=MobLanche_PDVPARATODOS.COM.BR');
                               
                            }

                            ?>
                                </td>
                            </tr>
                        </table>
                        
                      <p style="text-align: left;font-size: 9px;padding-bottom: 1px;"><div class="well well-sm" align="left" >
                <?= $Settings->footer; ?>
            </div></p>
                   <p style="text-align: left;font-size: 12px;padding-bottom: 10px;">
                            <?php
                                $hash_str = $inv->Hash;
                            ?>
                        <?php echo substr($hash_str, 0,1).substr($hash_str, 10,1).substr($hash_str, 20,1).substr($hash_str, 30,1) ; ?>-Processado por programa validado nº 230/AGT/2019</p>     
                  </td>
                    <td style="width: 40%; padding-left: 20px; vertical-align: top;">
                        <table style="width: 100%; font-size: 12px;" class="total_table">
                            <tr> 
                                <th height="2"  style="font-size: 12px;"><?= lang("total"); ?></th>
                                <th  style="font-size: 12px;" class="text-right"><?= $this->tec->formatMoney($inv->total); ?></th>
                            </tr>
                            <tr>
                                <th height="2" style="font-size: 12px" ><?= lang("tax"); ?></th>
                                <th  class="text-right" style="font-size: 12px"><?= $this->tec->formatMoney( $inv->product_tax); ?></th>
                            </tr>
                            <?php
                            if ($inv->order_tax != 0) {
                                echo '<tr><th >' . lang("order_tax") . '</th><th class="text-right">' . $this->tec->formatMoney($inv->order_tax) . '</th></tr>';
                            }
                            if ($inv->total_discount != 0) {
                                echo '<tr> <th>' . lang("order_discount") . '</th><th class="text-right">' . $this->tec->formatMoney($inv->total_discount) . '</th></tr>';
                            }

                            if ($Settings->rounding) {
                                $round_total = $this->tec->roundNumber($inv->grand_total, $Settings->rounding);
                                $rounding = $this->tec->formatMoney($round_total - $inv->grand_total);
                            ?>
                                <tr>
                                    <th height="2" style="font-size: 14px" ><?= lang("rounding"); ?></th>
                                    <th  class="text-right" style="font-size: 14px"><?= $rounding; ?></th>
                                </tr>
                                <tr>
                                    <th  style="padding: 0px;"><p class="td-color" style="font-size: 12px"><?= lang("grand_total"); ?></p>
                                    <p class="td-color" style="font-size: 12px">&nbsp;</p></th>
                                    <th  style="padding: 0px;"><p class="td-color" style="text-align: right; font-size: 12px;"><?= $this->tec->formatMoney($inv->grand_total); ?></p></th>
                                </tr>
                            <?php
                            } else {
                                $round_total = $inv->grand_total;
                                ?>
                                <tr>
                                    <th style="padding: 0px;"><p class="td-color" style="font-size: 14px"><?= lang("grand_total"); ?></p></th>
                                    <th style="padding: 0px;"><p class="td-color" style="text-align: right; font-size: 14px;"><?= $this->tec->formatMoney($inv->grand_total); ?></p></th>
                                </tr>
                            <?php }

                            if ($inv->paid < $round_total) { ?>
                                <tr>
                                    <th style="font-size: 12px" ><?= lang("paid_amount"); ?></th>
                                    <th class="text-right" style="padding: 0px; font-size: 12px;"><?= $this->tec->formatMoney($inv->paid); ?></th>
                                </tr>
                                <tr>
                                    <th style="font-size: 12px" ><?= lang("due_amount"); ?></th>
                                    <th  class="text-right" style="font-size: 12px"><?= $this->tec->formatMoney($inv->grand_total - $inv->paid); ?></th>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
            </table>
            <style type="text/css">
                .no-screen-tr{
                    display: none;
                }
                .no-screen-p{
                    display: none;
                }
                @media print{
                    .print-spec{
                        min-height: <?php if ($inv->paid < $round_total)  echo "320px"; else echo "320px"; ?>  !important;
                    }      
                    .no-screen-tr{
                        display: table-row;
                    }
                    .no-screen-tr td{
                        border:0px !important;
                    }
                    .no-screen-p{
                        display: block;
                    }
                }
                .total_table th{
                    height: <?php if ($inv->paid < $round_total)  echo "35px"; else echo "50px"; ?> ;
                    vertical-align:middle;
                }
            </style>
              
            <p style="text-align: right; font-weight: bold;">
            <?php echo '<b style="font-size: 12px ">Operador:</b>'; ?> <?= $this->session->userdata('username'); ?>
            </p>
           <p style="text-align: left; font-size: 12px;">
                            <strong>Extenso</strong>:
<?php
                                echo extenstotal($inv->grand_total);
                                // $dim_mes = extenstotal($total_pagar);

                            function extenstotal($total_pagar = 0, $maiusculas = false) { 
                                $singular = array("centimos", "Kwanza", "Mil", "milhão", "bilhão", "trilhão", "quatrilhão"); 
                                $plural = array("centimos", "Kwanzas", "Mil", "milhões", "bilhões", "trilhões", 
                                "quatrilhões"); 

                                $c = array("", "Cem", "Duzentos", "Trezentos", "Quatrocentos", 
                                "Quinhentos", "Seiscentos", "Setecentos", "Oitocentos", "Novecentos"); 
                                $d = array("", "Dez", "Vinte", "Trinta", "Quarenta", "Cinquenta", 
                                "Sessenta", "Setenta", "Oitenta", "Noventa"); 
                                $d10 = array("Dez", "Onze", "Doze", "Treze", "Catorze", "Quinze", 
                                "Dezasseis", "Dezasete", "Dezoito", "Dezanove"); 
                                $u = array("", "Um", "Dois", "Três", "Quatro", "Cinco", "Seis", 
                                "Sete", "Oito", "Nove"); 

                                $z = 0; 
                                $rt = "";

                                $total_pagar = number_format($total_pagar, 2, ".", "."); 
                                $inteiro = explode(".", $total_pagar); 
                                for($i=0;$i<count($inteiro);$i++) 
                                for($ii=strlen($inteiro[$i]);$ii<3;$ii++) 
                                $inteiro[$i] = "0".$inteiro[$i]; 

                                $fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2); 
                                for ($i=0;$i<count($inteiro);$i++) { 
                                $total_pagar = $inteiro[$i]; 
                                $rc = (($total_pagar > 100) && ($total_pagar < 200)) ? "cento" : $c[$total_pagar[0]]; 
                                $rd = ($total_pagar[1] < 2) ? "" : $d[$total_pagar[1]]; 
                                $ru = ($total_pagar > 0) ? (($total_pagar[1] == 1) ? $d10[$total_pagar[2]] : $u[$total_pagar[2]]) : ""; 

                                $r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && 
                                $ru) ? " e " : "").$ru; 
                                $t = count($inteiro)-1-$i; 
                                $r .= $r ? " ".($total_pagar > 1 ? $plural[$t] : $singular[$t]) : ""; 
                                if ($total_pagar == "000")$z++; elseif ($z > 0) $z--; 
                                if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t]; 
                                if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && 
                                ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r; 
                                } 

                                if(!$maiusculas){ 
                                return($rt ? $rt : "zero"); 
                                } else { 

                                if ($rt) $rt=ereg_replace(" E "," e ",ucwords($rt));
                                return (($rt) ? ($rt) : "Zero"); 
                                } 

                            } 
                            ?>
          </p>
             
          <table style="width: 100%; margin-top: 1px;">
                <tr style="border-bottom: 1px solid #ccc;">
                    <td style="text-align: left; font-size: 10px;"><?php echo lang("OBS:"); ?></td>
                </tr>
                <tr > 
                    <td align="left" style="text-align: left; font-size: 8px;">
                      
						
                            <?php 
						$c = preg_replace('/\r\n|\r|\n/',"<br>", $inv->note);
echo $c;
						 ?>
                            
                    </td>
                </tr>
            </table>
            
        </div>
        <div style="clear:both;"></div>
    </div>
<?php if ($modal) {
    echo '</div></div></div></div>';
} else { ?>
<div id="buttons" style="padding-top:10px; text-transform:uppercase;" class="no-print">
    <hr>
    <?php if ($message) { ?>
    <div class="alert alert-success">
        <button data-dismiss="alert" class="close" type="button">×</button>
        <?= is_array($message) ? print_r($message, true) : $message; ?>
    </div>
<?php } ?>

    <?php if ($Settings->java_applet) { ?>
        <span class="col-xs-12"><a class="btn btn-block btn-primary" onClick="printReceipt()"><?= lang("print"); ?></a></span>
        <span class="col-xs-12"><a class="btn btn-block btn-info" type="button" onClick="openCashDrawer()"><?= lang('open_cash_drawer'); ?></a></span>
        <div style="clear:both;"></div>
    <?php } else { ?>
        <span class="pull-right col-xs-12">
        <a href="javascript:window.print()" id="web_print" class="btn btn-block btn-primary"
           onClick="window.print();return false;"><?= lang("web_print"); ?></a>
    </span>
    <?php } ?>
    <span class="pull-left col-xs-12"><a class="btn btn-block btn-success" href="#" id="email"><?= lang("email"); ?></a></span>

    <span class="col-xs-12">
        <a class="btn btn-block btn-warning" href="<?= site_url('pos'); ?>"><?= lang("back_to_pos"); ?></a>
    </span>
    <?php if (!$Settings->java_applet) { ?>
        <div style="clear:both;"></div>
        <font>
    <?php } ?>
    <div style="clear:both;"></div>

</div>

</div>
<canvas id="hidden_screenshot" style="display:none;">

</canvas>

<div class="canvas_con" style="display:none;"></div>
<script src="<?= $assets ?>plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
<?php if ($Settings->java_applet) {

        function drawLine($Settings)
        {
            $size = $Settings->char_per_line;
            $new = '';
            for ($i = 1; $i < $size; $i++) {
                $new .= '-';
            }
            $new .= ' ';
            return $new;
        }

        function printLine($str, $Settings, $sep = ":", $space = NULL)
        {
            $size = $space ? $space : $Settings->char_per_line;
            $lenght = strlen($str);
            list($first, $second) = explode(":", $str, 2);
            $new = $first . ($sep == ":" ? $sep : '');
            for ($i = 1; $i < ($size - $lenght); $i++) {
                $new .= ' ';
            }
            $new .= ($sep != ":" ? $sep : '') . $second;
            return $new;
        }

        function printText($text, $Settings)
        {
            $size = $Settings->char_per_line;
            $new = wordwrap($text, $size, "\\n");
            return $new;
        }

        function taxLine($name, $code, $qty, $amt, $tax)
        {
            return printLine(printLine(printLine(printLine($name . ':' . $code, '', 18) . ':' . $qty, '', 25) . ':' . $amt, '', 35) . ':' . $tax, ' ');
        }

        ?>

        <script type="text/javascript" src="<?= $assets ?>plugins/qz/js/deployJava.js"></script>
        <script type="text/javascript" src="<?= $assets ?>plugins/qz/qz-functions.js"></script>
        <script type="text/javascript">
            deployQZ('themes/<?=$Settings->theme?>/assets/plugins/qz/qz-print.jar', '<?= $assets ?>plugins/qz/qz-print_jnlp.jnlp');
            usePrinter("<?= $Settings->receipt_printer; ?>");
            <?php /*$image = $this->tec->save_barcode($inv->reference_no);*/ ?>
            function printReceipt() {
                //var barcode = 'data:image/png;base64,<?php /*echo $image;*/ ?>';
                receipt = "";
                receipt += chr(27) + chr(69) + "\r" + chr(27) + "\x61" + "\x31\r";
                receipt += "<?= printText(strip_tags(preg_replace('/\s+/',' ', $Settings->header)), $Settings); ?>" + "\n";
                receipt += " \x1B\x45\x0A\r ";
                receipt += "<?=drawLine($Settings);?>\r\n";
                //receipt += "<?php // if($Settings->invoice_view == 1) { echo lang('tax_invoice'); } ?>\r\n";
                //receipt += "<?php // if($Settings->invoice_view == 1) { echo drawLine(); } ?>\r\n";
                receipt += "\x1B\x61\x30";
                receipt += "<?= printLine(lang("sale_no") . ": " . $inv->id, $Settings) ?>" + "\n";
                receipt += "<?= printLine(lang("sales_person") . ": " . $created_by->first_name." ".$created_by->last_name, $Settings); ?>" + "\n";
                receipt += "<?= printLine(lang("customer") . ": " . $inv->customer_name, $Settings); ?>" + "\n";
                receipt += "<?= printLine(lang("date") . ": " . $this->tec->hrld($inv->date), $Settings); ?>" + "\n\n";
                receipt += "<?php $r = 1;
            foreach ($rows as $row): ?>";
                receipt += "<?= "#" . $r ." "; ?>";
                receipt += "<?= product_name(addslashes($row->product_name)); ?>" + "\n";
                receipt += "<?= printLine($this->tec->formatNumber($row->quantity)."x".$this->tec->formatMoney($row->net_unit_price+($row->item_tax/$row->quantity)) . ":  ". $this->tec->formatMoney($row->subtotal), $Settings, ' ') . ""; ?>" + "\n";
                receipt += "<?php $r++;
            endforeach; ?>";
                receipt += "\x1B\x61\x31";
                receipt += "<?=drawLine($Settings);?>\r\n";
                receipt += "\x1B\x61\x30";
                receipt += "<?= printLine(lang("total") . ": " . $this->tec->formatMoney($inv->total+$inv->product_tax), $Settings); ?>" + "\n";
                <?php if ($inv->order_tax != 0) { ?>
                receipt += "<?= printLine(lang("tax") . ": " . $this->tec->formatMoney($inv->order_tax), $Settings); ?>" + "\n";
                <?php } ?>
                <?php if ($inv->total_discount != 0) { ?>
                receipt += "<?= printLine(lang("discount") . ": " . $this->tec->formatMoney($inv->total_discount), $Settings); ?>" + "\n";
                <?php } ?>
                <?php if($Settings->rounding) { ?>
                receipt += "<?= printLine(lang("rounding") . ": " . $rounding, $Settings); ?>" + "\n";
                receipt += "<?= printLine(lang("grand_total") . ": " . $this->tec->formatMoney($inv->grand_total + $rounding), $Settings); ?>" + "\n";
                <?php } else { ?>
                receipt += "<?= printLine(lang("grand_total") . ": " . $this->tec->formatMoney($inv->grand_total), $Settings); ?>" + "\n";
                <?php } ?>
                <?php if($inv->paid < $inv->grand_total) { ?>
                receipt += "<?= printLine(lang("paid_amount") . ": " . $this->tec->formatMoney($inv->paid), $Settings); ?>" + "\n";
                receipt += "<?= printLine(lang("due_amount") . ": " . $this->tec->formatMoney($inv->grand_total-$inv->paid), $Settings); ?>" + "\n\n";
                <?php } ?>
                <?php
                if($payments) {
                    foreach($payments as $payment) {
                        if ($payment->paid_by == 'cash' && $payment->pos_paid) { ?>
                receipt += "<?= printLine(lang("paid_by") . ": " . lang($payment->paid_by), $Settings); ?>" + "\n";
                receipt += "<?= printLine(lang("amount") . ": " . $this->tec->formatMoney($payment->pos_paid), $Settings); ?>" + "\n";
                receipt += "<?= printLine(lang("change") . ": " . ($payment->pos_balance > 0 ? $this->tec->formatMoney($payment->pos_balance) : 0), $Settings); ?>" + "\n";
                <?php } if (($payment->paid_by == 'CC' || $payment->paid_by == 'ppp' || $payment->paid_by == 'stripe') && $payment->cc_no) { ?>
                receipt += "<?= printLine(lang("paid_by") . ": " . lang($payment->paid_by), $Settings); ?>" + "\n";
                receipt += "<?= printLine(lang("amount") . ": " . $this->tec->formatMoney($payment->pos_paid), $Settings); ?>" + "\n";
                receipt += "<?= printLine(lang("card_no") . ": xxxx xxxx xxxx " . substr($payment->cc_no, -4), $Settings); ?>" + "\n";
                <?php  } if ($payment->paid_by == 'gift_card') { ?>
                receipt += "<?= printLine(lang("paid_by") . ": " . lang($payment->paid_by), $Settings); ?>" + "\n";
                receipt += "<?= printLine(lang("amount") . ": " . $this->tec->formatMoney($payment->pos_paid), $Settings); ?>" + "\n";
                receipt += "<?= printLine(lang("card_no") . ": " . $payment->gc_no, $Settings); ?>" + "\n";
                <?php } if ($payment->paid_by == 'Cheque' && $payment->cheque_no) { ?>
                receipt += "<?= printLine(lang("paid_by") . ": " . lang($payment->paid_by), $Settings); ?>" + "\n";
                receipt += "<?= printLine(lang("amount") . ": " . $this->tec->formatMoney($payment->pos_paid), $Settings); ?>" + "\n";
                receipt += "<?= printLine(lang("cheque_no") . ": " . $payment->cheque_no, $Settings); ?>" + "\n";
                <?php if ($payment->paid_by == 'other' && $payment->amount) { ?>
                receipt += "<?= printLine(lang("paid_by") . ": " . lang($payment->paid_by), $Settings); ?>" + "\n";
                receipt += "<?= printLine(lang("amount") . ": " . $this->tec->formatMoney($payment->amount), $Settings); ?>" + "\n";
                receipt += "<?= printText(lang("payment_note") . ": " . $payment->note, $Settings); ?>" + "\n";
                <?php }
            }

        }
    }

    /* if($Settings->invoice_view == 1) {
        if(!empty($tax_summary)) {
    ?>
                receipt += "\n" + "<?= lang('tax_summary'); ?>" + "\n";
                receipt += "<?= taxLine(lang('name'),lang('code'),lang('qty'),lang('tax_excl'),lang('tax_amt')); ?>" + "\n";
                receipt += "<?php foreach ($tax_summary as $summary): ?>";
                receipt += "<?= taxLine($summary['name'],$summary['code'],$this->tec->formatNumber($summary['items']),$this->tec->formatMoney($summary['amt']),$this->tec->formatMoney($summary['tax'])); ?>" + "\n";
                receipt += "<?php endforeach; ?>";
                receipt += "<?= printLine(lang("total_tax_amount") . ":" . $this->tec->formatMoney($inv->product_tax)); ?>" + "\n";
                <?php
                    }
                } */
                ?>
                receipt += "\x1B\x61\x31";
                <?php if ($inv->note) { ?>
                receipt += "<?= printText(strip_tags(preg_replace('/\s+/',' ', $this->tec->decode_html($inv->note))), $Settings); ?>" + "\n";
                <?php } ?>
                receipt += "<?= printText(strip_tags(preg_replace('/\s+/',' ', $Settings->footer)), $Settings); ?>" + "\n";
                receipt += "\x1B\x61\x30";
                <?php if(isset($Settings->cash_drawer_cose)) { ?>
                print(receipt, '', '<?=$Settings->cash_drawer_cose;?>');
                <?php } else { ?>
                print(receipt, '', '');
                <?php } ?>

            }

        </script>
    <?php } ?>
            <script type="text/javascript">
                $(document).ready(function () {
                    $('#email').click(function () {
                        var email = prompt("<?= lang("email_address"); ?>", "<?= $customer->email; ?>");
                        if (email != null) {
                            $.ajax({
                                type: "post",
                                url: "<?= site_url('pos/email_receipt') ?>",
                                data: {<?= $this->security->get_csrf_token_name(); ?>: "<?= $this->security->get_csrf_hash(); ?>", email: email, id: <?= $inv->id; ?>},
                                dataType: "json",
                                success: function (data) {
                                    alert(data.msg);
                                },
                                error: function () {
                                    alert('<?= lang('ajax_request_failed'); ?>');
                                    return false;
                                }
                            });
                        }
                        return false;
                    });
                });
        <?php if (!$Settings->java_applet && !$noprint) { ?>
        $(window).load(function () {
            window.print();
        });
    <?php } ?>
            </script>
        <script type="text/javascript">
            window.addEventListener('afterprint', (event) => {
              $("#print_order").html("2Via");
            });

        </script>
</body>
</table >
</html>
<?php } ?>
