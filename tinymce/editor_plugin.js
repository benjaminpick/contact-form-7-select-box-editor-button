(function(){tinymce.PluginManager.requireLangPack("addContactForm7Link");tinymce.create("tinymce.plugins.addContactForm7Link",{init:function(ed,url){ed.addCommand("mceAddContactForm7Link",function(){ed.windowManager.open({file:ajaxurl+"?action=addContactForm7Link_tinymce",width:330+ed.getLang("AddContactForm7Link.delta_width",0),height:195+ed.getLang("AddContactForm7Link.delta_height",0),inline:1},{plugin_url:url,some_custom_arg:"custom arg"});});ed.addButton("addContactForm7Link",{title:ed.getLang("AddContactForm7Link.desc","Add contact link (default)"),cmd:"mceAddContactForm7Link",image:url+"/addLink.gif"});ed.onNodeChange.add(function(ed,cm,n){cm.setActive("addContactForm7Link",n.nodeName=="IMG");});},createControl:function(n,cm){return null;},getInfo:function(){return{longname:"Contact Form 7 Select Box Editor Button",author:"Benjamin Pick",authorurl:"https://github.com/benjamin4ruby",infourl:"http://wordpress.org/extend/plugins/contact-form-7-select-box-editor-button/",version:"0.1"};}});tinymce.PluginManager.add("addContactForm7Link",tinymce.plugins.addContactForm7Link);})();