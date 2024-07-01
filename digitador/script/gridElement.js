	Ext.getBody().on("contextmenu", Ext.emptyFn, null, {preventDefault: true});
	/*----------------------------------
	 *------Grid-Monitoreo-trámites-----
	 *----------------------------------*/
	var storeProgramacionCia = new Ext.data.GroupingStore({
		reader:new Ext.data.JsonReader({
			root: 'data',
			id: '___id',
			fields:[
				{name:'tramiteId', type: 'string'},
				{name:'fechaLlegada' , type: 'string'},
				{name:'semaforo' , type: 'string'},
				{name:'fecha', type: 'string'},
				{name:'hora', type: 'string'},
				{name:'orden', type: 'string'},
				{name:'etapa', type: 'string'},
 				{name:'tipoCarga', type: 'string'},
				{name:'pedido', type: 'string'},
				{name:'producto', type: 'string'},
				{name:'importador', type: 'string'},
				{name:'items', type: 'string'},
				{name:'cnt20', type: 'string'},
				{name:'cnt40', type: 'string'},
				{name:'tipoCont', type: 'string'},
				{name:'digitadorNom', type: 'string'},
				{name:'digitadorId', type: 'string'},
				{name:'tiempoDigitar', type: 'string'},
				{name:'asignadoDate', type: 'string'},
				{name:'daeDate', type: 'string'},
				{name:'desContenedor', type: 'string'},
				{name:'tiempo', type: 'int'},
				{name:'daeUser', type: 'string'},
				{name:'tiempoConv', type: 'string'},
				{name:'anticipado', type: 'string'},
				{name:'colorReeferCont3', type: 'string'},
				{name:'fechaOfi', type: 'string'},
				{name:'diasOfi', type: 'string'},
				{name:'colorOfi', type: 'string'},
				{name:'problema', type: 'string'},
				{name:'ordenPP', type: 'string'},
				{name:'refrendo', type: 'string'},
				{name: 'desc'}
			]
		}),
		url: 'phpJson/jsonSeekDai.php',
		root: 'data',
		storeId:'idProgram',
		totalProperty: 'totalCount',
		//idProperty: 'threadid',
		baseParams: {typeQuery:'lista.no.programado'},
		//autoDestroy:true,
		sortInfo:{field: 'semaforo', direction: "DESC"},
		fields: [ 	'semaforo','fechaLlegada','dias','fecha','hora','orden','tipoCarga','pedido',
					'producto','importador','items','cnt20','cnt40','etapa','digitadorNom','digitadorId',
					'tiempoDigitar','asignadoDate','daeDate','tiempo', 'desContenedor','daeUser','tiempoConv',
					'anticipado','colorReeferCont3', 'fechaOfi','diasOfi','colorOfi', 'problema','ordenPP', 'refrendo'
				],
		remoteGroup: true,
		groupOnSort:true,
		groupField:'semaforo'
	});

	/*Columnas de Monitoreo trámites*/
	var columnProgramacionCia = [new Ext.grid.RowNumberer({header:'No.', width: 30}),
		{id:'semaforo', header:'Estado', dataIndex:'semaforo', renderer:colorRiesgo, groupable :true,width:20,menuDisabled: true, sortable: true,hidden:true},
		{id:'fecha', header:'Fecha', dataIndex:'fecha', hideable:false, width:82, align:'center', menuDisabled: true,groupable :false,resizable: false, locked: true},
		{id:'hora', header:'Hora', dataIndex:'hora', hideable:false, width:46, align:'center', menuDisabled: true,groupable :false,resizable: false, locked: true},
		
		{id:'refrendo', header:'Refrendo', hideable:false, dataIndex:'refrendo', hideable:false, align:'center', menuDisabled: true, groupable :false,width:180, locked: true},
		{id:'orden', header:'Orden', hideable:false, dataIndex:'orden', hideable:false, align:'center', menuDisabled: true, groupable :false,width:85, locked: true, renderer:colorAnticipado},
		//{id:'ordenPP', header:'OrdenPP', hideable:false, dataIndex:'ordenPP', hideable:false, align:'center', menuDisabled: true, groupable :false,width:85, locked: true},
		{id:'etapa', header:'Etapa', hideable:false, dataIndex:'etapa', hideable:false, align:'center', menuDisabled: true, groupable :false,width:110, locked: true, renderer:colorAnticipado},
		{id:'importador', header:'<b style="color:#6D00D9">Exportador</b>', dataIndex:'importador',width:135, hideable:false, menuDisabled: true, hideable:false, groupable :false,sortable: false},
		{id:'tiempo', header:'T', dataIndex:'tiempo', renderer:colorTiempo,hideable:false, groupable :false,width:20,menuDisabled: true,groupable :false,resizable: false, locked: true,hidden:true},
		{id:'fechaLlegada', header:'Vencimiento', dataIndex:'fechaLlegada', hideable:false, width:82, align:'center', menuDisabled: true,groupable :false,resizable: false, locked: true, renderer:colorRiesgo},
		{id:'digitadorNom', header:'<b style="color:#DF013A">Digitador</b>', dataIndex:'digitadorNom', renderer:colorTiempo,css:'background-color: #99E5FF;', width:90, hideable:false, menuDisabled: true, groupable :false,sortable: false},
		{id:'pedido', header:'<b style="color:red">* Pedido</b>', dataIndex:'pedido', hideable:false, menuDisabled: true,groupable :false, resizable: true,width:120,   /*css:'background-color: #FFFFCC;',*/ locked: true, hidden:true},
		{id:'producto', header:'Producto', dataIndex:'producto', groupable :false,width:150, resizable: true, renderer :colorProblema},
		{id:'tipoCarga', header:' Carga', dataIndex:'tipoCarga',groupable :false, width:100, flex: 1},
		{id:'cnt20', header:'<b>20"</b>', dataIndex:'cnt20', width:25, align:'center', groupable :false,resizable: false, hidden:true},
		{id:'cnt40', header:'<b>40"</b>', dataIndex:'cnt40', width:25, align:'center', groupable :false,resizable: false, hidden:true},
		{id:'desContenedor', header:' Descripción', dataIndex:'desContenedor',groupable :false, width:100, renderer: colorReefer, flex: 1},
		{id:'items', header:'#Items', dataIndex:'items', width:55, align:'right', hideable:false, menuDisabled: true, groupable :false},
		{id:'tiempoDigitar', header:' Tiempo', dataIndex:'tiempoDigitar',width:50, menuDisabled: true, hideable:false, groupable :false},
		{id:'asignadoDate', header:'Fecha Asig.', dataIndex:'asignadoDate', hideable:false, width:83, align:'center', groupable :false,resizable: false, locked: true},
		{id:'daeDate', header:'Fecha Dae', dataIndex:'daeDate', hideable:false, width:120, align:'center', groupable :false,resizable: false, locked: true}//,
		//{id:'fechaOfi', header:'F. OPE.', dataIndex:'fechaOfi', hideable:false, width:120, align:'center', groupable :false,sortable: true,resizable: false, locked: true, renderer:colorOficial },
		//{id:'diasOfi', header:'D. OPE', dataIndex:'diasOfi', hideable:false, width:60, align:'center', groupable :false,sortable: true,resizable: false, locked: true, renderer:colorOficial}
	];
	/*Grid de Monitoreo Trámites*/
	var gridProgramacionCia = new Ext.grid.GridPanel ({
		id:'grd-programacion-cia' ,
		name:'grd-programacion-cia' ,
		loadMask: true,
		module:'cia',
		border : false,
		store: storeProgramacionCia,
		stripeRows:true,
		columnLines : true,
		cls: 'custom-grid', 
		cm: new Ext.grid.ColumnModel({columns:columnProgramacionCia}),
		autoExpandColumn: 'producto',
		listeners:{
			"render": {
				scope: this,
				fn: function(grid) {
					//if (segPerm ('TRA-04-27-01-05')==false || segPerm ('TRA-04-27-01-06')==false){
						if (segPerm ('CTR-DIG-07-01')==false){//false
						var ddrow = new Ext.dd.DropTarget(grid.container, {
							ddGroup : 'mygridDD',
							copy:false,
							notifyDrop : function(dd, e, data){
								var ds = grid.store;
								var sm = grid.getSelectionModel();
								var rows = sm.getSelections();
								var records =  data.selections[0];
								var t = e.getTarget(grid.view.cellSelector);
								var columnIndex = grid.view.findCellIndex(t);
								if(dd.getDragData(e)) {
									var cindex = dd.getDragData(e).rowIndex;
									/*Asignacion de Digitador*/
									if(typeof(cindex) != "undefined") {
										var grdProg = Ext.getCmp('grd-programacion-cia');
										var recProg = grdProg.store.getAt(cindex);
										var cp_ordenCia = recProg.get('orden');
										var cp_fecha_Dae = recProg.get('daeDate');
										var cp_usuario_Dae = recProg.get('daeUser');
										function asign(opt){
											if(opt == 'yes'){/*Asignacion de digitador*/
												winAsignacion(recProg, records, cindex );
											}
										}
										if (cp_fecha_Dae != ''){
											Ext.MessageBox.confirm('Alerta->Asignacion->Digitador', '¿Esta seguro de asignar un digitador por que ya existe una DAE Creada...?<br>Por el Usuario: '+cp_usuario_Dae+'<br>Fecha Creacion Dae:'+cp_fecha_Dae, asign);
										}else
											asign('yes');
									}
								}
							}
						})
						}//permiso
					}
				//}
			},
			rowclick : function(grid, rowIndex, evt){
				var record = grid.getStore().getAt(rowIndex);
				Ext.Ajax.request({
					url : 'phpJson/jsonSeekDai.php',
					params :{typeQuery:'timer.tramite', tramiteId:record.get('tramiteId')},
					root: 'data',
					success: function(resp) {
						var data = Ext.decode(resp.responseText);
						var tiempo = data.data.tiempo ;
						var tiempoConv =  data.data.tiempoConv ;
						var daeDate =  data.data.daeDate ;
						if(daeDate != ''){
							if (tiempo > 0)
								Ext.example.msg('Tiempo estimado de digitación de trámite ','<b style="color:green">'+tiempoConv+'</b>','');
							if(tiempo < 0)
								Ext.example.msg('Tiempo estimado de digitación se ha excedido ','<b style="color:red">'+tiempoConv+'</b>','');	
						}
					}
				});

			}
		},
		view: new Ext.grid.GroupingView({
            forceFit:false,	//enableRowBody: true,
			getRowClass: function(record, index, rowParams, ds) {
				rowParams.tstyle = 'width:' + this.getTotalWidth() + ';';
				var color = 'black';
				return '';
			},
			groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Trámites" : "Trámites"]}) '
        })
	});

	/*Grid Estatus Digitador*/
	function jsGridEstatusDigitador(){
		var storeStatusAsig = new Ext.data.JsonStore({
			url: 'phpJson/jsonSeekDai.php',
			root: 'data',
			storeId:'idStatusAsig',
			totalProperty: 'totalCount',
			idProperty: 'idCam',
			baseParams: {typeQuery:'list.status.cia', typeRecurso:'CAM', tipoFlota : 1},
			remoteSort : false,
			autoDestroy:true,
			autoLoad: true,
			fields: [	'digitadorId','digitadorNom','trmAsig','trmAsigSem', 'trmIniciado', 'email' ,'trmRevFinal']
		});
		/*Columnas de Digitador*/
		var columnStatusAsig = [new Ext.grid.RowNumberer({header:'N.'}),
			{id:'digitadorNom', header:'Digitador', dataIndex:'digitadorNom', width:78, menuDisabled: true,flex: 1, renderer:colorDigitador},
			{id:'trmAsig', header:'<b>A</b>', dataIndex:'trmAsig', width:15, menuDisabled: true,flex: 1, tooltip:'# Trámites Asignados en el día'},
			{id:'trmAsigSem', header:'<b>FS</b>', dataIndex:'trmAsigSem', width:15, menuDisabled: true,flex: 1, tooltip:'# Trámites Terminados en la Semana'},
			{id:'trmRevFinal', header:'<b>FH</b>', dataIndex:'trmRevFinal', width:15, menuDisabled: true,flex: 1, tooltip:'# Trámites Terminados en el día'}
		];
		/*Grid de Status digitador*/
		return gridStatusAsig = new Ext.grid.GridPanel ({
			id:'grd-status-asignacion-cia' ,
			name:'grd-status-asignacion-cia' ,
			loadMask: true,
			iconCls: 'truck-icon',
			region: 'center',
			autoScroll: true,
			margins: '2 2 2 2',
			module:'cia',
			border : true,
			store: storeStatusAsig,
			//cls: 'custom-first-last', 
			cls: 'custom-grid',
			columnLines : true,
			typeGrd :'CAM',
			columns: columnStatusAsig,
			ddGroup          : 'mygridDD',
			enableDragDrop   : (segPerm ('CTR-DIG-07-01')==false)?true:false,//true,
			sm: new Ext.grid.RowSelectionModel({  
				singleSelect:true,  
				listeners: {  
					beforerowselect: function(sm,i,ke,row){  
						gridStatusAsig.ddText = row.data.digitadorNom;  
					}  
				}  
			}),
			viewConfig: {
				forceFit: true,
				getRowClass: function(record, index, rowParams, ds) {
					rowParams.tstyle = 'width:' + this.getTotalWidth() + ';';
				}
			},/*tbar: [
				{xtype:'label', text:'Oficina: '},
				comboStatic({
					name:'cmb_division', 
					fields:['id','nombre','codigo'], 
					typeQuery:'lista.divisiones',
					width:150,
					minListWidth:150,
					url:'../phpJson/jsonSeekGlobal.php',
					fieldLabel:'Oficina',
					change:function (){
						loadDataGridProgramacion();
					}
				})
			],*/
			listeners:{
				rowdblclick : function(grid, rowIndex, evt){
					var record = grid.getStore().getAt(rowIndex);
					var box = Ext.MessageBox.wait('Cargando los Datos...', 'Cargar');
					
					var storeView = new Ext.data.JsonStore({
						url: 'phpJson/jsonSeekDai.php',
						root: 'data',
						storeId:'idView',
						totalProperty: 'totalCount',
						idProperty: 'idView',
						baseParams: {typeQuery : 'view.operaciones.cia', digitadorId:record.get('digitadorId')},
						remoteSort : false,
						autoDestroy:true,
						autoLoad: true,
						fields: [	{name: 'fechaLlegada', type: 'date', dateFormat:'d/m/Y'},
									'tramiteId','dias','semaforo','fecha','hora','orden',
									'tipoCarga','pedido','producto','importador','items','cnt20','cnt40',
									'tiempoDigitar',{name: 'asignadoDate', type: 'date', dateFormat:'d/m/Y'},'daeDate','daeHora','daeHoraEstTer',
									'tiempo', 'tipo', 'estado','tiempoTotal','tiempoTotalfechas' ]
					});
					//console.log(grid);
					/*Columnas de Digitador*/
					var columnView = [new Ext.grid.RowNumberer({header:'N.'}),
						{id:'fecha', header:'Fec. Trámite', dataIndex:'fecha', width:100},
						{id:'fechaLlegada', header:'Fec. Llegada', dataIndex:'fechaLlegada', width:85,  renderer:colorRiesgo, sortable: true,renderer: Ext.util.Format.dateRenderer('d/m/Y')},
						{id:'asignadoDate', header:'Fec. Asignada', dataIndex:'asignadoDate', width:85,  sortable: true,renderer: Ext.util.Format.dateRenderer('d/m/Y')},
						{id:'estado', header:'Estado', dataIndex:'estado', width:83, renderer:colorAlerta},
						{id:'orden', header:'Orden', dataIndex:'orden', width:83, renderer:colorAlerta},
						{id:'importador', header:'Exportador', dataIndex:'importador', width:120, renderer:colorAlerta},
						{id:'items', header:'#', dataIndex:'items', width:45},
						{id:'tiempoDigitar', header:'T. Digitar', dataIndex:'tiempoDigitar', width:60},
						{id:'daeDate', header:'Fec. DAE', dataIndex:'daeDate', width:80},
						{id:'daeHoraEstTer', header:'Fec. Estimada', dataIndex:'daeHoraEstTer', width:80},
						//{id:'tiempoTotal', header:'Tiempo Real', dataIndex:'tiempoTotal', width:80},
						{id:'tiempoTotalfechas', header:'Tiempo Total', dataIndex:'tiempoTotalfechas', width:80}
					];
					
					var gridview = new Ext.grid.GridPanel ({
						id:'grd-status-view-cia' ,
						name:'grd-status-view-cia' ,
						loadMask: true,
						autoScroll: true,
						margins: '2 2 0 2',
						border : true,
						store: storeView,
						columnLines : true,
						columns: columnView
					});
					
					
					/*Ultimas Operaciones del digitaodr*/
					var win = new Ext.Window({  
						title: 'Trámites - Digitador: <b style= "color:red">'+record.data.digitadorNom+"</b>",  
						width:950,  
						height:300,  
						modal: true,  
						resizable: false,
						layout:'fit',
						autoScroll: true,
						bodyStyle: 'padding:0px;background-color:#fff',  
						items: [gridview]  
					});       
					win.show();
					box.hide(); 
				}
			}
		});
	}

	/*convertir fecha dd/mm/YYYY a YYYYmmdd*/
	function convertDateSql(dateStr){
		var dateConve = dateStr.replace(/\//gi, "");
		return dateConve.substr(4,4)+''+dateConve.substr(2,2)+''+dateConve.substr(0,2);
	}
	/*Function de parpadeo de carta de retiro*/
	function vku_parpadeo(otro) {
		var el = document.getElementById(otro);
		if(el==null)
			return;
		if ( el.style.visibility != 'hidden' ) {
			el.style.visibility = 'hidden';
		}
		else {
			el.style.visibility = 'visible';
		}
	} 
	
	function selectColumnGrid(nameGrid, nameIndex){
		var gridTmp  =	Ext.getCmp(nameGrid);
		var cm = gridTmp.getColumnModel();
		for (var i = 0; i < cm.getColumnCount(); i++) {
			var fld = gridTmp.store.recordType.prototype.fields.get(cm.getDataIndex(i));
			if(fld != undefined)
				if (nameIndex == fld.name){
					return i;
				}
		}
	}