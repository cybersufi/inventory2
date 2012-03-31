Ext.define('App.SiteAdmin.MenuPanel', {
	requires: [
		'Ext.layout.*',
		'Ext.panel.*'
	],
	
    extend: 'Ext.panel.Panel',
    alias: 'widget.siteadmin-menupanel',
	
	layout:'card',
    activeItem: 0,
	
	items: [{
        id: 'card-0',
        layout: 'fit',
        border: false,
        items: [{
	        title: 'Menu Manager: Menus',
			xtype: 'siteadmin-menulistpanel',
			id: 'siteadmin-menus',
			border: false,
			tools: [{
				type:'refresh',
				handler: function() {
					var grid = Ext.getCmp('siteadmin-menus');
					grid.getStore().load();
				},	
				scope: this,
			}],
		}]
    },{
        id: 'card-1',
        layout: 'fit',
        border: false,
        items: [{
	        title: 'Menu Manager: Menu Items',
			xtype: 'siteadmin-menuitemlistpanel',
			id: 'siteadmin-menuitems',
			border: false,
			tools: [{
				type:'refresh',
				handler: function() {
					var grid = Ext.getCmp('siteadmin-menus');
					grid.getStore().load();
				},	
				scope: this,
			}],
		}]
    },{
        id: 'card-2',
        html: '<h1>Congratulations!</h1><p>Step 3 of 3 - Complete</p>'
    }],
	
	initComponent: function() {
		this.dockedItems = [{
    		xtype: 'toolbar',
    		items: [{
	    		text: '<< Prev',
	    		id: 'card-prev',
	  			scope: this,
	  			handler: Ext.Function.bind(this.cardNav, this, [-1]),
	    	}, {
	    		text: 'Next >>',
	  			id: 'card-next',
	  			scope: this,
	  			handler: Ext.Function.bind(this.cardNav, this, [1]),
	    	}]
    	}];
	   	
		this.callParent(arguments);
	},
	
	cardNav: function(incr) {
        var l = Ext.getCmp('siteadmin-menupanel').getLayout();
        var i = l.activeItem.id.split('card-')[1];
        var next = parseInt(i, 10) + incr;
        l.setActiveItem(next);
        Ext.getCmp('card-prev').setDisabled(next===0);
        Ext.getCmp('card-next').setDisabled(next===2);
    }
});