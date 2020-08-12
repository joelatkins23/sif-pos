<?php
$v = "?v=1";

    if($this->input->post('customer')){
        $v .= "&customer=".$this->input->post('customer');
    }
    if($this->input->post('user')){
        $v .= "&user=".implode(",", $this->input->post('user'));
    }
    if($this->input->post('start_date')){
        $v .= "&start_date=".$this->input->post('start_date');
    }
    if($this->input->post('end_date')) {
        $v .= "&end_date=".$this->input->post('end_date');
    }
    if($this->input->post('invoice_type')) {
        $v .= "&invoice_type=".$this->input->post('invoice_type');
    }
    if($this->input->post('products')) {
        $v .= "&products=".implode(",", $this->input->post('products'));
    }
?>

<script>
    $(document).ready(function () {
        $('#SLRData').dataTable({
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?= lang('all'); ?>']],
            "aaSorting": [[ 0, "desc" ]], "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('reports/get_invoices/'. $v) ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": [{"mRender":hrld}, null, null, {"mRender":currencyFormat}, {"mRender":currencyFormat}, {"mRender":currencyFormat}, {"mRender":currencyFormat}, {"mRender":currencyFormat}, {"mRender":currencyFormat},{"bSortable":false, "bSearchable": false} ]
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#form').hide();
        $('.toggle_form').click(function(){
            $("#form").slideToggle();
            return false;
        });
    });
</script>
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header">
                    <a href="#" class="btn btn-default btn-sm toggle_form pull-right"><?= lang("show_hide"); ?></a>
                    <a id="report_print_btn" class="btn btn-primary btn-sm pull-right" style="margin-right:  10px;"><i class="fa fa-print"></i> &nbsp; Imprimir</a>
                    <h3 class="box-title"><?= lang('customize_report'); ?></h3>
                    <?= form_open("reports/print_invoices",'id="print_form" target="_blank" style="display:none;"');?>
                    <?php
                        $cu[0] = lang("select")." ".lang("customer");
                        foreach($customers as $customer){
                            $cu[$customer->id] = $customer->name;
                        }
                        echo form_dropdown('customer', $cu, set_value('customer')); ?>
             
                       <select class="form-control " multiple  name="user[]"   data-placeholder="<?php echo lang("select")." " . lang("user"); ?>" style="width:100%;">

                                <?php
                                $us[""] = "";
                                foreach ($users as $user) {
                                    // $us[$user->id] = $user->first_name . " " . $user->last_name;
                                    if(in_array($user->id, $this->input->post("user")))
                                        echo '<option selected="selected" value="'.$user->id.'">'.$user->first_name . " " . $user->last_name.'</option>';
                                    else 
                                        echo '<option value="'.$user->id.'">'.$user->first_name . " " . $user->last_name.'</option>';

                                }
                                // echo form_dropdown('user', $us, (isset($_POST['user']) ? $_POST['user'] : ""), 'class="form-control " multiple   id="user" data-placeholder="' . lang("select") . " " . lang("user") . '" style="width:100%;"');
                                ?>
                                </select>
                                <select class="form-control " multiple  name="products[]" id="products" data-placeholder="<?php echo lang("select")." " . lang("products"); ?>" style="width:100%;">

                                    <?php
                                    $us[""] = "";
                                    foreach ($products as $product) {
                                        // $us[$user->id] = $user->first_name . " " . $user->last_name;
                                        if(in_array($product->id, $this->input->post("products")))
                                            echo '<option selected="selected" value="'.$product->id.'">'.$product->name.'</option>';
                                        else 
                                            echo '<option value="'.$product->id.'">'.$product->name.'</option>';

                                    }
                                    // echo form_dropdown('user', $us, (isset($_POST['user']) ? $_POST['user'] : ""), 'class="form-control " multiple   id="user" data-placeholder="' . lang("select") . " " . lang("user") . '" style="width:100%;"');
                                    ?>
                                </select>
                        <?= form_input('invoice_type', set_value('invoice_type'));?>
                        <?= form_input('end_date', set_value('end_date'));?>
                        <?= form_input('end_date', set_value('end_date'));?>
                    <?= form_close();?>

                </div>
                <div class="box-body">
                <div id="form" class="panel panel-warning">
                        <div class="panel-body">
                        <?= form_open("reports/invoices");?>

                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label" for="customer"><?= lang("customer"); ?></label>
                                    <?php
                                    $cu[0] = lang("select")." ".lang("customer");
                                    foreach($customers as $customer){
                                        $cu[$customer->id] = $customer->name;
                                    }
                                    echo form_dropdown('customer', $cu, set_value('customer'), 'class="form-control select2" style="width:100%" id="customer"'); ?>
                                </div>
                            </div>
                            

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label" for="start_date"><?= lang("start_date"); ?></label>
                                    <?= form_input('start_date', set_value('start_date'), 'class="form-control datetimepicker" id="start_date"');?>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label" for="end_date"><?= lang("end_date"); ?></label>
                                    <?= form_input('end_date', set_value('end_date'), 'class="form-control datetimepicker" id="end_date"');?>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label" for="invoice_type"><?= lang("invoice_type"); ?></label>
                                    <select id="invoice_type"  name="invoice_type" class="form-control type select2" style="width:100%;">
                                     
                                        <option value=""><?= lang("select_invoice_type")?></option>
                                        <option value="FT"><?= lang("invoice")?></option>
                                        <option value="FR"><?= lang("invoice_receipt")?></option>
                                        <!-- <option value="TV"><?= lang("tiket")?></option> -->
                                        <option value="FP"><?= lang("pro-forma")?></option>
                                        <option value="VD"><?= lang("cash_sale")?></option>
                                    </select>

                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="user"><?= lang("user"); ?></label>
                                    <select class="form-control " multiple  name="user[]" id="user" data-placeholder="<?php echo lang("select")." " . lang("user"); ?>" style="width:100%;">

                                    <?php
                                    $us[""] = "";
                                    foreach ($users as $user) {
                                        // $us[$user->id] = $user->first_name . " " . $user->last_name;
                                        if(in_array($user->id, $this->input->post("user")))
                                            echo '<option selected="selected" value="'.$user->id.'">'.$user->first_name . " " . $user->last_name.'</option>';
                                        else 
                                            echo '<option value="'.$user->id.'">'.$user->first_name . " " . $user->last_name.'</option>';

                                    }
                                    // echo form_dropdown('user', $us, (isset($_POST['user']) ? $_POST['user'] : ""), 'class="form-control " multiple   id="user" data-placeholder="' . lang("select") . " " . lang("user") . '" style="width:100%;"');
                                    ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="products"><?= lang("products"); ?></label>
                                    <select class="form-control " multiple  name="products[]" id="products" data-placeholder="<?php echo lang("select")." " . lang("products"); ?>" style="width:100%;">

                                    <?php
                                    $us[""] = "";
                                    foreach ($products as $product) {
                                        // $us[$user->id] = $user->first_name . " " . $user->last_name;
                                        if(in_array($product->id, $this->input->post("products")))
                                            echo '<option selected="selected" value="'.$product->id.'">'.$product->name.'</option>';
                                        else 
                                            echo '<option value="'.$product->id.'">'.$product->name.'</option>';

                                    }
                                    // echo form_dropdown('user', $us, (isset($_POST['user']) ? $_POST['user'] : ""), 'class="form-control " multiple   id="user" data-placeholder="' . lang("select") . " " . lang("user") . '" style="width:100%;"');
                                    ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary"><?= lang("submit"); ?></button>
                            </div>
                        </div>
                        <?= form_close();?>
                    </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table id="SLRData" class="table table-striped table-bordered table-condensed table-hover">
                                    <thead>
                                        <tr class="active">
                                            <th class="col-sm-2"><?= lang("date"); ?></th>
                                            <th class="col-sm-2"><?= lang("customer"); ?></th>
                                            <th class="col-sm-2"><?= lang("InvoiceNo"); ?></th>
                                            <th class="col-sm-1"><?= lang("total"); ?></th>
                                            <th class="col-sm-1"><?= lang("tax"); ?></th>
                                            <th class="col-sm-1"><?= lang("discount"); ?></th>
                                            <th class="col-sm-1"><?= lang("grand_total"); ?></th>
                                            <th class="col-sm-1"><?= lang("paid"); ?></th>
                                            <th class="col-sm-2"><?= lang("due_amount"); ?></th>
                                            <th class="col-sm-1"><?= lang("action"); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="8" class="dataTables_empty"><?= lang('loading_data_from_server'); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <?php if($this->input->post('customer')) { ?>
                    <div class="row">
                        <div class="col-md-6"><button class="btn bg-purple btn-lg btn-block" style="cursor:default;"><strong><?=$total_sales?></strong> <?= lang("total_sales"); ?></button></div>
                        <div class="col-md-6"><button class="btn btn-success btn-lg btn-block" style="cursor:default;"><strong><?=$total_sales_value ? $total_sales_value : 0;?></strong> <?= lang("total_sales_value"); ?></button></div>
                    </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?= $assets ?>plugins/bootstrap-datetimepicker/js/moment.min.js" type="text/javascript"></script>
<script src="<?= $assets ?>plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $('.datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD HH:mm'
        });
        $("body").on("click","#report_print_btn",function(){
            $("#print_form").submit();
        })
    });
</script>
