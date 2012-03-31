Ext.onReady(function(){
	Ext.QuickTips.init();
	Ext.create('Ext.panel.Panel', {
		renderTo: 'menu_grid',
		layout: 'border',
		width: '100%',
		height: 500,
		items:[{
			region: 'center',
			border: false,
			layout: 'fit',
			items: [{
				xtype: 'siteadmin-menulistpanel',
				id: 'siteadmin-menulistpanel',
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
