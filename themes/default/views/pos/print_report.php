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
        <link href="<?= $assets ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        
    </head>
    <body class="with-promo-space22">
        <div class="modal-body" style="width: 80%; margin: 0px auto; font-size: 12px;">
            <table width="100%" class="stable">
                <tr>
                    <td colspan="2" align="center" valign="middle" style="border-bottom: 1px solid #EEE;"><h5><b>
                      <?= $this->Settings->CompanyName; ?>
                      <br>
                      <?= $this->Settings->TaxRegistrationNumber; ?>
                      <br>
                      <?= $this->Settings->AddressDetail; ?>
                      <br>
                      <?= $this->Settings->phone;; ?>
                    </b></h5></td>
                </tr>
				<tr>
                    <td style="border-bottom: 1px solid #EEE;"><h5><?= lang('cash_in_hand'); ?>:</h5></td>
                    <td style="text-align:right; border-bottom: 1px solid #EEE;"><h5>
                            <span><?= $this->tec->formatMoney($this->session->userdata('cash_in_hand')); ?></span></h5>
                    </td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #EEE;"><h5><?= lang('cash_sale'); ?>:</h5></td>
                    <td style="text-align:right; border-bottom: 1px solid #EEE;"><h5>
                            <span><?= $this->tec->formatMoney($cashsales->paid ? $cashsales->paid : '0.00') . ' (' . $this->tec->formatMoney($cashsales->total ? $cashsales->total : '0.00') . ')'; ?></span>
                        </h5></td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #EEE;"><h5>Cartão:</h5></td>
                    <td style="text-align:right;border-bottom: 1px solid #EEE;"><h5>
                            <span><?= $this->tec->formatMoney($chsales->paid ? $chsales->paid : '0.00') . ' (' . $this->tec->formatMoney($chsales->total ? $chsales->total : '0.00') . ')'; ?></span>
                        </h5></td>
                </tr>
                <tr>
                    <td width="300" style="font-weight:bold;"><h5><?= lang('total_sales'); ?>:</h5></td>
                    <td width="200" style="font-weight:bold;text-align:right;"><h5>
                            <span><?= $this->tec->formatMoney($totalsales->paid ? $totalsales->paid : '0.00') . ' (' . $this->tec->formatMoney($totalsales->total ? $totalsales->total : '0.00') . ')'; ?></span>
                        </h5></td>
                </tr>

                <tr>
                    <td width="300" style="font-weight:bold;"><h5><?= lang('expenses'); ?>:</h5></td>
                    <td width="200" style="font-weight:bold;text-align:right;"><h5>
                            <span><?= $this->tec->formatMoney($expenses->total ? $expenses->total : '0.00'); ?></span>
                        </h5></td>
                </tr>
                <?php $total_cash = ($cashsales->paid ? $cashsales->paid + ($cash_in_hand ? $cash_in_hand : $this->session->userdata('cash_in_hand')) : (($cash_in_hand ? $cash_in_hand : $this->session->userdata('cash_in_hand'))));
                $total_cash -= ($expenses->total ? $expenses->total : 0.00);
                ?>
                <tr>
                    <td width="300" style="font-weight:bold;"><h5><strong><?= lang('total_cash'); ?></strong>:</h5>
                    </td>
                    <td style="text-align:right;"><h5>
                            <span><strong><?= $this->tec->formatMoney($total_cash); ?></strong></span>
                        </h5></td>
                </tr>
				 <tr>
                    <td colspan="2" style="font-weight:bold;"><h5><span style="text-align: right; font-weight: bold;"> <?php echo '<b style="font-size: 12px ">Operador:</b>'; ?>
                          <?= $this->session->userdata('username'); ?>
                    </span></h5>               <?= lang('opened_at').': '.$this->tec->hrld($this->session->userdata('register_open_time')) ?>  <br>   <b style="font-size: 12px ">Fechado em:  <?php echo date("d-m-Y") ?> <?php echo date("H:m:s");?></b></td>
                </tr>
            </table>


                <?php

                if ($suspended_bills) {
                    echo '<hr><h5>' . lang('opened_bills') . '</h5><table class="table table-hovered table-bordered"><thead><tr><th>' . lang('customer') . '</th><th>' . lang('date') . '</th><th>' . lang('Mesa') . '</th><th>' . lang('amount') . '</th></tr></thead><tbody>';
                    foreach ($suspended_bills as $bill) {
                        echo '<tr><td>' . $bill->customer_name . '</td><td>' . $this->tec->hrld($bill->date) . '</td><td class="col-xs-4">' . $bill->hold_ref . '</td><td class="text-right">' . $bill->grand_total . '</td></tr>';
                    }
                    echo '</tbody></table>';

                    //          echo '<hr><h5>' . lang('opened_bills') . '</h5><table class="table table-hovered table-bordered"><thead><tr><th>' . lang('customer') . '</th><th>' . lang('date') . '</th><th>' . lang('reference') . '</th><th>' . lang('amount') . '</th><th><i class="fa fa-trash-o"></i></th></tr></thead><tbody>';
                    // foreach ($suspended_bills as $bill) {
                    //     echo '<tr><td>' . $bill->customer_name . '</td><td>' . $this->tec->hrld($bill->date) . '</td><td class="col-xs-4">' . $bill->hold_ref . '</td><td class="text-right">' . $bill->grand_total . '</td><td class="text-center"><a class="tip" title="' . lang("delete_bill") . '" href="' . site_url('sales/delete_holded/' . $bill->id) . '" onclick="return confirm(\''.lang('alert_x_holded').'\')"><i class="fa fa-trash-o"></i></a></td></tr>';
                    // }
                    // echo '</tbody></table>';
                }

                ?>
                <hr>
                <div class="row">
                    <div class="col-sm-6 hidden">
                        <div class="form-group">
                            <?= lang("total_cash", "total_cash_submitted"); ?>
                            <?= form_hidden('total_cash', $total_cash); ?>
                            <?= form_input('total_cash_submitted', (isset($_POST['total_cash_submitted']) ? $_POST['total_cash_submitted'] : $total_cash), 'class="form-control input-tip" id="total_cash_submitted" required="required"'); ?>
                        </div>
                        <div class="form-group">
                            <?= lang("total_cheques", "total_cheques_submitted"); ?>
                            <?= form_hidden('total_cheques', $chsales->total_cheques); ?>
                            <?= form_input('total_cheques_submitted', (isset($_POST['total_cheques_submitted']) ? $_POST['total_cheques_submitted'] : $chsales->total_cheques), 'class="form-control input-tip" id="total_cheques_submitted" required="required"'); ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php if ($suspended_bills) { ?>
                            <div class="form-group hidden">
                                <?= lang("transfer_opened_bills", "transfer_opened_bills"); ?>
                                <?php $u = $user_id ? $user_id : $this->session->userdata('user_id');
                                $usrs[-1] = lang('delete_all');
                                $usrs[0] = lang('leave_opened');
                                foreach ($users as $user) {
                                    if ($user->id != $u) {
                                        $usrs[$user->id] = $user->first_name . ' ' . $user->last_name;
                                    }
                                }
                                ?>
                                <div class="clearfix"></div>
                                <?= form_dropdown('transfer_opened_bills', $usrs, (isset($_POST['transfer_opened_bills']) ? $_POST['transfer_opened_bills'] : 0), 'class="form-control input-tip select2" id="transfer_opened_bills" required="required" style="width:100%;"'); ?>
                            </div>
                        <?php } ?>
                        <div class="form-group hidden">
                            <?= lang("total_cc_slips", "total_cc_slips_submitted"); ?>
                            <?= form_hidden('total_cc_slips', $ccsales->total_cc_slips); ?>
                            <?= form_input('total_cc_slips_submitted', (isset($_POST['total_cc_slips_submitted']) ? $_POST['total_cc_slips_submitted'] : $ccsales->total_cc_slips), 'class="form-control input-tip" id="total_cc_slips_submitted" required="required"'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="note"><?= lang("note"); ?></label>
                    <?= form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ""), 'class="form-control redactor" id="note" style="margin-top: 10px; height: 100px; resize:none;"', 'readonly="true'); ?>
                </div>

            </div>
           
        </div>
    </body>
    <script src="<?php echo base_url(); ?>themes/default/assets/plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function(){
            $("#note").val(window.localStorage.getItem('note'));
            window.print();
        })
    </script>
</html>