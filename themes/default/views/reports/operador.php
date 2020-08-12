<?php
	  include_once ("segura.php");
	 
	  $user_logado = $_SESSION['userID'];

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" href="images/ICO.png" >
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <title>Seleção de Dados</title>
   
  <link rel="stylesheet" href="file:///C|/xampp/htdocs/pdv/themes/default/assets/dist/css/AdminLTE.min.css">
    <link href="file:///C|/xampp/htdocs/pdv/themes/default/assets/bootstrap/css/bootstrap.css" rel="stylesheet" />
  
     <!-- FONTAWESOME STYLES-->
    <link href="../../assets/dist/fonts/" rel="stylesheet" />
     <!-- MORRIS CHART STYLES-->
 
     <!-- GOOGLE FONTS-->
   
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="plugins/iCheck/all.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="plugins/colorpicker/bootstrap-colorpicker.min.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- Select2 -->
  
   </style>

   <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
     <!-- MORRIS CHART SCRIPTS -->
     <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
    <script src="assets/js/morris/datapiker.js"></script>
      <!-- CUSTOM SCRIPTS -->
<script src="assets/js/custom.js"></script>


   <script type="text/javascript">
            // When the document is ready
            $(document).ready(function () {
                
                $("#mes").datepicker( {
    format: "yyyy-mm-dd"
    
});
				
				
				
				$('#data2').datepicker({
                    format: "yyyy-mm-dd"
					
                }); 
				$('#data1').datepicker({
                    format: "yyyy-mm-dd"
					
                }); 
				
		
            });
			
  
        </script>
        
        <?php
$data = date ("Y-m-d");
$ano = date ("Y");
$hora = date ("H:i:s");

		 ?> 
</head>
<body>

      

      </nav>
        <div id="page-wrapper">

<div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.php">Dashboard</a>
                            </li>
                           <li class="active">
                                <i class="fa fa-edit"></i></li>
                                  <li class="active">
                                <i class="fa fa-edit"></i> Listagem de Vendas</li>
                                
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

  <div class="row">
                 <div class="box box-default">
                   <div class="box-header with-border">
                     <h3 class="box-title">Listagem de Vendas POS Por Operadores</h3>
                     <div class="box-tools pull-right">
                       <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                       <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                     </div>
</div>
<form role="form" action="relatorio_operador.php?fatura=fatura" enctype="multipart/form-data" name="matricula" method="POST" id="matricula" target="_blank" >
                   <!-- /.box-header -->
                   <div class="box-body">
                     <div class="row">
                       <div class="col-md-6">
                         <div class="form-group">
                         
                           <label>Da Data</label>
                           <input class="form-control" placeholder="a Data" name="data2" id="data2" value="<?php echo $data?>" >
                         </div>
                          <div class="form-group">
                         
                           <label>Do Operador</label>
                           <select name="operador1" class="form-control select2" style="width: 100%;">
                            <option value ="0" selected="selected">Todos</option> 
                                 </select>
                          </div>
                           <div class="form-group">
                         
                           <label>Do Cliente</label>
                           <select name="cliente1" class="form-control select2" style="width: 100%;">
                            <option value ="0" selected="selected">Todos</option>                           </select>
                          </div>
                           <div class="form-group">
                         
                           <label>Relatório</label>
                           <select name="relatorio" id="relatorio" class="form-control select2" style="width: 100%;">
                            <option value ="relatorio" selected="selected">Resumido</option>
                            <option value="relatorio">Detalhado</option>
                           </select>
                          </div>
                         <!-- /.form-group -->
                         
                        
                         <!-- /.form-group -->
                       </div>
                       <!-- /.col -->
                       <div class="col-md-6">
                          <div class="form-group">
                          <label >A Data</label>
                                
                                <input class="form-control" placeholder="da data" name="data1" id="data1" value="<?php echo $data?>" >
                          </div> 
                           <div class="form-group">
                         
                           <label>Ao Operador</label>
                           <select name="operador2" class="form-control select2" style="width: 100%;">
                             <option value = "9999" selected="selected" >Todos</option>
                                </select>
                           </div> 
                            <div class="form-group">
                         
                           <label>Ao Cliente</label>
                           <select name="cliente2" class="form-control select2" style="width: 100%;">
                            <option value ="99999" selected="selected">Todos</option>  
                                 </select>
                          </div>    
                          <!-- /.form-group -->
                       </div>
                       <!-- /.col -->
                     </div>
                     <!-- /.row -->
                   </div>
                   <!-- /.box-body -->
                   
  <div class="box-footer"> 
                    <button type="submit" class="btn btn-primary">Imprimir</button>
  </div>
  </div>
</form>
                 <!-- /#page-wrapper -->
<div class="panel-body">
                       <div class="box-body">
 <div style="font-size: 36px; color: #FF0004;" align="right"></div>
<script src="plugins/select2/select2.full.min.js"></script>
    <!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
<script src="plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
    <!-- bootstrap time picker -->
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <!-- SlimScroll 1.3.0 -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- iCheck 1.0.1 -->
<script src="plugins/iCheck/icheck.min.js"></script>
    <!-- FastClick -->
<script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
    <!-- Page script -->
<script>
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

        //Datemask dd/mm/yyyy
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        //Datemask2 mm/dd/yyyy
        $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
        //Money Euro
        $("[data-mask]").inputmask();

        //Date range picker
        $('#reservation').daterangepicker();
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            {
              ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
              },
              startDate: moment().subtract(29, 'days'),
              endDate: moment()
            },
        function (start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        );

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
          checkboxClass: 'icheckbox_minimal-red',
          radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_flat-green'
        });

        //Colorpicker
        $(".my-colorpicker1").colorpicker();
        //color picker with addon
        $(".my-colorpicker2").colorpicker();

        //Timepicker
        $(".timepicker").timepicker({
          showInputs: false
        });
	
		  
      });
    </script>
</body>
</html>
