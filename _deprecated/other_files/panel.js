Liferay.Panel = Liferay.Observable.extend(
	{

		/**
		 * OPTIONS
		 *
		 * Optional
		 * container {string|object}: A jQuery selector of the panel container if there are multiple panels handled by this one.
		 * panel {string|object}: A jQuery selector of the panel.
		 * panelContent {string|object}: A jQuery selector of the content section of the panel.
		 * header {string|object}: A jQuery selector of the panel's header area.
		 * titles {string|object}: A jQuery selector of the titles in the panel.
		 * footer {string|object}: A jQuery selector of the panel's footer area.
		 * accordion {boolean}: Whether or not the panels have accordion behavior (meaning only one panel can be open at a time).
		 * collapsible {boolean}: Whether or not the panel can be collapsed by clicking the title.
		 *
		 */

		initialize: function(options) {
			var instance = this;

			var defaults = {
				container: null,
				panel: '.lfr-panel',
				panelContent: '.lfr-panel-content',
				header: '.lfr-panel-header',
				titles: '.lfr-panel-titlebar',
				footer: '.lfr-panel-footer',
				accordion: false,
				collapsible: true,
				persistState: false
			};

			options = jQuery.extend(defaults, options);

			instance._inContainer = false;
			instance._container = jQuery(document.body);

			if (options.container) {
				instance._container = jQuery(options.container);
				instance._inContainer = true;
			}

			instance._panel = instance._container.find(options.panel);

			instance._panelContent = instance._panel.find(options.panelContent);
			instance._header = instance._panel.find(options.header);
			instance._footer = instance._panel.find(options.footer);
			instance._panelTitles = instance._panel.find(options.titles);
			instance._accordion = options.accordion;

			instance._collapsible = options.collapsible;
			instance._persistState = options.persistState;

			if (instance._collapsible) {
				instance.makeCollapsible();

				instance._panelTitles.disableSelection();
				instance._panelTitles.css(
					{
						cursor: 'pointer'
					}
				);

				var collapsedPanels = instance._panel.filter('.lfr-collapsed');

				if (instance._accordion && !collapsedPanels.length) {
					instance._panel.slice(1).addClass('lfr-collapsed');
				}
			}

			instance.set('container', instance._container);
			instance.set('panel', instance._panel);
			instance.set('panelContent', instance._panelContent);
			instance.set('panelTitles', instance._panelTitles);
		},

		makeCollapsible: function() {
			var instance = this;

			instance._panelTitles.each(
				function(i, n) {
					var title = jQuery(this);
					var panel = title.parents('.lfr-panel:first');

					if (panel.hasClass('lfr-extended')) {
						var toggler = title.find('.lfr-panel-button');

						if (!toggler.length) {
							title.append('<a class="lfr-panel-button" href="javascript: ;"></a>');
						}
					}
				}
			);

			instance._panelTitles.mousedown(
				function(event) {
					instance.onTitleClick(this);
				}
			);
		},

		onTitleClick: function(el) {
			var instance = this;

			var currentContainer = jQuery(el).parents('.lfr-panel');

			currentContainer.toggleClass('lfr-collapsed');

			if (instance._accordion) {
				var siblings = currentContainer.siblings('.lfr-panel');

				siblings.each(
					function (i, n) {
						if (this.id) {
							instance._saveState(this.id, 'closed');
						}

						jQuery(this).addClass('lfr-collapsed');
					}
				);
			}

			var panelId = currentContainer.attr('id');
			var state = 'open';

			if (currentContainer.hasClass('lfr-collapsed')) {
				state = 'closed';
			}

			instance._saveState(panelId, state);

			instance.trigger('titleClick');
		},

		_saveState: function (id, state) {
			var instance = this;

			if (instance._persistState) {
				var data = {};

				data[id] = state;

				jQuery.ajax(
					{
						url: themeDisplay.getPathMain() + '/portal/session_click',
						data: data
					}
				);
			}
		}
	}
);

jQuery.extend(
	Liferay.Panel,
	{
		get: function(id) {
			var instance = this;

			return instance[instance._prefix + id];
		},

		register: function(id, panel) {
			var instance = this;

			instance[instance._prefix + id] = panel;
		},

		_prefix: '__'
	}
);