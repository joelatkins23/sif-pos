<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<script type="text/javascript">
    $(document).ready(function () {
        function image(n) {
            if (n !== null) {
                return '<div style="width:32px; margin: 0 auto;"><a href="<?= base_url(); ?>uploads/' + n + '" class="open-image"><img src="<?= base_url(); ?>uploads/thumbs/' + n + '" alt="" class="img-responsive"></a></div>';
            }
            return '';
        }
        function method(n) {
            return (n == 0) ? '<span class="label label-primary"><?= lang('inclusive'); ?></span>' : '<span class="label label-warning"><?= lang('exclusive'); ?></span>';
        }
        $('#fileData').dataTable({
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?= lang('all'); ?>']],
            "aaSorting": [[1, "asc"]], "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('products/get_products_itens') ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": [null, {"mRender": image, "bSortable": false}, null, null, {"mRender": currencyFormat}, {"bSortable": false, "bSearchable": false}]
        });
        //{"data":"tax_method","render":method},
        $('#fileData').on('click', '.image', function () {
            var a_href = $(this).attr('href');
            var code = $(this).attr('id');
            $('#myModalLabel').text(code);
            $('#product_image').attr('src', a_href);
            $('#picModal').modal();
            return false;
        });
        $('#fileData').on('click', '.barcode', function () {
            var a_href = $(this).attr('href');
            var code = $(this).attr('id');
            $('#myModalLabel').text(code);
            $('#product_image').attr('src', a_href);
            $('#picModal').modal();
            return false;
        });
        $('#fileData').on('click', '.open-image', function () {
            var a_href = $(this).attr('href');
            var code = $(this).closest('tr').find('.image').attr('id');
            $('#myModalLabel').text(code);
            $('#product_image').attr('src', a_href);
            $('#picModal').modal();
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
                    <h3 class="box-title"><?= lang('list_results'); ?></h3>
                    <div class="btn-group">
                        <button class="btn btn-default btn-xs dropdown-toggle" title="Exportar dados da tabela" data-toggle="dropdown"><i class="fa fa-share-square-o"></i> Exportar Tabela</button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="javascript:;" class="printTable" data-type="csv"><i class="fa fa-file-text-o"></i> CSV</a></li>
                            <li><a href="javascript:;" class="printTable" data-type="txt"><i class="fa fa-file-text-o"></i> TXT</a></li>
                            <li class="divider"></li>				
                            <li><a href="javascript:;" class="printTable" data-type="excel"><i class="fa fa-file-excel-o"></i> XLS</a></li>
                            <li><a href="javascript:;" class="printTable" data-type="doc"><i class="fa fa-file-word-o"></i> Word</a></li>
                            <li><a href="javascript:;" class="printTable" data-type="powerpoint"><i class="fa fa-file-powerpoint-o"></i> PowerPoint</a></li>
                        </ul>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="fileData" class="table table-striped table-bordered table-hover" style="margin-bottom:5px;">
                            <thead>
                                <tr class="active">
                                    <th style="max-width:30px;"><?= lang("code"); ?></th>
                                    <th style="max-width:30px;"><?= lang("image"); ?></th>
                                    <th class="col-xs-3"><?= lang("name"); ?></th>
                                    <th class="col-xs-3">Item</th>
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
<!-- default export -->
<script type="text/javascript" src="<?= $assets ?>plugins/tableExport.jquery.plugin/tableExport.js"></script>
<script type="text/javascript" src="<?= $assets ?>plugins/tableExport.jquery.plugin/jquery.base64.js"></script>
<!-- PDF Export -->
<script type="text/javascript" src="<?= $assets ?>plugins/tableExport.jquery.plugin/jspdf/libs/sprintf.js"></script>
<script type="text/javascript" src="<?= $assets ?>plugins/tableExport.jquery.plugin/jspdf/libs/base64.js"></script>
<script type="text/javascript" src="<?= $assets ?>plugins/tableExport.jquery.plugin/jspdf/jspdf.js"></script>
<!-- PNG Export -->
<script type="text/javascript" src="<?= $assets ?>plugins/tableExport.jquery.plugin/html2canvas.js"></script>
<script src="<?= $assets ?>plugins/printTable.js"></script>
<script>
    jQuery(document).ready(function () {
        exportTable.init("#fileData", [0, 3, 7, 10]);
    });
</script>