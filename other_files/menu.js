Liferay.Menu = new Liferay.Class(
	{
		initialize: function() {
			var instance = this;

			if (!arguments.callee._hasRun) {
				arguments.callee._hasRun = true;

				instance._window = jQuery(window);
				instance._active = {
					menu: null,
					trigger: null
				};

				if (Liferay.Layout && Liferay.Layout.Columns.sortColumns) {
					Liferay.Layout.Columns.sortColumns.bind(
						'sortstart.sortable',
						function(event) {
							instance._closeActiveMenu();
						}
					);
				}

				jQuery(window).bind(
					'resize',
					function(event) {
						instance._positionActiveMenu();
					}
				);

				jQuery(document).bind(
					'click.liferay',
					function(event) {
						var target = jQuery(event.target);
						var cssClass = (event.target.className || '');
						var isTrigger = (cssClass.indexOf('lfr-actions') > -1);
						var trigger = [];

						if (!isTrigger) {
							trigger = target.parents('.lfr-actions');
						}
						else {
							trigger = target;
						}

						if (trigger.length) {
							var menu = trigger.data('lfr-menu-list');

							if (!menu) {
								var list = trigger.find('ul:first');
								list.find('li:last-child').addClass('last');

								menu = jQuery('<div class="lfr-component lfr-menu-list" />');
								menu.append(list);
								menu.appendTo('body');
								menu.hide();

								Liferay.Util.createFlyouts(
									{
										container: menu[0]
									}
								);

								trigger.data('lfr-menu-list', menu);
							}

							if (instance._active.menu && instance._active.menu[0] != menu[0]) {
								instance._closeActiveMenu();
							}
						

							if (menu.is(':visible')) {
								instance._closeActiveMenu();
							}
							else {
								instance._active.menu = menu;
								instance._active.trigger = trigger;

								instance._positionActiveMenu();
							}

							return false;
						}

						instance._closeActiveMenu();
					}
				);
			}
		},
			
		

		_closeActiveMenu: function() {
			var instance = this;

			if (instance._active.menu) {
				instance._active.menu.hide();
				instance._active.menu = null;

				instance._active.trigger.removeClass('visible');
				instance._active.trigger = null;
			}
		},
		
		_positionActiveMenu: function() {
			var instance = this;

			var menu = instance._active.menu;
			var trigger = instance._active.trigger;

			if (menu) {
				var offset = trigger.offset();
				offset.position = 'absolute';

				cssClass = trigger.attr('class');

				var direction = 'auto';
				var vertical = 'bottom';
				var win = instance._window;

				if (cssClass.indexOf('right') > -1) {
					direction = 'left';
				}
				else if (cssClass.indexOf('left') > -1) {
					direction = 'left';
				}

				var menuHeight = menu.height();
				var menuWidth = menu.width();

				var triggerHeight = trigger.outerHeight();
				var triggerWidth = trigger.outerWidth();

				var menuTop = menuHeight + offset.top;
				var menuLeft = menuWidth;
				var scrollTop = win.scrollTop();
				var scrollLeft = win.scrollLeft();

				var windowHeight = win.height() + scrollTop;
				var windowWidth = win.width() + scrollLeft;

				if (direction == 'auto') {
					if (menuTop > windowHeight
						&& !((offset.top - menuHeight) < 0)) {

						offset.top -= menuHeight;
					}
					else {
						offset.top += triggerHeight;
					}
					
					if (( menuWidth) < 0)	 {

						offset.left = (triggerWidth);
					} 
				}
				else {/* 
					if (direction == 'right') {
						offset.left -= (menuWidth - 2);
					}
					else if (direction == 'left') {
						offset.left += (triggerWidth + 2);
					} */

					offset.top -= (menuHeight - triggerHeight);
				}

				menu.css(offset);
				menu.show();

				trigger.addClass('visible');

				instance._active = {
					menu: menu,
					trigger: trigger
				};
			}
		}

	}
);
