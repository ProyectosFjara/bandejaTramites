/* Desarrollado por: RBALLA
 * Fecha:24-07-2013
 * Descripcion: Paneles, Arboles, Grid
 */
	/*Asignacion de digitaores a la programacion*/
	function js_save_assign_digitador(record, recordGrdAsignado,horaEst, FechaEst, ObsEst, indexRecord){
		var tramiteId = record.get('tramiteId');
		var orden = record.get('orden');
		var importador = record.get('importador');
		var digitadorId = recordGrdAsignado.get('digitadorId');
		var digitadorNomb = recordGrdAsignado.get('digitadorNom');
		var emailDigitador = recordGrdAsignado.get('email');
		
		var box = Ext.MessageBox.wait('Realizando Asignación...', 'Envio');
		Ext.Ajax.request({
			url : 'phpJson/jsonTaskForm.php',
			params :{typeQuery:'save.assign.digitador', tramiteId:tramiteId,digitadorId:digitadorId, 
					 horaEst:horaEst, FechaEst:FechaEst, ObsEst:ObsEst, orden:orden, mail:emailDigitador, digitadorNomb:digitadorNomb,importador:importador},
			root: 'data',
			success: function(resp) {
				var data = Ext.decode(resp.responseText);
				if (js_connect_session( data.conexion )){
					msgBoxExtJs('Error'  , data.conexion,'ERROR');
					return;
				}
				var respuesta = data.data.ErrorMensaje ;
				var NumError =  data.data.NumError ;
				if (NumError == 0 && respuesta != ""){
					box.hide();
					msgBoxExtJs('Registros '  , respuesta,'INFO');
					/*Datos del camión*/
					record.set('digitadorNom',recordGrdAsignado.get('digitadorNom'));
					record.set('digitadorId',recordGrdAsignado.get('digitadorId'));
					record.set('tiempoDigitar',horaEst);
					record.commit();
					Ext.getCmp('win-chof-cia').destroy();
					
					/*var Objoficina =  Ext.getCmp('cmb_division');
					var oficina =  Objoficina.getCodigo();
					oficina = (oficina=='')?'01':oficina;*/
					
					var grdMonitoreo = Ext.getCmp('grd-programacion-cia');
					var posMon = grdMonitoreo.store.indexOf(record);
					grdMonitoreo.focus() ;
					grdMonitoreo.getStore().reload({params:{typeQuery:'lista.no.programado'/*, oficina:oficina*/},
						callback: function(r,options,success) {
							setTimeout(function(){ moveScroll(grdMonitoreo, posMon); }, 1000);
						}
					});
					
					var grdDigitador = Ext.getCmp('grd-status-asignacion-cia');
					var posDig = grdDigitador.store.indexOf(recordGrdAsignado);
					grdDigitador.store.reload({params:{typeQuery:'list.status.cia'/*, typeRecurso:'CAM', oficina:oficina*/},
						callback: function(r,options,success) {
							setTimeout(function(){ moveScroll(grdDigitador, posDig); }, 1000);
						}
					})
				}else{
					box.hide();
					msgBoxExtJs('Error '  , respuesta+'<br>Problemas al realizar la operación..','ERROR');	
				}
			}
		});
	}
	/*ventana de asignacion */	
	function winAsignacion(record, recordGrdAsignado, indexRecord ){
		var timeEnvio = new Ext.form.TimeField({
			id:'cmb-time-cia',
			name:'cmb-time-cia',
			minValue: '00:00',
			maxValue: '23:30',
			format:'H:i', 
			width   : 60,
			increment: 5
		});
	
		var dateProgra = new Ext.form.DateField({
			id:'date-prog-cia',
			name : 'date-prog-cia',
			emptyText: 'Fecha Programas',
			lazyRender: true,  
			selectOnFocus: true, 
			hidden:true,     
			forceSelection: true,  
			width:120,
			format:'d/m/Y',   
			value :  new Date()
		});
		
		var formAsignacion = new Ext.form.FormPanel({
			autoHeight: true,
			id:'form-asignacion-cia',
			name:'form-asignacion-cia',
			width   : 600,
			frame:true,
			border:false,
			labelWidth: 10,
			bodyStyle: 'padding: 5px',
			defaults: {	anchor: '0'	},
			items   : [
				{	xtype: 'compositefield',combineErrors: false,
					items: [
						{   xtype: 'displayfield', 	value:'<b>Exportador</b>', width:80, style: fontSize},
						{   xtype: 'displayfield', 	value:'<span style="color:red;">'+record.get('importador')+'</span>', style: fontSize}]
				},
				{	xtype: 'compositefield',combineErrors: false,
					items: [
						{   xtype: 'displayfield', 	value:'<b>Pedido</b>', width:80, style: fontSize},
						{   xtype: 'displayfield', 	value:'<span style="color:green;">'+record.get('pedido')+'</span>', style: fontSize}]
				},
				{	xtype: 'compositefield',combineErrors: false,
					items: [
						{   xtype: 'displayfield', 	value:'<b>Digitador</b>', width:80, style: fontSize},
						{   xtype: 'displayfield', 	value:'<span style="color:green;">'+recordGrdAsignado.get('digitadorNom')+'</span>', style: fontSize}]
				},
				{	xtype: 'compositefield',combineErrors: false,
					items: [
						{   xtype: 'displayfield', 	value:'<b>Trámite ID:</b>', width:80, style: fontSize},
						{   xtype: 'displayfield', 	value:''+record.get('tramiteId')+'', width:120, style: styleHeadText},
						{   xtype: 'displayfield', 	value:'<b>Orden:</b>',width:80,style: fontSize},
						{   xtype: 'displayfield', 	value:''+record.get('orden')+'', width:120, style: styleHeadText}]
				},
				{	xtype: 'compositefield',combineErrors: false,
					items: [
						{   xtype: 'displayfield', 	value:'<b>Fecha:</b>', width:80, style: fontSize},
						{   xtype: 'displayfield', 	value:''+record.get('fechaLlegada')+'', width:120, style: styleHeadText},
						{   xtype: 'displayfield', 	value:'<b>Fecha Embarque:</b>',width:80, style: fontSize},
						{   xtype: 'displayfield', 	value:''+record.get('fecha')+' - '+record.get('hora'), width:150, style: styleHeadText}]
				},
				{	xtype: 'compositefield',combineErrors: false,
					items: [
						{   xtype: 'displayfield', 	value:'<b>Fecha Estimada:</b>', width:80, style: fontSize, hidden:true},
						dateProgra,
						{   xtype: 'displayfield', 	value:'<b>Hora Estimada:</b>',style: fontSize},
						timeEnvio,
						{   xtype: 'displayfield', 	value:'<b>#Items:</b>',style: fontSize},
						{   xtype: 'textfield', id:'txt-items',name: 'txt-items', 	value:(record != undefined)?record.get('items'):'', width:60, style: styleHeadText, readOnly: true}]
				},
				{	xtype: 'compositefield',combineErrors: false,
					items: [
						{   xtype: 'displayfield', 	value:'<b>Observacion:</b>', width:80, style: fontSize, hidden:true},
						{ 	xtype:'textarea', name:'txt-observacion', id:'txt-observacion',value : '',  width: 270, height:60, hidden:true},
						{   xtype: 'panel', html:'<img src="../../Framework/images/'+record.get('semaforo')+'.png"/>'}]
				}
			]
		 });

		 /*ventana de Asignacion*/
		 var wind = new Ext.Window({
			title : 'Asignación de Digitador a Trámite - Correctoras',
			id : 'win-chof-cia',
			name : 'win-chof-cia',
			draggable : false,
			closable : true,
			resizable:false,
			border:false,
			items : [formAsignacion],
			modal : true,
			width : 530,
			bbar: new Ext.ux.StatusBar({
				id: 'basic-statusbar',
				border:false,
				defaultText: 'Verifique los Datos antes de guardar',
				text: 'Listo',
				iconCls: 'x-status-valid',
				items:[
					{	text: 'Guardar',
						iconCls :'icon-save',
						handler: function (){
							var horaEst = Ext.getCmp('cmb-time-cia').getValue();
							var FechaEst = Ext.getCmp('date-prog-cia').getValue();
							var ObsEst = Ext.getCmp('txt-observacion').getValue();
							ObsEst =replaceData(ObsEst);
							if (horaEst!='')
								js_save_assign_digitador(record, recordGrdAsignado,horaEst, FechaEst, ObsEst, indexRecord)
							else
								msgBoxExtJs('Asignacion->Tiempo->Trámite '  , 'Seleccione un tiempo promedio estimado de digitacion del trámite','WARNING');		
						}
					}
				]
			 })
		});
		
		wind.show();
	}