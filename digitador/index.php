<?php
	require ($_SERVER['DOCUMENT_ROOT'].'/Framework/include/defined.php');
	require( _CONNECT_ );
	require( _SMARTY_ );
	
	//echo "ing a php";

	$var_scr = "false";
	$var_permiso = "";
	$var_permisoC = "";
	$var_permisoE = "";
	$empresa = (isset($_REQUEST["empresa"])?$_REQUEST["empresa"]:'');	
	
	if (validSessionCookie() == 1){
		if($conn->valid_connect()){
			$var_scr = "true";
		}

		$idu = $_SESSION[$_COOKIE["PHPSESSID"]]["idu"];
		if(isset($_SESSION[$_COOKIE["PHPSESSID"]]["idu"])) {
			$codRecurso = 'CTR-DIG';
			$lista_permisos = [];
			$str_SQL = "EXEC SEG_USUARIOS_SELECT_ROL_WEB  '$idu', '$codRecurso', 'RH' ";
			$rs  =  $conn->db_query( $str_SQL );

			while ($row  =  $conn->db_fetch_array( $rs )){
				$codigo = isset($row["codigo"])? $row["codigo"] :'';
				array_push($lista_permisos, $codigo );
				if ($codigo <> ''){
					$var_permiso .= "{codigo:'".$codigo."'},";
				}
			}

			if ( !in_array('CTR-DIG-07', $lista_permisos) ) { 
				echo "<script> alert ('No tiene autorización para ingresar a este módulo.'); location.href = '../../../'; </script>";

			} else {
				$v_perm = "false";
				if ($var_permiso != ''){
					$var_permiso = substr($var_permiso, 0, strlen($var_permiso)-1);
					$var_permiso = "var v_per_seg = {data:[".$var_permiso."]};";
					$v_perm = "true";
				}	
			

				$vc_script = "";
				$vc_script .= "<script>";
				$vc_script .= "var vb_host = '".HOST."/webControlTyT';";
				$vc_script .= "var vb_host_site = '".URL_SCRIPT."';";
				$vc_script .= "var vb_connection = ".$var_scr.";".
									$var_permiso;
				$vc_script .= "var vb_empresa = '".$empresa."';";
				$vc_script .= "</script>";
				echo $vc_script;
				$smarty->assign("session",$var_scr);
				$smarty->assign("urlHost",URL_SCRIPT);
				$msj = "";
				$smarty->display("index.html");
			}
		}	
	}else
		echo "<script> alert ('ALERTA: ".SESSION_X."'); location.href = '../../../'; </script>";
?>

