Liferay.Navigation = new Liferay.Class(
	{

		/**
		 * OPTIONS
		 *
		 * Required
		 * hasPermission {boolean}: Whether the current user has permission to modify the navigation
		 * layoutIds {array}: The displayable layout ids.
		 * navBlock {string|object}: A jQuery selector or DOM element of the navigation.
		 */

		initialize: function(options) {
			var instance = this;
			instance.options = options;
			
			instance._navBlock = jQuery(instance.options.navBlock);
			
			instance._isWorkflowEnabled = instance.options.isWorkflowEnabled;
			instance._jsonReviewers = instance.options.jsonReviewers;
			instance._portletURL = instance.options.portletURL;
			instance._stagingGroupId = instance.options.stagingGroupId;
			instance._groupId = instance.options.groupId;
			instance._className = instance.options.className;
			instance._urlCurrent = instance.options.urlCurrent;
			
			
			instance._hasPermission = instance.options.hasPermission;
			instance._isModifiable = instance._navBlock.is('.modify-pages');
			instance._isSortable = instance._navBlock.is('.sort-pages') && instance._hasPermission;
			instance._isUseHandle = instance._navBlock.is('.use-handle');

			instance._updateURL = themeDisplay.getPathMain() + '/layout_management/update_page';

			var items = instance._navBlock.find('> ul > li');

			items.each(
				function(i) {
					this._LFR_layoutId = instance.options.layoutIds[i];
				}
			);

			instance._makeAddable();
			instance._makeDeletable();
			instance._makeSortable();
			instance._makeEditable();

			Liferay.bind('tree', instance._treeCallback, instance);
		},

		_addPage: function(event, obj) {
			var instance = this;

			var navItem = instance._navBlock;
			var addBlock = jQuery('<li>' + instance._enterPage + '</li>');

			var blockInput = addBlock.find('input');

			navItem.find('ul:first').append(addBlock);

			var savePage = addBlock.find('.save-page');
			var cancelPage = addBlock.find('.cancel-page');
			var currentInput = addBlock.find('.enter-page input');

			var pageParents = jQuery(document);

			var pageBlur = function(internalEvent) {
				var currentEl = jQuery(internalEvent.target);
				var liParent = currentEl.parents('ul:eq(0)');

				if ((liParent.length == 0) && !currentEl.is('li') && !currentEl.parents('#add-page').length) {
					cancelPage.trigger('click');
				}
			};

			pageParents.bind('click.liferay', pageBlur);

			cancelPage.click(
				function(event) {
					instance._cancelAddingPage(event, addBlock);
					pageParents.unbind('click.liferay', pageBlur);
				}
			);

			savePage.click(
				function(event) {
					instance._savePage(event, this);
					pageParents.unbind('click.liferay', pageBlur);
				}
			);

			currentInput.keyup(
				function(event) {
					if (event.keyCode == 13) {
						savePage.trigger('click');
					}
					else if (event.keyCode == 27) {
						cancelPage.trigger('click');
					}
					else {
						return;
					}

					pageParents.unbind('click.liferay', pageBlur);
				}
			);
		},

		_cancelAddingPage: function(event, obj) {
			var instance = this;
			obj.remove();
		},

		_cancelPage: function(event, obj, oldName) {
			var navItem = null;

			if (oldName) {
				navItem = jQuery(obj).parents('li');

				var enterPage = navItem.find('.enter-page');

				enterPage.prev().show();
				enterPage.remove();
			}
			else {
				navItem = jQuery(this).parents('li');

				navItem.remove();
			}
		},

		_deleteButton: function(obj) {
			var instance = this;

			obj.append('<span class="delete-tab">X</span>');

			var deleteTab = obj.find('.delete-tab');

			deleteTab.click(
				function(event) {
					instance._removePage(this);
				}
			);

			deleteTab.hide();

			obj.hover(
				function() {
					jQuery(this).find('.delete-tab').fadeIn('fast');
				},
				function() {
					jQuery(this).find('.delete-tab').fadeOut('fast');
				}
			);
		},

		_makeAddable: function() {
			var instance = this;

			if (instance._isModifiable) {
				var navList = instance._navBlock.find('ul:first');

				instance._enterPage =
					'<div class="enter-page">' +
					'<input class="lfr-auto-focus" type="text" name="new_page" value="" class="text" placeholder="Page name" />' +
					'<a class="cancel-page" href="javascript: ;"></a>' +
					'<a class="save-page btn btn-info margin-t-10" href="javascript: ;">' + Liferay.Language.get('save') + '</a>' +
					'</div>';

				if (instance._hasPermission) {
					navList.after(
						'<div id="add-page">' +
						'<a href="javascript:;">' +
						'<span>' + Liferay.Language.get('add-page') + '</span>' +
						'</a>' +
						'</div>');

					var addPage = navList.parent().find('#add-page a');

					addPage.click(
						function(event) {
							instance._addPage(event, this);
						}
					);
					//MC-718 this will call the add page functionality where class "mycampus-add-page" is used
					var addPagenewmycampus = jQuery('.mycampus-add-page');
					addPagenewmycampus.click(
					    function() {
					        instance._addPage('click', this);
					    }
					);
					addPagenewmycampus.bind("click", Liferay.Navigation._addPage, Liferay.Navigation );
				}
			}
		},

		_makeDeletable: function() {
			var instance = this;

			if (instance._isModifiable && instance._hasPermission) {
				var navItems = instance._navBlock.find('> ul > li').not('.selected');

				instance._deleteButton(navItems);
			}
		},

		_makeEditable: function() {
			var instance = this;

			if (instance._isModifiable) {
				var currentItem = instance._navBlock.find('li.selected');
				var currentLink = currentItem.find('a');
				var currentSpan = currentLink.find('span');

				currentLink.click(
					function(event) {
						if (event.shiftKey) {
							return false;
						}
					}
				);

				var resetCursor = function() {
					currentSpan.css('cursor', 'pointer');
				};

				currentLink.hover(
					function(event) {
						if (!themeDisplay.isStateMaximized() || event.shiftKey) {
							currentSpan.css('cursor', 'text');
						}
					},
					resetCursor
				);

				currentSpan.click(
					function(event) {
						if (themeDisplay.isStateMaximized() && !event.shiftKey) {
							return;
						}

						var span = jQuery(this);
						var text = span.text();

						span.parent().hide();
						span.parent().after(instance._enterPage);

						var enterPage = span.parent().next();

						var pageParents = enterPage.parents();

						var enterPageInput = enterPage.find('input');

						var pageBlur = function(event) {
							event.stopPropagation();

							if (!jQuery(this).is('li')) {
								cancelPage.trigger('click');
							}

							return false;
						};

						enterPageInput.val(text);

						enterPageInput.trigger('select');

						var savePage = enterPage.find('.save-page');

						savePage.click(
							function(event) {
								instance._savePage(event, this, text);
								pageParents.unbind('blur.liferay', pageBlur);
								pageParents.unbind('click.liferay', pageBlur);
							}
						);

						var cancelPage = enterPage.find('.cancel-page');

						cancelPage.hide();

						cancelPage.click(
							function(event) {
								instance._cancelPage(event, this, text);
								pageParents.unbind('blur.liferay', pageBlur);
								pageParents.unbind('click.liferay', pageBlur);
							}
						);

						enterPageInput.keyup(
							function(event) {
								if (event.keyCode == 13) {
									savePage.trigger('click');
									pageParents.unbind('blur.liferay', pageBlur);
									pageParents.unbind('click.liferay', pageBlur);
								}
								else if (event.keyCode == 27) {
									cancelPage.trigger('click');
									pageParents.unbind('blur.liferay', pageBlur);
									pageParents.unbind('click.liferay', pageBlur);
								}
							}
						);

						pageParents.bind('click.liferay', pageBlur);

						resetCursor();

						return false;
					}
				);
			}
		},

		_makeSortable: function() {
			var instance = this;

			var navBlock = instance._navBlock;
			var navList = navBlock.find('ul:first');

			if (instance._isSortable) {
				var items = navList.find('li');
				var anchors = items.find('a');

				if (instance._isUseHandle) {
					items.append('<span class="sort-handle">+</span>');
				}
				else {
					anchors.css('cursor', 'move');
					anchors.find('span').css('cursor', 'pointer');
				}

				items.addClass('sortable-item');

				instance.sortable = navList.sortable(
					{
						items: '.sortable-item',
						placeholder: 'navigation-sort-helper',
						handle: (instance._isUseHandle ? '.sort-handle' : 'a'),
						opacity: 0.8,
						revert:	false,
						tolerance: 'pointer',
						distance: 5,
						stop: function(event, ui) {
							instance._saveSortables(ui.item[0]);

							Liferay.trigger(
								'navigation',
								{
									item: ui.item[0],
									type: 'sort'
								}
							);
						}
					}
				);
			}
		},

		_removePage: function(obj) {
			var instance = this;
			
			var tab = jQuery(obj).parents('li');
			var tabText = tab.find('a span').html();
			
			if (confirm(Liferay.Language.get('are-you-sure-you-want-to-delete-this-page'))) {
				if(instance._isWorkflowEnabled) {
					var proposalURL = instance._portletURL + '/group/control_panel/manage?p_p_id=134&p_p_lifecycle=1&p_p_state=maximized&p_p_mode=view&_134_struts_action=/enterprise_admin_communities/edit_proposal&_134_cmd=add&_134_proposal_type=delete&_134_redirect=/group/control_panel/manage&_134_privateLayout='+themeDisplay.isPrivateLayout()+'&_134_stagingGroupId='+instance._stagingGroupId+'&_134_groupId='+instance._groupId+'&_134_className='+instance._className;
					Liferay.LayoutExporter.proposeLayout({url: proposalURL, namespace: '_134_', reviewers: instance._jsonReviewers, title: Liferay.Language.get('proposal-description')}, tab[0]._LFR_layoutId, instance._urlCurrent);
					
				} else {
					var data = {
							doAsUserId: themeDisplay.getDoAsUserIdEncoded(),
							cmd: 'delete',
							groupId: themeDisplay.getScopeGroupId(),
							privateLayout: themeDisplay.isPrivateLayout(),
							layoutId: tab[0]._LFR_layoutId
						}; 
						
						jQuery.ajax( 
							{
								data: data,
								success: function() {
									Liferay.trigger(
										'navigation',
										{
											item: tab,
											type: 'delete'
										}
									);

									tab.remove();
								},
								url: instance._updateURL
							}
						);
				}
			}
		},

		_savePage: function(event, obj, oldName) {
			var instance = this;

			if ((event.type == 'keyup') && (event.keyCode !== 13)) {
				return;
			}

			var data = null;
			var onSuccess = null;

			var newNavItem = jQuery(obj).parents('li');
			var name = newNavItem.find('input').val();
			var enterPage = newNavItem.find('.enter-page');
			var getPageNameInput = newNavItem.find('.enter-page input');
			var validName = /^[-A-Za-z0-9 ]+$/;
			var getPageName = newNavItem.find('.enter-page input').val();
			if(getPageName == '' || getPageName == 'null' || getPageName == 'undefined'){
				alert("Please enter a valid name");
				getPageNameInput.focus();
				return false;
				}
			if (!getPageName.match(validName)){
				alert("Page Name Should Have Only A-Z, 1-9 _ -");
				return false;
				}
			name = jQuery.trim(name);

			if (name) {
				if (oldName) {

					// Updating an existing page

					if (name != oldName) {
						data = {
							doAsUserId: themeDisplay.getDoAsUserIdEncoded(),
							cmd: 'name',
							groupId: themeDisplay.getScopeGroupId(),
							privateLayout: themeDisplay.isPrivateLayout(),
							layoutId: themeDisplay.getLayoutId(),
							name: name,
							languageId: themeDisplay.getLanguageId()
						};

						onSuccess = function(data) {
							var currentTab = enterPage.prev();
							var currentSpan = currentTab.find('span');

							currentSpan.text(name);
							currentTab.show();

							enterPage.remove();

							var oldTitle = jQuery(document).attr('title');

							var regex = new RegExp(oldName, 'g');

							newTitle = oldTitle.replace(regex, name);

							jQuery(document).attr('title', newTitle);
						}
					}
					else {

						// The new name is the same as the old one

						var currentTab = enterPage.prev();

						currentTab.show();
						enterPage.remove();

						return false;
					}
				}
				else {

					// Adding a new page

					data = {
						mainPath: themeDisplay.getPathMain(),
						doAsUserId: themeDisplay.getDoAsUserIdEncoded(),
						cmd: 'add',
						groupId: themeDisplay.getScopeGroupId(),
						privateLayout: themeDisplay.isPrivateLayout(),
						parentLayoutId: themeDisplay.getParentLayoutId(),
						name: name
					};

					onSuccess = function(data) {
						var newTab = jQuery('<a href="' + data.url + '"><span>' + Liferay.Util.escapeHTML(name) + '</span></a>');

						if (instance._isUseHandle) {
							enterPage.before('<span class="sort-handle">+</span>');
						}
						else {
							newTab.css('cursor', 'move');
						}						
						newNavItem[0]._LFR_layoutId = data.layoutId;

						enterPage.before(newTab);
						enterPage.remove();

						newNavItem.addClass('sortable-item');

					instance.sortable.sortable('refresh');
						instance._deleteButton(newNavItem);

						Liferay.trigger(
							'navigation',
							{
								item: newNavItem,
								type: 'add'
							}
						)
					}
				}

				jQuery.ajax(
					{
						data: data,
						dataType: 'json',
						success: onSuccess,
						url: instance._updateURL
					}
				);
			}
		},

		_saveSortables: function(obj) {
			var instance = this;

			var tabs = jQuery('li', instance._navBlock);

			var data = {
				doAsUserId: themeDisplay.getDoAsUserIdEncoded(),
				cmd: 'priority',
				groupId: themeDisplay.getScopeGroupId(),
				privateLayout: themeDisplay.isPrivateLayout(),
				layoutId: obj._LFR_layoutId,
				priority: tabs.index(obj)
			};

			jQuery.ajax(
				{
					data: data,
					url: instance._updateURL
				}
			);
		},

		_treeCallback: function(event, data) {
			var instance = this;

			var navigation = instance._navBlock.find('> ul');
			var droppedItem = jQuery(data.droppedItem);
			var dropTarget = jQuery(data.dropTarget);

			if (instance._isSortable) {
				var liItems = navigation.find('> li');

				var tree = droppedItem.parent();
				var droppedName = droppedItem.find('span:first').text();
				var newParent = dropTarget.parents('li:first');

				var liChild = liItems.find('span').not('.delete-tab');

				liChild = liChild.filter(
					function() {
						var currentItem = jQuery(this);

						if (currentItem.text() == droppedName) {
							return true;
						}
						else {
							return false;
						}
					}
				);

				var treeItems = tree.find('> li');

				var newIndex = treeItems.index(droppedItem);

				if (liChild.length > 0) {
					var newSibling = liItems.eq(newIndex);
					var parentLi = liChild.parents('li:first');

					if (!newParent.is('.tree-item')) {
						newSibling.after(parentLi);

						if (parentLi.is(':hidden')) {
							parentLi.show();
						}
					}
					else {

						//TODO: add parsing to move child elements around by their layoutId

						parentLi.hide();
					}
				}
				else if (!newParent.is('.tree-item')) {
					var newTab = liItems.slice(0, 1).clone();

					newTab.removeClass('selected');
					newTab.find('.child-menu').remove();

					var newTabLink = newTab.find('a span');

					newTabLink.text(droppedName);
					newTabLink.css('cursor', 'pointer');

					liItems.parent().append(newTab);
				}
			}
		},

		_enterPage: '',
		_updateURL: ''
	}
);