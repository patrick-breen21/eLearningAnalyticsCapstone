Liferay.UndoManager = Liferay.Observable.extend(
	{

		/**
		 * OPTIONS
		 *
		 * Required
		 * container {string|object}: A jQuery selector that contains the rows you wish to duplicate.
		 *
		 * Optional
		 * location {string}: The location in the container (top or bottom) where the manager will be added
		 *
		 */

		initialize: function(options) {
			var instance = this;

			var defaults = {
				container: null,
				location: 'top'
			};

			options = jQuery.extend(defaults, options);

			if (options.container) {
				var undoText = Liferay.Language.get('undo-x', ['[$SPAN$]']);
				undoText = undoText.replace(/\[\$SPAN\$\]/, '<span class="items-left">(0)</span>');

				instance._container = jQuery(options.container);
				instance._manager = jQuery('<div class="portlet-msg-info undo-queue queue-empty"><a class="undo-action" href="javascript: ;">' + undoText + '</a><a class="clear-undos" href="javascript: ;">' + Liferay.Language.get('clear-history') + '</a></div>');

				instance._undoItemsLeft = instance._manager.find('.items-left');
				instance._undoButton = instance._manager.find('.undo-action');
				instance._clearUndos = instance._manager.find('.clear-undos');

				instance.bind('update', instance._updateList);

				instance._clearUndos.click(
					function(event) {
						instance._undoCache = [];

						instance.trigger('update');
						instance.trigger('clearList');
					}
				);

				instance._undoButton.click(
					function(event) {
						instance.undo(1);
					}
				);

				var attachMethod = 'prepend';

				if (options.location != 'top') {
					attachMethod = 'append';
				}

				instance._container[attachMethod](instance._manager);

				instance.set('container', instance._container);

				jQuery(window).unload(
					function(event) {
						instance._undoCache = [];
					}
				);
			}
		},

		add: function(handler, stateData) {
			var instance = this;

			if (handler && typeof handler == 'function') {
				var undo = {
					handler: handler,
					stateData: stateData
				};

				instance._undoCache.push(undo);

				instance.trigger('update');
				instance.trigger('add');
			}
		},

		undo: function(limit) {
			var instance = this;

			limit = limit || 1;

			var i = instance._undoCache.length - 1;

			while (limit > 0 && i >= 0) {
				var undoAction = instance._undoCache.pop();

				undoAction.handler.call(instance, undoAction.stateData);

				limit--;
				i--;
			}

			instance.trigger('update');
			instance.trigger('undo');
		},

		_updateList: function() {
			var instance = this;

			var itemsLeft = instance._undoCache.length;
			var manager = instance._manager;

			if (itemsLeft == 1) {
				manager.addClass('queue-single');
			}
			else {
				manager.removeClass('queue-single');
			}

			if (itemsLeft > 0) {
				manager.removeClass('queue-empty');
			}
			else {
				manager.addClass('queue-empty');
			}

			instance._undoItemsLeft.text('(' + itemsLeft + ')');
		},

		_undoCache: []
	}
);