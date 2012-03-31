Ext.define('App.SiteAdmin.MenuForm',  {
	extend: 'Ext.Window',
	requires: 'Ext.form.*',
	
	alias: 'widget.siteadmin-menuform-window',
	title: 'Menu Manager: Add Menu Dialog',
	width: 370,
	height: 235,
	//iconCls: 'key-icon',
	resizable: false,
	closable: false,
	bodyStyle: 'padding 5px',
	border: false,
	plain: true,
	layout: 'border',
	id: 'app-menuform-dialog',
	
	initComponent: function() {
		this.items = [{
       			id:'btns',
               	region:'south',
               	baseCls:'x-plain',
               	split: false,
               	height: 40,
               	layout: {
					type: 'hbox',
					padding: '10',
					align:'top',
				},
				items:[{
					xtype:'button',
					text: 'Reset',
					tabIndex: 5,
					//handler: this.onSiteButtonClick,
					scope: this,
				}, {
			     xtype:'tbspacer',
			     flex:0.1
				}, {
			     xtype:'tbspacer',
			     flex:1
				}, {
					xtype:'button',
					id:'save-button',
					text: 'Save',
					tabIndex: 3,
					//handler: this.onLoginButtonClick,
					scope: this,
				}, {
					xtype:'button',
					id:'cancel-button',
					text: 'Cancel',
					tabIndex: 3,
					//handler: this.onLoginButtonClick,
					scope: this,
				}]
		}, {
			xtype: 'form',
  			region: 'center',
			labelWidth: 60,
			waitTitle: 'Saving data ... Please wait ...',
			baseCls: 'x-plain',
			border: false,
			padding: 10,
			id: 'menu-form',
			items: [{
      			xtype: 'textfield',
				fieldLabel: 'Menu Title',
				anchor: '100%',
				name: 'title',
		    	allowBlank: false,
		    	selectOnFocus: true,
		    	tabIndex: 1,
			},	{
	      		xtype: 'textfield',
				fieldLabel: 'Menu Alias',
				anchor: '100%',
				name: 'alias',
			    allowBlank: false,
			    selectOnFocus: true,
			    tabIndex: 2,
			},	{
		      	xtype: 'textfield',
				fieldLabel: 'Menu Url',
				anchor: '100%',
				name: 'url',
				allowBlank: false,
				selectOnFocus: true,
				tabIndex: 3,
			}, {
      			xtype: 'textfield',
				fieldLabel: 'Menu Description',
				anchor: '100%',
				name: 'desc',
		    	allowBlank: true,
		    	selectOnFocus: true,
		    	tabIndex: 4,
			}]
		}];
    		
		this.callParent(arguments);
		this.form = this.getComponent('menu-form').getForm();
	},
	
	resetForm: function() {
		this.form.reset();	
	},
	
});