Ext.define('MenuItemData', {
  	extend: 'Ext.data.Model',
  	fields: [
  		{name: 'menuitemid', type: 'string'},
      	{name: 'menuitemtitle', type: 'string'},
 		{name: 'menuitemdesc', type: 'string'},
 		{name: 'menuitemurl', type: 'string'},
 		{name: 'menuitemstatus', type: 'boolean'},
  	],
});

Ext.define('App.SiteAdmin.MenuItemList', {
	requires: [
		'Ext.data.*',
		'Ext.grid.Panel',
		'Ext.toolbar.Paging'
	],
	
    extend: 'Ext.grid.Panel',
    alias: 'widget.siteadmin-menuitemlistpanel',
	
	selModel: Ext.create("Ext.selection.CheckboxModel"),
	
    columns: [{
    	dataIndex: 'menuitemid',
       	id: 'menuitemid',
       	header: 'ID',
       	sortable: true,
       	flex: 0.08,
    }, {
    	dataIndex: 'menuitemtitle',
       	id: 'menuitemtitle',
       	header: 'Title',
       	sortable: true,
       	flex: 0.50,
    }, {
       	dataIndex: 'menuitemdesc',
       	id: 'menuitemdesc',
       	header: 'Description',
       	flex: 0.7,
   	}, {
       	dataIndex: 'menuitemurl',
       	id: 'menuitemurl',
       	header: 'URL',
       	sortable: true,
    	align: 'center',
       	flex: 0.7,
   	}, {
		xtype: 'booleancolumn',
    	dataIndex: 'menuitemstatus',
    	id: 'menuitemstatus',
    	header: 'Status',
    	trueText: 'Active',
    	falseText: 'Inactive',
    	sortable: true,
    	align: 'center',
    	flex: 0.17,
	}],
    	
	viewConfig: {
		forceFit: true,
		emptyText: 'No record found',
	},
    
	initComponent: function() {
		this.store = Ext.create('Ext.data.Store', {
			pageSize: 50,
			model: 'MenuItemData',
			remoteSort: true,
	  		proxy: {
		      	type: 'ajax',
		 		actionMethod: 'POST',
		 		url: menu_list_url,
		 		reader: {
		            	type: 'json',
		            	root: 'data',
		            	totalProperty: 'total'
		        	}
	       	},
	       	autoLoad: true,
	       	autoDestroy: true,
   		});
	   	
   		this.dockedItems = [{
    		xtype: 'toolbar',
    		items: [{
	    		text: 'Add Group',
	  			iconCls: 'add',
	  			scope: this,
	  			handler: this.onAddGroupClick,
	    	}, '-', {
	    		text: 'Delete Group',
	  			iconCls: 'remove',
	  			scope: this,
	  			handler: this.onDelGroupClick,
	    	}, '-', {
	    		text: 'Edit Group',
	  			iconCls: 'edit',
	    	}]
    	}];
   	
	   	this.bbar = Ext.create('Ext.PagingToolbar', {
        	store: this.store,
        	displayInfo: true,
        	displayMsg: 'Displaying {0} - {1} of {2}',
        	emptyMsg: "No items to display",
    	});
	   	
		this.callParent(arguments);
	}
});