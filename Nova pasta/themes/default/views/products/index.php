<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>
<?php
$v = "?v=1";

    if($this->input->post('category_id')){
        $v .= "&category_id=".$this->input->post('category_id');
    }

    if($this->input->post('product_amount')){
        $v .= "&product_amount=".$this->input->post('product_amount');
    }

   
?>



<script type="text/javascript">
    $(document).ready(function() {
        function image(n) {
            if(n !== null) {
                return '<div style="width:32px; margin: 0 auto;"><a href="<?=base_url();?>uploads/'+n+'" class="open-image"><img src="<?=base_url();?>uploads/thumbs/'+n+'" alt="" class="img-responsive"></a></div>';
            }
            return '';
        }
        function method(n) {
            return (n == 0) ? '<span class="label label-primary"><?= lang('inclusive'); ?></span>' : '<span class="label label-warning"><?= lang('exclusive'); ?></span>';
        }
        $('#fileData').dataTable( {
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?= lang('all'); ?>']],
            "aaSorting": [[ 1, "asc" ]], "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('products/get_products/'.$v) ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": [{"mRender":image,"bSortable":false}, null, null, null, null, null, null, {"mRender":method}, <?= $Admin ? '{"mRender":currencyFormat},' : ''; ?> {"mRender":currencyFormat}, {"bSortable":false, "bSearchable": false}]
        });
        //{"data":"tax_method","render":method},
        $('#fileData').on('click', '.image', function() {
            var a_href = $(this).attr('href');
            var code = $(this).attr('id');
            $('#myModalLabel').text(code);
            $('#product_image').attr('src',a_href);
            $('#picModal').modal();
            return false;
        });
        $('#fileData').on('click', '.barcode', function() {
            var a_href = $(this).attr('href');
            var code = $(this).attr('id');
            $('#myModalLabel').text(code);
            $('#product_image').attr('src',a_href);
            $('#picModal').modal();
            return false;
        });
        $('#fileData').on('click', '.open-image', function() {
            var a_href = $(this).attr('href');
            var code = $(this).closest('tr').find('.image').attr('id');
            $('#myModalLabel').text(code);
            $('#product_image').attr('src',a_href);
            $('#picModal').modal();
            return false;
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

<style type="text/css">
    .table td:first-child { padding: 1px; }
    .table td:nth-child(6), .table td:nth-child(7), .table td:nth-child(8) { text-align: center; }
    .table td:nth-child(9)<?= $Admin ? ', .table td:nth-child(10)' : ''; ?> { text-align: right; }
</style>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    
                    <a href="#" class="btn btn-default btn-sm toggle_form pull-right"><?= lang("show_hide"); ?></a>
                    <a id="report_print_btn" class="btn btn-primary btn-sm pull-right" style="margin-right:  10px;"><i class="fa fa-print"></i> &nbsp; Imprimir</a>

                    <h3 class="box-title"><?= lang('list_results'); ?></h3>
                    <?= form_open("products/print_products",'id="print_form" target="_blank" style="display:none;"');?>
                            
                        <input type="hidden" name="category_id" value="<?=$this->input->post("category_id")?>">
                        <input type="text" name="product_amount" class="form-control" value="<?=$this->input->post('product_amount')?>">
                        <button type="submit" class="btn btn-primary"><?= lang("submit"); ?></button>
                    <?= form_close();?>

                </div>
                <div class="box-body">
                    <div id="form" class="panel panel-warning">
                        <div class="panel-body">
                            <?= form_open("products");?>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label" for="invoice_type"><?= lang("category"); ?></label>
                                    <select id="category_id"  name="category_id" class="form-control type select2" style="width:100%;">
                                        <option value="-1">All</option>
                                    <?php
                                        $rows = get_rows('tec_categories');
                                        foreach ($rows as $key => $row) {
                                            if($this->input->post("category_id") == $row['id'])
                                                echo '<option value="'.$row['id'].'" selected="selected">'.$row['name'].'</option>';
                                            else 
                                                echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';

                                        }
                                    ?>
                                    </select>

                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label" for="user"><?= lang("Qtd Stock"); ?></label>
                                    <input type="text" name="product_amount" class="form-control" value="<?=$this->input->post('product_amount')?>">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary"><?= lang("submit"); ?></button>
                            </div>

                            <?= form_close();?>
                        </div>
                    </div>
                        <div class="table-responsive">
                        <table id="fileData" class="table table-striped table-bordered table-hover" style="margin-bottom:5px;">
                            <thead>
                            <tr class="active">
                                <th style="max-width:30px;"><?= lang("image"); ?></th>
                                <th class="col-xs-1"><?= lang("code"); ?></th>
                                <th><?= lang("name"); ?></th>
                                <th class="col-xs-1"><?= lang("type"); ?></th>
                                <th class="col-xs-1"><?= lang("category"); ?></th>
                                <th class="col-xs-1"><?= lang("quantity"); ?></th>
                                <th class="col-xs-1"><?= lang("tax"); ?></th>
                                <th class="col-xs-1"><?= lang("method"); ?></th>
                                <?php if($Admin) { ?>
                                <th class="col-xs-1"><?= lang("cost"); ?></th>
                                <?php } ?>
                                <th class="col-xs-1"><?= lang("price"); ?></th>
                                <th style="width:145px;"><?= lang("actions"); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="10" class="dataTables_empty"><?= lang('loading_data_from_server'); ?></td>
                            </tr>
                            </tbody>
                        </table>
                        </div>

                        <div class="modal fade" id="picModal" tabindex="-1" role="dialog" aria-labelledby="picModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                                        <h4 class="modal-title" id="myModalLabel">title</h4>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img id="product_image" src="" alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
      $(function () {
        $("body").on("click","#report_print_btn",function(){
            $("#print_form").submit();
        })
    });
</script>