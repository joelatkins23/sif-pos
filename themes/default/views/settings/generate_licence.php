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
                    <table id="UTable" class="table table-bordered table-striped table-hover">
                        <thead class="cf">
                        <tr>
                            <th><?php echo lang('full_name'); ?></th>
                            <th><?php echo lang('username'); ?></th>
                            <th><?php echo lang('email'); ?></th>
                            <th><?php echo lang('group'); ?></th>
                            <th><?php echo lang('licence_code'); ?></th>
                            <th><?php echo lang('months'); ?></th>
                            <th><?php echo lang('expired_date'); ?></th>
                            <th style="width:100px;"><?php echo lang('status'); ?></th>
                            <th style="width:80px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($users as $user) {
                            $licence_info = get_row("tec_licences",array("user_id"=>$user['id']));
                            $licence_info['expired_month'] = base64_decode($licence_info['expired_month']);
                            echo '<tr>';
                            echo '<td>'.$user['first_name']." ".$user['last_name'].'</td>';
                            echo '<td>'.$user['username'].'</td>';
                            echo '<td>'.$user['email'].'</td>';
                            $group_info = get_row("tec_groups",array("id"=>$user['group_id']));
                            echo '<td>'.$group_info['description'].'</td>';
                            echo '<td>'.$licence_info['licence'].'</td>';
                            echo '<td>'.$licence_info['expired_month'].'</td>';
                            echo '<td>';
                            if($licence_info['insert_date'] == "") 
                                echo "&nbsp;";
                            else {
                                $expired_date = date("Y-m-d", strtotime("+".$licence_info['expired_month']." month", strtotime($licence_info['insert_date'])));
                                echo $expired_date;
                            }
                            echo '</td>';
                            echo '<td>';
                            if($licence_info){
                                if($licence_info['insert_date']!="" && strtotime($expired_date) < strtotime(date("Y-m-d"))) 
                                    echo "Expired";
                                if($licence_info['status'] == "used") echo "Used";
                                if($licence_info['status'] == "") echo "No Used";
                            } else {
                                echo "No generated";
                            }
                            echo '</td>';
                            if($licence_info['status'] == "used" && strtotime($expired_date) > strtotime(date("Y-m-d")))
                                echo '<td><button class="btn btn-success" disabled>Generate</button></td>';
                            else 
                                echo '<td><button class="btn btn-success generate_btn" data-id="'.$user['id'].'" data-name="'.$user['first_name']." ".$user['last_name'].'">Generate</button></td>';

                            echo "</tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" data-easein="flipYIn" id="licence_modal" tabindex="-1" role="dialog" aria-labelledby="dsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <?= form_open('settings/generate', 'id="pos-sale-form"'); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title" id="dsModalLabel"><?php echo lang("generate_licence"); ?></h4>
            </div>
            <p style="margin: 0px; padding: 0px 15px;">
                <span style="font-weight: 700;"><?php echo lang("username"); ?> : </span>
                &nbsp;
                <span id="user_name"></span>
            </p>
            <div class="modal-body">
                 <input type="hidden" name="user_id" id="user_id">
                  <div class="form-group">
                    <?= lang("expired_month", "expired_month"); ?> *
                    <input type="number" name="expired_month" class="form-control" id="expired_month" required="" min="1">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-sm pull-right"><?= lang('Generate') ?></button>
                <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal"><?= lang('close') ?></button>
            </div>
        </div>
        <?= form_close(); ?>
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
