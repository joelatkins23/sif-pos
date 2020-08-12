<?php
(defined('BASEPATH')) OR exit('No direct script access allowed');
require realpath(__DIR__) . '/../../../../vendor/autoload.php';
$suspend = '';
if (!empty($_GET['hold'])) {
    $suspend = Func::array_table('tec_suspended_sales', array("id" => $_GET['hold']));
}
?> 
<section class="content">
            <div class="">
                <div class="col-lg-12 alerts">
                    <?php if ($error) { ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            <h4><i class="icon fa fa-ban"></i> <?= lang('error'); ?></h4>
                            <?= $error; ?>
                        </div>
                    <?php } if ($message) { ?>
                        <div class="alert alert-success alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            <h4><i class="icon fa fa-check"></i> <?= lang('Success'); ?></h4>
                            <?= $message; ?>
                        </div>
                    <?php } ?>
                </div>

                <div id="box_left">

                    <div id="pos">
                        <?= form_open('sales/update_invoice', 'id="pos-sale-form"'); ?>
                        <div class="well well-sm" id="leftdiv">
                            <div id="lefttop" style="margin-bottom:3px;">
                                <div class="form-group" style="margin-bottom:3px; display: none;">
                                    <div class="input-group">
                                        <?php
                                        foreach ($customers as $customer) {
                                            $cus[$customer->id] = $customer->name . ' | ' . $customer->phone . ' | ' . $customer->cf2 . ' | ' . $customer->endereco . ' ' . $customer->numero . ' ' . $customer->bairro;
                                        }
                                        ?>
                                        <?= form_dropdown('customer_id', $cus, set_value('customer_id', $Settings->default_customer), 'id="spos_customer" data-placeholder="' . lang("select") . ' ' . lang("customer") . '" required="required" class="form-control select2" style="width:100%;"'); ?>
                                        <div class="input-group-addon no-print" style="padding: 2px 5px;">
                                            <a href="#" id="add-customer" class="external" data-toggle="modal" data-target="#myModal"><i class="fa fa-2x fa-plus-circle" id="addIcon"></i></a>
                                        </div>
                                    </div>
                                    <div style="clear:both;"></div>
                                </div>
                                <div class="form-group" style="margin-bottom:3px;">
                                    <label style="color: white;"><?php echo lang("add_product"); ?></label>
                                    <input type="text" name="code" id="add_item" class="form-control" placeholder="<?= lang('search__scan') ?>" />
                                </div>

                                <div class="form-group" style="margin-bottom:3px;">
                                    <label style="color: white;"><?php echo lang("reason"); ?></label>
                                    <textarea style="height: 70px;" name="Reason"  class="form-control" ><?php echo $sale->Reason; ?></textarea>
                                </div>


                            </div>
                            
                            <div id="print">
                                <div id="list-table-div" style="border: 1px solid #ccc; background: white; min-height: calc(100VH - 500px);">
                                    <table id="posTable" class="table table-striped table-condensed table-hover list-table" style="margin:0;">
                                        <thead>
                                            <tr class="success">
                                                <th><?= lang('product') ?></th>
                                                <th style="width: 15%;text-align:center;"><?= lang('price') ?></th>
                                                <th style="width: 15%;text-align:center;"><?= lang('qty') ?></th>
                                                <th style="width: 20%;text-align:center;"><?= lang('subtotal') ?></th>
                                                <th style="width: 20px;" class="satu"><i class="fa fa-trash-o"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <div style="clear:both;"></div>
                                <div id="totaldiv">
                                    <table id="totaltbl" class="table table-condensed totals" style="margin-bottom:10px;">
                                        <tbody>
                                            <tr class="info">
                                                <td width="25%"><?= lang('total_items') ?></td>
                                                <td class="text-right" style="padding-right:10px;"><span id="count">0</span></td>
                                                <td width="25%"><?= lang('total') ?></td>
                                                <td class="text-right" colspan="2"><span id="total">0</span></td>
                                            </tr>
                                            <tr class="info">
                                                <td width="25%"><a href="#" id="add_discount"><?= lang('discount') ?></a></td>
                                                <td class="text-right" style="padding-right:10px;"><span id="ds_con">0</span></td>
                                                <td width="25%"><a href="#" id="add_tax"><?= lang('order_tax') ?></a></td>
                                                <td class="text-right"><span id="ts_con">0</span></td>
                                            </tr>
                                            <tr class="success">
                                                <td colspan="2" style="font-weight:bold;"><?= lang('total_payable') ?></td>
                                                <td class="text-right" colspan="2" style="font-weight:bold;"><span id="total-payable">0</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="botbuttons" class="col-xs-12 text-center">

                            </div>
                            <div class="clearfix"></div>
                            <span id="hidesuspend"></span>
                            <input type="hidden" name="spos_note" value="" id="spos_note">

                            <div id="payment-con">
                                <input type="hidden" name="amount" id="amount_val" value="<?= $eid ? $sale->paid : ''; ?>"/>
                                <input type="hidden" name="balance_amount" id="balance_val" value=""/>
                                <input type="hidden" name="paid_by" id="paid_by_val" value="cash"/>
                                <input type="hidden" name="cc_no" id="cc_no_val" value=""/>
                                <input type="hidden" name="paying_gift_card_no" id="paying_gift_card_no_val" value=""/>
                                <input type="hidden" name="cc_holder" id="cc_holder_val" value=""/>
                                <input type="hidden" name="cheque_no" id="cheque_no_val" value=""/>
                                <input type="hidden" name="cc_month" id="cc_month_val" value=""/>
                                <input type="hidden" name="cc_year" id="cc_year_val" value=""/>
                                <input type="hidden" name="cc_type" id="cc_type_val" value=""/>
                                <input type="hidden" name="cc_cvv2" id="cc_cvv2_val" value=""/>
                                <input type="hidden" name="payment_note" id="payment_note_val" value=""/>
                            </div>
                            <input type="hidden" name="balance" id="balance_val" value="" />   
                            <input type="hidden" name="customer" id="customer" value="<?= $Settings->default_customer ?>" />
                            <input type="hidden" name="order_tax" id="tax_val" value="" />
                            <input type="hidden" name="order_discount" id="discount_val" value="" />
                            <input type="hidden" name="count" id="total_item" value="" />
                            <input type="hidden" name="did" id="is_delete" value="<?= $sid; ?>" />
                            <input type="hidden" name="eid" id="is_delete" value="<?= $eid; ?>" />
                            <input type="hidden" name="hold_ref" id="hold_ref" value="" />
                            <input type="hidden" name="total_items" id="total_items" value="0" />
                            <input type="hidden" name="total_quantity" id="total_quantity" value="0" />
                            <input type="submit" id="submit" value="Submit Sale" style="display: none;" />
                            <button class="btn btn-success" style="width: 150px;"> Update </button>

                        </div>
                        <?= form_close(); ?>
                    </div>

                </div>

            </div>

        <!-- <aside class="control-sidebar control-sidebar-dark" id="categories-list">
            <div class="tab-content">
                <div class="tab-pane active" id="control-sidebar-home-tab">
                    <ul class="control-sidebar-menu">
                        <?php
                        foreach ($categories as $category) {
                            echo '<li><a href="#" class="category' . ($category->id == $Settings->default_category ? ' active' : '') . '" id="' . $category->id . '">';
                            if ($category->image) {
                                echo '<div class="menu-icon"><img src="' . base_url('uploads/thumbs/' . $category->image) . '" alt="" class="img-thumbnail img-circle img-responsive"></div>';
                            } else {
                                echo '<i class="menu-icon fa fa-folder-open bg-red"></i>';
                            }
                            echo '<div class="menu-info"><h4 class="control-sidebar-subheading">' . $category->code . '</h4><p>' . $category->name . '</p></div>
							</a></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </aside> -->
        <div class="control-sidebar-bg"></div>
    </div>
</div>
<div id="order_tbl" style="display:none;"><span id="order_span"></span>
    <table id="order-table" class="prT table table-striped table-condensed" style="width:100%;margin-bottom:0;"></table>
</div>
<div id="bill_tbl" style="display:none;"><span id="bill_span"></span>
    <table id="bill-table" width="100%" class="prT table table-striped table-condensed" style="width:100%;margin-bottom:0;"></table>
    <table id="bill-total-table" width="100%" class="prT table table-striped table-condensed" style="width:100%;margin-bottom:0;"></table>
</div>

<div class="modal" data-easein="flipYIn" id="posModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div class="modal" data-easein="flipYIn" id="posModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true"></div>
<div id="ajaxCall"><i class="fa fa-spinner fa-pulse"></i></div>

<div class="modal" data-easein="flipYIn" id="gcModal" tabindex="-1" role="dialog" aria-labelledby="mModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title" id="myModalLabel"><?= lang('sell_gift_card'); ?></h4>
            </div>
            <div class="modal-body">
                <p><?= lang('enter_info'); ?></p>

                <div class="alert alert-danger gcerror-con" style="display: none;">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <span id="gcerror"></span>
                </div>
                <div class="form-group">
                    <?= lang("card_no", "gccard_no"); ?> *
                    <div class="input-group">
                        <?php echo form_input('gccard_no', '', 'class="form-control" id="gccard_no"'); ?>
                        <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;"><a href="#" id="genNo"><i class="fa fa-cogs"></i></a></div>
                    </div>
                </div>
                <input type="hidden" name="gcname" value="<?= lang('gift_card') ?>" id="gcname"/>
                <div class="form-group">
                    <?= lang("value", "gcvalue"); ?> *
                    <?php echo form_input('gcvalue', '', 'class="form-control" id="gcvalue"'); ?>
                </div>
                <div class="form-group">
                    <?= lang("price", "gcprice"); ?> *
                    <?php echo form_input('gcprice', '', 'class="form-control" id="gcprice"'); ?>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?= lang('close') ?></button>
                <button type="button" id="addGiftCard" class="btn btn-primary"><?= lang('sell_gift_card') ?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal" data-easein="flipYIn" id="subitemModal" tabindex="-1" role="dialog" aria-labelledby="dsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title" id="dsModalLabel">Sub Itens </h4>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-condensed">
                    <thead>
                        <tr class="success">
                            <th>Subitem</th>
                            <th style="width: 15%;text-align:center;">Preço</th>
                            <th style="width: 15%;text-align:center;">Adicionar</th>
                        </tr>
                    </thead>
                    <tbody id="listingDatasubitem"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal"><?= lang('close') ?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal" data-easein="flipYIn" id="dsModal" tabindex="-1" role="dialog" aria-labelledby="dsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title" id="dsModalLabel"><?= lang('discount_title'); ?></h4>
            </div>
            <div class="modal-body">
                <input type='text' class='form-control input-sm kb-pad' id='get_ds' onClick='this.select();' value=''>

                <label class="checkbox" for="apply_to_order">
                    <input type="radio" name="apply_to" value="order" id="apply_to_order" checked="checked"/>
                    <?= lang('apply_to_order') ?>
                </label>
                <label class="checkbox" for="apply_to_products">
                    <input type="radio" name="apply_to" value="products" id="apply_to_products"/>
                    <?= lang('apply_to_products') ?>
                </label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal"><?= lang('close') ?></button>
                <button type="button" id="updateDiscount" class="btn btn-primary btn-sm"><?= lang('update') ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal" data-easein="flipYIn" id="tsModal" tabindex="-1" role="dialog" aria-labelledby="tsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title" id="tsModalLabel"><?= lang('tax_title'); ?></h4>
            </div>
            <div class="modal-body">
                <input type='text' class='form-control input-sm kb-pad' id='get_ts' onClick='this.select();' value=''>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal"><?= lang('close') ?></button>
                <button type="button" id="updateTax" class="btn btn-primary btn-sm"><?= lang('update') ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal" data-easein="flipYIn" id="proModal" tabindex="-1" role="dialog" aria-labelledby="proModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-primary">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title" id="proModalLabel">
                    <?= lang('payment') ?> 
                </h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th style="width:25%;"><?= lang('net_price'); ?></th>
                        <th style="width:25%;"><span id="net_price"></span></th>
                        <th style="width:25%;"><?= lang('product_tax'); ?></th>
                        <th style="width:25%;"><span id="pro_tax"></span> <span id="pro_tax_method"></span></th>
                    </tr>
                </table>
                <input type="hidden" id="row_id" />
                <input type="hidden" id="item_id" />
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <?= lang('unit_price', 'nPrice') ?>
                            <input type="text" class="form-control input-sm kb-pad" id="nPrice" onClick="this.select();" placeholder="<?= lang('new_price') ?>">
                        </div>
                        <div class="form-group">
                            <?= lang('discount', 'nDiscount') ?>
                            <input type="text" class="form-control input-sm kb-pad" id="nDiscount" onClick="this.select();" placeholder="<?= lang('discount') ?>">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <?= lang('quantity', 'nQuantity') ?>
                            <input type="text" class="form-control input-sm kb-pad" id="nQuantity" onClick="this.select();" placeholder="<?= lang('current_quantity') ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?= lang('close') ?></button>
                <button class="btn btn-success" id="editItem"><?= lang('update') ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal" data-easein="flipYIn" id="susModal" tabindex="-1" role="dialog" aria-labelledby="susModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title" id="susModalLabel"><?= lang('suspend_sale'); ?></h4>
            </div>
            <div class="modal-body">
                <p><?= lang('type_reference_note'); ?></p>

                <div class="form-group">
                    <?= lang("reference_note", "reference_note"); ?>
                    <?php echo form_input('reference_note', $reference_note, 'class="form-control kb-text" id="reference_note"'); ?>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"> <?= lang('close') ?> </button>
                <button type="button" id="suspend_sale" class="btn btn-primary"> <?= lang('submit') ?></button>
            </div>
        </div>
    </div>
</div>



<div class="modal" data-easein="flipYIn" id="saleModal" tabindex="-1" role="dialog" aria-labelledby="saleModalLabel" aria-hidden="true"></div>
<div class="modal" data-easein="flipYIn" id="opModal" tabindex="-1" role="dialog" aria-labelledby="opModalLabel" aria-hidden="true"></div>

<div class="modal" data-easein="flipYIn" id="payModal" tabindex="-1" role="dialog" aria-labelledby="payModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-success">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title" id="payModalLabel">
                    <?= lang('payment') ?> 
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-9">
                        <div class="font16">
                            <table class="table table-bordered table-condensed" style="margin-bottom: 0;">
                                <tbody>
                                    <tr>
                                        <td width="25%" style="border-right-color: #FFF !important;"><?= lang("total_items"); ?></td>
                                        <td width="25%" class="text-right"><span id="item_count">0.00</span></td>
                                        <td width="25%" style="border-right-color: #FFF !important;"><?= lang("total_payable"); ?></td>
                                        <td width="25%" class="text-right"><span id="twt">0.00</span></td>
                                    </tr>
                                    <tr>
                                        <td style="border-right-color: #FFF !important;"><?= lang("total_paying"); ?></td>
                                        <td class="text-right"><span id="total_paying">0.00</span></td>
                                        <td style="border-right-color: #FFF !important;"><?= lang("balance"); ?></td>
                                        <td class="text-right"><span id="balance">0.00</span></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="clearfix"></div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">

                                <div class="form-group">
                                    <?= lang('note', 'note'); ?>
                                    <textarea  name="note" required="required" class="pa form-control kb-text"  id="note" style=" height:100px;"></textarea>
                                </div>
                            </div>
							
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <?= lang("amount", "amount"); ?>
                                    <input name="amount[]" type="text" required="required"
                                           class="pa form-control kb-pad amount" value="<?php echo $amount ?>"  id="amount"/>
                                </div>
                                <div id="amount_error">
                                    
                                </div>
                            </div>
							<div class="col-xs-6">
                                <div class="form-group">
                                    <?= lang("type", "type"); ?>
                                    <select id="type" name="invoice_type" class="form-control type select2" style="width:100%;">
                                        <option value="VD"><?= "Venda a Dinheiro"?></option>
                                         <option value="TIKECT"><?= "TIKECT" ?></option>
                                        </select>
                                </div>
                            </div>
                            <div class="col-xs-4 hidden">
                                <div class="form-group">
                                    <label for="vbalance">Valor Balança</label>
                                    <input name="balance" type="text" required="required"
                                           class="pa form-control kb-pad amount" id="vbalance" value="0"/>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <?= lang("paying_by", "paid_by"); ?>
                                    <select id="paid_by" class="form-control paid_by select2" style="width:100%;">
                                        <option value="cash"><?= lang("cash"); ?></option>
                                         <option value="CC"><?= lang("cc"); ?></option>
                                        <option value="Cheque">cartao</option>
                                        <option value="gift_card"><?= lang("gift_card"); ?></option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group gc" style="display: none;">
                                    <?= lang("gift_card_no", "gift_card_no"); ?>
                                    <input type="text" id="gift_card_no"
                                           class="pa form-control kb-pad gift_card_no gift_card_input"/>

                                    <div id="gc_details"></div>
                                </div>
                                <div class="pcc" style="display:none;">
                                    <div class="form-group">
                                        <input type="text" id="swipe" class="form-control swipe swipe_input"
                                               placeholder="<?= lang('focus_swipe_here') ?>"/>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <input type="text" id="pcc_no"
                                                       class="form-control kb-pad"
                                                       placeholder="<?= lang('cc_no') ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group">

                                                <input type="text" id="pcc_holder"
                                                       class="form-control kb-text"
                                                       placeholder="<?= lang('cc_holder') ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <div class="form-group">
                                                <select id="pcc_type"
                                                        class="form-control pcc_type select2"
                                                        placeholder="<?= lang('card_type') ?>">
                                                    <option value="Visa"><?= lang("Visa"); ?></option>
                                                    <option
                                                        value="MasterCard"><?= lang("MasterCard"); ?></option>
                                                    <option value="Amex"><?= lang("Amex"); ?></option>
                                                    <option
                                                        value="Discover"><?= lang("Discover"); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <div class="form-group">
                                                <input type="text" id="pcc_month"
                                                       class="form-control kb-pad"
                                                       placeholder="<?= lang('month') ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <div class="form-group">

                                                <input type="text" id="pcc_year"
                                                       class="form-control kb-pad"
                                                       placeholder="<?= lang('year') ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <div class="form-group">

                                                <input type="text" id="pcc_cvv2"
                                                       class="form-control kb-pad"
                                                       placeholder="<?= lang('cvv2') ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pcheque" style="display:none;">
                                    <div class="form-group"><label for="cheque_no">Cartão N°</label>      
                                        <input type="text" id="cheque_no"
                                               class="form-control cheque_no  kb-text"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-3 text-center">
                            <!-- <span style="font-size: 1.2em; font-weight: bold;"><?= lang('quick_cash'); ?></span> -->

                        <div class="btn-group btn-group-vertical" style="width:100%;">
                            <button type="button" data-amount="0" class="btn btn-info btn-block quick-cash" id="quick-payable">0.00
                            </button>
                            <?php
                            foreach (lang('quick_cash_notes') as $cash_note_amount) {
                                echo '<button type="button" data-amount="'.$cash_note_amount.'" class="btn btn-block btn-warning quick-cash">' . $cash_note_amount . '</button>';
                            }
                            ?>
                            <button type="button" class="btn btn-block btn-danger"
                                    id="clear-cash-notes"><?= lang('clear'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"> <?= lang('close') ?> </button>
                <button class="btn btn-primary" id="<?= $eid ? '' : 'submit-sale'; ?>"><?= lang('submit') ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal" data-easein="flipYIn" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="cModalLabel" aria-hidden="true">
    <div class="modal-dialog"> 
        <div class="modal-content">
            <div class="modal-header modal-primary">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-remove"></i></button>
                <h4 class="modal-title" id="cModalLabel">
                    <?= lang('add_customer') ?>
                </h4>
            </div>
            <?= form_open('pos/add_customer', 'id="customer-form"'); ?>
            <div class="modal-body">
                <div id="c-alert" class="alert alert-danger" style="display:none;"></div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label class="control-label" for="code">
                                <?= lang("name"); ?>
                            </label>
                            <?= form_input('name', '', 'class="form-control input-sm kb-text" id="cname"'); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label class="control-label" for="cemail">
                                Email:
                            </label>
                            <?= form_input('email', '', 'class="form-control input-sm kb-text" id="cemail"'); ?>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label class="control-label" for="phone">
                                <?= lang("phone"); ?>
                            </label>
                            <?= form_input('phone', '', 'class="form-control input-sm kb-pad" id="cphone"'); ?>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label class="control-label" for="cf2">
                                Telefone 2:
                            </label>
                            <?= form_input('cf2', '', 'class="form-control input-sm kb-pad" id="cf2"'); ?>
                        </div>
                    </div>			
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label class="control-label" for="cf1">
                                Nascimento:
                            </label>
                            <?= form_input('cf1', '', 'class="form-control input-sm kb-pad" id="cf1"'); ?>
                        </div>
                    </div>	
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label class="control-label" for="endereco">
                                Endereço
                            </label>
                            <?= form_input('endereco', '', 'class="form-control input-sm kb-pad" id="cphone"'); ?>
                        </div>
                    </div>	
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label class="control-label" for="numero">
                                Nº:
                            </label>
                            <?= form_input('numero', '', 'class="form-control input-sm kb-pad" id="cphone"'); ?>
                        </div>
                    </div>		
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label class="control-label" for="complemento">
                                Complemento:
                            </label>
                            <?= form_input('complemento', '', 'class="form-control input-sm kb-pad" id="cphone"'); ?>
                        </div>
                    </div>		
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label class="control-label" for="bairro">
                                Bairro:
                            </label>
                            <?= form_input('bairro', '', 'class="form-control input-sm kb-pad" id="cphone"'); ?>
                        </div>
                    </div>		
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label class="control-label" for="cep">
                                NIF:
                            </label>
                            <?= form_input('cep', '', 'class="form-control input-sm kb-pad" id="cphone"'); ?>
                        </div>
                    </div>		
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label class="control-label" for="cidade">
                                Cidade:
                            </label>
                            <?= form_input('cidade', '', 'class="form-control input-sm kb-pad" id="cphone"'); ?>
                        </div>
                    </div>		
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label class="control-label" for="estado">
                                Estado:
                            </label>
                            <?= form_input('estado', '', 'class="form-control input-sm kb-pad" id="cphone"'); ?>
                        </div>
                    </div>		
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label class="control-label" for="obs1">
                                OBS:
                            </label>
                            <?= form_input('obs1', '', 'class="form-control input-sm kb-pad" id="cphone"'); ?>
                        </div>
                    </div>							



                </div>


            </div>
            <div class="modal-footer" style="margin-top:0;">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"> <?= lang('close') ?> </button>
                <button type="submit" class="btn btn-primary" id="add_customer"> <?= lang('add_customer') ?> </button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<style type="text/css">
    .table_wrap{
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        grid-gap: 10px;
    }
    .table-item{
        border: 3px double #ccc;
        width: 100%;
        min-height: 50px;
        text-align: center;
        display: flex;
        align-content: center;
        justify-content: center;
        flex-direction: column;
        cursor: pointer;
    }
    .table_busy{
        background: red !important;
    }
    .table_active{
        background: #8c8c8c;
        color: white;
    }

</style>
<div id="table_modal" data-easein="flipYIn" class="modal fade " role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo lang("select_mesa"); ?></h4>
      </div>
      <div class="modal-body">
        <div class="table_wrap">

            <?php 
                $tables = get_rows("mesas");
                foreach ($tables as $key => $table) {
            ?>
            <div class="table-item <?php if(!empty($suspend["mesa"]) && $suspend["hold_ref"] == $table["name"]) echo "table_active"; ?> <?php if($table['status'] == 1) echo "table_busy"; ?>" data-id="<?php echo $table['id']; ?>" data-name="<?php echo $table['name']; ?>">
                <span><?php echo $table['name']; ?></span>
            </div>
            <?php 
            }
            ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
    var page_title = "index";
</script>
<script src="<?= $assets ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?= $assets ?>plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?= $assets ?>plugins/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<script src="<?= $assets ?>plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
<script src="<?= $assets ?>plugins/redactor/redactor.min.js" type="text/javascript"></script>
<script src="<?= $assets ?>plugins/iCheck/icheck.min.js" type="text/javascript"></script>
<script src="<?= $assets ?>plugins/select2/select2.min.js" type="text/javascript"></script>
<script src="<?= $assets ?>plugins/formvalidation/js/formValidation.popular.min.js" type="text/javascript"></script>
<script src="<?= $assets ?>plugins/formvalidation/js/framework/bootstrap.min.js" type="text/javascript"></script>
<script src="<?= $assets ?>dist/js/common-libs.js" type="text/javascript"></script>
<script src="<?= $assets ?>dist/js/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?= $assets ?>dist/js/app.js" type="text/javascript"></script>
<script src="<?= $assets ?>dist/js/pages/all.js" type="text/javascript"></script>
<script src="<?= $assets ?>dist/js/custom.js" type="text/javascript"></script>
<script src="<?= $assets ?>plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?= $assets ?>plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script src="<?= $assets ?>plugins/velocity/velocity.min.js" type="text/javascript"></script>
<script src="<?= $assets ?>plugins/velocity/velocity.ui.min.js" type="text/javascript"></script>
<script src="<?= $assets ?>dist/js/parse-track-data.js" type="text/javascript"></script>
<?php if ($Settings->java_applet) { ?>
    <script type="text/javascript" src="<?= $assets ?>plugins/qz/js/deployJava.js"></script>
    <script type="text/javascript" src="<?= $assets ?>plugins/qz/qz-functions.js"></script>
    <script type="text/javascript">
                                    deployQZ('themes/<?= $Settings->theme ?>/assets/plugins/qz/qz-print.jar', '<?= $assets ?>plugins/qz/qz-print_jnlp.jnlp');
                                    function printBill(bill) {
                                        usePrinter("<?= $Settings->receipt_printer; ?>");
                                        printData(bill);
                                    }
    <?php
    $printers = json_encode(explode('|', $Settings->pos_printers));
    echo 'var printer = ' . $printers . ';
';
    ?>
                                    function printOrder(order) {
                                        for (index = 0; index < printers.length; index++) {
                                            usePrinter(printers[index]);
                                            printData(order);
                                        }
                                    }
    </script>
<?php } ?>
<script type="text/javascript">
    var base_url = '<?= base_url(); ?>', assets = '<?= $assets ?>';
</script>
<!-- Notifications -->
<link rel="stylesheet" href="<?= $assets ?>plugins/jquery-toast-plugin-master/src/jquery.toast.css">
<script src="<?= $assets ?>plugins/jquery-toast-plugin-master/src/jquery.toast.js"></script>
<script src="<?= $assets ?>dist/js/pos.js" type="text/javascript"></script>
<script src="<?= $assets ?>dist/js/subitem.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("body").on("click","#select_mesa_show",function(){
            $(".table_active").removeClass("table_active");
            $(".table-item[data-id='"+localStorage.getItem('table')+"']").addClass("table_active");
            $("#table_modal").modal("show");
        })
        $("body").on("click",".table-item",function(){
            $(".table_active").removeClass("table_active");
            $(this).addClass("table_active");
            $("#select_mesa_show").html($(this).data("name"));
            value = $(this).data("id");
            $("#select_mesa option[value='"+value+"']").prop("selected","selected");
            $("#select_mesa").change();
            $("#table_modal").modal("hide");
            $("#suspend").click();
        })
        //   $('#select_mesa').select2({"width": "100%"});
        var $default = localStorage.getItem('table');
<?php if (empty($_GET['hold'])): ?>
            if ($default > 0) {
                $('#select_mesa').val($default).trigger('change');
                $("#select_mesa_show").html($("#select_mesa option[value='"+$default+"']").html());

            } else {
                $('#select_mesa').val('no').trigger('change');
                $("#select_mesa_show").html($("#select_mesa option[value='no']").html());

            }
<?php endif; ?>
<?php if (!empty($_GET['hold'])): ?>
            localStorage.setItem('table', $("#select_mesa :selected").val());
            localStorage.setItem('table-t', $("#select_mesa :selected").text());
<?php endif; ?>
        $("#select_mesa").change(function () {
            if ($(this).val() !== "no") {
                localStorage.setItem('table', $(this).val());
                localStorage.setItem('table-t', $("#select_mesa :selected").text());
            }
        });
    });
</script>
<script type="text/javascript">
    var admin = "<?php echo ($Admin)?'1':'0'; ?>";
    var dateformat = '<?= $Settings->dateformat; ?>', timeformat = '<?= $Settings->timeformat ?>';
<?php unset($Settings->protocol, $Settings->smtp_host, $Settings->smtp_user, $Settings->smtp_pass, $Settings->smtp_port, $Settings->smtp_crypto, $Settings->mailpath, $Settings->timezone, $Settings->setting_id, $Settings->default_email, $Settings->version, $Settings->stripe, $Settings->stripe_secret_key, $Settings->stripe_publishable_key); ?>
    var Settings = <?= json_encode($Settings); ?>;
    var sid = false, username = '<?= $this->session->userdata('username'); ?>', spositems = {};
    $(window).load(function () {
        $('#mm_<?= $m ?>').addClass('active');
        $('#<?= $m ?>_<?= $v ?>').addClass('active');
    });
    var pro_limit = <?= $Settings->pro_limit ?>, java_applet = 0, count = 1, total = 0, an = 1, p_page = 0, page = 0, cat_id = <?= $Settings->default_category ?>, tcp = <?= $tcp ?>;
    var gtotal = 0, order_discount = 0, order_tax = 0, protect_delete = <?= ($Admin) ? 0 : ($Settings->pin_code ? 1 : 0); ?>;
    var order_data = '', bill_data = '';
    var lang = new Array();
    lang['code_error'] = '<?= lang('code_error'); ?>';
    lang['r_u_sure'] = '<?= lang('r_u_sure'); ?>';
    lang['please_add_product'] = '<?= lang('please_add_product'); ?>';
    lang['paid_less_than_amount'] = '<?= lang('paid_less_than_amount'); ?>';
    lang['x_suspend'] = '<?= lang('x_suspend'); ?>';
    lang['discount_title'] = '<?= lang('discount_title'); ?>';
    lang['update'] = '<?= lang('update'); ?>';
    lang['tax_title'] = '<?= lang('tax_title'); ?>';
    lang['leave_alert'] = '<?= lang('leave_alert'); ?>';
    lang['close'] = '<?= lang('close'); ?>';
    lang['delete'] = '<?= lang('delete'); ?>';
    lang['no_match_found'] = '<?= lang('no_match_found'); ?>';
    lang['wrong_pin'] = '<?= lang('wrong_pin'); ?>';
    lang['file_required_fields'] = '<?= lang('file_required_fields'); ?>';
    lang['enter_pin_code'] = '<?= lang('enter_pin_code'); ?>';
    lang['incorrect_gift_card'] = '<?= lang('incorrect_gift_card'); ?>';
    lang['card_no'] = '<?= lang('card_no'); ?>';
    lang['value'] = '<?= lang('value'); ?>';
    lang['balance'] = '<?= lang('balance'); ?>';
    lang['unexpected_value'] = '<?= lang('unexpected_value'); ?>';
    lang['inclusive'] = '<?= lang('inclusive'); ?>';
    lang['exclusive'] = '<?= lang('exclusive'); ?>';
    lang['total'] = '<?= lang('total'); ?>';
    lang['total_items'] = '<?= lang('total_items'); ?>';
    lang['order_tax'] = '<?= lang('order_tax'); ?>';
    lang['order_discount'] = '<?= lang('order_discount'); ?>';
    lang['total_payable'] = '<?= lang('total_payable'); ?>';
    lang['rounding'] = '<?= lang('rounding'); ?>';
    lang['grand_total'] = '<?= lang('grand_total'); ?>';

    $(document).ready(function () {
        

        posScreen();
<?php if ($this->session->userdata('rmspos')) { ?>
            if (get('spositems')) {
                remove('spositems');
            }
            if (get('spos_discount')) {
                remove('spos_discount');
            }
            if (get('spos_tax')) {
                remove('spos_tax');
            }
            if (get('spos_note')) {
                remove('spos_note');
            }
            if (get('spos_customer')) {
                remove('spos_customer');
            }
            if (get('amount')) {
                remove('amount');
            }
    <?php
    $this->tec->unset_data('rmspos');
}
?>

        if (get('rmspos')) {
            if (get('spositems')) {
                remove('spositems');
            }
            if (get('spos_discount')) {
                remove('spos_discount');
            }
            if (get('spos_tax')) {
                remove('spos_tax');
            }
            if (get('spos_note')) {
                remove('spos_note');
            }
            if (get('spos_customer')) {
                remove('spos_customer');
            }
            if (get('amount')) {
                remove('amount');
            }
            remove('rmspos');
        }
<?php if ($sid) { ?>
            store('spositems', JSON.stringify(<?= $items; ?>));
    <?php if (!empty($subitems)): ?>
                store('subitem', JSON.stringify(<?= $subitems; ?>));
    <?php endif; ?>
            store('spos_discount', '<?= $suspend_sale->order_discount_id; ?>');
            store('spos_tax', '<?= $suspend_sale->order_tax_id; ?>');
            store('spos_customer', '<?= $suspend_sale->customer_id; ?>');
            $('#spos_customer').select2('val', '<?= $suspend_sale->customer_id; ?>');
            store('rmspos', '1');
            $('#tax_val').val('<?= $suspend_sale->order_tax_id; ?>');
            $('#discount_val').val('<?= $suspend_sale->order_discount_id; ?>');
<?php } elseif ($eid) { ?>

            console.log(<?= $subitems; ?>);
            store('spositems', JSON.stringify(<?= $items; ?>));
            // store('subitem', JSON.stringify(<?= $subitems; ?>));
            
            store('spos_discount', '<?= $sale->order_discount_id; ?>');
            store('spos_tax', '<?= $sale->order_tax_id; ?>');
            store('spos_customer', '<?= $sale->customer_id; ?>');
            $('#spos_customer').select2('val', '<?= $sale->customer_id; ?>');
            store('rmspos', '1');
            $('#tax_val').val('<?= $sale->order_tax_id; ?>');
            $('#discount_val').val('<?= $sale->order_discount_id; ?>');
<?php } else { ?>
            if (!get('spos_discount')) {
                store('spos_discount', '<?= $Settings->default_discount; ?>');
                $('#discount_val').val('<?= $Settings->default_discount; ?>');
            }
            if (!get('spos_tax')) {
                store('spos_tax', '<?= $Settings->default_tax_rate; ?>');
                $('#tax_val').val('<?= $Settings->default_tax_rate; ?>');
            }
<?php } ?>

        if (ots = get('spos_tax')) {
            $('#tax_val').val(ots);
        }
        if (ods = get('spos_discount')) {
            $('#discount_val').val(ods);
        }
        if (Settings.display_kb == 1) {
            display_keyboards();
        }
        nav_pointer();
        loadItems();
        read_card();
        bootbox.addLocale('bl', {OK: '<?= lang('ok'); ?>', CANCEL: '<?= lang('no'); ?>', CONFIRM: '<?= lang('yes'); ?>'});
        bootbox.setDefaults({closeButton: false, locale: "bl"});
<?php if ($eid) { ?>
            $('#suspend').attr('disabled', true);
            $('#print_order').attr('disabled', true);
            $('#print_bill').attr('disabled', true);
<?php } ?>
    });
</script>

</body>
</html>
