<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-header">
					<h3 class="box-title"><?= lang('enter_info'); ?></h3>
				</div>
				<div class="box-body">
					<?php echo form_open("customers/add");?>

					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label" for="code"><?= $this->lang->line("name"); ?></label>
							<?= form_input('name', set_value('name'), 'class="form-control input-sm" id="name"'); ?>
						</div>

						<div class="form-group">
							<label class="control-label" for="email_address"><?= $this->lang->line("email_address"); ?></label>
							<?= form_input('email', set_value('email'), 'class="form-control input-sm" id="email_address"'); ?>
						</div>

						<div class="form-group">
							<label class="control-label" for="phone"><?= $this->lang->line("phone"); ?></label>
							<?= form_input('phone', set_value('phone'), 'class="form-control input-sm" id="phone"');?>
						</div>
									
						<div class="form-group">
							<label class="control-label" for="numero"><?= $this->lang->line("BuildingNumber"); ?></label>
							<?= form_input('numero', set_value('numero'), 'class="form-control input-sm" id="numero"');?>
						</div>

						<div class="form-group">
							<label class="control-label" for="bairro"><?= $this->lang->line("StreetName"); ?></label>
							<?= form_input('endereco', set_value('endereco'), 'class="form-control input-sm" id="bairro"');?>
						</div>

						<div class="form-group">
							<label class="control-label" for="bairro"><?= $this->lang->line("AddressDetail"); ?></label>
							<?= form_input('bairro', set_value('bairro'), 'class="form-control input-sm" id="bairro"');?>
						</div>


						<div class="form-group">
							<label class="control-label" for="cidade"><?= $this->lang->line("City"); ?></label>
							<?= form_input('cidade', set_value('cidade'), 'class="form-control input-sm" id="cidade"');?>
						</div>

						<div class="form-group">
							<label class="control-label" for="cidade"><?= $this->lang->line("Province"); ?></label>
							<?= form_input('estado', set_value('estado'), 'class="form-control input-sm" id="estado"');?>
						</div>

						<div class="form-group">
							<label class="control-label" for="Country"><?= $this->lang->line("Country"); ?></label>
							<?= form_input('Country', set_value('Country'), 'class="form-control input-sm" id="Country"');?>
						</div>

						<div class="form-group">
							<label class="control-label" for="AccountID"><?= $this->lang->line("AccountID"); ?></label>
							<?= form_input('AccountID', set_value('AccountID'), 'class="form-control input-sm" id="AccountID"');?>
						</div>


						<div class="form-group">
							<label class="control-label" for="cf1"><?= $this->lang->line("CustomerTaxID"); ?></label>
							<?= form_input('cf1', set_value('cf1'), 'class="form-control input-sm" id="cf1"'); ?>
						</div>

						<div class="form-group">
							<label class="control-label" for="cf2"><?= $this->lang->line("ccf2"); ?></label>
							<?= form_input('cf2', set_value('cf2'), 'class="form-control input-sm" id="cf2"');?>
						</div>
						

						<div class="form-group">
							<?php echo form_submit('add_customer', $this->lang->line("add_customer"), 'class="btn btn-primary"');?>
						</div>
					</div>
					<?php 

					echo form_close();?>
				</div>
			</div>
		</div>
	</div>
</section>
