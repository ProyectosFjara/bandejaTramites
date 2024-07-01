<?php
/**
 * Proyecto Piloteando 
 * Nombre del archivo: jsonSeekDai.php
 * Descripción del contenido del archivo
 * 		Obtiene los datos de la consulta de la Tramites DAI.
 *
 * @author 			Rodolfo Balla <rballa@torresytorres.com>
 * @copyright 		Copyright 2013, Grupo Torres&Torres.
 * @modifiedby		Rodolfo Balla <rballa@torresytorres.com>
 * @lastmodified	06/03/2015
*/
	header("Content-Type: text/plain");
	require ($_SERVER['DOCUMENT_ROOT'].'/Framework/include/defined.php');
	require( _CONNECT_ );
        /*include_once($_SERVER['DOCUMENT_ROOT'].'/Framework/PHPMailer-master/class.phpmailer.php');
	$mail = new PHPMailer();*/
	/*Envio de Mails / configuracion*/
	/*require $_SERVER['DOCUMENT_ROOT'].'/Framework/PHPMailer-master/PHPMailerAutoload.php';
	include $_SERVER['DOCUMENT_ROOT'].'/Framework/include/configMail.php';
	$mail = new PHPMailer();
	$mail->SMTPAuth = $SMTPAuth;
	$mail->Host = $Host; // SMTP a utilizar. Por ej. mail.tudominio.com
	$mail->Username = $Username; // Correo completo a utilizar
	$mail->Password = $Password; // ContraseÃƒÂ±a
	$mail->Port = $Port; // Puerto a utilizar
	$mail->IsSMTP();*/
	/*Fin configuracion*/
    include($_SERVER["DOCUMENT_ROOT"]."/Framework/newsletters/sendPhpMailer.php");

	$cp_typeQuery =  isset($_POST["typeQuery"])?$_POST["typeQuery"]:"";
	/*Monitoreo tramites*/
	$tramiteId = isset($_POST['tramiteId'])?$_POST['tramiteId']:'';					 
	$digitadorId = isset($_POST['digitadorId'])?$_POST['digitadorId']:'';	
	$digitadorNomb = isset($_POST['digitadorNomb'])?$_POST['digitadorNomb']:'';	
					 
	$horaEst = isset($_POST['horaEst'])?$_POST['horaEst']:'';					 
	$FechaEst = isset($_POST['FechaEst'])?$_POST['FechaEst']:'';					 
	$ObsEst = isset($_POST['ObsEst'])?$_POST['ObsEst']:'';	
	$orden = isset($_POST['orden'])?$_POST['orden']:'';
	$mailUser = isset($_POST['mail'])?$_POST['mail']:'';	

	$nameBase = '';
	$idUser = '';
	$codeUser = '';
	$mailEnvio = '';
	/*Tipos de consultas que se pueden ejecutar*/
	if ($conn->valid_connect() && isset($_SESSION[$_COOKIE["PHPSESSID"]])){
		$nameBase = $_SESSION[$_COOKIE["PHPSESSID"]]["empresa"];
		$idUser = $_SESSION[$_COOKIE["PHPSESSID"]]["idu"];
		$codeUser = $_SESSION[$_COOKIE["PHPSESSID"]]["codu"];
		$mailEnvio = $_SESSION[$_COOKIE["PHPSESSID"]]["email"];
		switch($cp_typeQuery){
			case 'save.assign.digitador':
				echo saveAssignDigitador();
			break;
		}
	}else{
		$arr_data = array();
		$arr_paging = array('data'=> $arr_data, 'conexion'=>'Error en la Conexión ó a Caducado su sessión');
		echo json_encode($arr_paging);
	}
	
	/*Asignación de Digitador*/
	function saveAssignDigitador(){
		global $conn, $class_fn_basic, $tramiteId, $mailUser, $orden, $digitadorId, $horaEst, $FechaEst, $ObsEst, $digitadorNomb, $nameBase, $idUser, $codeUser, $mailEnvio;
		$arr_paging = array();
		
 		$CreadoPor = $codeUser;
		$supervisorID = $idUser;
		
		$ErrorMensaje = "Error de Conexión, vuelva a iniciar sessión";
		$NumError = 1;
		if ($CreadoPor != ''){
			$pcID = $class_fn_basic->sysGetIpClientSrv()." #". $CreadoPor;
			$str_SQL = str_replace("&nbsp;", "NULL"," $nameBase..PRO_UPDATE_ASSIGN_DIGITADOR_EXP_CORRECTORA  ".
									"'$tramiteId', '$digitadorId', '$horaEst', '$FechaEst', '$ObsEst', '$CreadoPor', '$pcID', '$supervisorID', '$digitadorNomb' ");
			$rs = $conn->db_query($str_SQL);
			$row = $conn->db_fetch_array($rs);
	
			$ErrorMensaje = $row["ErrorMensaje"];
			$NumError = $row["NumError"];
			$Email =  $row["Email"];
							
			$ErrorMensaje = ($ErrorMensaje == "")?"Problemas en el proceso..":$ErrorMensaje;
			$NumError = ($NumError == "")?"1":$NumError;
			if($NumError == "0"){
				$Asunto = "Digitación Trámite ($orden)";
				$MailUser = $mailEnvio;
				$Para = $mailUser;
				if(!mailSend($Asunto, $Para, $MailUser, $orden, $horaEst, $CreadoPor, $Email)){
					$ErrorMensaje .= "//Problemas al enviar el Mail";
					$NumError = 1;
				}
			}
		}
		
		$arr_data = array(
			'ErrorMensaje'=>$ErrorMensaje,
			'NumError'=>$NumError
		);
		$arr_paging = array('data'=>$arr_data, 'conexion'=>'', 'str'=>$str_SQL);
		return json_encode($arr_paging);
	}

	/*function mailSend($Asunto, $Para, $MailUser, $orden, $horaEst, $CreadoPor, $mailOficial = ''){
		global $conn, $class_fn_basic, $mail ;

		$tr = "<table>";
		$importador = isset($_POST['importador'])?$_POST['importador']:'';
		if($importador!='')
			$tr .= "<tr><td class=det colspan=5>$importador</td></tr>";
		$tr .= "<tr>";
		$tr .= "<td class=det>Orden</td>";
		$tr .= "<td class=det>$orden</td>";
		$tr .= "<td class=det>Tiempo Estimado</td>";
		$tr .= "<td class=det>$horaEst</td>";
		$tr .= "<td class=det>Se toma control del tiempo a partir de la creacion de la Observación</td>";
		$tr .= "</tr>";
		$tr .= "</table>";
		
		
		$body = $mail->styleCss().
				"<table border=0 cellpadding=0 cellspacing=0 background=\"../../images/background.JPG\">".
							"<tr><td colspan='2'>".
							"<div><img src=\"../../images/headtyt.jpg\" ></div><br/><br/>".
							"</td></tr>".
							"<tr>".
							"<td width='15%'>".
							"<div align='center'><img src=\"../../images/lefttyt.jpg\" border='none'></div>".
							"</td>".
							"<td width='85%'>".
								$tr.
							"</td>".
						"</tr>".
						"<tr>".
						"<td>".
						"</td>".
						"<td>".
						"<br/><div align='center'><img src=\"../../images/foottyt.jpg\"></div>".
						"</td>".
						"</tr>".
					"</table>";

		$body             = eregi_replace("[\]",'',($body)); 
		//$from = "$CreadoPor@torresytorres.com";
		
		$mail->From       = $MailUser;//"rballa@torresytorres.com";
		$mail->FromName   = "Asignación de Trámite";
		
		$Subject = "Orden $orden //Asignación de Trámite";
		$mail->Subject    = ($Subject);
		
		$mail->AltBody    = ""; // optional, comment out and test
		//echo $body;
		$mail->MsgHTML($body); 
		//$mail->Body = $body; 
		$mail->IsHTML(true);
		$mails = "";
		
		$mail->AddAddress("$Para", "");
		
		if ($mailOficial != '')
			$mail->AddCC("$mailOficial", "");
		
		
		$mail->Priority = 1;
		if(!$mail->Send()) {
			return false;
			//echo json_encode (array('data' => "Problemas al enviar el Mail..", 'error'=>1),$mail->ErrorInfo);
		} else {
			return true;
			//echo json_encode ( array('data' => "Mensaje enviado..", 'error'=>0));
		}
	}*/
	function mailSend($Asunto, $Para, $MailUser, $orden, $horaEst, $CreadoPor, $mailOficial = ''){
		global $conn, $class_fn_basic, $mail, $pathRoot, $pathFramework ;

		$tr = '<table style="border: 1px solid #2879CB;padding: 3px;background: #f3f4f5; '.
				'font-family: Cambria; font-size: 12px;" width="100%">';
		$importador = isset($_POST['importador'])?$_POST['importador']:'';
		if($importador!='')
			$tr .= "<tr><td class=det colspan=5>$importador</td></tr>";
		$tr .= "<tr>";
		$tr .= "<td>Orden</td>";
		$tr .= "<td>$orden</td>";
		$tr .= "<td>Tiempo Estimado</td>";
		$tr .= "<td>$horaEst</td>";
		$tr .= "<td>Se toma control del tiempo a partir de la creacion de la Observación</td>";
		$tr .= "</tr>";
		$tr .= "</table>";
		
		
		$body = $tr;
		/*
		* Reemplazar datos en plantilla de correo
		*/
		$body = str_replace("{{body}}", $body, file_get_contents($pathFramework."/newsletters/plantilla1.html"));
		$body = eregi_replace("[\]",'',($body)); 
		/*
		* Asignar lista de mails, CC, CCO, files
		*/
		$address = array();
		$CC = array();
		$BCC = array();
		$files = array();

		$from       = $MailUser;	
		$subject = "Asignación de Trámite //"."Orden $orden //Asignación de Trámite";
		
		array_push($address, array("mail"=>"$Para", "name"=>""));
		array_push($BCC, array("mail"=>"$mailOficial", "name"=>""));
		
		// array_push($BCC, array("mail"=>"rballa@torresytorres.com", "name"=>""));
		// array_push($BCC, array("mail"=>"rmacias@torresytorres.com", "name"=>""));
		
		$mensajeMail = sendMailNewsletter($subject, $body, $from, json_encode($address), json_encode($CC), json_encode($BCC), json_encode($files));
		$respuesta = json_decode($mensajeMail);

		if ($respuesta->error=="0")
			return true;
		else
			return false;
	}
	
?>