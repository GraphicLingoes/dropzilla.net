Dropzilla.history = function () {
	var config = {
		parentMenuItems: {},
		parentMenuItemsCss: {}
	};

	var set = function(key, value, setConfig) {
		if(typeof(setConfig) === "object") {
			switch(setConfig.item) {
				case 'parentMenuItems':
					config[key][setConfig.key] = value;
					break;
				case 'parentMenuItemsCss':
					config[key][setConfig.key] = value;
					break;
			}
		} else {
			config[key] = value;
		}
		for(var k in config) {
			for(key in config[k]) {
				console.log(key + " => " + config[k][key]);
			}

		}
	};

	var get = function(key) {
		return config[key];
	};

	var remove = function(key, subKey) {
		var _subKey = subKey || false;
		if (_subKey) {
			if(config[key][subKey]) {
				delete config[key][subKey];
			}
		} else {
			if(config[key][subKey]) {
				delete config[key];
			}
		}
	};

	return {
		config: config,
		set: set,
		get: get,
		remove: remove
	};
}();