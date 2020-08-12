<?php 
(defined('BASEPATH')) OR exit('No direct script access allowed'); 
?>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?= lang('enter_info'); ?></h3>
                </div>
                <div class="box-body">
                    <div class="col-lg-12">
                        <?= form_open_multipart("reports/relatorio_detalhado"); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Produto">Select Vendas POSee</label>
                                    <?php
                                    $cat[''] = lang("select") . " Produto";
                                    $q = new Query();
                                    $q
                                            ->select()
                                            ->from("tec_products")
                                            ->run();
                                    foreach ($q->get_selected() as $category) {
                                        $cat[$category["id"]] = $category["name"];
                                    }
                                    ?>
                                    <?= form_dropdown('product', $cat, set_value('category'), 'class="form-control select2 tip" id="category"  required="required" style="width:100%;"'); ?>

                                </div>
                                <div class="form-group">
                                    <?= lang('name', 'name'); ?>
                                    <?= form_input('name', set_value('name'), 'class="form-control tip" id="name"  required="required"'); ?>
                                </div>

                                <div class="form-group">
                                    <?= lang('price', 'price'); ?>
                                    <?= form_input('price', set_value('price'), 'class="form-control tip" id="price"  required="required"'); ?>
                                </div>

                            </div>

                        </div>
                        <div class="form-group">
                            <?= form_submit('add_product', lang('add_product'), 'class="btn btn-primary"'); ?>
                        </div>
                        <?= form_close(); ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?= $assets ?>dist/js/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8">
    var price = 0;
    cost = 0;
    items = {};
    $(document).ready(function () {
        $('#type').change(function (e) {
            var type = $(this).val();
            if (type == 'combo') {
                $('#st').slideUp();
                $('#ct').slideDown();
                //$('#cost').attr('readonly', true);
            } else if (type == 'service') {
                $('#st').slideUp();
                $('#ct').slideUp();
                //$('#cost').attr('readonly', false);
            } else {
                $('#ct').slideUp();
                $('#st').slideDown();
                //$('#cost').attr('readonly', false);
            }
        });

        $("#add_item").autocomplete({
            source: '<?= site_url('products/suggestions'); ?>',
            minLength: 1,
            autoFocus: false,
            delay: 200,
            response: function (event, ui) {
                if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                    bootbox.alert('<?= lang('no_product_found') ?>', function () {
                        $('#add_item').focus();
                    });
                    $(this).val('');
                } else if (ui.content.length == 1 && ui.content[0].id != 0) {
                    ui.item = ui.content[0];
                    $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                    $(this).autocomplete('close');
                    $(this).removeClass('ui-autocomplete-loading');
                } else if (ui.content.length == 1 && ui.content[0].id == 0) {
                    bootbox.alert('<?= lang('no_product_found') ?>', function () {
                        $('#add_item').focus();
                    });
                    $(this).val('');

                }
            },
            select: function (event, ui) {
                event.preventDefault();
                if (ui.item.id !== 0) {
                    var row = add_product_item(ui.item);
                    if (row) {
                        $(this).val('');
                    }
                } else {
                    bootbox.alert('<?= lang('no_product_found') ?>');
                }
            }
        });
        $('#add_item').bind('keypress', function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $(this).autocomplete("search");
            }
        });

        $(document).on('click', '.del', function () {
            var id = $(this).attr('id');
            delete items[id];
            $(this).closest('#row_' + id).remove();
        });


        $(document).on('change', '.rqty', function () {
            var item_id = $(this).attr('data-item');
            items[item_id].row.qty = (parseFloat($(this).val())).toFixed(2);
            add_product_item(null, 1);
        });

        $(document).on('change', '.rprice', function () {
            var item_id = $(this).attr('data-item');
            items[item_id].row.price = (parseFloat($(this).val())).toFixed(2);
            add_product_item(null, 1);
        });

        function add_product_item(item, noitem) {
            if (item == null && noitem == null) {
                return false;
            }
            if (noitem != 1) {
                item_id = item.row.id;
                if (items[item_id]) {
                    items[item_id].row.qty = (parseFloat(items[item_id].row.qty) + 1).toFixed(2);
                } else {
                    items[item_id] = item;
                }
            }
            price = 0;
            cost = 0;

            $("#prTable tbody").empty();
            $.each(items, function () {
                var item = this.row;
                var row_no = item.id;
                var newTr = $('<tr id="row_' + row_no + '" class="item_' + item.id + '"></tr>');
                tr_html = '<td><input name="combo_item_id[]" type="hidden" value="' + item.id + '"><input name="combo_item_code[]" type="hidden" value="' + item.code + '"><input name="combo_item_name[]" type="hidden" value="' + item.name + '"><input name="combo_item_cost[]" type="hidden" value="' + item.cost + '"><span id="name_' + row_no + '">' + item.name + ' (' + item.code + ')</span></td>';
                tr_html += '<td><input class="form-control text-center rqty" name="combo_item_quantity[]" type="text" value="' + formatDecimal(item.qty) + '" data-id="' + row_no + '" data-item="' + item.id + '" id="quantity_' + row_no + '" onClick="this.select();"></td>';
                //tr_html += '<td><input class="form-control text-center rprice" name="combo_item_price[]" type="text" value="' + formatDecimal(item.price) + '" data-id="' + row_no + '" data-item="' + item.id + '" id="combo_item_price_' + row_no + '" onClick="this.select();"></td>';
                tr_html += '<td class="text-center"><i class="fa fa-times tip del" id="' + row_no + '" title="Remove" style="cursor:pointer;"></i></td>';
                newTr.html(tr_html);
                newTr.prependTo("#prTable");
                //price += formatDecimal(item.price*item.qty);
                cost += formatDecimal(item.cost * item.qty);
            });
            $('#cost').val(cost);
            return true;

        }
<?php
if ($this->input->post('type') == 'combo') {
    $c = sizeof($_POST['combo_item_code']);
    $items = array();
    for ($r = 0; $r <= $c; $r++) {
        if (isset($_POST['combo_item_code'][$r]) && isset($_POST['combo_item_quantity'][$r])) {
            $items[] = array('id' => $_POST['combo_item_id'][$r], 'row' => array('id' => $_POST['combo_item_id'][$r], 'name' => $_POST['combo_item_name'][$r], 'code' => $_POST['combo_item_code'][$r], 'qty' => $_POST['combo_item_quantity'][$r], 'cost' => $_POST['combo_item_cost'][$r]));
        }
    }
    echo '
            var ci = ' . json_encode($items) . ';
            $.each(ci, function() { add_product_item(this); });
            ';
}
if ($this->input->post('type')) {
    ?>
            var type = '<?= $this->input->post('type'); ?>';
            if (type == 'combo') {
                $('#st').slideUp();
                $('#ct').slideDown();
                //$('#cost').attr('readonly', true);
            } else if (type == 'service') {
                $('#st').slideUp();
                $('#ct').slideUp();
                //$('#cost').attr('readonly', false);
            } else {
                $('#ct').slideUp();
                $('#st').slideDown();
                //$('#cost').attr('readonly', false);
            }

<?php }
?>
    });




</script>
