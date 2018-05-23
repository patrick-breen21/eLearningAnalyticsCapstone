Liferay.AutoFields = Liferay.Observable.extend(
	{

		/**
		 * OPTIONS
		 *
		 * Required
		 * container {string|object}: A jQuery selector that contains the rows you wish to duplicate.
		 * baseRows {string|object}: A jQuery selector that defines which fields are duplicated.
		 *
		 * Optional
		 * fieldIndexes {string}: The name of the POST parameter that will contain a list of the order for the fields.
		 * sortable{boolean}: Whether or not the rows should be sortable
		 * sortableHandle{string}: A jQuery selector that defines a handle for the sortables
		 *
		 */

		initialize: function(options) {
			var instance = this;

			var container = jQuery(options.container);
			var baseRows = jQuery(options.baseRows);

			var fullContainer = jQuery('<div class="row-container"></div>');
			var baseContainer = jQuery('<div class="lfr-form-row"></div>');

			var rowControls = jQuery('<span class="row-controls"><a href="javascript: ;" class="add-row">' + Liferay.Language.get('add-row') + '</a><a href="javascript: ;" class="delete-row modify-link">' + Liferay.Language.get('delete-row') + '</a></span>');

			instance._baseContainer = fullContainer;
			instance._idSeed = baseRows.length;

			instance._undoManager = new Liferay.UndoManager(
				{
					container: container
				}
			);

			if (options.fieldIndexes) {
				instance._fieldIndexes = jQuery('[name=' + options.fieldIndexes + ']');

				if (!instance._fieldIndexes.length) {
					instance._fieldIndexes = jQuery('<input name="' + options.fieldIndexes + '" type="hidden" />')
					instance._baseContainer.append(instance._fieldIndexes);
				}
			}
			else {
				instance._fieldIndexes = jQuery([]);
			}

			fullContainer.click(
				function(event) {
					if (event.target.parentNode.className.indexOf('row-controls') > -1) {
						var target = jQuery(event.target);
						var currentRow = target.parents('.lfr-form-row:first')[0];

						if (target.is('.add-row')) {
							instance.addRow(currentRow);
						}

						if (target.is('.delete-row')) {
							target.trigger('change');

							instance.deleteRow(currentRow);
						}
					}
				}
			);

			instance._container = container;
			instance._rowContainer = fullContainer;

			baseRows.each(
				function(i) {
					var formRow;
					var controls = rowControls.clone();
					var currentRow = jQuery(this);

					if (currentRow.is('.lfr-form-row')) {
						formRow = currentRow;
					}
					else {
						formRow = baseContainer.clone();
						formRow.append(this);
					}

					formRow.append(controls);
					fullContainer.append(formRow);

					if (i == 0) {
						instance._rowTemplate = formRow.clone();
						instance._rowTemplate.clearForm();
					}
				}
			);

			var rows = fullContainer.find('.lfr-form-row');

			container.append(fullContainer);

			if (options.sortable){
				instance._makeSortable(options.sortableHandle);
			}

			Liferay.bind(
				'submitForm',
				function(event, data) {
					var form = jQuery(data.form);

					form.find('.lfr-form-row:hidden').remove();

					var fieldOrder = instance.serialize();

					instance._fieldIndexes.val(fieldOrder);
				}
			);

			instance._undoManager.bind(
				'clearList',
				function(event) {
					var hiddenRows = instance._rowContainer.find('.lfr-form-row:hidden');

					hiddenRows.remove();
				}
			);
		},

		addRow: function(el) {
			var instance = this;

			var currentRow = jQuery(el);
			var clone = currentRow.clone(true);

			var newSeed = (++instance._idSeed);
                        //MC-836
                        clone.find('option:selected').attr('selected', currentRow.find('option:selected').val());
			clone.find('select').attr('value', currentRow.find('option:selected').val());
                        
			clone.find('input, select, textarea').each(
				function() {
					var el = jQuery(this);
					var oldName = el.attr('name');
					var originalName = oldName.replace(/([0-9]+)$/, '');
					var newName = originalName + newSeed;

					if (!el.is(':radio')) {
						el.attr('name', newName);
					}
					else {
						oldName = el.attr('id');

						el.attr('checked', '');
						el.attr('value', newSeed);
					}

					el.attr('id', newName);
					clone.find('label[for=' + oldName + ']').attr('for', newName);
				}
			);

			//clone.clearForm();

			clone.find("input[type=hidden]").each(
				function() {
					this.value = '';
				}
			);

			currentRow.after(clone);

			clone.find('input:text:first').trigger('focus');

			instance.trigger('addRow', {row: clone, originalRow: currentRow, idSeed: newSeed});
		},

		deleteRow: function(el) {
			var instance = this;

			var visibleRows = instance._rowContainer.find('.lfr-form-row:visible');

			if (visibleRows.length == 1) {
				instance.addRow(el);
			}

			var deletedElement = jQuery(el);

			deletedElement.hide();

			instance._undoManager.add(
				function(stateData) {
					deletedElement.show();
				}
			);

			instance.trigger('deleteRow', {row: deletedElement});
		},

		serialize: function(filter) {
			var instance = this;

			var rows = instance._baseContainer.find('.lfr-form-row:visible');
			var serializedData = [];

			if (filter) {
				serializedData = filter.apply(instance, [rows]) || [];
			}
			else {
				rows.each(
					function(i) {
						var formField = jQuery(this).find(':input:first');
						var fieldId = formField.attr('id');

						if (!fieldId) {
							fieldId = formField.attr('name');
						}
						fieldId = (fieldId || '').match(/([0-9]+)$/);

						if (fieldId && fieldId[0]) {
							serializedData.push(fieldId[0]);
						}
					}
				)
			}

			return serializedData.join(',');
		},

		_moveDown: function(target) {
			var element = jQuery(target);

			while (!element.is('.lfr-form-row')) {
				element = element.parent();
			}

			element.next().after(element);
		},

		_moveUp: function(target) {
			var element = jQuery(target);

			while(!element.is('.lfr-form-row')) {
				element = element.parent();
			}

			element.prev().before(element);
		},

		_makeSortable: function(sortableHandle) {
			var instance = this;

			var rows = instance._rowContainer.find('.lfr-form-row');

			if (sortableHandle) {
				rows.find(sortableHandle).addClass('handle-sort-vertical');
			}

			instance._rowContainer.sortable(
				{
					axis: 'y',
					helper: function(event, obj) {
						var height = obj.height();
						var width = obj.width();

						var helper = obj.clone();

						helper.css(
							{
								height: height,
								width: width
							}
						);

						return helper[0];
					},
					items: '.lfr-form-row',
					handle: sortableHandle
				}
			);
		},

		_idSeed: 0
	}
);