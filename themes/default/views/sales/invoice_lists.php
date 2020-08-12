<script>
	$(document).ready(function () {
		$('#SLData').dataTable({
			"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?= lang('all'); ?>']],
            "aaSorting": [[ 0, "desc" ]], "iDisplayLength": <?= $Settings->rows_per_page ?>,
			'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('sales/get_invoices') ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": [{"mRender":hrld}, null, null, {"mRender": function(data){
            	if(data == "partial") 
            		return "<?php echo lang("Pago Parcial"); ?>";
		        if(data == "paid") 
            		return "<?php echo lang("Pago"); ?>";
            	else 
            		return "<?php echo lang("Não Pago"); ?>";

            }},{"mRender":currencyFormat},{"mRender":currencyFormat},{"mRender":currencyFormat},{"mRender": function(data){
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
									<th class="col-sm-2" ><?php echo $this->lang->line("date"); ?></th>
									<th class="col-xs-2" ><?php echo $this->lang->line("customer"); ?></th>
									<th class="col-xs-1"><?php echo $this->lang->line("InvoiceNo"); ?></th>
                                    <!-- <th class="col-xs-2"><?php echo $this->lang->line("paid"); ?></th> -->
									<th class="col-xs-1"><?php echo $this->lang->line("status"); ?></th>
									<th class="col-sm-1"><?= lang("grand_total"); ?></th>
                                    <th class="col-sm-1"><?= lang("paid"); ?></th>
                                    <th class="col-sm-1"><?= lang("due_amount"); ?></th>
                                    <th class="col-xs-1"><?php echo $this->lang->line("InvoiceStatus"); ?></th>
									<th class="col-sm-2"><?php echo $this->lang->line("actions"); ?></th>
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
		$("body").on("click",".edit_invoice_btn",function(e){
			if($(this).closest("tr").find("td").eq(5).text() != "0.00" && $(this).closest("tr").find("td").eq(5).text() != "0,00"){
				alert("Não é Permitido Editar Facturas Pagas");
				e.preventDefault();
			}
		})

		$("body").on("click",".delete_invoice",function(e){
			if($(this).closest("tr").find("td").eq(5).text() != "0.00" && $(this).closest("tr").find("td").eq(5).text() != "0,00"){
				alert("Não é Permitido Eliminar Facturas Pagas");
				e.preventDefault();
			} else {
				return confirm($(this).data("title"));
			}
		})


		$("body").on("mouseover",".add_payment_btn",function(e){
			
			var tt = $(this).closest("tr").find("td").eq(7).text();
			if(tt == "Canceled" || tt == "Cancelada"){
				$(this).removeAttr("data-toggle");
			}
		})


		$("body").on("click",".add_payment_btn",function(e){
			var tt = $(this).closest("tr").find("td").eq(7).text();
			if(tt == "Canceled" || tt == "Cancelada"){
				alert("Voce não pode Adicinar Pagamentos em Facturas Anuladas");
				e.preventDefault();
			}
		})



		
			<?php
		if($this->session->userdata("add_payment") == "yes"){
?>
		window.open("printPaymentInvoice/<?= $this->session->userdata("sale_id")?>","PrintPaymentInvoice");
<?php			
			$this->session->unset_userdata("add_payment");
	        $this->session->unset_userdata("sale_id");
		}
	?>
<?php

		if($this->session->userdata("cancel_payment") == "yes"){
?>

		window.open("printPaymentInvoice/<?= $this->session->userdata("sale_id")?>","PrintPaymentInvoice");
		// window.open("<?= site_url('pos/printInvoice') ?>/<?= $this->session->userdata("sale_id")?>","PrintPaymentInvoice");
<?php			
			$this->session->unset_userdata("cancel_payment");
	        $this->session->unset_userdata("sale_id");
		}
	?>

	<?php
		if(!empty($this->session->userdata("reprint"))){

	?>	
			setTimeout(function(){
				$(".print<?php echo $this->session->userdata("reprint"); ?>").click();
			}, 500) ;
	
	<?php
		$this->session->unset_userdata("reprint");
		}
	?>
	})
</script>