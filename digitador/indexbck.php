<?php
	require ($_SERVER['DOCUMENT_ROOT'].'/Framework/include/defined.php');
	require( _CONNECT_ );
	require( _SMARTY_ );
	
	$var_scr = "false";
	$var_permiso = "";
	$var_permisoC = "";
	$var_permisoE = "";
	$empresa = (isset($_REQUEST["empresa"])?$_REQUEST["empresa"]:'');
	if (validSessionCookie() == 1){
		if($conn->valid_connect()){
			$var_scr = "true";
		}
		
		$vc_script = "";
		$vc_script .= "<script>";
		$vc_script .= "var vb_host = '".HOST."/webControlTyT';";
		$vc_script .= "var vb_host_site = '".URL_SCRIPT."';";
		$vc_script .= "var vb_connection = ".$var_scr.";";
		$vc_script .= "var vb_empresa = '".$empresa."';";
		$vc_script .= "</script>";
		echo $vc_script;
		$smarty->assign("session",$var_scr);
		$smarty->assign("urlHost",URL_SCRIPT);
		$msj = "";
		$smarty->display("index.html");
	}else
		echo "<script> alert ('ALERTA: ".SESSION_X."'); location.href = '../../../'; </script>";	
?>