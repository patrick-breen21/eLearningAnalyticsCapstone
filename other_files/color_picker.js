Liferay.ColorPicker = new Liferay.Class(
	{

		/**
		 * OPTIONS
		 *
		 * Required
		 * item {string|object}: A jQuery selector or DOM element that specifies which field to insert the selected value into.
		 *
		 * Optional
		 * context {object}: A DOM element which specifies the context in which to search for the item.
		 * hasImage {boolean}: Whether an image is provided in the DOM or options object (via the item option).
		 *
		 * Callbacks
		 * onChange {function}: Called whenever the color changes.
		 * onClose {function}: Called when the color picker is closed.
		 */

		initialize: function(options) {
			var instance = this;

			instance._onClose = options.onClose;
			instance._onChange = options.onChange;
			instance._context = options.context || document.body;
			instance._hasImage =  options.hasImage || false;
			instance._item = jQuery(options.item || '.use-colorpicker', instance._context);

			instance._currentColor = {r:255, g:255, b:255};

			instance._insertImages();

			instance._buildHTML();
		},

		_buildHTML: function() {
			var instance = this;

			var baseDiv = jQuery('<div class="lfr-colorpicker" />');
			var closeButton = jQuery('<div class="ui-colorpicker-close" />');

			baseDiv.append(closeButton);

			baseDiv.appendTo('body');

			closeButton.click(
				function(event) {
					instance._toggle(event, this);
				}
			);

			var onChange = function(event, ui) {
				instance._currentInput.val('#' + ui.hex);
				instance._currentColor = ui.rgb;

				if (instance._onChange) {
					instance._onChange(ui.rgb);
				}
			};

			baseDiv.colorpicker(
				{
					change: onChange,
					picking: onChange,
					pick: onChange
				}
			);

			baseDiv.hide();

			baseDiv.css(
				{
					position: 'absolute',
					zIndex: Liferay.zIndex.ALERT + 1
				}
			);

			instance._baseDiv = baseDiv;
		},

		_insertImages: function() {
			var instance = this;

			var context = instance._context;

			var items = instance._item;

			var colorPickerImgHTML = '<img alt="' + Liferay.Language.get('color-picker') + '" class="lfr-colorpicker-img" src="' + themeDisplay.getPathThemeImages() + '/color_picker/color_picker.png" title="' + Liferay.Language.get('color-picker') + '" />';

			if (items.length == 1) {
				var colorPickerImg;

				if (instance._hasImage) {
					colorPickerImg = items;
				}
				else {
					colorPickerImg = jQuery(colorPickerImgHTML);

					items.after(colorPickerImg);
				}

				colorPickerImg.click(
					function(event) {
						instance._toggle(event, this);
					}
				);
			}
			else {
				items.each(
					function() {
						var item = jQuery(this);
						var colorPickerImg;

						if (!instance._hasImage) {
							colorPickerImg = jQuery(colorPickerImgHTML);
						}
						else {
							colorPickerImg = item;
						}

						colorPickerImg.click(
							function(event) {
								instance._toggle(event, this);
							}
						);

						item.after(colorPickerImg);
					}
				);
			}
		},

		_toggle: function(event, obj) {
			var instance = this;

			var item = jQuery(obj);

			var dimensions = item.offset();

			instance._currentInput = item.prev();

			var baseDiv = instance._baseDiv;

			if (baseDiv.is(':visible')) {
				baseDiv.hide();

				if (instance._item.is('input')) {
					instance._item.trigger('blur');
				}

				if (instance._onClose) {
					instance._onClose();
				}
			}
			else {
				baseDiv.show();

				if (instance._item.is('input')) {
					instance._item.trigger('focus');
				}

				baseDiv.css(
					{
						top: dimensions.top + 'px',
						left: dimensions.left + 25 + 'px'
					}
				);
			}
		}
	}
);