Ext.define('App.SiteAdmin.MenuManager', {
	requires: [
        'Ext.container.Viewport',
        'Ext.layout.container.Border',
    	],
    
	init: function() {
    	Ext.QuickTips.init();
        	
    	Ext.create('Ext.container.Viewport', {
    		renderTo: Ext.getBody(),
        	layout: 'border',
        	minWidth: 600,
			minHeight: 400,
        	items:[{
        		region: 'center',
        		border: false,
        		layout: 'fit',
        		items: [{
        			xtype: 'siteadmin-menupanel',
        			id: 'siteadmin-menupanel',
        			border: false,
					/*title: 'Menu Manager: Menus',
					xtype: 'siteadmin-menulistpanel',
					id: 'siteadmin-menus',
					tools: [{
						type:'refresh',
						handler: function() {
							var grid = Ext.getCmp('siteadmin-menus');
							grid.getStore().load();
						},	
						scope: this,
					}],*/
				}]
        	}]
		});
	},
});
