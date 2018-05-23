Liferay.TagsCategoriesSelector = new Liferay.Class(
	{

		/**
		 * OPTIONS
		 *
		 * Required
		 * curTagsCategories (string): The current categories.
		 * instanceVar {string}: The instance variable for this class.
		 * hiddenInput {string}: The hidden input used to pass in the current categories.
		 * summarySpan {string}: The summary span to show the current categories.
		 */

		initialize: function(options) {
			var instance = this;

			instance._curTagsCategories = [];

			instance.options = options;
			instance._ns = instance.options.instanceVar || '';
			instance._mainContainer = jQuery('<div class="lfr-tag-select-container"></div>');
			instance._container = jQuery('<div class="lfr-tag-container"></div>');
			instance._searchContainer = jQuery('<div class="lfr-tag-search-container"><input class="lfr-tag-search-input" type="text"/></div>');

			var hiddenInput = jQuery('#' + options.hiddenInput);

			hiddenInput.attr('name', hiddenInput.attr('id'));

			instance._popupVisible = false;

			instance._setupSelectTagsCategories();

			if (options.curTagsCategories != '') {
				instance._curTagsCategories = options.curTagsCategories.split(',');

				instance._update();
			}
		},

		deleteTagCategory: function(id) {
			var instance = this;

			var options = instance.options;
			var curTagsCategories = instance._curTagsCategories;

			jQuery('#' + instance._ns + 'CurTags' + id).remove();

			var value = curTagsCategories.splice(id, 1);

			if (instance._popupVisible) {
				jQuery('input[type=checkbox][value$=' + value + ']', instance.selectTagCategoryPopup).attr('checked', false);
			}

			instance._update();
		},

		_tagCategoryIterator: function(entries, parent, buffer, counter) {
			var instance = this;

			jQuery.each(
				entries,
				function(i) {
					var entry = this;
					var entryName = entry.name;
					var entryId = entry.entryId;
					var checked = (instance._curTagsCategories.indexOf(entryName) > -1) ? ' checked="checked" ' : '';

					buffer.push('<label title="');
					buffer.push(entryName);
					buffer.push('" style="padding: 1px 0 1px ');
					buffer.push(counter * 20);
					buffer.push('px;">');
					buffer.push('<input type="checkbox" value="');
					buffer.push(entryName);
					buffer.push('" ');
					buffer.push(checked);
					buffer.push('> ');
					buffer.push(entryName);
					buffer.push('</label>');

					var childEntries = Liferay.Service.Tags.TagsEntry.getGroupVocabularyEntries(
						{
							groupId: themeDisplay.getScopeGroupId(),
							parentEntryName: entryName,
							vocabularyName: parent
						},
						false
					);

					if (childEntries.length > 0) {
						instance._tagCategoryIterator(childEntries, parent, buffer, counter + 1);
					}
				}
			);

			counter = counter - 1;
		},

		_createPopup: function() {
			var instance = this;

			var ns = instance._ns;
			var container = instance._container;
			var mainContainer = instance._mainContainer;
			var searchContainer = instance._searchContainer;

			var saveBtn = jQuery('<input class="submit lfr-save-button" id="' + ns + 'saveButton" type="submit" value="' + Liferay.Language.get('save') + '" />');

			saveBtn.click(
				function() {
					instance._curTagsCategories = instance._curTagsCategories.length ? instance._curTagsCategories : [];

					container.find('input[type=checkbox]').each(
						function() {
							var currentIndex = instance._curTagsCategories.indexOf(this.value);
							if (this.checked) {
								if (currentIndex == -1) {
									instance._curTagsCategories.push(this.value);
								}
							}
							else {
								if (currentIndex > -1) {
									instance._curTagsCategories.splice(currentIndex, 1);
								}
							}
						}
					);

					instance._update();
					Liferay.Popup.close(instance.selectTagCategoryPopup);
				}
			);

			mainContainer.append(searchContainer).append(container).append(saveBtn);

			if (!instance.selectTagCategoryPopup) {
				var popup = Liferay.Popup(
					{
						className: 'lfr-tag-selector',
						message: mainContainer[0],
						modal: false,
						position: 'center',
						resizable: false,
						title: Liferay.Language.get('categories'),
						width: 400,
						open: function() {
	 						var inputSearch = jQuery('.lfr-tag-search-input');

							Liferay.Util.defaultValue(inputSearch, Liferay.Language.get('search'));
						},
						onClose: function() {
							instance._popupVisible = false;
							instance.selectTagCategoryPopup = null;
						}
					}
				);
				instance.selectTagCategoryPopup = popup;
			}
			instance._popupVisible = true;

			if (Liferay.Browser.isIe()) {
				jQuery('.lfr-label-text', popup).click(
					function() {
						var input = jQuery(this.previousSibling);
						var checkedState = !input.is(':checked');
						input.attr('checked', checkedState);
					}
				);
			}
		},

		_initializeSearch: function(container) {
			var data = function() {
				var value = jQuery(this).attr('title');

				return value.toLowerCase();
			};

			var inputSearch = jQuery('.lfr-tag-search-input');

			var options = {
				data: data,
				list: '.lfr-tag-container label',
				after: function() {
					jQuery('fieldset', container).each(
						function() {
							var fieldset = jQuery(this);

							var visibleEntries = fieldset.find('label:visible');

							if (visibleEntries.length == 0) {
								fieldset.addClass('no-matches');
							}
							else {
								fieldset.removeClass('no-matches');
							}
						}
					);
				}
			};

			inputSearch.liveSearch(options);
		},

		_setupSelectTagsCategories: function() {
			var instance = this;

			var options = instance.options;
			var ns = instance._ns;

			var input = jQuery('#' + ns + 'selectTagsCategories');

			input.click(
				function() {
					instance._showSelectPopup();
				}
			);
		},

		_showSelectPopup: function() {
			var instance = this;

			var options = instance.options;
			var ns = instance._ns;
			var mainContainer = instance._mainContainer;
			var container = instance._container;
			var searchMessage = Liferay.Language.get('no-categories-found');

			mainContainer.empty();

			container.empty().html('<div class="loading-animation" />');

			Liferay.Service.Tags.TagsVocabulary.getGroupVocabularies(
				{
					groupId: themeDisplay.getScopeGroupId(),
					folksonomy: false
				},
				function(vocabularies) {
					var buffer = [];

					if (vocabularies.length == 0) {
						buffer.push('<fieldset class="no-matches"><legend>' + Liferay.Language.get('category-sets') + '</legend>');
						buffer.push('<div class="lfr-tag-message">' + searchMessage + '</div>');
						buffer.push('</fieldset>');

						container.html(buffer.join(''));
					}
					else {
						jQuery.each(
							vocabularies,
							function(i) {
								var tagCategorySet = this;
								var tagCategorySetName = tagCategorySet.name;
								var tagCategorySetId = tagCategorySet.groupId;

								Liferay.Service.Tags.TagsEntry.getGroupVocabularyRootEntries(
									{
										groupId: tagCategorySetId,
										name: tagCategorySetName
									},
									function(entries) {
										buffer.push('<fieldset>');
										buffer.push('<legend class="lfr-tag-set-title">');
										buffer.push(tagCategorySetName);
										buffer.push('</legend>');

										instance._tagCategoryIterator(entries, tagCategorySetName, buffer, 0);

										buffer.push('<div class="lfr-tag-message">' + searchMessage + '</div>');
										buffer.push('</fieldset>');

										container.html(buffer.join(''));

										instance._initializeSearch(container);
									}
								);
							}
						);
					}
				}
			);

			instance._createPopup();
		},

		_update: function() {
			var instance = this;

			instance._updateHiddenInput();
			instance._updateSummarySpan();
		},

		_updateHiddenInput: function() {
			var instance = this;

			var options = instance.options;
			var curTagsCategories = instance._curTagsCategories;

			var hiddenInput = jQuery('#' + options.hiddenInput);

			hiddenInput.val(curTagsCategories.join(','));
		},

		_updateSummarySpan: function() {
			var instance = this;

			var options = instance.options;
			var curTagsCategories = instance._curTagsCategories;

			var html = '';

			jQuery(curTagsCategories).each(
				function(i, curTagCategory) {
					html += '<span class="ui-tag" id="' + instance._ns + 'CurTags' + i + '">';
					html += curTagCategory;
					html += '<a class="ui-tag-delete" href="javascript: ' + instance._ns + '.deleteTagCategory(' + i + ');"><span>x</span></a>';
					html += '</span>';
				}
			);

			var tagsCategoriesSummary = jQuery('#' + options.summarySpan);

			if (curTagsCategories.length) {
				tagsCategoriesSummary.removeClass('empty');
			}
			else {
				tagsCategoriesSummary.addClass('empty');
			}

			tagsCategoriesSummary.html(html);
		}
	}
);