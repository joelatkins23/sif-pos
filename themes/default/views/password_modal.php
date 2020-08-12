<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<div class="modal" data-easein="flipYIn" id="change_password_modal" tabindex="-1" role="dialog" aria-labelledby="mModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button> -->
                <h4 class="modal-title"><?= lang('please_change_password'); ?></h4>
            </div>
            <div class="modal-body">
                <p><?= lang('enter_info'); ?></p>

                <div class="alert alert-danger gcerror-con password_error_wrap" style="display:none ;">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <span id="password_error">
                        Passwords do not match.
                    </span>
                </div>
                <div class="form-group">
                    <?= lang("new_password"); ?> 
                    <?php echo form_password('new_password', '', 'class="form-control" id="new_password"'); ?>
                </div>
                <div class="form-group">
                    <?= lang("confirm_password"); ?> 
                    <?php echo form_password('confirm_password', '', 'class="form-control" id="confirm_password"'); ?>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" id="cancel_password"><?= lang('close') ?></button>
                <button type="button" id="change_password" class="btn btn-primary"><?= lang('change') ?></button>
            </div>
        </div>
    </div>
</div>
 
<script type="text/javascript">
    var change_password_status = "<?php echo $this->session->userdata("change_password_status"); ?>";
    $(function(){
        if(change_password_status == "yes"){
            $("#change_password_modal").modal("show");
        }
        $("body").on("click","#cancel_password",function(){
            $.ajax({
                type: "post",
                url: "<?= site_url('auth/cancel_password') ?>",
                data: {<?= $this->security->get_csrf_token_name(); ?>: "<?= $this->security->get_csrf_hash(); ?>"},
                dataType: "json",
                success: function (data) {
                    $("#change_password_modal").modal("hide");
                    change_password_status = "no";
                },
                error: function () {
                    
                }
            });
        })

        $("body").on("click","#change_password",function(){
            if($("#new_password").val() == "" || $("#confirm_password").val() == ""){
                $("#password_error").html("You have to fill all input.");
                $(".password_error_wrap").show();
                return;
            }
            if($("#new_password").val() != $("#confirm_password").val()){
                $("#password_error").html("Passwords do not match.");
                $(".password_error_wrap").show();
                return;
            }
            $.ajax({
                type: "post",
                url: "<?= site_url('auth/change_password_first') ?>",
                data: {<?= $this->security->get_csrf_token_name(); ?>: "<?= $this->security->get_csrf_hash(); ?>",new_password:$("#new_password").val()},
                dataType: "json",
                success: function (data) {
                    $("#change_password_modal").modal("hide");
                    change_password_status = "no";
                    alert("Password are changeed successfully");
                },
                error: function () {
                    
                }
            });
        })

    })
</script>

