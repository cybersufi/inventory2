Ext.define('UserData', {
  	extend: 'Ext.data.Model',
  	fields: [
  		{name: 'id', type: 'string'},
      	{name: 'username', type: 'string'},
 		{name: 'email', type: 'string'},
 		{name: 'usergroup', type: 'string'},
 		{name: 'status', type: 'string'},
 		{name: 'lastlogin', type: 'string'},
 		{name: 'ipaddress', type: 'strin'},
  	],
});

Ext.define('App.Administrator.UserList', {
	requires: [
		'Ext.data.*',
		'Ext.grid.Panel',
		'Ext.toolbar.Paging'
	],
	
    extend: 'Ext.grid.Panel',
    alias: 'widget.administrator-userlistpanel',
	
	selModel: Ext.create("Ext.selection.CheckboxModel"),
	
    columns: [{
    	dataIndex: 'id',
       	id: 'menuid',
       	header: 'ID',
       	sortable: true,
       	flex: 0.08,
    }, {
    	dataIndex: 'username',
       	id: 'username',
       	header: 'User Name',
       	sortable: true,
       	flex: 0.50,
    }, {
       	dataIndex: 'email',
       	id: 'email',
       	header: 'User Email',
       	flex: 0.6,
   	}, {
       	dataIndex: 'usergroup',
       	id: 'usergroup',
       	header: 'User Group',
       	sortable: true,
    	align: 'center',
       	flex: 0.2,
   	}, {
		dataIndex: 'status',
    	id: 'status',
    	header: 'User Status',
    	sortable: true,
    	align: 'center',
    	flex: 0.17,
	}, {
    	xtype: 'actioncolumn',
    	width: 50,
    	items: [{
        	icon   : '../shared/icons/fam/delete.gif',  // Use a URL in the icon config
        	tooltip: 'Sell stock',
        	handler: function(grid, rowIndex, colIndex) {
            	var rec = store.getAt(rowIndex);
            	alert("Sell " + rec.get('company'));
        	}
       }]
    }],
    	
	viewConfig: {
		forceFit: true,
		emptyText: 'No record found',
	},
    
	initComponent: function() {
		this.store = Ext.create('Ext.data.Store', {
			pageSize: 50,
			model: 'UserData',
			remoteSort: true,
	  		proxy: {
		      	type: 'ajax',
		 		actionMethod: 'POST',
		 		url: user_list_url,
		 		reader: {
		            	type: 'json',
		            	root: 'data',
		            	totalProperty: 'total'
		        	}
	       	},
	       	autoLoad: true,
	       	autoDestroy: true,
   		});
	   	
   		/*this.dockedItems = [{
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
    	}];*/
   	
	   	this.bbar = Ext.create('Ext.PagingToolbar', {
        	store: this.store,
        	displayInfo: true,
        	displayMsg: 'Displaying {0} - {1} of {2}',
        	emptyMsg: "No items to display",
    	});
	   	
		this.callParent(arguments);
	}
});