// Core Dropzilla app
Dropzilla = {
	/**
	 * [_config description]
	 * @type {Object}
	 */
	_config: {},
	/**
	 * [bind method used to bind handlebar templates to main DOM]
	 * @param  {[string]} targetID           [CSS style selector of div to inject compiled handlebar template]
	 * @param  {[string]} handlebarsTemplate [ID of handlebar template]
	 * @param  {[json]} data               [Optional data JSON object used to bind data to handlebar template]
	 */
	bind: function (targetID, handlebarsTemplate, data) {
		var source   = $(handlebarsTemplate).html();
		var template = Handlebars.compile(source);
		// Bind data to template
		if(data) {
			template(data);
		}
		// Attach template to DOM
		$(targetID).html(template);
	},
	/**
	 * [ description]
	 * @param  {[type]} panelKey [description]
	 * @return {[type]}          [description]
	 */
	loadExternals: function (panelConfigs, initLoad) {
		var self = this;
		$.get('js/header-controls.js').done(function(e){
			for(var i = 0; i < panelConfigs.length; i++) {
				self.bindScripts(panelConfigs[i]);
			}
		});
		// If initial load, load necessary files
		if(initLoad) {
			self.bindScripts('libs/spectrumColorPicker/spectrum.js');
			self.bindScripts('libs/spectrumColorPicker/panel1-init.js');
			self.bindScripts('js/SPA/Modules/History/history.js');
			self.bindScripts('js/SPA/formValidator.js');
		}
	},
	/**
	 * [ description]
	 * @param  {[type]} panelKey [description]
	 * @return {[type]}          [description]
	 */
	bindScripts: function(panelScriptPath) {
		var script = document.createElement( 'script' );
		script.src = panelScriptPath;
		$("#externalScripts").append( script );
	},
	/**
	 * [ description]
	 * @param  {[type]} panel      [description]
	 * @param  {[type]} replaceDiv [description]
	 * @return {[type]}            [description]
	 */
	loadNextPanel: function(handlebarsDiv, panel) {
		this.bind(handlebarsDiv, pandel);
	}
};