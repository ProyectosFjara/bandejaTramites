<?php /* Smarty version Smarty-3.0.6, created on 2015-08-21 17:08:51
         compiled from "smarty/templates/index.html" */ ?>
<?php /*%%SmartyHeaderCode:46543064355d7a173e5ecc4-84793298%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e51862780276e80934f4b094d15f8f9e94a27091' => 
    array (
      0 => 'smarty/templates/index.html',
      1 => 1440194756,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '46543064355d7a173e5ecc4-84793298',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<html>
<head>
  <title>Monitoreo Digitadores</title>
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getVariable('urlHost')->value;?>
/ext-3.3.0/resources/css/ext-all.css" />
    <link rel="stylesheet" type="text/css" href="../../../css_js_fonts/css/layout-browser.css" />    
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getVariable('urlHost')->value;?>
/ext-3.3.0/ux/statusbar/css/statusbar.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getVariable('urlHost')->value;?>
/ext-3.3.0/ux/css/LockingGridView.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getVariable('urlHost')->value;?>
/ext-3.3.0/shared/examples.css" />
    <style type="text/css">
    p {
        margin:5px;
    }
    .settings {
        /*background-image:url(<?php echo $_smarty_tpl->getVariable('urlHost')->value;?>
/ext-3.3.0/shared/icons/fam/folder_wrench.png);*/
    }
    .nav {
        /*background-image:url(<?php echo $_smarty_tpl->getVariable('urlHost')->value;?>
/ext-3.3.0/shared/icons/fam/folder_go.png);*/
    }
	
	.child-row { 
		font-weight: bold; 
	} 

	#table{
		font-family:Verdana, Geneva, sans-serif;
		border-collapse:collapse;
		
	}
	#table th{
		font-weight:bold;
		color:#FFF;
		background:#006AD5;
		padding: 5px;
		border:1px solid #fff;
	}
	
	#table td{
		color:#333;
		background:#C6E2FF;
		border:1px solid #fff;
		font-size:11px;
		padding-left:2px;
		padding-right:2px;
	}
	
	.alignCenter{
		text-align:center;
	}
	
	#table tr:hover > td {
		background:#89D8B0;
	}
	
	.bold-line .x-grid3-cell{
	  font-weight: bold;
	  font-size:12px;
	  font-style:italic;
	  font-family:"Courier New", Courier, monospace;
	}
	
	/*.x-grid3{
		background-image: url(<?php echo $_smarty_tpl->getVariable('urlHost')->value;?>
/images/backeeo.png) ;
	}*/
	.x-grid3-row-over{
		border:1px solid #06F;
    	background: url("<?php echo $_smarty_tpl->getVariable('urlHost')->value;?>
/images/fi.jpg");
	}
	
	.x-grid3-row-selected{
    	background: url("<?php echo $_smarty_tpl->getVariable('urlHost')->value;?>
/images/select.jpg");
	}
	
	.x-plain-1{
		background: url("<?php echo $_smarty_tpl->getVariable('urlHost')->value;?>
/images/title.png");
	}
	.x-panel{
		background: url("<?php echo $_smarty_tpl->getVariable('urlHost')->value;?>
/images/title.png");
	}
	.x-panel-header{
		background: url("<?php echo $_smarty_tpl->getVariable('urlHost')->value;?>
/images/title.png");
	}
	.x-toolbar{
		background: url("<?php echo $_smarty_tpl->getVariable('urlHost')->value;?>
/images/title.png");
	}
	
    </style>

    <script type="text/javascript">
	document.onkeydown = function(evento){  
		var evt = window.event || evento;
		if (evt && (evt.keyCode == 122 || evt.keyCode == 116)){ 
			evt.keyCode = 505;  
		} 
		
		if (evt.keyCode == 505 || evt.keyCode == 116){  
			return false;  
		}  
		
		if (evt && (evt.keyCode == 8)) 
		{ 
			valor = document.activeElement.value; 
			if (valor==undefined) { return false; } //Evita Back en página. 
			else 
			{ 
				if (document.activeElement.getAttribute('type')=='select-one') 
					{ return false; } //Evita Back en select. 
				if (document.activeElement.getAttribute('type')=='button') 
					{ return false; } //Evita Back en button. 
				if (document.activeElement.getAttribute('type')=='radio') 
					{ return false; } //Evita Back en radio. 
				if (document.activeElement.getAttribute('type')=='checkbox') 
					{ return false; } //Evita Back en checkbox. 
				if (document.activeElement.getAttribute('type')=='file') 
					{ return false; } //Evita Back en file. 
				if (document.activeElement.getAttribute('type')=='reset') 
					{ return false; } //Evita Back en reset. 
				if (document.activeElement.getAttribute('type')=='submit') 
					{ return false; } //Evita Back en submit. 
				else //Text, textarea o password 
				{ 
					if (document.activeElement.value.length==0) 
						{ return false; } //No realiza el backspace(largo igual a 0). 
					else 
						{ document.activeElement.value.keyCode = 8; } //Realiza el backspace. 
				} 
			} 
		} 
	} 
	var datosPdfComp;
	var datosPdfCompCs;
	var datosPdfCompIm;
	var banActRd1 = 0;
	var banActRd2 = 0;
	
	var uvar = null;
	var ivar = null;
	var sess = null;
	var wind;
	var sessionGlobal = true;
	function disableKey(event) {
	  if (!event) event = window.event;
	  if (!event) return;
	
	  var keyCode = event.keyCode ? event.keyCode : event.charCode;
	
	  if (keyCode == 116) {
	   window.status = "F5 key detected! Attempting to disabling default response.";
	   window.setTimeout("window.status='';", 2000);
	
	   // Standard DOM (Mozilla):
	   if (event.preventDefault) event.preventDefault();
	
	   //IE (exclude Opera with !event.preventDefault):
	   if (document.all && window.event && !event.preventDefault) {
		 event.cancelBubble = true;
		 event.returnValue = false;
		 event.keyCode = 0;
	   }
	
	   return false;
	  }
	}
	</script>
	
</head>
<body>
    <!-- use class="x-hide-display" to prevent a brief flicker of the content -->
    <div id="loading-mask" style=""></div>
    <div id="loading">
        <div class="loading-indicator"><img src="<?php echo $_smarty_tpl->getVariable('urlHost')->value;?>
/ext-3.3.0/shared/extjs/images/extanim32.gif" width="32" height="32" style="margin-right:8px;float:left;vertical-align:top;"/>Grupo T&amp;T Intranet- <a href="http://www.torresytorres.com">torresytorres.com</a><br /><span id="loading-msg">Cargando estilos e imagenes...</span></div>
    </div>
    <!-- LIBS -->
    <script type="text/javascript">document.getElementById('loading-msg').innerHTML = 'Cargando Core API...';</script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('urlHost')->value;?>
/ext-3.3.0/adapter/ext/ext-base.js"></script>
    <!-- ENDLIBS -->
	<script type="text/javascript">document.getElementById('loading-msg').innerHTML = 'Cargando UI Components...';</script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('urlHost')->value;?>
/ext-3.3.0/ext-all.js"></script>
	<!-- ENDLIBS -->
    <!-- OTRAS LIB -->
	<script type="text/javascript">document.getElementById('loading-msg').innerHTML = 'Cargando Otros Components...';</script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('urlHost')->value;?>
/ext-3.3.0/ux/statusbar/StatusBar.js"> </script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('urlHost')->value;?>
/ext-3.3.0/shared/examples.js"></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('urlHost')->value;?>
/ext-3.3.0/src/locale/ext-lang-es.js"></script>
    
	<!--END OTRAS LIB-->
    <script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('urlHost')->value;?>
/scriptJquery/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="../../../css_js_fonts/js/functionGlobal.js"></script>
    
    <script>
	if (vb_connection == false){
		Ext.MessageBox.show({
		   title: 'Mensaje ',
		   msg: 'Existe Problemas Internos con la Conexión a la BD...',
		   buttons: Ext.MessageBox.OK,
		   icon: Ext.MessageBox.ERROR
	   });
	}
    </script>
    <script type="text/javascript" src="script/action.js"></script>
    <div id="west" class="x-hide-display">
        
    </div>
    <div id="center2" class="x-hide-display">
        
    </div>
    <div id="tabPanel">
    <div id="center1" class="x-hide-display" align="center">
    </div>
    <div id="props-panel" class="x-hide-display" style="width:200px;height:200px;overflow:hidden;">
    </div>
    </div>
</body>
</html>