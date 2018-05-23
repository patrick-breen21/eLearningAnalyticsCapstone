Liferay.Layout = {
	init: function(options) {
		var instance = this;

		instance.isFreeForm = options.freeForm;

		var layoutHandler;

		if (!options.freeForm) {
			layoutHandler = instance.Columns;
		}
		else {
			layoutHandler = instance.FreeForm;
		}

		instance._useCloneProxy = options.clonePortlet;

		layoutHandler.init(options);

		instance.layoutHandler = layoutHandler;
	},

	refresh: function(portletBound) {
		var instance = this;

		instance.layoutHandler.refresh(portletBound);
	},

	showTemplates: function() {
		var instance = this;

		var url = themeDisplay.getPathMain() + '/layout_configuration/templates';

		Liferay.Popup(
			{
				modal: true,
				position: ['center', 100],
				title: Liferay.Language.get('layout'),
				url: url,
				urlData: {
					p_l_id: themeDisplay.getPlid(),
					doAsUserId: themeDisplay.getDoAsUserIdEncoded(),
					redirect: Liferay.currentURL
				},
				width: 700
			}
		);
	},

	_findIndex: function(portlet, parentNode) {
		var instance = this;

		parentNode = parentNode || portlet.parentNode;

		return jQuery('> .portlet-boundary', parentNode).index(portlet);
	},

	_saveLayout: function(options) {
		var instance = this;

		var data = {
			doAsUserId: themeDisplay.getDoAsUserIdEncoded(),
			p_l_id: themeDisplay.getPlid()
		};

		jQuery.extend(data, options);

		jQuery.ajax(
			{
				url: themeDisplay.getPathMain() + '/portal/update_layout',
				data: data
			}
		);
	}
};

Liferay.Layout.Columns = {
	init: function(options) {
		var instance = this;

		instance._columns = options.columnSelector;
		instance._portlets = options.boxSelector;
		instance._grid = jQuery(options.grid);
		instance._handleSelector = options.handleSelector;
		instance._boxSelector = options.boxSelector;
		instance._placeHolderClass = options.placeHolderClass;
		instance._onCompleteCallback = options.onComplete;

		instance._activeAreaClass = 'active-area';
		instance._dropAreaClass = 'drop-area';

		instance._gridColumns = '.lfr-column';

		instance._counter = 0;

		instance._placeholderCachedObject = jQuery('<div class="' + instance._placeHolderClass + '"></div>');

		instance.currentColumn = null;

		var options = {
			appendTo: 'body',
			connectWith: [instance._columns],
			dropOnEmpty: true,
			forcePointerForContainers: true,
			handle: instance._handleSelector,
			items: instance._boxSelector,
			helper: instance._createHelper,
			placeholder: {
				element: function() {
					return instance._placeholderCachedObject;
				},
				update: function(container, p) {
				}
			},
			tolerance: 'guess',
			revert:	false,
			distance: 2,
			scroll: true,
			scrollSensitivity: 50,
			scrollSpeed: 30,
			custom: {
				refreshContainers: function() {
					for (var i = this.containers.length - 1; i >= 0; i--){
						var container = this.containers[i];
						var cell = container.element.parent();
						var offset = cell.offset();

						container.containerCache.left = offset.left;
						container.containerCache.top = offset.top;
						container.containerCache.width	= cell.outerWidth();
						container.containerCache.height = cell.outerHeight();
					};
				}
			},

			// Callbacks

			start: function(event, ui) {
				instance._onStart(event, ui);
			},
			stop: function(event, ui) {
				instance._onStop(event, ui);
			},
			update: function(event, ui) {
				instance._onUpdate(event, ui);
			},
			receive: function(event, ui) {
				instance._onReceive(event, ui);
			},
			remove: function(event, ui) {
				instance._onRemove(event, ui);
			},

			// These methods are sensitive to performance, so we don't add to
			// the callstack and instead just do the work inline.

			over: function(event, ui) {
				instance._counter++;
				jQuery(this).parent(instance._gridColumns).addClass(instance._activeAreaClass);
				ui.helper.removeClass('not-intersecting');
				instance.currentColumn = ui.element;
			},
			out: function(event, ui) {
				instance._counter++;
				jQuery(this).parent(instance._gridColumns).removeClass(instance._activeAreaClass);

				// We need to make sure that the active class and the intersection
				// logic don't fall out of sync

				if (!(instance._counter % 2)) {
					ui.helper.addClass('not-intersecting');
					instance._counter = 0;
				}
			},
			activate: function(event, ui) {
				instance._grid.addClass('dragging');
				jQuery(this).parent(instance._gridColumns).addClass(instance._dropAreaClass);
			},
			deactivate: function(event, ui) {
				jQuery(this).parent(instance._gridColumns).removeClass(instance._dropAreaClass);
			}
		};

		instance.sortColumns = jQuery(instance._columns);

		instance.sortColumns.sortable(options);

		jQuery(instance._boxSelector).find(instance._handleSelector).css('cursor', 'move');
	},

	refresh: function(portletBound) {
		var instance = this;

		if (portletBound) {
			jQuery(instance._handleSelector, portletBound).css('cursor', 'move');
		}

		instance.sortColumns.sortable('refresh');
	},

	startDragging: function() {
		var instance = this;

		instance._grid.addClass('dragging');
	},

	stopDragging: function() {
		var instance = this;

		instance._grid.removeClass('dragging');
	},

	_createHelper: function(event, obj) {
		var instance = this;

		var width = obj[0].offsetWidth;
		var height = obj[0].offsetHeight;
		var div = [];

		if (instance._useCloneProxy) {
			div = obj.clone();
		}
		else {
			div = jQuery(Liferay.Template.PORTLET);
			div.addClass('ui-proxy');

			var titleHtml = obj.find('.portlet-title, .portlet-title-default').html();

			div.find('.portlet-title').html(titleHtml);
		}

		div.css(
			{
				width: width,
				height: height,
				zIndex: Liferay.zIndex.DRAG_ITEM
			}
		);

		return div[0];
	},

	_onOut: function(event, ui) {
		var instance = this;
	},

	_onReceive: function(event, ui) {
		var instance = this;

		if (ui.element[0].className.indexOf('empty') > -1) {
			ui.element.removeClass('empty');
		}
	},

	_onRemove: function(event, ui) {
		var instance = this;

		var oCol = ui.element;
		var foundPortlets = oCol.find('.portlet-boundary');
		var minPortlets = 1;
		if (foundPortlets.length < minPortlets) {
			oCol.addClass('empty');
		}
	},

	_onStart: function(event, ui) {
		var instance = this;

		var helperHeight = ui.helper.outerHeight();
		var cachedPlaceholder = instance._placeholderCachedObject;

		instance.startDragging();

		cachedPlaceholder.height(helperHeight);
	},

	_onStop: function(event, ui) {
		var instance = this;

		instance.stopDragging();
	},

	_onUpdate: function(event, ui) {
		var instance = this;

		var currentCol = instance.currentColumn[0] || ui.element[0];
		var portlet = (ui.item || [false])[0];

		if (portlet && portlet.parentNode == currentCol) {
			var position = Liferay.Layout._findIndex(portlet, currentCol);
			var currentColumnId = Liferay.Util.getColumnId(currentCol.id);
			var portletId = Liferay.Util.getPortletId(portlet.id);

			var viewport = Liferay.Util.viewport.scroll();
			var portletOffset = ui.item.offset();

			Liferay.Layout._saveLayout(
				{
					cmd: 'move',
					p_p_col_id: currentColumnId,
					p_p_col_pos: position,
					p_p_id: portletId
				}
			);

			if (instance._onCompleteCallback) {
				instance._onCompleteCallback(event, ui);
			}

			if (viewport.y > portletOffset.top) {
				window.scrollTo(portletOffset.left, portletOffset.top - 10);
			}
		}
	}
};

Liferay.Layout.FreeForm = {
	init: function(options) {
		var instance = this;

		// Set private variables

		instance._columns = options.columnSelector;
		instance._portlets = options.boxSelector;

		jQuery(instance._columns).find(instance._portlets).each(
			function() {
				instance.add(this);
			}
		);
	},

	add: function(portlet) {
		var instance = this;

		var handle = jQuery('.portlet-header-bar, .portlet-title-default, .portlet-topper', portlet);

		handle.css('cursor', 'move');

		var jPortlet = jQuery(portlet);

		if (!jPortlet.find('.ui-resizable-handle').length) {
			jPortlet.append('<div class="ui-resizable-handle ui-resizable-se"></div>');
		}

		jPortlet.css('position', 'absolute');

		instance._createHelperCache(portlet);

		var helperZIndex = instance._maxZIndex + 10;

		jPortlet.draggable(
			{
				handle: '.portlet-header-bar, .portlet-title-default, .portlet-topper, .portlet-topper *',
				helper: function(event) {
					var portlet = jQuery(this);
					var helper = instance._createHelperCache(this);

					var height = portlet.height();
					var width = portlet.width();

					helper.css(
						{
							height: height,
							width: width,
							zIndex: helperZIndex
						}
					);

					var titleHtml = portlet.find('.portlet-title, .portlet-title-default').html();

					helper.find('.portlet-title').html(titleHtml);

					return helper[0];
				},
				start: function(event, ui) {
					instance._moveToTop(this);
				},
				distance: 2,
				stop: function(event, ui) {
					var portlet = this;

					var left = parseInt(ui.position.left);
					var top = parseInt(ui.position.top);

					left = Math.round(left/10) * 10;
					top = Math.round(top/10) * 10;

					portlet.style.left = left + 'px';
					portlet.style.top = top + 'px';

					instance._savePosition(portlet);
				}
			}
		);

		jPortlet.mousedown(
			function(event) {
				if (instance._current != this) {
					instance._moveToTop(this, true);
					instance._savePosition(this, true);
					instance._current = this;
					this.style.zIndex = instance._maxZIndex;
				}
			}
		);

		var resizeBox = jQuery('.portlet-content-container, .portlet-borderless-container', portlet);
		var oldPortletHeight = parseInt(jPortlet[0].style.height) || jPortlet.height();

		jPortlet.resizable(
			{
				helper: 'ui-resizable-proxy',
				start: function(event, ui) {
					ui.helper.css('z-index', helperZIndex);
					instance._moveToTop(this);
				},
				stop: function(event, ui) {
					var portlet = this;
					var rBoxHeight = parseInt(resizeBox[0].style.height);
					var portletHeight = ui.size.height;
					var newHeight = Math.round((portletHeight / oldPortletHeight) * rBoxHeight);

					resizeBox.css('height', newHeight);
					jPortlet.css('height', 'auto');

					oldPortletHeight = portletHeight;
					instance._savePosition(portlet);
				}
			}
		);

		if ((parseInt(portlet.style.top) + parseInt(portlet.style.left)) == 0) {
			if (portlet.columnPos == undefined) {
				portlet.columnPos = 0;
			}

			portlet.style.top = (20 * portlet.columnPos) + 'px';
			portlet.style.left = (20 * portlet.columnPos) + 'px';
		}

		instance._current = portlet;
	},

	refresh: function(portletBound) {
		var instance = this;

		if (portletBound) {
			instance.add(portletBound);
		}
	},

	_createHelperCache: function(obj) {
		var instance = this;

		if (!obj.jquery) {
			obj = jQuery(obj);
		}

		var cache = obj.data('ui-helper-drag');

		if (!cache) {
			var cachedObj = jQuery(Liferay.Template.PORTLET);

			cachedObj.addClass('ui-proxy');

			cache = obj.data('ui-helper-drag', cachedObj);
		}

		return cache;
	},

	_moveToTop: function(portlet, temporary) {
		var instance = this;

		var container = portlet.parentNode;
		portlet.oldPosition = Liferay.Layout._findIndex(portlet);

		if (!temporary) {
			container.appendChild(portlet);
		}
		else {
			portlet.style.zIndex = instance._maxZIndex + 5;

			jQuery(portlet).one(
				'click',
				function(event) {
					instance._moveToTop(this);
				}
			);
		}
	},

	_savePosition: function(portlet, wasClicked) {
		var instance = this;
		var resizeBox = jQuery(portlet).find('.portlet-content-container, .portlet-borderless-container')[0];
		var position = Liferay.Layout._findIndex(portlet);
		var portletId = Liferay.Util.getPortletId(portlet.id);
		var changedIndex = (position != portlet.oldPosition);
		var changedPosition = (resizeBox && !wasClicked);

		if (changedIndex || changedPosition) {
			if (changedIndex) {
				var currentColumnId = Liferay.Util.getColumnId(portlet.parentNode.id);

				Liferay.Layout._saveLayout(
					{
						cmd: 'move',
						p_p_col_id: currentColumnId,
						p_p_col_pos: position,
						p_p_id: portletId
					}
				);
			}

			if (changedPosition) {
				Liferay.Layout._saveLayout(
					{
						cmd: 'drag',
						height: resizeBox.style.height,
						left: portlet.style.left,
						p_p_id: portletId,
						top: portlet.style.top,
						width: portlet.style.width
					}
				);
			}
		}
	},

	_maxZIndex: 99
};