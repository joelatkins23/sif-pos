<link rel="stylesheet" type="text/css" href="css/painel.css" />
<link rel="stylesheet" type="text/css" href="css/tipTip.css" />
<link rel="stylesheet" type="text/css" href="js/shadowbox/shadowbox.css" />
<link href='http://fonts.googleapis.com/css?family=Terminal+Dosis' rel='stylesheet' type='text/css' />
<link rel="icon" type="image/png" href="images/favico.png" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/ps.js"></script>
<script type="text/javascript" src="js/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="js/mask.js"></script>
<script type="text/javascript" src="js/tiptip.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>
<script type="text/javascript">
Shadowbox.init();

$(function(){
	$(".tip").tipTip({maxWidth: "auto", edgeOffset: 10});
});

jQuery(document).ready(function($){
	$('#input_senha').pstrength();
});

jQuery(function($){
   $("#telefone").mask("(99) 9999.9999");
   $("#cpf").mask("999.999.999-99");
   $("#cep").mask("99.999-999");
   $("#data").mask("99/99/9999 99:99:99");
});

google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
  function drawChart() {
	var data = google.visualization.arrayToDataTable([
	  ['Ano', 'Visitas', 'Pageviews'],
	  ['Março',  1000,      400],
	  ['Maio',  1170,      460],
	  ['Junho',  660,       1120],
	  ['Julho',  1030,      540]
	]);

	var options = {
	  title: 'Estatísticas do seu site:',
	  hAxis: {title: 'Mês', titleTextStyle: {color: 'red'}}
	};

	var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
	chart.draw(data, options);
  }
  
</script>
<script type="text/javascript">
  	tinyMCE.init({
		mode : "specific_textareas",
        editor_selector : "editor",
		language : "pt",
		theme : "advanced",
		elements : 'abshosturls',
		relative_urls : false,
		remove_script_host : false,
		skin : "o2k7",
		skin_variant : "silver",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

theme_advanced_buttons1 :"fullscreen,removeformat,cleanup,|,pastetext,pasteword,|,bold,italic,underline,strikethrough,|,forecolor,backcolor,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink,anchor,image,undo,redo",
		theme_advanced_buttons2 : "formatselect,fontsizeselect,|,outdent,indent,ltr,rtl,blockquote,sub,sup,hr,|,preview,print,code,|,insertdate,inserttime",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "center",
		theme_advanced_statusbar_location : false,
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",
		file_browser_callback : "tinyBrowser",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>