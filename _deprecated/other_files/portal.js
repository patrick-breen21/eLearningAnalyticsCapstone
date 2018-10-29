Liferay.Portal = {};

Liferay.Portal.Tabs = {
	show: function(namespace, names, id) {
		var tab = jQuery('#' + namespace + id + 'TabsId');
		var panel = jQuery('#' + namespace + id + 'TabsSection');

		tab.siblings().removeClass('current');
		tab.addClass('current');

		panel.show();

		var index = names.indexOf(id);
		names.splice(index, 1);

		for (var i = 0; i < names.length; i++) {
			el = jQuery('#' + namespace + names[i] + 'TabsSection');
			el.hide();
		}
	}
};

Liferay.Portal.StarRating = new Liferay.Class(
	{

		/**
		 * OPTIONS
		 *
		 * Required
		 * displayOnly {boolean}: Whether the display is modifiable.
		 *
		 * Optional
		 * rating {number}: The rating to initialize to.
		 *
		 * Callbacks
		 * onComplete {function}: Called when a rating is selected.
		 */

		initialize: function(id, options) {
			this.options = options || {};
			this.rating = this.options.rating || 0;
			var item = jQuery('#' + id);
			this.stars = item.find('img');
			var self = this;

			if (!this.options.displayOnly) {
				item.bind('mouseout', {self: this}, this.onHoverOut);

				this.stars.each(function(index) {
					this.index = index + 1;
					jQuery(this).bind('click', {self: self}, self.onClick)
						.bind('mouseover', {self: self}, self.onHoverOver);
				})
			}

			this.display(this.rating, 'rating');
		},

		display: function(rating, mode) {
			var self = this;
			rating = rating == null ? this.rating : rating;

			var whole = Math.floor(rating);
			var fraction = rating - whole;

			this.stars.each(function(index) {
				image = this;
				if (index < whole) {
					if (mode == 'hover') {
						image.src = image.src.replace(/\bstar_.*\./, 'star_hover.');
					}
					else {
						image.src = image.src.replace(/\bstar_.*\./, 'star_on.');
					}
				}
				else {
					if (fraction < 0.25) {
						image.src = image.src.replace(/\bstar_.*\./, 'star_off.');
					}
					else if (fraction < 0.50) {
						image.src = image.src.replace(/\bstar_.*\./, 'star_on_quarter.');
					}
					else if (fraction < 0.75) {
						image.src = image.src.replace(/\bstar_.*\./, 'star_on_half.');
					}
					else if (fraction < 1.00) {
						image.src = image.src.replace(/\bstar_.*\./, 'star_on_threequarters.');
					}
					fraction = 0;
				}
			});
		},

		onHoverOver: function(event) {
			event.data.self.display(this.index, 'hover');
		},

		onHoverOut: function(event) {
			event.data.self.display();
		},

		onClick: function(event) {
			var target = this;
			var newRating = target.index;
			var self = event.data.self;

			self.rating = newRating;

			if (self.options.onComplete) {
				self.options.onComplete(newRating);
			}

			self.display(newRating);
		}
	}
);

Liferay.Portal.ThumbRating = new Liferay.Class(
	{

		/**
		 * OPTIONS
		 *
		 * Required
		 * displayOnly {boolean}: Whether the display is modifiable.
		 *
		 * Optional
		 * rating {number}: The rating to initialize to.
		 *
		 * Callbacks
		 * onComplete {function}: Called when a rating is selected.
		 */

		initialize: function(options) {
			var instance = this;

			options = options || {};
			instance.rating = options.rating || 0;

			var item = jQuery('#' + options.id);
			instance.triggers = item.find('.rating');
			instance._onComplete = options.onComplete;

			if (!options.displayOnly) {
				instance.triggers.click(
					function(event) {
						instance._click(event, this);
					}
				);
			}
		},

		_click: function(event, obj) {
			var instance = this;
			var trigger = jQuery(obj);
			var rating = trigger.is('.rate-up') ? 1 : -1;

			if (trigger.is('.rated')) {
				rating = 0;
			}

			instance.triggers.not(obj).removeClass('rated');
			trigger.toggleClass('rated');

			if (instance._onComplete) {
				instance._onComplete(rating);
			}
		}
	}
);

Liferay.Portal.ToolTip = {
	container: null,

	show: function(event, obj, text) {
		var instance = this;

		var container = instance.container;
		var currentItem = jQuery(obj);
		var position = currentItem.offset();

		var dimensions = instance._windowCalculation();

		if (!container) {
			container = jQuery('<div class="portal-tool-tip"></div>').appendTo('body');

			instance.container = container;
		}

		container.html(text);

		container.show();

		var boxWidth = container.width();
		var width = currentItem.width();
		var height = currentItem.height();
		var boxHeight = container.height();
		var left = position.left - (boxWidth / 2);
		var top = position.top + height + 5;

		if (left < 0) {
			left = 5;
		}
		else {
			left += 5;
		}

		if (left + boxWidth > dimensions.right) {
			left = (left - (boxWidth / 2 )) + width;
		}

		if (top + boxHeight > dimensions.bottom) {
			top = top - (height + boxHeight + 5);
		}

		container.css(
			{
				cursor: 'default',
				left: left + 'px',
				position: 'absolute',
				top: top + 'px',
				zIndex: Liferay.zIndex.TOOLTIP
			}
		);

		currentItem.one(
			'mouseout',
			function() {
				instance.hide();
			}
		);
	},

	hide: function(event) {
		var instance = this;

		instance.container.hide();
	},

	_windowCalculation: function() {
		var instance = this;

		if (instance._window.right == null) {
			var windowSize = {};
			var body = instance._body;
			if (!body) {
				body = jQuery('body');
				instance._body = body;
			}

			instance._window = {
				bottom: body.height(),
				left: 0,
				right: body.width(),
				top: 0
			};

			jQuery(window).resize(
				function() {
					instance._window.bottom = body.height();
					instance._window.right = body.width();
				}
			);
		}
		return instance._window;
	},
	_body: null,
	_window: {}
};