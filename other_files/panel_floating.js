Liferay.PanelFloating = Liferay.Panel.extend(
	{

		/**
		 * OPTIONS
		 *
		 * Also inherits all configuration options from Liferay.Panel
		 *
		 * Optional
		 * trigger {string|object}: A jQuery selector of the element that triggers the opening of the floating panel.
		 * paging {boolean}: Whether or not to add pagination to the panel.
		 * pagingElements {string}: A jQuery selector of the elements that make up each "page".
		 * resultsPerPage {number}: The number of results to show per page.
		 * width {number}: The width of the panel.
		 *
		 */

		initialize: function(options) {
			var instance = this;

			var defaults = {
				trigger: '.lfr-trigger',
				paging: false,
				pagingElements: 'ul',
				resultsPerPage: 1,
				width: 300
			};

			options = jQuery.extend(defaults, options);

			instance._paging = options.paging;
			instance._pagingElements = options.pagingElements;
			instance._trigger = jQuery(options.trigger);
			instance._containerWidth = options.width;

			instance.parent(options);

			if (!instance._inContainer) {
				instance._container = jQuery('<div class="lfr-floating-container"></div>');

				instance._panel.eq(0).before(instance._container);
				instance._container.append(instance._panel);

				instance._inContainer = true;
			}

			instance.paginate(instance._container.find('.lfr-panel-content'));

			instance._trigger.addClass('lfr-floating-trigger');

			instance._trigger.click(
				function(event) {
					instance.onTriggerClick(this);

					jQuery(document).bind(
						'click.liferay-panel',
						function(event) {
							var target = jQuery(event.target);

							if (!target.is('.lfr-panel') && !target.parents('.lfr-position-helper').length) {

								instance.onOuterClick(this);
								jQuery(this).unbind('click.liferay-panel', arguments.callee);
							}
						}
					);

					return false;
				}
			);

			instance.set('trigger', instance._trigger);
		},

		hide: function() {
			var instance = this;

			instance._container.detachPositionHelper();

			instance._trigger.removeClass('lfr-trigger-selected');

			instance.trigger('hide');
		},

		onOuterClick: function() {
			var instance = this;

			instance.hide();

			instance.trigger('outerClick');
		},

		onTitleClick: function(el) {
			var instance = this;

			instance.parent(el);

			var currentContainer = jQuery(el).parents('.lfr-panel');
			var sets = currentContainer.find('ul');

			if (!sets.filter('.current-set').length) {
				sets.filter(':first').addClass('current-set');
			}

			instance.paginate(currentContainer);
		},

		onTriggerClick: function(trigger) {
			var instance = this;

			var panelHidden = instance._container.is(':hidden');

			if (panelHidden) {
				instance.show(trigger);
			}
			else {
				instance.hide(trigger);
			}

			instance.trigger('triggerClick');
		},

		paginate: function(currentPanelContent) {
			var instance = this;

			if (!currentPanelContent) {
				currentPanelContent = instance._container.find('.lfr-panel-open .lfr-panel-content');
			}

			if (instance._paging) {
				instance._container.addClass('lfr-panel-paging');

				currentPanelContent.each(
					function(i, n) {
						var currentPanelContent = jQuery(this);

						if (currentPanelContent.data('paginated') != true) {
							var sets = currentPanelContent.find('>' + instance._pagingElements);
							var totalPages = sets.length;

							var currentSet = sets.filter('.current-set');

							var pageNumber = 1;

							if (!currentSet.length) {
								currentSet = sets.eq(0);
								currentSet.addClass('current-set');
							}
							else {
								pageNumber = sets.index(currentSet[0]) + 1;
							}

							currentPanelContent.data('currentPageSet', currentSet);
							currentPanelContent.data('currentPageNumber', pageNumber);

							if (totalPages > 1) {
								var pagingContainer = jQuery('<div class="lfr-component lfr-paging-container"><ul class="lfr-paging-pages"></ul></div>');

								var pagingList = pagingContainer.find('.lfr-paging-pages');

								var listItems = ['<li class="lfr-page lfr-page-previous"><a href="javascript: ;">&laquo;</a></li>'];

								for (var i=1; i <= totalPages; i++) {
									var cssClass = '';

									if (i == 1) {
										cssClass = 'lfr-page-current';
									}

									listItems.push('<li class="lfr-page ' + cssClass + '" data-page="' + i + '"><a href="javascript: ;">' + i + '</a></li>');
								}

								listItems.push('<li class="lfr-page lfr-page-next"><a href="javascript: ;">&raquo;</a></li>');

								pagingList.append(listItems.join(''));

								var goToPage = function(pageNumber) {
									var currentSet = sets.eq(pageNumber - 1);

									if (currentSet.length) {
										sets.removeClass('current-set');
										currentSet.addClass('current-set');

										pagingList.find('.lfr-page').each(
											function(i) {
												var className = this.className || '';

												if (className.indexOf('lfr-page-current') > -1) {
													jQuery(this).removeClass('lfr-page-current');
												}
												else {
													if (className.indexOf('lfr-page-previous') < 0 &&
														className.indexOf('lfr-page-next') < 0 &&
														i == pageNumber) {

														jQuery(this).addClass('lfr-page-current');
													}
												}
											}
										);

										currentPanelContent.data('currentPageSet', currentSet);
										currentPanelContent.data('currentPageNumber', pageNumber);
									}
								};

								pagingContainer.attr('data-currentPageNumber', 1);

								pagingContainer.click(
									function(event) {
										var container = jQuery(this);
										var target = jQuery(event.target);

										if (target.is('.lfr-page') || (target = target.parents('.lfr-page')).length) {
											var pageNumber = target.attr('data-page');

											if (!pageNumber) {
												var currentPageNumber = currentPanelContent.data('currentPageNumber');
												currentPageNumber = parseInt(currentPageNumber);

												if (isNaN(currentPageNumber) || currentPageNumber == 0) {
													currentPageNumber = 1;
												}

												if (target.is('.lfr-page-next')) {
													currentPageNumber += 1;
												}
												else if (target.is('.lfr-page-previous')) {
													currentPageNumber -= 1;
												}

												pageNumber = currentPageNumber;
											}

											if (!target.is('.lfr-page-current')) {
												goToPage(pageNumber);
											}
										}
									}
								);

								currentPanelContent.append(pagingContainer);

								currentPanelContent.data('paginated', true);
							}
						}
					}
				);
			}
		},

		position: function(trigger) {
			var instance = this;

			instance._container.alignTo(trigger);
		},

		show: function(trigger) {
			var instance = this;

			instance._container.width(instance._containerWidth);
			instance._container.show();

			instance.position(trigger);

			instance._trigger.addClass('lfr-trigger-selected');

			if (instance._paging) {
				instance._setMaxPageHeight();
			}

			instance.trigger('show');
		},

		_setMaxPageHeight: function() {
			var instance = this;

			var sets = instance._container.find('.lfr-panel:not(.lfr-collapsed)');

			var maxHeight = 0;

			var panelContent = sets.find('.lfr-panel-content');
			var pages = panelContent.find('>' + instance._pagingElements);

			pages.each(
				function(i, n) {
					var setHeight = jQuery(this).height();

					if (setHeight > maxHeight) {
						maxHeight = setHeight;
					}
				}
			);

			pages.height(maxHeight);
		}
	}
);