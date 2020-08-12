<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        // $('#UTable').dataTable();
    });
</script>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?= lang('list_results'); ?></h3>
                </div>
                <style type="text/css">
                    th{
                        text-align: left !important;
                    }
                </style>
                <div class="box-body">
                     <div class="col-sm-12">
                         <p>Public Key</p>
                         <textarea style="width: 100%; height: 200px;"><?php echo $sign_key['public'] ?></textarea>
                     </div>
                     <div class="col-sm-12">
                         <p>Private Key</p>
                         <textarea style="width: 100%; height: 250px;"><?php echo $sign_key['private'] ?></textarea>
                     </div>
                     <div class="col-sm-12">
                        <?php
                            if($sign_key['private'] == "" || !isset($sign_key['private'])) { ?>
                         <a class="btn btn-primary" href="<?php echo base_url("settings/general_key"); ?>">General Keys</a>
                        <?php } ?>
                     </div>
                </div>
            </div>
        </div>
    </div>

    
<script type="text/javascript">
    $(function(){
        $("body").on("click",".generate_btn",function(){
            user_name = $(this).data("name");
            $("#user_name").html(user_name);
            $("#user_id").val($(this).data("id"));
            $("#licence_modal").modal("show");
        })
    })
</script>
</section>
