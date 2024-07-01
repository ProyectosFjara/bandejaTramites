/*Tab de Contenedor*/
	var tabContenedor = new Ext.Panel({
		region: 'center',
		id:'tab-master-aforo',
		name:'tab-master-aforo',
		module:'CT',
		idTrm:'',
		estatus:'',
		deferredRender: false,
		margins: '2 2 2 2',
		title:'Bandeja de Monitoreo y Asignación de Digitadores - Correctoras',
		tbar:[
			{	text:'Actualizar', 
				iconCls:'search',
				id : 'bnt-seek-pro',
				reorderable: true,
				handler: function(){
					loadDataGridProgramacion();
				}
			},'->',
			{
				text:'Orden por Defecto', 
				iconCls:'icon-order',
				id : 'bnt-defect-pro',
				reorderable: true,
				handler: function(){
					delete gridProgramacionCia.store.sortInfo;
					gridProgramacionCia.store.sortInfo = { field:"semaforo", direction:"DESC"};
					gridProgramacionCia.view.refresh();
				}
			}
		],
		bbar:['->',
			{	text:'Total Trámites', 
				id : 'bnt-total',
				reorderable: true
			},'-',{	text:'Total Trámites Asignados', 
				id : 'bnt-tot-asing',
				reorderable: true
			},'-',{	text:'Total Trámites en otra Etapa', 
				id : 'bnt-tot-asing-otro',
				reorderable: true
			},'-',{	text:'Total Trámites Sin Asignar', 
				id : 'bnt-tot-n-asing',
				reorderable: true
			},'-',{	text:'Total Trámites Iniciados', 
				id : 'bnt-tot-iniciado',
				reorderable: true
			}
		],
		layout:'fit',
		items:[gridProgramacionCia],
		autoScroll: true
	});

	/*Funcion de load de datos de Digitador*/
	function loadDataGridProgramacion(){
		/*var Objoficina =  Ext.getCmp('cmb_division');
		var oficina =  Objoficina.getCodigo();
		oficina = (oficina=='')?'01':oficina;*/
		sessionGlobal = validSessions();
		if (sessionGlobal == true){
			gridProgramacionCia.store.reload({
				scope: this,
				params: {typeQuery:'lista.no.programado'/*, oficina:oficina*/},
				callback: function(r,options,success) { 
					var count = gridProgramacionCia.getStore().getCount();
					var contAsig = gridProgramacionCia.getStore().reader.jsonData.totalCount;
					var contAsigOtro = gridProgramacionCia.getStore().reader.jsonData.contOtraEtapa;
					var contDae = gridProgramacionCia.getStore().reader.jsonData.totalCountDae;
					var contNAsig = count - contAsig-contAsigOtro;
					var totalTimeBandeja = gridProgramacionCia.getStore().reader.jsonData.totalTimeBandeja;
					//Ext.getCmp('bnt-totalTiempo').setText( "<b>Total Tiempo: "+totalTimeBandeja+"</b>");
					Ext.getCmp('bnt-total').setText( "<b>Total Trámites: "+count+"</b>");
					Ext.getCmp('bnt-tot-asing').setText("<b style='color:green'>Total Trámites Asignados: "+contAsig+"</b>");
					Ext.getCmp('bnt-tot-asing-otro').setText("<b style='color:brown'>Total Trámites en otra Etapa: "+contAsigOtro+"</b>");
					Ext.getCmp('bnt-tot-n-asing').setText( "<b style='color:red'>Total Trámites No Asignados: "+contNAsig+"</b>");
					Ext.getCmp('bnt-tot-iniciado').setText( "<b style='color:#FF4000'>Total Trámites Iniciados: "+contDae+"</b>");
				}
			});
			Ext.getCmp('grd-status-asignacion-cia').store.reload({params:{typeQuery:'list.status.cia'/*, typeRecurso:'CAM', oficina:oficina*/}	}) 
		}
	}