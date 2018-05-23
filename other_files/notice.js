Liferay.Notice = new Liferay.Class(
	{

		/**
		 * OPTIONS
		 *
		 * Required
		 * content {string}: The content of the toolbar.
		 *
		 * Optional
		 * closeText {string}: Use for the "close" button. Set to false to not have a close button.
		 * toggleText {object}: The text to use for the "hide" and "show" button. Set to false to not have a hide button.
		 * noticeClass {string}: A class to add to the notice toolbar.
		 * type {string}: Either 'notice' or 'warning', depending on the type of the toolbar. Defaults to notice.
		 *
		 * Callbacks
		 * onClose {function}: Called when the toolbar is closed.
		 */

		initialize: function(options) {
			var instance = this;
			options = options || {};
			instance._noticeType = options.type || 'notice';
			instance._noticeClass = 'popup-alert-notice';
			instance._useCloseButton = true;
			instance._onClose = options.onClose;
			instance._closeText = options.closeText;
			instance._body = jQuery('body');

			instance._useToggleButton = false;
			instance._hideText = '';
			instance._showText = '';

			if (options.toggleText !== false) {
				instance.toggleText = jQuery.extend(
					{
						hide: null,
						show: null
					},
				options.toggleText);

				instance._useToggleButton = true;
			}

			if (instance._noticeType == 'warning') {
				instance._noticeClass = 'popup-alert-warning';
			}

			if (options.noticeClass) {
				instance._noticeClass += ' ' + options.noticeClass;
			}

			instance._content = options.content || '';

			instance._createHTML();

			return instance._notice;
		},

		setClosing: function() {
			var instance = this;

			var staticAlerts = jQuery('.popup-alert-notice, .popup-alert-warning').not('[dynamic=true]');

			if (staticAlerts.length) {
				instance._useCloseButton = true;
				instance._addCloseButton(staticAlerts);

				if (!instance._body) {
					instance._body = jQuery('body');
				}

				instance._body.addClass('has-alerts')
			}
		},

		_createHTML: function() {
			var instance = this;

			var notice = jQuery('<div class="' + instance._noticeClass + '" dynamic="true"><div class="popup-alert-content"></div></div>');

			notice.html(instance._content);

			instance._addCloseButton(notice);
			instance._addToggleButton(notice);

			instance._body.append(notice);
			instance._body.addClass('has-alerts');

			instance._notice = notice;
		},

		_addCloseButton: function(notice) {
			var instance = this;

			if (instance._closeText !== false) {
				instance._closeText = instance._closeText || Liferay.Language.get('close');
			}
			else {
				instance._useCloseButton = false;
				instance._closeText = '';
			}

			if (instance._useCloseButton) {
				var html = '<input class="submit popup-alert-close" type="submit" value="' + instance._closeText + '" />';

				notice.append(html);

				var closeButton = notice.find('.popup-alert-close');
				closeButton.click(
					function() {
						notice.slideUp(
							'normal',
							function() {
								notice.remove();
								instance._body.removeClass('has-alerts');
							}
						);

						if (instance._onClose) {
							instance._onClose();
						}
					}
				);
			}
		},

		_addToggleButton: function(notice) {
			var instance = this;

			if (instance._useToggleButton) {
				instance._hideText = instance._toggleText.hide || Liferay.Language.get('hide');
				instance._showText = instance._toggleText.show || Liferay.Language.get('show');

				var toggleButton = jQuery('<a class="toggle-button" href="javascript:;"><span>' + instance._hideText + '</span></a>');
				var toggleSpan = toggleButton.find('span');
				var height = 0;

				toggleButton.toggle(
					function() {
						notice.slideUp();
						toggleSpan.text(instance._showText);
					},
					function() {
						notice.slideDown();
						toggleSpan.text(instance._hideText);
					}
				);

				notice.append(toggleButton);
			}
		}
	}
);