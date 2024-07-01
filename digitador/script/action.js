/* Desarrollado por: RBALLA
 * Fecha:16-07-2013
 * Descripcion: Paneles, Arboles, Grid
 */
	/*Incluir script*/
	Ext.onReady(function() {
    (function() {
		var hideMask = function () {
			if 	(Ext.get('loading') != null || Ext.get('loading') != undefined){
				Ext.get('loading').remove();
				Ext.fly('loading-mask').fadeOut({
					remove:true/*,
					callback : firebugWarning*/
				});
			}
		};
			hideMask.defer(250);
		}).defer(500);
		
	});
	//console.log(vb_host+'/php/jsonValidGlobal.php');
	/*Valida Session*/
	Ext.Ajax.request({
		url : vb_host+'/php/jsonValidGlobal.php',
		params :{'typeQuery' : 'session'},
		root: 'data',
		success: function(resp) {
			var data = Ext.decode(resp.responseText);
			//sess = data.data.sess ;
			ivar = data.data.idu;
			uvar = data.data.codu;
			if (ivar == null){
				 alert("Su Session a Caducado..!");
			}else{
				loadPortal();
			}
		}
	});
	/*Layout portal */
	function loadPortal (){
		require('script/taskForm.js');//chooser.js
 		require('script/gridElement.js');
		require('script/tabElement.js');//chooser.js
		Ext.onReady(function(){
			var viewport = new Ext.Viewport({
				layout: 'border',
				items: [//>MONITOREO - ASIGNACION - TRAMITES - DIGITADORES
				{
					id:'north',
					region:'north',
					baseCls:'x-plain-1',
					height:40,
					minHeight: 40,
					maxHeight: 85,
					layout:'fit',
					margins: '0 0 0 0',
					items: {
						baseCls: 'x-plain',
						html: '<table width=100% border= 0 cellpaddign = 0 cellspacing = 0 align="center">'+
								'<tr>'+
								'<td width=40% style="padding-left:20px;font-size:13px;">'+
								'<img src="'+vb_host_site+'/images/logomoncorrectoras.png" alt="" /></td>'+
								'<td align= "right" class="loginLabel"  width=60% style=" padding-right:20px;font-size:11px;">'+
								'<img src="'+vb_host_site+'/images/group_key.gif"/><span  style="color:#006CD8;">  '+ uvar + '</span><b> &nbsp;&nbsp;&nbsp;'+
								'<a onclick = "js_close_window()" style="cursor:pointer;"><img src="'+vb_host_site+'/images/door_out.png"/>  <span  style="color:red;">Salir</span></a></b></td>'+
								'</tr>'+
								'</table>' 
					}
				}, {
					region: 'west',
					id: 'west-panel',
					title: 'Estatus de Digitadores',
					split: true,
					width: 275,
					minSize: 175,
					maxSize: 400,
					collapsible: true,
					layout: 'border',
					margins: '2 0 2 2',
					items: [
						jsGridEstatusDigitador()
					],
					tools:[	
						{	id:'refresh',
							iconCls:'refresh',
							tooltip:'Refresh',
							handler: function(){
								loadDataGridProgramacion();
							}
						}
					]
				},
				tabContenedor
				]
			});
		});
		loadDataGridProgramacion();
	}