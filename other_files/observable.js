Liferay.Observable = new Liferay.Class(
	{
		initialize: function() {
			var instance = this;

			instance._eventObj = jQuery(instance);
		},

		bind: function(event, handler, scope) {
			var instance = this;

			if (handler && event) {
				instance._createEventObj();

				var method = handler;

				if (scope) {
					method = function(event) {
						handler.apply(scope || instance, arguments);
					};
				}

				instance._eventObj.bind(event, method);
			}

		},

		get: function(key, defaultValue) {
			var instance = this;

			var prop = '__' + key;
			var value = defaultValue;

			if (prop in instance) {
				value = instance[prop];
			}

			return value;
		},

		set: function(key, value) {
			var instance = this;

			var prop = '__' + key;

			var oldValue = instance[prop];

			if (value != oldValue) {
				instance[prop] = value;

				instance.trigger('update', [instance, {value: value}]);
			}
		},

		trigger: function(event, data){
			var instance = this;

			if (instance._eventsSuspended == false) {
				instance._createEventObj();

				instance._eventObj.triggerHandler(event, data);
			}
		},

		resumeEvents: function(){
			var instance = this;

			instance._eventsSuspended = false;
		},

		suspendEvents: function(){
			var instance = this;

			instance._eventsSuspended = true;
		},

		_createEventObj: function() {
			var instance = this;

			if (!instance._eventObj) {
				instance._eventObj = jQuery(instance);
			}
		},

		_eventsSuspended: false
	}
);