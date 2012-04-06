Ext.onReady(function(){
	Ext.QuickTips.init();
	Ext.create('Ext.panel.Panel', {
		renderTo: 'user_grid',
		layout: 'border',
		width: '100%',
		height: 500,
		items:[{
			region: 'center',
			border: false,
			layout: 'fit',
			items: [{
				xtype: 'administrator-userlistpanel',
				id: 'administrator-userlistpanel',
				border: false,
			}]
		}]
	});
});

/*Ext.define('App.SiteAdmin.MenuManager', {
	requires: [
        'Ext.container.Viewport',
        'Ext.layout.container.Border',
    	],
    
	init: function() {
    	
        	
    	Ext.create('Ext.container.Viewport', {
    		
		});
	},
});*/
