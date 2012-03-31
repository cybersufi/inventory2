Ext.define('MenuData', {
  	extend: 'Ext.data.Model',
  	fields: [
  		{name: 'menuid', type: 'string'},
      	{name: 'menutitle', type: 'string'},
 		{name: 'menudesc', type: 'string'},
 		{name: 'menucount', type: 'number'},
 		{name: 'menustatus', type: 'boolean'},
  	],
});

Ext.define('App.SiteAdmin.MenuList', {
	requires: [
		'Ext.data.*',
		'Ext.grid.Panel',
		'Ext.toolbar.Paging'
	],
	
    extend: 'Ext.grid.Panel',
    alias: 'widget.siteadmin-menulistpanel',
	
	selModel: Ext.create("Ext.selection.CheckboxModel"),
	
    columns: [{
    	dataIndex: 'menuid',
       	id: 'menuid',
       	header: 'ID',
       	sortable: true,
       	flex: 0.08,
    }, {
    	dataIndex: 'menutitle',
       	id: 'menutitle',
       	header: 'Title',
       	sortable: true,
       	flex: 0.50,
    }, {
       	dataIndex: 'menudesc',
       	id: 'menudesc',
       	header: 'Description',
       	flex: 1,
   	}, {
       	dataIndex: 'menucount',
       	id: 'menucount',
       	header: 'Sub Menu Count',
       	sortable: true,
    	align: 'center',
       	flex: 0.2,
   	}, {
		xtype: 'booleancolumn',
    	dataIndex: 'menustatus',
    	id: 'menustatus',
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
			model: 'MenuData',
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