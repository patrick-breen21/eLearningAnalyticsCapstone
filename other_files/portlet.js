Liferay.Portlet = {
	list: [],

	add: function(options) {
		var instance = this;

		var plid = options.plid || themeDisplay.getPlid();
		var portletId = options.portletId;
		var doAsUserId = options.doAsUserId || themeDisplay.getDoAsUserIdEncoded();
		var placeHolder = jQuery(options.placeHolder || '<div class="loading-animation" />');
		var positionOptions = options.positionOptions;
		var beforePortletLoaded = options.beforePortletLoaded;
		var onComplete = options.onComplete;

		var container = jQuery('.lfr-portlet-column:first');

		if (!container.length) {
			return;
		}

		var portletPosition = 0;
		var currentColumnId = 'column-1';

		if (options.placeHolder) {
			var column = placeHolder.parent();

			placeHolder.addClass('portlet-boundary');

			portletPosition = column.find('.portlet-boundary').index(placeHolder[0]);

			currentColumnId = Liferay.Util.getColumnId(column[0].id);
		}

		var url = themeDisplay.getPathMain() + '/portal/update_layout';

		var data = {
			p_l_id: plid,
			p_p_id: portletId,
			p_p_col_id: currentColumnId,
			p_p_col_pos: portletPosition,
			doAsUserId: doAsUserId,
			dataType: 'json',
			cmd: 'add'
		};

		var firstPortlet = container.find('.portlet-boundary:first');
		var hasStaticPortlet = (firstPortlet.length && firstPortlet[0].isStatic);

		if (!options.placeHolder && !options.plid) {
			if (!hasStaticPortlet) {
				container.prepend(placeHolder);
			}
			else {
				firstPortlet.after(placeHolder);
			}
		}

		if (themeDisplay.isFreeformLayout()) {
			container.prepend(placeHolder);
		}

		data.currentURL = Liferay.currentURL;

		return instance.addHTML(
			{
				beforePortletLoaded: beforePortletLoaded,
				data: data,
				url: url,
				placeHolder: placeHolder[0],
				onComplete: onComplete
			}
		);
	},

	addHTML: function(options) {
		var instance = this;

		var portletBoundary = null;

		var url = options.url;
		var data = options.data;
		var dataType = 'html';
		var placeHolder = options.placeHolder;
		var beforePortletLoaded = options.beforePortletLoaded;
		var onComplete = options.onComplete;

		if (data && data.dataType) {
			dataType = data.dataType;
		}

		var addPortletReturn = function(html) {
			var container = placeHolder.parentNode;

			var portletBound = jQuery('<div></div>')[0];

			portletBound.innerHTML = html;
			portletBound = portletBound.children[0];

			var portletId = Liferay.Util.getPortletId(portletBound.id);

			portletBound.portletId = portletId;

			jQuery(placeHolder).hide().after(portletBound).remove();

			instance.refreshLayout(portletBound);

			Liferay.Util.addInputType(portletBound.id);

			if (window.location.hash) {
				window.location.hash = "p_" + portletId;
			}

			portletBoundary = portletBound;

			if (onComplete) {
				onComplete(portletBoundary, portletId);
			}

			var jContainer = jQuery(container);

			if (jContainer.is('.empty')) {
				jContainer.removeClass('empty');
			}

			return portletId;
		};

		if (beforePortletLoaded) {
			beforePortletLoaded(placeHolder);
		}

		jQuery.ajax(
			{
				url: url,
				data: data,
				dataType: dataType,
				success: function(message) {
					if (dataType == 'html') {
						addPortletReturn(message);
					}
					else {
						if (message.refresh) {
							location.reload();
						}
						else {
							addPortletReturn(message.portletHTML);
						}
					}
				}
			}
		);
	},

	close: function(portlet, skipConfirm, options) {
		var instance = this;

		if (skipConfirm || confirm(Liferay.Language.get('are-you-sure-you-want-to-remove-this-component'))) {
			options = options || {};

			var plid = options.plid || themeDisplay.getPlid();
			var doAsUserId = options.doAsUserId || themeDisplay.getDoAsUserIdEncoded();

			var portletId = portlet.portletId;
			var currentPortlet = jQuery(portlet);
			var column = currentPortlet.parents('.lfr-portlet-column:first');

			currentPortlet.remove();
			jQuery('#' + portletId).remove();

			var url = themeDisplay.getPathMain() + '/portal/update_layout';

			jQuery.ajax(
				{
					url: url,
					data: {
						p_l_id: plid,
						p_p_id: portletId,
						doAsUserId: doAsUserId,
						cmd: 'delete'
					}
				}
			);

			var portletsLeft = column.find('.portlet-boundary').length;

			if (!portletsLeft) {
				column.addClass('empty');
			}

			Liferay.trigger('closePortlet', {plid: plid, portletId: portletId});
		}
		else {
			self.focus();
		}
	},

	minimize: function(portlet, el, options) {
		var instance = this;

		options = options || {};

		var plid = options.plid || themeDisplay.getPlid();
		var doAsUserId = options.doAsUserId || themeDisplay.getDoAsUserIdEncoded();

		var content = jQuery('.portlet-content-container', portlet);
		var restore = content.is(':hidden');

		content.slideToggle(
			'fast',
			function() {
				var action = (restore) ? 'removeClass' : 'addClass';

				jQuery(portlet)[action]('portlet-minimized');

				if (el) {
					var title = (restore) ? Liferay.Language.get('minimize') : Liferay.Language.get('restore');

					var link = jQuery(el);
					var img = link.find('img');

					var imgSrc = img.attr('src');

					if (restore) {
						imgSrc = imgSrc.replace(/restore.png$/, 'minimize.png');
					}
					else {
						imgSrc = imgSrc.replace(/minimize.png$/, 'restore.png');
					}

					img.attr('alt', title);
					img.attr('title', title);

					link.attr('title', title);
					img.attr('src', imgSrc);

					if (restore && Liferay.Browser.isIe()) {
						content.css('display', '');
					}
				}
			}
		);

		jQuery.ajax(
			{
				url: themeDisplay.getPathMain() + '/portal/update_layout',
				data: {
					p_l_id: plid,
					p_p_id: portlet.portletId,
					p_p_restore: restore,
					doAsUserId: doAsUserId,
					cmd: 'minimize'
				}
			}
		);
	},

	onLoad: function(options) {
		var instance = this;

		var canEditTitle = options.canEditTitle;
		var columnPos = options.columnPos;
		var isStatic = (options.isStatic == 'no') ? null : options.isStatic;
		var namespacedId = options.namespacedId;
		var portletId = options.portletId;

		jQuery(
			function () {
				var jPortlet = jQuery('#' + namespacedId);
				var portlet = jPortlet[0];

				if (!portlet.portletProcessed) {
					portlet.portletProcessed = true;
					portlet.portletId = portletId;
					portlet.columnPos = columnPos;
					portlet.isStatic = isStatic;

					// Functions to run on portlet load

					if (canEditTitle) {
						Liferay.Util.portletTitleEdit(
							{
								obj: jPortlet,
								plid: themeDisplay.getPlid(),
								doAsUserId: themeDisplay.getDoAsUserIdEncoded(),
								portletId: portletId
							}
						);
					}

					if (!themeDisplay.layoutMaximized) {
						jPortlet.find('.portlet-configuration:first a').click(
							function(event) {
								location.href = this.href + '&previewWidth=' + portlet.offsetHeight;

								return false;
							}
						);

						jPortlet.find('.portlet-minimize:first a').click(
							function(event) {
								instance.minimize(portlet, this);

								return false;
							}
						);

						jPortlet.find('.portlet-maximize:first a').click(
							function(event) {
								submitForm(document.hrefFm, this.href);

								return false;
							}
						);

						jPortlet.find('.portlet-close:first a').click(
							function(event) {
								instance.close(portlet);

								return false;
							}
						);

						jPortlet.find('.portlet-refresh:first a').click(
							function(event) {
								instance.refresh(portlet);

								return false;
							}
						);

						jPortlet.find('.portlet-print:first a').click(
							function(event) {
								location.href = this.href;

								return false;
							}
						);

						jPortlet.find('.portlet-css:first a').click(
							function(event) {
								Liferay.PortletCSS.init(portlet.portletId);
							}
						);
					}

					Liferay.trigger('portletReady', {portletId: portletId, portlet: jPortlet});

					var list = instance.list;

					var index = list.indexOf(portletId);

					if (index > -1) {
						list.splice(index, 1);
					}

					if (!list.length) {
						Liferay.trigger('allPortletsReady', {portletId: portletId});
					}
				}
			}
		);
	},

	refresh: function(portlet) {
		var instance = this;

		if (portlet.refreshURL) {
			var url = portlet.refreshURL;
			var id = portlet.id;

			portlet = jQuery(portlet);

			var placeHolder = jQuery('<div class="loading-animation" id="p_load' + id + '" />');

			portlet.before(placeHolder);
			portlet.remove();

			instance.addHTML(
				{
					url: url,
					placeHolder: placeHolder[0],
					onComplete: function(portlet, portletId) {
						portlet.refreshURL = url;
					}
				}
			);
		}
	},

	refreshLayout: function(portletBound) {
	}
};

jQuery.fn.last = function(fn) {
	Liferay.bind(
		'allPortletsReady',
		function(event) {
			fn();
		}
	)
};

// Backwards compatability

Liferay.Portlet.ready = function(fn) {
	Liferay.bind(
		'portletReady',
		function(event, data) {
			fn(data.portletId, data.portlet);
		}
	);
};
