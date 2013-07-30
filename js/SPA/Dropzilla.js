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
				self.bindPanelHandlers(panelConfigs[i]);
			}
		});
		// If initial load, load necessary files
		if(initLoad) {
			$.get('libs/spectrumColorPicker/spectrum.js');
			$.get('libs/spectrumColorPicker/panel1-init.js');
			$.get('js/SPA/Modules/History/history.js');
		}
	},
	/**
	 * [ description]
	 * @param  {[type]} panelKey [description]
	 * @return {[type]}          [description]
	 */
	bindPanelHandlers: function(panelScriptPath) {
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