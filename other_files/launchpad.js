/*==========================================================================+
 /*==========================================================================+
 |  LAUNCHPAD JS - launchpad.js
 |
 |  Version: 1.0
 |  Date Last Updated: 09/02/2015
 |  Last Updated By: Andrew Hyland
 +==========================================================================*/

window.qut = window.qut || {};
try {
    qut.launchpad = (function (module) {

        var clickEvents = "";
        if (navigator.userAgent.match(/iPad/i) != null || navigator.userAgent.match(/iPhone/i) != null)
            clickEvents = "touchend";
        else if (window.MSPointerEvent && !window.PointerEvent) //IE10
            clickEvents = "MSPointerDown " + clickEvents;
        else
            clickEvents = "click";

        // private
        // ----------
        function canonicalizeValues(model) {
            for (key in model) {
                var value = model[key];
                if (typeof value == 'string') {
                    value = value.toLowerCase().trim();
                    if (value == 'true')
                        model[key] = true;
                    else if (value == 'false')
                        model[key] = false;
                }
            }

            return model;
        }

        function genShowLoaderFunc(text) {
            return function () {
                $("#ajax-loader-text").text(text);
                $('#ajax-loader-overlay, #ajax-loader-wrapper').show();
            };
        }

        function hideLoader() {
            $('#ajax-loader-overlay, #ajax-loader-wrapper').hide();
        }

        function configureAddShortcut() {
            var $form = $('#add-launchpad-application-form');

            $("#add-launchpad-application-modal").appendTo('body');

            $(".launchpad-add-application").click(function (e) {
                e.preventDefault();
                module.showAddShortcut();
            });

            $('#add-launchpad-application-modal').off('hidden.bs.modal').on('hidden.bs.modal', function () {

                $form.data('bootstrapValidator').resetForm(true);
                $form.data('bootstrapValidator').destroy();
                $('#add-launchpad-application-item-id').val('');

                var $addShortcut =  $('.pers-shortcut');

                if( $('#add-application-shortcut').hasClass('hidden')) {
                    $('#add-application-shortcut').removeClass('hidden');
                }

                if($addShortcut.hasClass('col-md-12')) {
                    $addShortcut.removeClass('col-md-12');
                    $addShortcut.addClass('col-md-6');
                    $addShortcut.css('border-right','1px solid #065C95');
                }

                $('#add-launchpad-application-modal-label').text('Add a shortcut');
                $('#manage-launchpad-shortcut-save').html("Add shortcut");

                $('#add-shortcut-addn-info').show();
                $('#add-application-shortcut').show();

            });

            $("#manage-launchpad-shortcut-save").click(function (e) {
                var bootstrapValidator = $form.data('bootstrapValidator');
                bootstrapValidator.validate();
                $form.submit();
            });

            var working = false;

            $form.unbind('submit').bind('submit',function (e) {
                e.preventDefault();
                if (working)
                    return false;

                working = true;
                var bootstrapValidator = $form.data('bootstrapValidator');
                if (!bootstrapValidator.isValid()) {
                    working = false;
                    return false;
                }

                var $modal = $("#add-launchpad-application-modal");
                var errorMessage = "Link was not added to Launchpad.";
                // save
                $.ajax({
                    url: $form.attr("action"),
                    type: "POST",
                    data: $form.serialize(),
                    beforeSend: genShowLoaderFunc("Saving...")
                }).done(function (jsonData) {
                    try {

                        var link = jsonData.data.link;
                        var model = { type: 'link', id: jsonData.data.id, linkId: link.id, title: link.title, url: link.url };
                        module.notificationService.notify('add', model);
                        toastr.success("Link added to Launchpad.");
                        if(jsonData.action=='update') {
                            module.notificationService.notify('remove',{id: jsonData.oldId});
                            saveUpdateChanges(function (result) {
                                if (result == 'success') {
                                    module.storeLaunchpadList($('#manage-launchpad-list'));
                                    $("#manage-launchpad-modal").data('itemCount', $("#manage-launchpad-list li").length);
                                }
                            });
                        }
                        module.bindLaunchpadItemListeners($("#manage-launchpad-list"));
                    } catch (e) {
                        module.showError(errorMessage, e);
                    }
                }).fail(function (data) {
                    module.showError(errorMessage, null, data.status);
                }).always(function (data) {
                    working = false;
                    hideLoader();
                    $modal.modal('hide');
                });

                return false;
            });
        }

        function saveUpdateChanges(onFinish) {
            var $launchpadList = $('#manage-launchpad-list');
            var handlerId = module.notificationService.nextId();

            // update input name indexes
            $launchpadList.find('.launchPad-app').not('.manage-action').each(function (index, value) {
                $(this).find('input').each(function () {
                    var $inputField = $(this)
                    var name = $inputField.attr('name');
                    $inputField.attr('name', name.replace(/\[.*\]/g, "[" + index + "]"));
                });
            });

            // save
            var $form = $('#manage-launchpad-form');
            var errorMessage = "Launchpad update failed";

            $.ajax({
                url: $form.attr("action"),
                type: "POST",
                data: $form.serialize(),
                beforeSend: genShowLoaderFunc("Saving...")
            }).done(function (jsonData) {
                try {
                    module.userSettings.openInCurrentWindow = $form.find("input[name='openAction']:checked").val() == "cur" ? true : false;
                    module.notificationService.notify('clear', {}, handlerId);
                    for (var i = 0; i < jsonData.data.length; i++) {
                        var item = jsonData.data[i];
                        if (item.link != null)
                            module.notificationService.notify('add',
                                {
                                    type: 'link',
                                    append: true,
                                    id: item.id,
                                    linkId: item.link.id,
                                    title: item.link.title,
                                    url: item.link.url
                                }
                                , handlerId);
                        else if (item.unit != null)
                            module.notificationService.notify('add',
                                {
                                    type: 'unit',
                                    append: true,
                                    id: item.id,
                                    unitCode: item.unit.unitCode,
                                    timePeriodId: item.unit.timePeriod.timePeriodId,
                                    title: item.unit.title,
                                    url: item.unit.blackboardUnitUrl,
                                    longUnitCode: item.unit.unitCode.length > 6
                                }
                                , handlerId);
                        else
                            module.notificationService.notify('add',
                                {
                                    type: 'application',
                                    append: true,
                                    id: item.id,
                                    applicationId: item.application.id,
                                    title: item.application.launchpadTitle,
                                    abbrName: item.application.abbreviatedName,
                                    imageDescriptor: item.application.imageDescriptor,
                                    audience: item.application.audience,
                                    url: item.application.url
                                }
                                , handlerId);
                    }
                    toastr.success('Launchpad updated.');
                    onFinish('success');
                } catch (e) {
                    module.showError(errorMessage, e);
                    onFinish('fail', jsonData);
                }
            }).fail(function (data) {
                module.showError(errorMessage, null, data.status);
                onFinish('fail', data);
            }).always(function (data) {
                hideLoader();
            });
        };

        function configureManageLaunchpad() {
            var handlerId = module.notificationService.nextId();
            // manage launchpad modal

            // move the modal container to end of body tag. Bootstrap modals don't like being in html elements that have position:fixed/relative
            $("#manage-launchpad-modal").appendTo('body');

            var $list = $("#manage-launchpad-list");

            function bindLaunchpadItemListeners() {
                module.bindLaunchpadItemListeners($("#manage-launchpad-list"));
            }

            function unbindLaunchpadItemListeners() {
                module.unbindLaunchpadItemListeners($('#manage-launchpad-list'));
            }

            function storeLaunchpadList() {
                module.storeLaunchpadList($list);
            }

            function rollbackLaunchpadList() {
                module.rollbackLaunchpadList($list);
            }


            var $instances = $('body').find("div[id^=p_p_id_Launchpad_WAR_applicationdirectory_INSTANCE_]");
            for (i = 0; i < $instances.length; i++) {
                var instance = $instances[i].id.substring(42);
                instance = instance.substring(0, instance.length - 1);
                $("#manage-launchpad-form").append("<input type='hidden' name='launchpadInstances' value='" + instance + "' />");
            }

            // entry point to form
            $(".manage-launchPad").on(clickEvents, function () {
                var $modal = $("#manage-launchpad-modal");


                $modal.modal('show');
                $modal.data('closeAction', '');
                storeLaunchpadList();
                bindLaunchpadItemListeners();

                $modal.on('hidden.bs.modal', function () {
                    $modal.off('hidden.bs.modal');
                    unbindLaunchpadItemListeners();
                    if ($modal.data('closeAction') != 'save')
                        rollbackLaunchpadList();
                });
            });

            // make launchpad items sortable
            $("#manage-launchpad-list").sortable({
                items: 'li:not(.manage-action)',
                revert: true
            });

            module.notificationService.on(handlerId, function (event, model) {
                var $list = $("#manage-launchpad-list");
                if (event == 'add') {
                    model.closeable = true;
                    if(model.type=='link' || model.type=='application') {
                        model.shareable = true;
                    }
                    if(model.type=='link') {
                        model.editable = true;
                    }
                    module.addLaunchpadItem($list, model);
                }
                else if (event == 'remove')
                    module.removeLaunchpadItem($list, model.id);
                else if ( event == 'clear')
                    $list.find('.launchPad-app').not('.manage-action').remove();

            });

            // manage launchpad buttons
            // -----
            $("#manage-launchpad-reset-default").click(function (e) {
                var $launchpadList = $('#manage-launchpad-list');
                unbindLaunchpadItemListeners();
                // remove applications
                $launchpadList.find('.launchPad-app').not('.manage-action').remove();
                // add default applications
                $launchpadList.append($("#launchpad-defaults").html());
                bindLaunchpadItemListeners();
            });

            function saveChanges(onFinish) {
                var $launchpadList = $('#manage-launchpad-list');

                // update input name indexes
                $launchpadList.find('.launchPad-app').not('.manage-action').each(function (index, value) {
                    $(this).find('input').each(function () {
                        var $inputField = $(this)
                        var name = $inputField.attr('name');
                        $inputField.attr('name', name.replace(/\[.*\]/g, "[" + index + "]"));
                    });
                });

                // save
                var $form = $('#manage-launchpad-form');
                var errorMessage = "Launchpad update failed";

                $.ajax({
                    url: $form.attr("action"),
                    type: "POST",
                    data: $form.serialize(),
                    beforeSend: genShowLoaderFunc("Saving...")
                }).done(function (jsonData) {
                    try {
                        module.userSettings.openInCurrentWindow = $form.find("input[name='openAction']:checked").val() == "cur" ? true : false;
                        module.notificationService.notify('clear', {}, handlerId);
                        for (var i = 0; i < jsonData.data.length; i++) {
                            var item = jsonData.data[i];
                            if (item.link != null)
                                module.notificationService.notify('add',
                                    {
                                        type: 'link',
                                        append: true,
                                        id: item.id,
                                        linkId: item.link.id,
                                        title: item.link.title,
                                        url: item.link.url
                                    }
                                    , handlerId);
                            else if (item.unit != null)
                                module.notificationService.notify('add',
                                    {
                                        type: 'unit',
                                        append: true,
                                        id: item.id,
                                        unitCode: item.unit.unitCode,
                                        timePeriodId: item.unit.timePeriod.timePeriodId,
                                        title: item.unit.title,
                                        url: item.unit.blackboardUnitUrl,
                                        longUnitCode: item.unit.unitCode.length > 6
                                    }
                                    , handlerId);
                            else
                                module.notificationService.notify('add',
                                    {
                                        type: 'application',
                                        append: true,
                                        id: item.id,
                                        applicationId: item.application.id,
                                        title: item.application.launchpadTitle,
                                        abbrName: item.application.abbreviatedName,
                                        imageDescriptor: item.application.imageDescriptor,
                                        audience: item.application.audience,
                                        url: item.application.url
                                    }
                                    , handlerId);
                        }
                        toastr.success('Launchpad updated.');
                        onFinish('success');
                    } catch (e) {
                        module.showError(errorMessage, e);
                        onFinish('fail', data);
                    }
                }).fail(function (data) {
                    module.showError(errorMessage, null, data.status);
                    onFinish('fail', data);
                }).always(function (data) {
                    hideLoader();
                });
            };

            // "Save changes"
            $("#manage-launchpad-save").click(function (e) {
                e.preventDefault();
                saveChanges(function (result) {
                    if (result == 'success') {
                        $("#manage-launchpad-modal").data('closeAction', 'save');
                        $("#manage-launchpad-modal").modal('hide');
                    }
                });
            });

            // "Add a shortcut"
            $('#manage-launchpad-add-application').click(function (e) {
                e.preventDefault();
                // save changes before showing "add shortcut" modal
                saveChanges(function (result) {
                    if (result == 'success') {
                        storeLaunchpadList();
                        $("#manage-launchpad-modal").data('itemCount', $("#manage-launchpad-list li").length);
                        module.showAddShortcut();
                    }
                });
            });

            $('#add-launchpad-application-modal').on('hidden.bs.modal', function () {
                var $list = $("#manage-launchpad-list");
                if ($list.find('li').length != $("#manage-launchpad-modal").data('itemCount')) {
                    // new launchpad link has been saved, update launchpad list state, and rebind listeners
                    unbindLaunchpadItemListeners();
                    storeLaunchpadList();
                    bindLaunchpadItemListeners();
                }

            });
        }

        function configureDropdownBehaviour() {
            var resizeTimer;

            // Decide whether the show more links needs to be shown or not
            var showAllButton = function () {
                //Check to see how many application icons need to be shown and if greater than two rows, hide the extra icons and show the showAll link, otherwise hide the showAll link
                if ($('#launchpad-links .launchPad-apps-wrapper .row').height() > 235) {
                    if ($('#launchpad-links .launchPad-apps-wrapper.open').is(':visible')) {
                        $('#launchpad-links .launchPad-hideAll').show();
                    } else {
                        $('#launchpad-links .launchPad-showAll').show();
                    }
                } else {
                    $('#launchpad-links .launchPad-showAll').hide();

                    if ($('#launchpad-links .launchPad-hideAll').is(':visible')) {
                        $('#launchpad-links .launchPad-hideAll').hide();
                    }
                }
            };

            //If the user clicks anywhere on the page, ensure the launchpad menu is closed
            $("body").click(function () {
                $("#launchpad-links").removeClass("launchpad-open");
                $("#launchpad-toggle, #mlaunchpad-toggle").removeClass("launchpad-highlight");
            });

            //If the user clicks anywhere inside the launchpad menu, keep the menu open
            $("#launchpad-links").click(function (e) {
                $("#launchpad-links").addClass("launchpad-open");
                $("#launchpad-toggle, #mlaunchpad-toggle").addClass("launchpad-highlight");

                e.stopPropagation();
            });

            //If the user clicks the launchpad buttons or the close button, toggle the view launchpad open and closed
            var toggleClickEvent = "";
            if (navigator.userAgent.match(/iPad/i) != null || navigator.userAgent.match(/iPhone/i) != null)
                toggleClickEvent = "touchend";
            else
                toggleClickEvent = "click";

            $("#launchpad-toggle, #mlaunchpad-toggle, #launchPad-dropdown .close").on(toggleClickEvent, function (e) {
                $(".close-right-menu").trigger('click');

                $("#launchpad-links").toggleClass("launchpad-open");
                $("#launchpad-toggle, #mlaunchpad-toggle").toggleClass("launchpad-highlight");
                showAllButton();

                $(".msearch-highlight").removeClass("msearch-highlight");
                $(".close-menu-highlight").removeClass("close-menu-highlight");

                //Hide community dropdown menu (in student view) if open
                $("#community-dropdown").removeClass("community-open");
                $(".community-toggle, #mcommunity-toggle").removeClass("community-highlight");

                e.preventDefault();
                e.stopPropagation();
            });

            //When 'Show more shortcuts' link clicked, show all application icons
            $("#launchpad-links #launchPad-dropdown p a").on("click", function (e) {
                //If the launchPad-showAll link is being shown
                if ($(this).parent().hasClass("launchPad-showAll")) {
                    $("#launchpad-links .launchPad-apps-wrapper").removeClass("closed").addClass("open");
                    $(this).html("<span class='glyphicon glyphicon-chevron-up'></span> Show fewer shortcuts");
                    $(this).parent().removeClass("launchPad-showAll").addClass("launchPad-hideAll");
                } else { //else if the launchPad-hideAll link is being shown
                    $("#launchpad-links .launchPad-apps-wrapper").removeClass("open").addClass("closed");
                    $(this).html("<span class='glyphicon glyphicon-chevron-down'></span> Show more shortcuts");
                    $(this).parent().removeClass("launchPad-hideAll").addClass("launchPad-showAll");
                }

                e.preventDefault();
                e.stopPropagation();
            });

            //When browser window is resized, check to see if all application icons are being showing
            $(window).resize(function () {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(showAllButton(), 100);
            });
        }

        // public
        // ----------

        module.showError = function (errorMessage, exception, ajaxStatus) {
            if (ajaxStatus != undefined && ajaxStatus == 0)
                errorMessage += " Please ensure you are logged in.";
            toastr.error(errorMessage);
            if (exception != undefined)
                console.log(exception)
        }

        module.removeLaunchpadItem = function ($list, id, byFieldName) {
            if (!byFieldName)
                $list.find("li input.id[value=" + id + "]").parents('li').remove();
            else
                $list.find("li input[name$='" + byFieldName + "'][value=" + id + "]").parents('li').remove();
        };

        module.clearLaunchpad = function ($list) {
            $list.find('li').not($list.find('.action').parents('li')).remove();
        };

        module.addLaunchpadItem = function ($list, _model) {
            var model = $.extend({}, _model);
            model = canonicalizeValues(model);
            model.openInCurrentWindow = module.userSettings.openInCurrentWindow;
            var html = '';
            var template;
            if (model.type == 'link') {
                template = $("#launchpad-link-template").html();
                model.imageDescriptor = 'f0f6';
            } else if (model.type == 'unit') {
                template = $("#launchpad-unit-template").html();
            } else {
                template = $("#launchpad-application-template").html();
            }

            if (template != null) {
                Mustache.parse(template);

                if (model.audience != undefined) {
                    if (model.audience == 'LOCAL')
                        model.audience = 'local-app';
                    else if (model.audience == 'STUDENT_CORPORATE')
                        model.audience = 'stu-app';
                    else if (model.audience == 'STAFF_CORPORATE')
                        model.audience = 'staff-app';
                    else
                        model.audience = 'corp-app';
                }
                html = Mustache.render(template, model);
            }
            if (model.append)
                $list.append(html);
            else {
                var $manageActions = $list.find(".manage-action");
                if ($manageActions.length > 0)
                    $manageActions.last().after(html);
                else
                    $list.prepend(html);
            }
        };

        module.bindLaunchpadItemListeners = function ($launchpadList, onCloseCallback) {
            var $closeableItems = $launchpadList.find(".stack-trash");
            var $shareableItems = $launchpadList.find(".stack-share");
            var $editableItems = $launchpadList.find(".stack-edit");

            $closeableItems.click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).parents('.launchPad-app').remove();
                if (onCloseCallback)
                    onCloseCallback();
            });

            $shareableItems.click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                var applicationDirectoryUrlEncoded = $('#manage-launchpad-form').attr('data-href');
                var launchpadApp = $(this).parents('.launchPad-app');
                var title = encodeURIComponent( launchpadApp.find('.launchPad-title').text() );
                var titleEncoded = encodeURIComponent(encodeURIComponent( launchpadApp.find('.launchPad-title').text() ));
                var url = encodeURIComponent(encodeURIComponent ( launchpadApp.find('a').attr('href')));
                if (launchpadApp.find(".applicationId").length>0) {
                    var id = launchpadApp.find('.applicationId').val();
                    window.location.href ="mailto:?subject=Add this application to your Launchpad&body=Hi,%0A%0ATo add %22"+title+"%22 to your Launchpad, please click on this link:%0A"+applicationDirectoryUrlEncoded+"%3Faction%3Dadd%26id%3D"+id;
                } else if (launchpadApp.find('.linkId').length>0) {
                    window.location.href ="mailto:?subject=Add this shortcut to your Launchpad&body=Hi,%0A%0ATo add the link %22"+title+"%22 to your Launchpad, please click on this link:%0A"+applicationDirectoryUrlEncoded+"%3Faction%3DaddLink%26title%3D"+titleEncoded+"%26url%3D"+url;
                } else if(launchpadApp.find('.unitId').length>0) {
                    window.location.href ="mailto:?subject=Add this shortcut to your Launchpad&body=Hi,%0A%0ATo add the blackboard link for unit %22"+title+"%22 to your Launchpad, please click on this link:%0A"+applicationDirectoryUrlEncoded+"%3Faction%3DaddLink%26title%3D"+titleEncoded+"%26url%3D"+url;
                }
            });

            $editableItems.click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                var launchpadApp = $(this).parents('.launchPad-app');
                var id = launchpadApp.find('input.id').val();
                var title = launchpadApp.find('.launchPad-title').text() ;
                var url = launchpadApp.find('a').attr('href');


                module.showAddShortcut();
                $('#add-launchpad-application-item-id').val(id);
                $('#add-launchpad-application-custom-title').val(title);
                $('#add-launchpad-application-custom-url').val(url);
                $('#add-launchpad-application-modal-label').text('Update your shortcut');
                $('#manage-launchpad-shortcut-save').html("Update shortcut");
                $('#add-application-shortcut').hide();
                $('div.pers-shortcut').removeClass('col-md-6').addClass('col-md-12');
                $('#add-shortcut-addn-info').hide();
                $('div.pers-shortcut').css('border-right','none');

            });


            $launchpadList.find("li a").click(function (e) {
                e.preventDefault();
            });
        };

        module.unbindLaunchpadItemListeners = function ($launchpadList) {
            $launchpadList.find(' .close-tag').off();
            $launchpadList.find("li a").off();
        };

        module.storeLaunchpadList = function ($list) {
            // copy launchpad item list, does not clone listeners
            $list.data('restorePoint', $list.find('.launchPad-app').not('.manage-action').clone(false));
        }
        module.rollbackLaunchpadList = function ($list) {
            $list.find('.launchPad-app').not('.manage-action').remove();
            $list.append($list.data('restorePoint'));
        }

        // singleton service for communicating changes that affect launchpad display
        module.notificationService = (function () {
            // private
            var listeners = {};
            var id = 0;
            //public
            return {
                on: function (id, callback) {
                    listeners[id] = callback;
                },
                off: function (id) {
                    delete listeners[id];
                },
                notify: function (event, model, calleeHandlerId) {
                    for (var handlerId in listeners) {
                        if (calleeHandlerId == null || (handlerId != calleeHandlerId)) {
                            try {
                                listeners[handlerId].call(null, event, model);
                            } catch (e) {
                                console.log(e);
                            }
                        }
                    }
                },
                nextId: function () {
                    return ++id;
                }

            };
        })();

        module.configureToggleApplicationLinks = function ($applicationLinks) {
            var handlerId = qut.launchpad.notificationService.nextId();
            qut.launchpad.notificationService.on(handlerId, function (event, model) {
                if (event == 'clear') {
                    $applicationLinks.removeClass("selected");
                    $applicationLinks.attr('data-original-title', 'Add to Launchpad');
                    $applicationLinks.find('span').attr('class', 'glyphicon glyphicon-plus');
                }
                else if (event == 'add' && model != null && model.applicationId != null) {
                    var $applicationLink = $applicationLinks.filter('[data-applicationid=' + model.applicationId + ']');
                    $applicationLink.addClass("selected");
                    $applicationLink.attr('data-original-title', 'Remove from Launchpad');
                    $applicationLink.find('span').attr('class', 'glyphicon glyphicon-minus');
                }
            });

            $applicationLinks.off();
            $applicationLinks.on(clickEvents, function (e) {
                e.preventDefault();

                var $anchor = $(this);
                var isAddingToLaunchpad = !$anchor.hasClass("selected");
                var errorMessage = "Application was not " + (isAddingToLaunchpad ? "added to Launchpad." : "removed from Launchpad.");
                $.ajax({
                    url: $(this).attr("href"),
                    type: "POST",
                    beforeSend: genShowLoaderFunc("Saving...")
                }).done(function (jsonData) {
                    try {
                        if (isAddingToLaunchpad) {
                            var application = jsonData.data.application;
                            qut.launchpad.notificationService.notify('add', {
                                    id: jsonData.data.id,
                                    applicationId: application.id,
                                    title: application.launchpadTitle,
                                    abbrName: application.abbreviatedName,
                                    imageDescriptor: application.imageDescriptor,
                                    audience: application.audience,
                                    url: application.url
                                }
                                , handlerId
                            );
                            $anchor.find('span').attr('class', 'glyphicon glyphicon-minus');
                            toastr.success("Application added to Launchpad.");
                        }
                        else {
                            qut.launchpad.notificationService.notify('remove', {id: jsonData.data.id}, handlerId);
                            $anchor.find('span').attr('class', 'glyphicon glyphicon-plus');
                            toastr.success("Application removed from Launchpad.");
                        }
                        // update anchor details
                        $anchor.toggleClass("selected");
                        $anchor.attr('data-original-title', ($anchor.hasClass('selected') ? 'Remove from' : 'Add to' ) + ' Launchpad');
                    } catch (e) {
                        module.showError(errorMessage, e);
                    }
                }).fail(function (data) {
                    module.showError(errorMessage, null, data.status);
                }).always(function (data) {
                    hideLoader();
                });
            });

            return handlerId;
        };

        module.showAddShortcut = function() {
            var addApplicationValidationSettings = {
                message: 'This value is not valid',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                }
            };
            $("#add-launchpad-application-form").bootstrapValidator(addApplicationValidationSettings);
            $("#add-launchpad-application-modal").modal('show');
        };

        module.configurePage = function () {

            module.userSettings = JSON.parse($("#launchpad-user-settings").html());

            // reposition ajax loader to end of body tag to avoid unintentionally inheriting styles
            $('#ajax-loader-overlay, #ajax-loader-wrapper').appendTo('body');

            configureDropdownBehaviour();
            configureManageLaunchpad();
            configureAddShortcut();

            // for each launchpad on the page listen for notifications
            $(".launchPad-dropdown-list").each(function () {
                var handlerId = module.notificationService.nextId();
                var $list = $(this);
                module.notificationService.on(handlerId, function (event, model) {
                    if (event == 'add') {
                        model.closeable = false;
                        model.shareable = false;
                        model.editable = false;
                        module.addLaunchpadItem($list, model);
                    }
                    else if (event == 'remove')
                        module.removeLaunchpadItem($list, model.id);
                    else if (event == 'clear') {
                        module.clearLaunchpad($list);
                    }

                    $list.trigger('launchpad-update');
                });
            });
        };

        module.reloadChanges = function() {
            var errorMessage= "Error loading the launchpad";

            $('#launchpad-toggle span').each(function() {
                if($(this).is('.fa-th')) {
                    $(this).removeClass('fa fa-th');
                    $(this).addClass('fa fa-refresh fa-spin');
                }
            });

            $('.manage-launchPad span').each(function() {
                if($(this).is('.glyphicon, .glyphicon-cog')) {
                    $(this).removeClass('glyphicon glyphicon-cog');
                    $(this).addClass('fa fa-refresh fa-spin');
                }
            });

            $(".launchPad-dropdown-list li a").addClass('disabled');
            $('#launchpad-toggle').addClass('disabled');
            $('.manage-launchPad').addClass('disabled');

            $(".launchPad-dropdown-list li a, #launchpad-toggle, .manage-launchPad").on("click", function(event){
                if ($(this).hasClass("disabled")) {
                    event.preventDefault();
                }
            });

            $("#launchpad-links").removeClass("launchpad-open");
            $("#launchpad-toggle, #mlaunchpad-toggle").removeClass("launchpad-highlight");

            $.ajax({
                url: $('#no-show').attr("action"),
                type: "GET"
            }).done(function (jsonData) {
                try {
                    qut.launchpad.notificationService.notify('clear');
                    for (var i = 0; i < jsonData.data.length; i++) {
                        var item = jsonData.data[i];
                        if (item.link != null)
                            qut.launchpad.notificationService.notify('add',
                                {
                                    type: 'link',
                                    append: true,
                                    id: item.id,
                                    linkId: item.link.id,
                                    title: item.link.title,
                                    url: item.link.url
                                }
                            );
                        else if (item.unit != null)
                            qut.launchpad.notificationService.notify('add',
                                {
                                    type: 'unit',
                                    append: true,
                                    id: item.id,
                                    unitCode: item.unit.unitCode,
                                    timePeriodId: item.unit.timePeriod.timePeriodId,
                                    title: item.unit.title,
                                    url: item.unit.blackboardUnitUrl,
                                    longUnitCode: item.unit.unitCode.length > 6
                                }
                            );
                        else
                            qut.launchpad.notificationService.notify('add',
                                {
                                    append: true,
                                    id: item.id,
                                    applicationId: item.application.id,
                                    title: item.application.launchpadTitle,
                                    abbrName: item.application.abbreviatedName,
                                    imageDescriptor: item.application.imageDescriptor,
                                    audience: item.application.audience,
                                    url: item.application.url
                                }
                            );
                    }
                } catch(e) {
                    module.showError(errorMessage, e);
                }
            }).fail(function (data) {
                module.showError(errorMessage, null, data.status);
            }).always(function (data) {

                $(".launchPad-dropdown-list li a").removeClass('disabled');
                $('#launchpad-toggle').removeClass('disabled');
                $('.manage-launchPad').removeClass('disabled');

                $('#launchpad-toggle span').each(function() {
                    if($(this).hasClass('fa-refresh')) {
                        $(this).removeClass('fa fa-refresh fa-spin');
                        $(this).addClass('fa fa-th');
                    }
                });

                $('.manage-launchPad span').each(function() {
                    if($(this).hasClass('fa-refresh')) {
                        $(this).removeClass('fa fa-refresh fa-spin');
                        $(this).addClass('glyphicon glyphicon-cog');
                    }
                });
            });
        };

        return module;
    }(qut.launchpad || {}));

    $(function() {
        qut.launchpad.configurePage();
        var $reloadValue = $('#reloadValue');
        if ( $reloadValue.length > 0 ) {
            var d = new Date();
            d = d.getTime();
            if ($reloadValue.val().length == 0) {
                $('#reloadValue').val(d);
            }
            else {
                qut.launchpad.reloadChanges();
            }
        }
    });
} catch (e) {
    console.log("Launchpad uncaught exception (this will cause launchpad to fail): " + e, e);
    if (e.stack)
        console.log(e.stack);
}
