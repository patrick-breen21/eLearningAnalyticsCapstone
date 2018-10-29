jQuery.noConflict();

Liferay = Liferay || {};

Liferay.Editor = {};

if (!Liferay._ajaxOld) {
	Liferay._ajaxOld = jQuery.ajax;
}

if (Liferay._ajaxOld) {
	jQuery.ajax = function(options) {
		if (Liferay.Util) {
			options.url = Liferay.Util.getURLWithSessionId(options.url);
		}

		return Liferay._ajaxOld(options);
	};
}

jQuery.ajaxSetup(
	{
		data: {},
		type: 'POST'
	}
);

Liferay.Service = {
	actionUrl: themeDisplay.getPathMain() + '/portal/json_service',

	tunnelUrl: themeDisplay.getPathContext() + '/tunnel-web/secure/json',

	classNameSuffix: 'ServiceUtil',

	ajax: function(options, callback) {
		var instance = this;

		var serviceUrl = instance.actionUrl;
		var tunnelEnabled = (Liferay.ServiceAuth && Liferay.ServiceAuth.header);

		if (tunnelEnabled) {
			serviceUrl = instance.tunnelUrl;
		}

		options.serviceParameters = Liferay.Service.getParameters(options);

		if (callback) {
			jQuery.ajax(
				{
					type: 'POST',
					url: serviceUrl,
					data: options,
					cache: false,
					dataType: 'json',
					beforeSend: function(xHR) {
						if (tunnelEnabled) {
							xHR.setRequestHeader('Authorization', Liferay.ServiceAuth.header);
						}
					},
					success: callback
				}
			);
		}
		else {
			var xHR = jQuery.ajax(
				{
					url: serviceUrl,
					data: options,
					dataType: 'json',
					async: false
				}
			);

			return eval('(' + xHR.responseText + ')');
		}
	},

	getParameters: function(options) {
		var serviceParameters = '';

		for (var key in options) {
			if ((key != 'serviceClassName') && (key != 'serviceMethodName') && (key != 'serviceParameterTypes')) {
				serviceParameters += key + ',';
			}
		}

		if (Liferay.Util.endsWith(serviceParameters, ',')) {
			serviceParameters = serviceParameters.substring(0, serviceParameters.length - 1);
		}

		return serviceParameters;
	},

	namespace: function(namespace) {
		var curLevel = Liferay || {};

		if (typeof namespace == 'string') {
			var levels = namespace.split(".");

			for (var i = (levels[0] == "Liferay") ? 1 : 0; i < levels.length; i++) {
		 		curLevel[levels[i]] = curLevel[levels[i]] || {};
				curLevel = curLevel[levels[i]];
			}
		}
		else {
			curLevel = namespace || {};
		}

		return curLevel;
	},

	register: function(serviceName, servicePackage) {
		var module = Liferay.Service.namespace(serviceName);

		module.servicePackage = servicePackage.replace(/[.]$/, '') + '.';

		return module;
	},

	registerClass: function(serviceName, className, prototype) {
		var module = Liferay.Service.namespace(serviceName);
		var moduleClassName = module[className] = {};

		moduleClassName.serviceClassName = module.servicePackage + className + Liferay.Service.classNameSuffix;

		jQuery.each(
			prototype,
			function(methodName, value) {
				if (value) {
					var handler = function(params, callback) {
						params.serviceClassName = moduleClassName.serviceClassName;
						params.serviceMethodName = methodName;

						return Liferay.Service.ajax(params, callback);
					};

					if (jQuery.isFunction(value)) {
						handler = value;
					}

					moduleClassName[methodName] = handler;
				}
			}
		);
	}
};

Liferay.Template = {
	PORTLET: '<div class="portlet"><div class="portlet-topper"><div class="portlet-title"></div></div><div class="portlet-content"></div><div class="forbidden-action"></div></div>'
}

jQuery.fn.exactHeight = jQuery.fn.height;
jQuery.fn.exactWidth = jQuery.fn.width;

if (!window.String.prototype.trim) {
	String.prototype.trim = function() {
		return jQuery.trim(this);
	};
}

// Fixing IE's lack of an indexOf/lastIndexOf on an Array

if (!window.Array.prototype.indexOf) {
	window.Array.prototype.indexOf = function(item) {
		for (var i=0; i<this.length; i++) {
            if(this[i]==item) {
                return i;
            }
        }

        return -1;
	};
}

if (!window.Array.prototype.lastIndexOf) {
	window.Array.prototype.lastIndexOf = function(item, fromIndex) {
		var length = this.length;

		if (fromIndex == null) {
			fromIndex = length - 1;
		}
		else if (fromIndex < 0) {
			fromIndex = Math.max(0, length + fromIndex);
		}

		for (var i = fromIndex; i >= 0; i--) {
			if (this[i] === item) {
				return i;
			}
		}

		return -1;
	};
}