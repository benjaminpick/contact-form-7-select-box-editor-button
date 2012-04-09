(function() {

	// http://javascriptcompressor.com/
	
	// Load plugin specific language pack
	tinymce.PluginManager.requireLangPack('addContactForm7Link');

	tinymce.create('tinymce.plugins.addContactForm7Link', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {
			ed.addCommand('mceAddContactForm7Link', function() {
				ed.windowManager.open({
					file : ajaxurl + '?action=addContactForm7Link_tinymce',
					width : 330 + ed.getLang('AddContactForm7Link.delta_width', 0),
					height : 195 + ed.getLang('AddContactForm7Link.delta_height', 0),
					inline : 1
				}, {
					plugin_url : url, // Plugin absolute URL
					some_custom_arg : 'custom arg' // Custom argument
				});
			});

			// Register button
			ed.addButton('addContactForm7Link', {
				title : ed.getLang('AddContactForm7Link.desc', 'Add contact link (default)'),
				cmd : 'mceAddContactForm7Link',
				image : url + '/addLink.gif'
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('addContactForm7Link', n.nodeName == 'IMG');
			});
		},

		/**
		 * Creates control instances based in the incomming name. This method is normally not
		 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		 * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
		 * method can be used to create those.
		 *
		 * @param {String} n Name of the control to create.
		 * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
		 * @return {tinymce.ui.Control} New control instance or null if no control was created.
		 */
		createControl : function(n, cm) {
			return null;
		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'Contact Form 7 Select Box Editor Button',
				author : 'Benjamin Pick',
				authorurl : 'https://github.com/benjamin4ruby',
				infourl : 'http://wordpress.org/extend/plugins/contact-form-7-select-box-editor-button/',
				version : "0.1"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('addContactForm7Link', tinymce.plugins.addContactForm7Link);
	
	//tinymce.addVisual(); // Add edit helps for tables etc.
})();
