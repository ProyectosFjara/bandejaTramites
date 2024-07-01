<?php
/**
 * Proyecto Piloteando
 * Nombre del archivo: jsonSeekDai.php
 * Descripción del contenido del archivo
 * 		Obtiene los datos de la consulta de la Tramites-DAI.
 *
 * @author 			Rodolfo Balla <rballa@torresytorres.com>
 * @copyright 		Copyright 2013, Grupo Torres&Torres.
 * @modifiedby		Rodolfo Balla <rballa@torresytorres.com>
 * @lastmodified	06/03/2015
*/
	header("Content-Type: text/plain");
	require ($_SERVER['DOCUMENT_ROOT'].'/Framework/include/defined.php');
	require( _CONNECT_ );
	
	$cp_typeQuery =  isset($_POST["typeQuery"])?$_POST["typeQuery"]:"";

	$start = isset($_POST['start'])?$_POST['start']:0;
	$limit = isset($_POST['limit'])?$_POST['limit']:0;

	/*NUEVOS DATOS*/
	$digitadorId = isset($_POST['digitadorId'])?$_POST['digitadorId']:'';
	$supervisorId = isset($_POST['supervisorId'])?$_POST['supervisorId']:'';
	$tramiteId = isset($_POST['tramiteId'])?$_POST['tramiteId']:'';
	
	$nameBase = "";
	/*Tipos de consultas que se pueden ejecutar*/
	if ($conn->valid_connect()&& isset($_SESSION[$_COOKIE["PHPSESSID"]])){
		$nameBase = $_SESSION[$_COOKIE["PHPSESSID"]]["empresa"];
		switch($cp_typeQuery){
			case 'lista.no.programado':
				echo loadListNoProgramado();
			break;
			case 'list.status.cia':
				echo loadListStatus();
			break;
			case 'view.operaciones.cia':
				echo loadOperacionesUlt();
			break;
			case 'cmb.turnos':
				echo loadListTimer();
			break;
			case 'timer.tramite':
				echo loadTimerTramite();
			break;	
		}
	}else{
		$arr_data = array();
		$arr_paging = array('data'=> $arr_data, 'conexion'=>'Error en la Conexión ó a Caducado su sessión');
		echo json_encode($arr_paging);
	}

	/*Ordenes No Programadas*/
	function loadListNoProgramado (){
		global $conn, $class_fn_basic, $nameBase;
		$arr_data = array();
		$oficina = isset($_POST['oficina'])?$_POST['oficina']:'01';
		$str_SQL = "EXEC  $nameBase..MON_SELECT_TRAMITES_DIGITADOR_EXP  '$oficina'"; 
		
		$cont = 0;
		$contAsig = 0;
		$contAsigOtraEtapa = 0;
		$contNAsig = 0;
		$contDae = 0;
		if ( $str_SQL != ''){
			$rs  =  $conn->db_query( $str_SQL );
			while ($row  =  $conn->db_fetch_array( $rs )){
				$tramiteId= $class_fn_basic->sysGetDataFieldSrv( $row[ "tramiteId" ] );
				$fechaLlegada= $class_fn_basic->sysGetDataFieldSrv( $row[ "fechaLlegada" ] );
				$dias= $class_fn_basic->sysGetDataFieldSrv( $row[ "dias" ] );
				$semaforo= $class_fn_basic->sysGetDataFieldSrv( $row[ "semaforo" ] );
				$fecha= $class_fn_basic->sysGetDataFieldSrv( $row[ "fecha" ] );
				$hora= $class_fn_basic->sysGetDataFieldSrv( $row[ "hora" ] );
				$orden= $class_fn_basic->sysGetDataFieldSrv( $row[ "orden" ] );
				$tipoCarga= $class_fn_basic->sysGetDataFieldSrv( $row[ "tipoCarga" ] );
				$pedido= $class_fn_basic->sysGetDataFieldSrv( $row[ "pedido" ] );
				$producto= $class_fn_basic->sysGetDataFieldSrv( $row[ "producto" ] );
				$importador= $class_fn_basic->sysGetDataFieldSrv( $row[ "importador" ] );
				$items= $class_fn_basic->sysGetDataFieldSrv( $row[ "items" ] );
				$cnt20= $class_fn_basic->sysGetDataFieldSrv( $row[ "cnt20" ] );
				$cnt40= $class_fn_basic->sysGetDataFieldSrv( $row[ "cnt40" ] );
				$etapa= $class_fn_basic->sysGetDataFieldSrv( $row[ "etapa" ] );
				$digitadorNom= ltrim(rtrim($class_fn_basic->sysGetDataFieldSrv( $row[ "digitadorNom" ] )));
				$digitadorId= $class_fn_basic->sysGetDataFieldSrv( $row[ "digitadorId" ] );
				$tiempoDigitar= $class_fn_basic->sysGetDataFieldSrv( $row[ "tiempoDigitar" ] );
				
				$asignadoDate = $class_fn_basic->sysGetDataFieldSrv( $row[ "asignadoDate" ] );
				$daeDate= $class_fn_basic->sysGetDataFieldSrv( $row[ "daeDate" ] );
				$daeHora= $class_fn_basic->sysGetDataFieldSrv( $row[ "daeHora" ] );
				
				$daeUser= $class_fn_basic->sysGetDataFieldSrv( $row[ "creadoPor" ] );
				$tiempo = ( $row[ "tiempo" ] );
				$tiempoConv = conversorMinutos($tiempo);
				//$daeHoraEstTer= $daeDate." ".$class_fn_basic->sysGetDataFieldSrv( $row[ "daeHoraEstTer" ] );
				$daeDate= ltrim(rtrim($daeDate." ".$daeHora));
				
				$desContenedor= $class_fn_basic->sysGetDataFieldSrv( $row[ "desContenedor" ] );
				$anticipado= $class_fn_basic->sysGetDataFieldSrv( $row[ "anticipado" ] );
				$EtapaID = $class_fn_basic->sysGetDataFieldSrv( $row[ "EtapaID" ] );
				$Problema = $class_fn_basic->sysGetDataFieldSrv( $row[ "Problema" ] );
				$ordenPP = $class_fn_basic->sysGetDataFieldSrv( $row[ "ordenPP" ] );
				//22/01/2015|53|#BCA9F5
				$controlTramite = $class_fn_basic->sysGetDataFieldSrv( $row[ "controlTramite" ] );
				$Refrendo = $class_fn_basic->sysGetDataFieldSrv( $row[ "Refrendo" ] );
				$arrControl = explode("|",$controlTramite);
				
				$fechaOfi = "";
				$diasOfi = "";
				$colorOfi = "";
				if(count($arrControl)==3 ){
				$fechaOfi = $arrControl[0];
				$diasOfi = $arrControl[1];
				$colorOfi = $arrControl[2];
				}
				
				
				$ordenTyTTmp = $orden ;
				if ($daeDate != '' && in_array($EtapaID, array("0000000214","0000000144")) )
					$contDae++;
				if (strlen($orden)>0){
					$ordenTyTTmp = substr($orden,0,4)."-".substr($orden,4,2)/*."-"*/.substr($orden,6,5);
				}
				
				if ($digitadorNom!='' && in_array($EtapaID, array("0000000214","0000000144") ))
					$contAsig++;
				if ($digitadorNom!='' && in_array($EtapaID, array("0000000130") ))	
					$contAsigOtraEtapa++;
				$posicion_coincidencia = strpos(strtoupper($desContenedor), "REEFER");
				$colorReeferCont3 = "";
				if ($posicion_coincidencia === false) 
					$colorReeferCont3 = "";
				else
					$colorReeferCont3 = "#FF7373";
				
				if ($cnt20>2 || $cnt40>2)
					$colorReeferCont3 = "#FF7373";
					
				array_push($arr_data, array(
					'fechaLlegada'=>$fechaLlegada,
					'dias'=>$dias,
					'semaforo'=>$semaforo,
					'fecha'=>$fecha,
					'hora'=>$hora,
					'orden'=>$ordenTyTTmp,
					'tipoCarga'=>$tipoCarga,
					'pedido'=>$pedido,
					'producto'=>$producto,
					'importador'=>$importador,
					'items'=>$items,
					'cnt20'=>$cnt20,
					'cnt40'=>$cnt40,
					'etapa'=>$etapa,
					'digitadorNom'=>$digitadorNom,
					'digitadorId'=>$digitadorId,
					'tiempoDigitar'=>$tiempoDigitar,
					//'cont20'=>$cont20,
					//'cont40'=>$cont40,
					'tramiteId'=>$tramiteId,
					'asignadoDate'=>$asignadoDate,
					'daeDate'=>$daeDate,
					'tiempo'=>$tiempo,
					'desContenedor'=>$desContenedor,
					'daeUser'=>$daeUser,
					'tiempoConv'=>$tiempoConv,
					'anticipado'=>$anticipado,
					'colorReeferCont3'=>$colorReeferCont3,
					'problema' => $Problema,
					'fechaOfi' =>$fechaOfi,
					'diasOfi' =>$diasOfi,
					'colorOfi' =>$colorOfi,
					'ordenPP'=>$ordenPP,
					'refrendo'=>$Refrendo
				));
				$cont++;
			}
			$contNAsig = $cont - ($contAsig + $contAsigOtraEtapa);
		}
				
		$arr_paging = array('SQL'=>$str_SQL, 'contOtraEtapa'=>$contAsigOtraEtapa, 'totalCount'=>$contAsig,'totalCountDae'=>$contDae, 'data'=> $arr_data, 'conexion'=>'');
		return json_encode($arr_paging);
	}

	/**
	 * Lista de Items Digitadores, equipos estatus "Estatus Recursos"
	 */	
	function loadListStatus (){
		global $conn, $class_fn_basic, $nameBase;
		$arr_data = array();
		$oficina = isset($_POST['oficina'])?$_POST['oficina']:'01';
		$str_SQL = 	" $nameBase..MON_SELECT_DIGITADOR_EXP_LIST ";//'$oficina'
	
			$cont = 0;
			if ( $str_SQL != ''){
				$rs  =  $conn->db_query( $str_SQL );
				while ($row  =  $conn->db_fetch_array( $rs ) ){
					$cont++;
					
					$digitadorId= $class_fn_basic->sysGetDataFieldSrv( $row[ "digitadorId" ] );
					$digitadorNom= $class_fn_basic->sysGetDataFieldSrv( $row[ "digitadorNom" ] );
					$trmAsig= $class_fn_basic->sysGetDataFieldSrv( $row[ "trmAsig" ] );
					$trmAsigSem= $class_fn_basic->sysGetDataFieldSrv( $row[ "trmAsigSem" ] );
					$trmIniciado= $class_fn_basic->sysGetDataFieldSrv( $row[ "trmIniciado" ] );
					$email= $class_fn_basic->sysGetDataFieldSrv( $row[ "email" ] );
					array_push($arr_data,array(

						'digitadorId'=>$digitadorId,
						'digitadorNom'=>$digitadorNom,
						'trmAsig'=>$trmAsig,
						'trmAsigSem'=>$trmAsigSem,
						'trmIniciado'=>$trmIniciado,
						'email'=>$email
					));
				}
		}
		$arr_paging = array('data'=>$arr_data, 'str'=>$str_SQL );
		return json_encode($arr_paging);
	}
	 
	/*Consulta el Tiempo real vigente del tramite a digitar*/
	function loadTimerTramite (){
		global $conn, $class_fn_basic, $tramiteId, $nameBase;
		$arr_data = array();
		//TOMADO DE LA TABLA DE TURNO DE LA BASE DE CIATEITE
		$str_SQL = 	" $nameBase..MON_SELECT_TRAMITES_DIGITADOR_EXP_UNIQ '$tramiteId' ";
		$cont = 0;
		if ( $str_SQL != ''){
			$rs  =  $conn->db_query( $str_SQL );
			$row  =  $conn->db_fetch_array( $rs ) ;
			$tiempo = ( $row[ "tiempo" ] );
			if ($tiempo < (-6000000))
				$tiempo = 0;
			$daeDate = $class_fn_basic->sysGetDataFieldSrv( $row[ "daeDate" ] );
			$tiempoConv = conversorMinutos($tiempo);

			$arr_data = array(
				'tiempo' => $tiempo,
				'tiempoConv' => $tiempoConv,
				'daeDate'=>$daeDate
			);
		
		}
		$arr_paging = array('data'=>$arr_data, 'str'=>$str_SQL);
		return json_encode($arr_paging);
	}
	/*Lista de las 3 ultimas Operaciones*/
	function loadOperacionesUlt (){
		global $conn, $class_fn_basic, $digitadorId, $nameBase;
		$arr_data = array();

		$str_SQL = 	" $nameBase..MON_SELECT_LIST_TRM_DIG_EXP '$digitadorId'";
		$cont = 0;
		if ( $str_SQL != ''){
			$rs  =  $conn->db_query( $str_SQL );
			while ($row  =  $conn->db_fetch_array( $rs ) ){
				$tramiteId= $class_fn_basic->sysGetDataFieldSrv( $row[ "tramiteId" ] );
				$fechaLlegada= $class_fn_basic->sysGetDataFieldSrv( $row[ "FechaEmbarque" ] );
				$dias= $class_fn_basic->sysGetDataFieldSrv( $row[ "dias" ] );
				$semaforo= $class_fn_basic->sysGetDataFieldSrv( $row[ "semaforo" ] );
				$hora = $class_fn_basic->sysGetDataFieldSrv( $row[ "hora" ] );
				$fecha = $class_fn_basic->sysGetDataFieldSrv( $row[ "fecha" ] )." ".$hora;
				$orden= $class_fn_basic->sysGetDataFieldSrv( $row[ "orden" ] );
				$tipoCarga= $class_fn_basic->sysGetDataFieldSrv( $row[ "tipoCarga" ] );
				$pedido= $class_fn_basic->sysGetDataFieldSrv( $row[ "pedido" ] );
				$producto= $class_fn_basic->sysGetDataFieldSrv( $row[ "producto" ] );
				$importador= $class_fn_basic->sysGetDataFieldSrv( $row[ "importador" ] );
				$items= $class_fn_basic->sysGetDataFieldSrv( $row[ "items" ] );
				$cnt20= $class_fn_basic->sysGetDataFieldSrv( $row[ "cnt20" ] );
				$cnt40= $class_fn_basic->sysGetDataFieldSrv( $row[ "cnt40" ] );
				$tiempoDigitar= $class_fn_basic->sysGetDataFieldSrv( $row[ "tiempoDigitar" ] );
				$asignadoDate= $class_fn_basic->sysGetDataFieldSrv( $row[ "asignadoDate" ] );
				$daeHora= $class_fn_basic->sysGetDataFieldSrv( $row[ "daeHora" ] );
				$daeDate= $class_fn_basic->sysGetDataFieldSrv( $row[ "daeDate" ] );
				$daeHoraEstTer= $daeDate." ".$class_fn_basic->sysGetDataFieldSrv( $row[ "daeHoraEstTer" ] );
				$tiempo = $class_fn_basic->sysGetDataFieldSrv( $row[ "tiempo" ] );	
				$tipo = $class_fn_basic->sysGetDataFieldSrv( $row[ "tipo" ] );
				$estado = $class_fn_basic->sysGetDataFieldSrv( $row[ "etapa" ] );				
				
				$daeDate= ltrim(rtrim($daeDate." ".$daeHora));
				
				array_push($arr_data,array(
					'tramiteId'=>$tramiteId,
					'fechaLlegada'=>$fechaLlegada,
					'dias'=>$dias,
					'semaforo'=>$semaforo,
					'fecha'=>$fecha,
					'hora'=>$hora,
					'orden'=>$orden,
					'tipoCarga'=>$tipoCarga,
					'pedido'=>$pedido,
					'producto'=>$producto,
					'importador'=>$importador,
					'items'=>$items,
					'cnt20'=>$cnt20,
					'cnt40'=>$cnt40,
					'tiempoDigitar'=>$tiempoDigitar,
					'asignadoDate'=>$asignadoDate,
					'daeDate'=>$daeDate,
					'daeHora'=>$daeHora,
					'daeHoraEstTer'=>$daeHoraEstTer,
					'tiempo'=>$tiempo,
					'tipo'=>$tipo,
					'estado'=>$estado
				));
			}
		}
		$arr_paging = array('data'=>$arr_data, 'conexion'=>'');
		return json_encode($arr_paging);
	}


	function seekcadenaarr($array, $cadena){
		$resPos = 0;
		for ($x=0; $x<count($array); $x++){
			$pos = strpos($cadena, $array[$x]);
			if ($pos!='')
				$resPos++;
		}
		return $resPos;
	}
	
	function seekcadena($cadena, $cad){
		$resPos = 0;
		$pos = strpos($cad, $cadena);
		if ($pos!='')
			$resPos++;
		return $resPos;
	}
	
	function conversorMinutos($tiempo) {
		$conDias = abs($tiempo / 1440);
		$dias = floor($conDias);
		$sinDias = abs($conDias-$dias);
		$horas = '00';
		$segundos = '00';
		$minutos =floor($sinDias*1440);
		if ($minutos > 59){
			$horas = floor($minutos/60);
			$minutos = $minutos-($horas*60);
		}else
			
		$HoraNormal=date("H:i", $sinDias);
		$horas = str_pad($horas,2,"0",STR_PAD_LEFT);
		$minutos = str_pad($minutos,2,"0",STR_PAD_LEFT);
		$tiempoHora = $horas . ':' . $minutos . ":" . $segundos;
		if($tiempoHora == "00:00:00")
			return "";
		else
			return 'Dias: '.$dias. '  Hora: '.$tiempoHora. "(hh:mm:ss)";
	}
?>