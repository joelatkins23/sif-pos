<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title"><?= lang('update_info'); ?></h3>
        </div>
        <div class="box-body">
          <?php echo form_open("customers/edit/".$customer->id);?>

          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label" for="code"><?= $this->lang->line("name"); ?></label>
              <?= form_input('name', set_value('name', $customer->name), 'class="form-control input-sm" id="name"'); ?>
            </div>

            <div class="form-group">
              <label class="control-label" for="email_address">Email</label>
              <?= form_input('email', set_value('email', $customer->email), 'class="form-control input-sm" id="email_address"'); ?>
            </div>

            <div class="form-group">
              <label class="control-label" for="phone"><?= $this->lang->line("phone"); ?></label>
              <?= form_input('phone', set_value('phone', $customer->phone), 'class="form-control input-sm" id="phone"');?>
            </div>

            <div class="form-group">
              <label class="control-label" for="cf2">Telefone 2</label>
              <?= form_input('cf2', set_value('cf2', $customer->cf2), 'class="form-control input-sm" id="cf2"');?>
            </div>

            <div class="form-group">
              <label class="control-label" for="cf1">NIF</label>
              <?php  if($edit_nif == "no")
                     echo form_input('cf1', set_value('cf1', $customer->cf1), 'class="form-control input-sm" id="cf1" disabled=""'); 
                  else 
                     echo form_input('cf1', set_value('cf1', $customer->cf1), 'class="form-control input-sm" id="cf1"'); 

              ?>
            </div>			
			
            <div class="form-group">
              <label class="control-label" for="cf1">Endereço</label>
              <?= form_input('endereco', set_value('endereco', $customer->endereco), 'class="form-control input-sm" id="endereco"'); ?>
            </div>			
			
            <div class="form-group">
              <label class="control-label" for="cf1">Nº</label>
              <?= form_input('numero', set_value('numero', $customer->numero), 'class="form-control input-sm" id="numero"'); ?>
            </div>				
			
            <div class="form-group">
              <label class="control-label" for="cf1">Complemento</label>
              <?= form_input('complemento', set_value('complemento', $customer->complemento), 'class="form-control input-sm" id="complemento"'); ?>
            </div>		

            <div class="form-group">
              <label class="control-label" for="cf1">Bairro</label>
              <?= form_input('bairro', set_value('bairro', $customer->bairro), 'class="form-control input-sm" id="bairro"'); ?>
            </div>	

            <div class="form-group">
              <label class="control-label" for="cf1">Cep</label>
              <?= form_input('cep', set_value('cep', $customer->cep), 'class="form-control input-sm" id="cep"'); ?>
            </div>	
			
            <div class="form-group">
              <label class="control-label" for="cf1">Cidade</label>
              <?= form_input('cidade', set_value('cidade', $customer->cidade), 'class="form-control input-sm" id="cidade"'); ?>
            </div>	

            <div class="form-group">
              <label class="control-label" for="cf1">Provincia</label>
              <?= form_input('estado', set_value('estado', $customer->estado), 'class="form-control input-sm" id="estado"'); ?>
            </div>	
			
            <div class="form-group">
              <label class="control-label" for="cf1">Obs</label>
              <?= form_input('obs1', set_value('obs1', $customer->obs1), 'class="form-control input-sm" id="obs1"'); ?>
            </div>				

			
			
			

            <div class="form-group">
              <?php echo form_submit('edit_customer', $this->lang->line("edit_customer"), 'class="btn btn-primary"');?>
            </div>
          </div>
          <?php echo form_close();?>
        </div>
      </div>
    </div>
  </div>
</section>
