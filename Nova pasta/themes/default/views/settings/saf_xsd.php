 <style type="text/css">
     .content-wrap{
        width: 100%;
        margin-bottom: 10px;
     }
     .pattern-content{
        width: 100%;
        min-height: 200px;
        overflow: auto;
        resize: vertical;
     }
     .pattern-content-350{
        height: 350px;
     }
     .pattern-content-title{
        font-size: 20px;
        color: white;
        margin: 0px;
     }
     textarea{
        font-size: 14px;
     }
 </style>
 <?php
    $start_date = date("Y-m-01");
    $end_date = date("Y-m-t");
 ?>
<section class="content">
    <div class="row" style="">
        <?= form_open("settings/xmlReport", 'name="saf_xsd" method="post"'); ?>
        <div class="col-md-12">

            <div class="row" style="background:#78abcc;">
                <div class="col-md-2 col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="start_date"><?= lang("start_date"); ?></label>
                        <?= form_input('start_date', $start_date, 'class="form-control datetimepicker" id="start_date"');?>
                    </div>
                </div>
                <div class="col-sm-2 col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="end_date"><?= lang("end_date"); ?></label>
                        <?= form_input('end_date', $end_date, 'class="form-control datetimepicker" id="end_date"');?>
                    </div>
                </div>

                <div class="col-md-2 col-sm-4">
                    <button style="margin-top: 25px;" href="<?php echo base_url("settings/xmlReport");  ?>" class="btn btn-success" id="export_btn"><?php echo lang("Export XML"); ?> </button>
                </div>
            </div>
        <?= form_close(); ?>
        </div>
    <?= form_open("settings/save_pattern", 'name="saf_xsd" method="post"'); ?>
        <div class="col-md-6 col-xs-12">
            <div class="content-wrap">
                <p class="pattern-content-title"><?php echo lang("SAF-AO XSD File Content"); ?></p>
                <textarea name="xsd_content" id="xsd_content" class="pattern-content pattern-content-350" spellcheck='false' required=""><?php echo $saf_xsd_setting['xsd_content']; ?></textarea>
            </div>
            <div style="margin-bottom: 10px;">
                <a class="btn btn-info" id="generate_btn"><?php echo lang("Generate XML Pattern"); ?></a>
                <button type="submit" class="btn btn-info" id="save_btn"><?php echo lang("Save Pattern"); ?></button>
                

            </div>
            <div class="content-wrap">
                <p class="pattern-content-title"><?php echo lang("SAF-AO XML Model"); ?></p>
                <textarea name="xml_pattern" id="xml_pattern" class="pattern-content pattern-content-350" spellcheck='false' required=""><?php echo $saf_xsd_setting['xml_pattern']; ?></textarea>
            </div>
        </div>
        <div class="col-md-6 col-xs-12">
            <div class="content-wrap">
                <p class="pattern-content-title"><?php echo lang("SAF-AO XML Pattern"); ?></p>
                <textarea name="audit_pattern" id="audit_pattern" class="pattern-content" spellcheck='false' required=""><?php echo $saf_xsd_setting['audit_pattern']; ?></textarea>
            </div>

            <div class="content-wrap">
                <p class="pattern-content-title"><?php echo lang("XML Header Pattern"); ?></p>
                <textarea name="header_pattern" id="header_pattern" class="pattern-content" spellcheck='false'><?php echo $saf_xsd_setting['header_pattern']; ?></textarea>
            </div>

            <div class="content-wrap">
                <p class="pattern-content-title"><?php echo lang("XML Account Pattern"); ?></p>
                <textarea name="account_pattern" id="account_pattern" class="pattern-content" spellcheck='false'><?php echo $saf_xsd_setting['account_pattern']; ?></textarea>
            </div>

            <div class="content-wrap">
                <p class="pattern-content-title"><?php echo lang("XML Customer Pattern"); ?></p>
                <textarea name="customer_pattern" id="customer_pattern" class="pattern-content" spellcheck='false'><?php echo $saf_xsd_setting['customer_pattern']; ?></textarea>
            </div>

            <div class="content-wrap">
                <p class="pattern-content-title"><?php echo lang("XML Supplier Pattern"); ?></p>
                <textarea name="supplier_pattern" id="supplier_pattern" class="pattern-content" spellcheck='false'><?php echo $saf_xsd_setting['supplier_pattern']; ?></textarea>
            </div>

            <div class="content-wrap">
                <p class="pattern-content-title"><?php echo lang("XML Product Pattern"); ?></p>
                <textarea name="product_pattern" id="product_pattern" class="pattern-content" spellcheck='false'><?php echo $saf_xsd_setting['product_pattern']; ?></textarea>
            </div>

            <div class="content-wrap">
                <p class="pattern-content-title"><?php echo lang("XML TaxTable Pattern"); ?></p>
                <textarea name="taxtable_pattern" id="taxtable_pattern" class="pattern-content" spellcheck='false'><?php echo $saf_xsd_setting['taxtable_pattern']; ?></textarea>
            </div>

            <div class="content-wrap">
                <p class="pattern-content-title"><?php echo lang("XML General Ledger Entries Pattern"); ?></p>
                <textarea name="generalledgerentries_pattern" id="generalledgerentries_pattern" class="pattern-content" spellcheck='false'><?php echo $saf_xsd_setting['generalledgerentries_pattern']; ?></textarea>
            </div>

            <div class="content-wrap">
                <p class="pattern-content-title"><?php echo lang("XML Sale Invoice Pattern"); ?></p>
                <textarea name="saleinvoice_pattern" id="saleinvoice_pattern" class="pattern-content" spellcheck='false'><?php echo $saf_xsd_setting['saleinvoice_pattern']; ?></textarea>
            </div>

            <div class="content-wrap">
                <p class="pattern-content-title"><?php echo lang("XML Movement of Good Pattern"); ?></p>
                <textarea name="movementofgood_pattern" id="movementofgood_pattern" class="pattern-content" spellcheck='false'><?php echo $saf_xsd_setting['movementofgood_pattern']; ?></textarea>
            </div>

            <div class="content-wrap">
                <p class="pattern-content-title"><?php echo lang("XML Working Documents Pattern"); ?></p>
                <textarea name="workingdocuments_pattern" id="workingdocuments_pattern" class="pattern-content" spellcheck='false'><?php echo $saf_xsd_setting['workingdocuments_pattern']; ?></textarea>
            </div>

            <div class="content-wrap">
                <p class="pattern-content-title"><?php echo lang("XML Payment Pattern"); ?></p>
                <textarea name="payment_pattern" id="payment_pattern" class="pattern-content" spellcheck='false'><?php echo $saf_xsd_setting['payment_pattern']; ?></textarea>
            </div>

            <div class="content-wrap">
                <p class="pattern-content-title"><?php echo lang("XML Purchase Invoice Pattern"); ?></p>
                <textarea name="purchaseinvoice_pattern" id="purchaseinvoice_pattern" class="pattern-content" spellcheck='false'><?php echo $saf_xsd_setting['purchaseinvoice_pattern']; ?></textarea>
            </div>

        </div>
    </div>
    </form>
</section>
<script src="<?= $assets ?>plugins/bootstrap-datetimepicker/js/moment.min.js" type="text/javascript"></script>
<script src="<?= $assets ?>plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>

<script type="text/javascript">
    $(function(){
        $('.datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $("textarea").change(function(){
            $("#export_btn").attr("disabled","true");
        })
        $("#generate_btn").click(function(){
            $.ajax({
                url: "https://cors-anywhere.herokuapp.com/http://xsd2xml.com/GetXmlData",
                data: {XsdData:$("#xsd_content").val()},
                dataType:"json",
                type: 'POST',
                success: function (res) {
                    if(res[0] == true) {
                        re = RegExp("str1234",'g');
                        res[1] = res[1].replace(re,"XML Correct Value");
                        
                        re = RegExp("2012-12-13",'g');
                        res[1] = res[1].replace(re,"YYYY-MM-DD");
                        $("#xml_pattern").val(res[1]);
                        var xml_content =  $("#xml_pattern").val();
                        $.ajax({
                            url: base_url + "settings/getXmlPattern",
                            data: {'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>', xml: xml_content},
                            dataType:"json",
                            type: "post",
                            success : function(result){
                                $("#audit_pattern").val(result.Audit);
                                $("#header_pattern").val(result.Header);
                                $("#account_pattern").val(result.Account);
                                $("#customer_pattern").val(result.Customer);
                                $("#supplier_pattern").val(result.Supplier);
                                $("#product_pattern").val(result.Product);
                                $("#taxtable_pattern").val(result.TaxTable);
                                $("#generalledgerentries_pattern").val(result.GeneralLedgerEntries);
                                $("#saleinvoice_pattern").val(result.SalesInvoices);
                                $("#movementofgood_pattern").val(result.MovementOfGoods);
                                $("#workingdocuments_pattern").val(result.WorkingDocuments);
                                $("#payment_pattern").val(result.Payments);
                                $("#purchaseinvoice_pattern").val(result.PurchaseInvoices);
                            }
                        })

                    }    else {
                        $("#xml_pattern").val(res[1]);
                    }               
                }
            });
        })
    })  
</script>
