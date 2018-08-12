Liferay.DynamicSelect = new Liferay.Class(
	{

		/**
		 * OPTIONS
		 *
		 * Required
		 * array {array}: An array of options.
		 * array[i].select {string}: An id of a select box.
		 * array[i].selectId {string}: A JSON object field name for an option value.
		 * array[i].selectDesc {string}: A JSON object field name for an option description.
		 * array[i].selectVal {string}: The value that is displayed in an option field.
		 *
		 * Callbacks
		 * array[i].selectData {function}: Returns a JSON array to populate the next select box.
		 */

		initialize: function(array) {
			var instance = this;

			instance.array = array;

			jQuery.each(
				array,
				function(i, options) {
					var id = options.select;
					var select = jQuery('#' + id);
					var selectData = options.selectData;

					select.attr('data-componentType', 'dynamic_select');

					var prevSelectVal = null;

					if (i > 0) {
						prevSelectVal = array[i - 1].selectVal;
					}

					selectData(
						function(list) {
							instance._updateSelect(i, list);
						},
						prevSelectVal
					);

					select.attr('name', id);

					select.bind(
						'change',
						function() {
							instance._callSelectData(i);
						}
					);
				}
			);
		},

		_callSelectData: function(i) {
			var instance = this;

			var array = instance.array;

			if ((i + 1) < array.length) {
				var curSelect = jQuery('#' + array[i].select);
				var nextSelectData = array[i + 1].selectData;

				nextSelectData(
					function(list) {
						instance._updateSelect(i + 1, list);
					},
					curSelect.val()
				);
			}
		},

		_updateSelect: function(i, list) {
			var instance = this;

			var options = instance.array[i];

			var select = jQuery('#' + options.select);
			var selectId = options.selectId;
			var selectDesc = options.selectDesc;
			var selectVal = options.selectVal;
			var selectNullable = options.selectNullable || true;

			var selectOptions = [];

			if (selectNullable) {
				selectOptions.push('<option value="0"></option>');
			}

			jQuery.each(
				list,
				function(i, obj) {
					var key = obj[selectId];
					var value = obj[selectDesc];

					selectOptions.push('<option value="' + key + '">' + value + '</option>');
				}
			);

			selectOptions = selectOptions.join('');

			select.html(selectOptions);
			select.find('option[value=' + selectVal + ']').attr('selected', 'selected');

			if (Liferay.Browser.isIe()) {
				select.css('width', 'auto');
			}
		}
	}
);