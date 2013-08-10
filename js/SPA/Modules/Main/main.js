// Set up module handle bar templates
Dropzilla.Dropzilla_Main = function () {
	var _config = {
		panelClickHandlers: {
			panel1: 'js/SPA/Modules/Main/clickHandlersPanel1.js',
			panel2: 'js/SPA/Modules/Main/clickHandlersPanel2.js'
		}
	};
	/**
	 * [ description]
	 * @return {[type]} [description]
	 */
	var init = function () {
		var panelConfig = _config["panelClickHandlers"];
		$.get('/js/SPA/Templates/Modules/Main/controlPanel-main.html', function(result){
			$('#moduleScripts').append(result);
			Dropzilla.bind('#panelBody', '#cp-main-panel');
		}).done(function(data){
			Dropzilla.loadExternals([panelConfig["panel1"]], true);
		});
	};
	/**
	 * [ description]
	 * @param  {[type]} key   [description]
	 * @param  {[type]} value [description]
	 * @return {[type]}       [description]
	 */
	var set = function(key, value) {
		if(typeof(key) == "object") {
			for(var k in key) {
				_config[k] = key[k];
			}
			return;
		}

		_config[key] = value;
	};
	/**
	 * [ description]
	 * @param  {[type]} key [description]
	 * @return {[type]}     [description]
	 */
	var get = function(key) {
		return _config[key];
	};

	return {
		init: init,
		set: set,
		get: get
	};
}();

Dropzilla.Dropzilla_Main.init();