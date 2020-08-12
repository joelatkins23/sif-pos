<script>
	$(document).ready(function () {
		$('#SLData').dataTable({
			"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?= lang('all'); ?>']],
            "aaSorting": [[ 0, "desc" ]], "iDisplayLength": <?= $Settings->rows_per_page ?>,
			'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('sales/get_sales') ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": [{"mRender":hrld},  null, null, {"mRender":currencyFormat}, {"mRender":currencyFormat}, {"mRender":currencyFormat},  {"mRender": function(data){
            	if(data == "A") 
            		return "<?php echo lang("canceled"); ?>";
            	else 
            		return "<?php echo lang("normal"); ?>";

				}}, {"bSortable":false, "bSearchable": false}]
		});
		

	});


</script>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-header">
					<h3 class="box-title"><?= lang('list_results'); ?></h3>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table id="SLData" class="table table-striped table-bordered table-condensed table-hover">
							<thead>
								<tr class="active">
									<th class="col-xs-2"><?php echo $this->lang->line("date"); ?></th>
									<th class="col-xs-2"><?php echo $this->lang->line("customer"); ?></th>
									<th class="col-xs-1"><?php echo $this->lang->line("InvoiceNo"); ?></th>
									<th class="col-xs-1"><?php echo $this->lang->line("discount"); ?></th>
									<th class="col-xs-1"><?php echo $this->lang->line("grand_total"); ?></th>
                                    <th class="col-xs-1"><?php echo $this->lang->line("paid"); ?></th>
									<th class="col-xs-1"><?php echo $this->lang->line("status"); ?></th> 
									<th class="col-xs-2"><?php echo $this->lang->line("actions"); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td colspan="10" class="dataTables_empty"><?= lang('loading_data_from_server'); ?></td>
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
<script type="text/javascript">
	$(function(){
			<?php
		if($this->session->userdata("add_payment") == "yes"){
?>
		window.open("sales/printPaymentInvoice/<?= $this->session->userdata("sale_id")?>","PrintPaymentInvoice");
<?php			
			$this->session->unset_userdata("add_payment");
	        $this->session->unset_userdata("sale_id");
		}
	?>

	})
</script>