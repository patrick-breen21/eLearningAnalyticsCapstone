Liferay.Events = {
	bind: function(event, func, scope) {
		var instance = this;

		event = event + '.liferay-events';

		jQuery(document).bind(
			event,
			function() {
				func.apply(scope || this, arguments);
			}
		);
	},

	trigger: function(event, data) {
		var instance = this;

		event = event + '.liferay-events';

		jQuery(document).trigger(event, data);
	},

	unbind: function(event, func) {
		var instance = this;

		event = event + '.liferay-events';

		jQuery(document).unbind(event, func);
	}
};

// Shorthand

Liferay.bind = Liferay.Events.bind;
Liferay.trigger = Liferay.Events.trigger;
Liferay.unbind = Liferay.Events.unbind;