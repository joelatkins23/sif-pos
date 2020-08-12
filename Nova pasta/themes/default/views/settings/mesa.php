<script>
    function removeTable(id) {
        window.location.href = '<?= site_url('settings/remove_mesa'); ?>?id=' + id;
    }
    function updateTable(id) {
        $.post("<?php echo site_url(); ?>/ajax/getTable.php", {"id": id}, function (json) {
            if (!json.error) {
                console.log(json);
                $("#form2").removeClass('hidden');
                $("#up_table_name").val(json.name);
                $("#up_table_place").val(json.places);
                $("#form2 #update").val(id);
                return true;
            }
        }, "JSON");

    }
    $(document).ready(function () {
        function places(x) {
            if (x !== null) {
                if (x > 1) {
                    return x + " Lugares";
                }
                return "1 Lugar";
            }
            return '';
        }
        function status(x) {
            if (x !== null && x > 0) {
                return "Ocupado";
            }
            return "-";
        }
        function action(x) {
            if (x !== null) {
                return '<button class="btn btn-xs updateTable"  onclick="updateTable(' + x + ')" data-id="' + x + '" type="button"><i class="fa fa-pencil"></i> </button> ' +
                        '<button class="btn btn-xs btn-danger removeTable" onclick="removeTable(' + x + ')" data-id="' + x + '" type="button"><i class="fa fa-times"></i> </button>';
            }
            return '';
        }
        $('#SLData').dataTable({
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?= lang('all'); ?>']],
            "aaSorting": [[0, "desc"]], "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('settings/get_mesas_logs') ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": [null, null, {"mRender": places}, {"mRender": status}, {"mRender": action}]
        });
        $('#form').hide();
        $('.toggle_form').click(function () {
            $("#form").slideToggle();
            return false;
        });
    });
</script>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <a href="#" class="btn btn-default btn-sm toggle_form pull-right"><i class="fa fa-plus"></i> Nova Mesa</a>
                    <h3 class="box-title"><?= lang('list_results'); ?></h3>
                </div>
                <div class="box-body">
                    <div id="form" class="panel panel-warning">
                        <div class="panel-body">
                            <?= form_open("settings/new_table"); ?>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="table_name">Nome</label>
                                        <?= form_input('table_name', set_value('table_name'), 'class="form-control" id="table_name"'); ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="table_place">Lugares</label>
                                        <?= form_input('table_place', set_value('table_place'), 'class="form-control" id="table_place"'); ?>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary"><?= lang("submit"); ?></button>
                                </div>
                            </div>
                            <?= form_close(); ?>
                        </div>
                    </div>
                    <div id="form2" class="panel panel-warning hidden">
                        <div class="panel-body">
                            <?= form_open("settings/update_mesa"); ?>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                          <label for="table_name">Nome</label>
                                        <?= form_input('table_name', set_value('table_name'), 'class="form-control" id="up_table_name"'); ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                          <label for="table_place">Lugares</label>
                                        <?= form_input('table_place', set_value('table_place'), 'class="form-control" id="up_table_place"'); ?>
                                    </div>
                                </div>
                                <input type="hidden" name="update" id="update">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary"><?= lang("submit"); ?></button>
                                    <button type="button" onclick="$('#form2').addClass('hidden')" class="btn btn-default">Cancelar</button>
                                </div>
                            </div>
                            <?= form_close(); ?>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="SLData" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <tr class="active">
                                    <th class="col-xs-1">Código</th>
                                    <th class="col-xs-1">Nome da Mesa</th>
                                    <th class="col-xs-1">Número de Pessoas</th>
                                    <th class="col-xs-1">Estado</th>
                                    <th class="col-xs-1">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="9" class="dataTables_empty"><?= lang('loading_data_from_server'); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section>
