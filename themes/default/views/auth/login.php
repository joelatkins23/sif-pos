<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $page_title.' | '.$Settings->site_name; ?></title>
    <link rel="shortcut icon" href="<?= $assets ?>images/icon.png"/>
    <script type="text/javascript">if (parent.frames.length !== 0) { top.location = '<?=site_url('login')?>'; }</script>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="<?= $assets ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= $assets ?>dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= $assets ?>plugins/iCheck/square/green.css" rel="stylesheet" type="text/css" />
    <link href="<?= $assets ?>dist/css/star.css" rel="stylesheet" type="text/css" />
    <script src='https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js'></script>
    <script src='<?= $assets; ?>dist/js/star.js'></script>
</head>
<body>
    <div class="contain" style="position: fixed; top: 0px;">
    <div class="gradient gradient-tl"></div>
    <div class="gradient gradient-tr"></div>
    <div class="gradient gradient-br"></div>
    <div class="gradient gradient-bl"></div>
      <div class="grain">
        <div id="stars"></div>
        <div id="stars2"></div>
        <div id="stars3"></div>
      </div>
    </div> 
    <div class="login-box" style="position: relative;">
        <div class="login-logo">
            <a href="<?=base_url();?>"><?= $Settings->site_name == 'PDV' ? '<b>POS</b>' : '<img src="'.base_url('uploads/'.$Settings->logo).'" alt="'.$Settings->site_name.'" />'; ?></a>
        </div>
        <div class="login-box-body" style="background: #fff;">
            <?php if($error)  { ?>
            <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <?= $error; ?>
            </div>
            <?php } if($message) { ?>
            <div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <?= $message; ?>
            </div>
            <?php } ?>
            <p id="login_msg" class="login-box-msg"><?= lang('login_to_your_account'); ?></p>
            <?= form_open("auth/login","id='login_form' name='login_form'"); ?>
            <div class="form-group has-feedback">
                <input type="text" name="identity" id="login_identity" value="<?= set_value('identity'); ?>" class="form-control" placeholder="<?= lang('email'); ?>" />
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="<?= lang('password'); ?>" />
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>

            <button id="login_btn" type="submit" class="btn btn-primary btn-block btn-flat"><i class="glyphicon glyphicon-log-in"></i> <?= lang('sign_in'); ?></button>

            <?= form_close(); ?>

            <div class="">
                <p>&nbsp;</p>
                <p><span class="text-danger"><?= lang('forgot_your_password'); ?></span><br>
                    <?= lang('dont_worry'); ?> <a href="#" class="text-danger" data-toggle="modal" data-target="#myModal"><?= lang('click_here'); ?></a> <?= lang('to_reset'); ?> </p>

                </div>

            </div>
        </div>

        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal"
        class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php echo form_open("auth/forgot_password"); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</i></button>
                    <h4 class="modal-title"><?= lang('forgot_password'); ?></h4>
                </div>
                <div class="modal-body">
                    <p><?= lang('forgot_password_heading'); ?></p>
                    <input type="email" name="forgot_email" placeholder="<?= lang('email'); ?>" autocomplete="off"
                    class="form-control placeholder-no-fix">
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default pull-left" type="button"><?= lang('close'); ?></button>
                    <button class="btn btn-primary" type="submit"><?= lang('submit'); ?></button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>

    <script src="<?= $assets ?>plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
    <script src="<?= $assets ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?= $assets ?>plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <?php  
        $csrf = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
        );
    ?>
    <script>

        $.ajaxSetup({cache: false, headers: {"cache-control": "no-cache"}});
        var cct = "<?php echo $csrf ['hash']; ?>";

        $(function () {
            if ($('#identity').val())
                $('#password').focus();
            else
                $('#identity').focus();
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
                increaseArea: '20%'
            });

            $("#login_form").submit(function(e){
                e.preventDefault();
                console.log("OK");
                if($("#login_identity").val() == "") {
                    $("#username_field").remove();
                    ele = "";
                    ele += '<div id="username_field" class="alert alert-danger alert-dismissable">';
                    ele += '    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>';
                    ele += '    <?php echo lang("username_required"); ?>';
                    ele += '</div>';
                    $(ele).insertBefore("#login_msg");
                    return false;
                }

                if( $("#login_licence").length >0 ){
                    licence_str = $("#login_licence").val();
                } else {
                    licence_str = "no";
                }
                $("#login_identity").change(function(){
                    $(".alert-danger ").remove();
                    $("#licence_wrap").remove();
                })
                $.ajax({
                    url:"<?php echo base_url("CheckLicence/check") ?>",
                    data:{'<?php echo $this->security->get_csrf_token_name(); ?>': cct, user_id : $("#login_identity").val(),  licence: licence_str},
                    dataType:"json",
                    type:"post",
                    success: function(res){
                        if(res.status == "ok"){
                            document.login_form.submit();
                        }
                        if(res.status == "need_licence"){
                            $("#licence_wrap").remove();
                            ele = "";
                            ele += '<div class="form-group has-feedback" id="licence_wrap">';
                            ele += '    <input id="login_licence" type="text" name="licence" class="form-control" placeholder="<?= lang('licence_code'); ?>" />';
                            ele += '    <span class="glyphicon glyphicon-qrcode form-control-feedback"></span>';
                            ele += '</div>';
                            $(ele).insertBefore("#login_btn");
                        }
                        if(res.status == "no"){
                            $("#username_field").remove();
                            ele = "";
                            ele += '<div id="username_field" class="alert alert-danger alert-dismissable">';
                            ele += '    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>';
                            ele += res.error;
                            ele += '</div>';
                            $(ele).insertBefore("#login_msg");
                            return false;
                        }
                    }
                })
            })
        });
    </script>
</body>
</html>
