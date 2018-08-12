/*==========================================================================+
|  SOLR QUEST JS - solrquest.js
|  All JavaScript relating to the new search porlet within QV and Digital Workplace
|
|  Version: 0.4
|  Date Last Updated: 22/03/2016
|  Last Updated By: Andy McBride
+==========================================================================*/

$(document).ready(function () {

    /* ==================================================================================================
     |
     |            INIT
     |
       ================================================================================================== */

    // If this has been loaded before, quit
    if (typeof window.SQ == 'undefined') {
        window.SQ = {};
        window.SQ.loaded = false;
    }

    // If this has been loaded before, quit
    if ( window.SQ.loaded ) {
        console.log('SolrQuest JS Already loaded... exiting');
        return;
    }

    // Set so that SQ never loads again
    window.SQ.loaded = true;
    var searchQuery = $( '#solrquest #searchQuery' ).val();
    var profile = $( '.search-profile:enabled' ).val();

    var $globalForm = $('form#global-search-form');
    var $portletForm  = $( 'form#solrquest' );

    var $defaultForm =  $portletForm.length == 1 ? $portletForm : $globalForm;
    var $defaultInput = $defaultForm.find('input.search-input');

    var $inputs = $('input.search-input');

    // default no auth
    window.SQ.isAuthenticated = false;

    // auth check
    if ( Liferay.ThemeDisplay.isSignedIn() ){
        window.SQ.isAuthenticated = true;
    }

    // Recent searches functionality
    window.SQ.recentSearches = false;
    getPref('recentSearches', function(data) { window.SQ.recentSearches = data.value })

    // kill tt after 10 minutes to stop weirdness
    // var stopTt = setTimeout( function() { $inputs.typeahead('destroy'); }, 1000 * 60 * 10 );



	// toastr feedback for feedback success message
    if (typeof toastr != 'undefined') {
        toastr.options = {
            closeButton: true,
            positionClass: "toast-bottom-center",
            toastClass: '',
            timeOut: "2000",
            iconClasses: {
                error: 'portlet-msg-error',
                info: 'portlet-msg-info',
                success: 'portlet-msg-success',
                warning: 'portlet-msg-alert'
            }
        }
    };

    /* ==================================================================================================
     |
     |            INIT TOUR
     |
     ================================================================================================== */

    var staffTour = [
        {
            title: "Search has been updated!",
            content: "<p>Take a quick tour now to get to know all the new features.</p>",
            orphan: true
        },
        {
            element: "#SolrQuestSearchForm",
            title: "Search over 200 QUT sites here",
            content: "<p>Enter your search term(s) here. You'll see some suggestions as you type.</p> <p>You can search for information, people, units, classes and applications. Results now appear from QUT sites outside the Digital Workplace.</p>",
            placement: "top"
        },
        {
            element: "#solrquest-navtabs li:first-child",
            title: "Switch tabs to see different kinds of results",
            content: "<p>Depending on your search, select a tab to see results for web, staff, students, units, classes and applications.</p>",
            placement: "top"
        },
        {
            element: ".filter-toggle",
            title: "Seeing too many results?",
            content: "<p>Narrow down your search by using the refine menu. You’ll see different options depending on which tab you’re in.</p>",
            placement: "right"
        },
        {
            element: ".preferences-select-wrapper",
            title: "Make search work better for you",
            content: "<p>Customise the way search appears for you by setting your own search preferences.</p> <p>Change the order of your results tabs, the number of results shown on each page, and set other preferences.</p>",
            placement: "left"
        },
        {
            element: ".content-result-item:first-child .action-menu-block",
            title: "Help me find this page later",
            content: "<p>Use this option to include a page in your LaunchPad or share it by email.</p>",
            placement: "left"
        },
        {
            element: ".search-feedback",
            title: "Send us your feedback",
            content: "<p>If you have trouble finding what you’re looking for, we would love your feedback to continue improving search.</p>",
            placement: "top"
        },
        {
            title: "Thanks for taking the tour!",
            content: "<p>We hope you enjoy the new and improved search.</p> <p>For more information, check out our <a href='https://qutvirtual4.qut.edu.au/group/intranet-project-information/resources-and-training/search-guide'>quick reference guide</a>.</p>",
            orphan: true
        }
    ];
    var studentTour = [
        {
            title: "Search has been updated!",
            content: "<p>Take a quick tour now to get to know all the new features.</p>",
            orphan: true
        },
        {
            element: "#SolrQuestSearchForm",
            title: "Search QUT sites here",
            content: "<p>Enter your search term(s) here. You'll see some suggestions as you type.</p> <p>You can search for information, staff, unit details, and QUT apps. Results now appear from the QUT Students site and other QUT sites.</p>",
            placement: "top"
        },
        {
            element: "#solrquest-navtabs li:first-child",
            title: "Switch tabs to see different kinds of results",
            content: "<p>Depending on your search, select a tab to see results for web pages, staff, units, and applications.</p> <p>Specific tabs will only appear if there are results matching your search.</p>",
            placement: "top"
        },
        {
            element: ".filter-toggle",
            title: "Seeing too many results?",
            content: "<p>Narrow down your search by using the refine menu. You’ll see different options depending on which tab you’re in.</p>",
            placement: "right"
        },
        {
            element: ".preferences-select-wrapper",
            title: "Make search work better for you",
            content: "<p>Customise the way search appears for you by setting your own search preferences.</p> <p>Change the number of results shown on each page, the order of your results tabs and set other preferences.</p>",
            placement: "left"
        },
        {
            element: ".content-result-item:first-child .action-menu-block",
            title: "Help me find this page later",
            content: "<p>Use this option to include a page in your LaunchPad or share it by email.</p>",
            placement: "left"
        },
        {
            element: ".search-feedback",
            title: "Send us your feedback",
            content: "<p>If you have trouble finding what you’re looking for, we’d love your feedback to continue improving search.</p>",
            placement: "top"
        },
        {
            title: "Thanks for taking the tour!",
            content: "<p>We hope you enjoy the new and improved search.</p> <p>For more information, check out our <a href='https://www.ithelpdesk.qut.edu.au/pages/guides/displayguide.jsp?ID=79'>HiQ user guides</a>.</p>",
            orphan: true
        }
    ];

    if ( typeof Tour == 'function' ) {

        if ($portletForm.attr('data-student') == 'true') {
            chosenTour = studentTour;
        } else {
            chosenTour = staffTour;
        }

        window.SQ.solrquesttour = new Tour({
            storage: false,
            onEnd: function (tour) {
                setHiddenPref("tour", false)
            },
            steps: chosenTour
        });
    }


    /* ==================================================================================================
     |
     |            CUSTOM FUNCTIONS
     |
       ================================================================================================== */

    /*========================================
     | Functions to get user's geolocation
     =========================================*/

    //function getLocation() {
    //    if (navigator.geolocation) {
    //        navigator.geolocation.getCurrentPosition(showPosition, showError);
    //    }
    //}
    //
    //function showPosition(position) {
    //    var $latlonInput = $('#searchLatLon');
    //
    //    $latlonInput.prop('disabled',false);
    //    $latlonInput.val(position.coords.latitude+","+position.coords.longitude);
    //    $latlonInput.closest( "form").submit();
    //}
    //
    //function showError(error) {
    //    $('#searchLatLon').prop('disabled',true);
    //}

    /*========================================
     | Test if an object is empty
     =========================================*/
    function isEmpty(obj) {
        for(var prop in obj) {
            if(obj.hasOwnProperty(prop))
                return false;
        }

        return true && JSON.stringify(obj) === JSON.stringify({});
    }

    /*========================================
     | Function to get form corresponding to
     | current event
     =========================================*/
    function getForm(event) {

        // get theoretical event
        var e = event || window.event;
        var $form;

        if (    typeof e != 'undefined' &&
                typeof e.target != 'undefined' &&
                $( e.target ).closest( "form").length > 0 ) {
            // console.log("target: " + $( e.target).attr('id'));
            $form = $( e.target ).closest( "form" );
        }

        return $form;
    }


    /*========================================
     | Print func
     =========================================*/
    function printView(event) {
        window.print();
        event.preventDefault();
    }


    /*========================================
     | CHECK SEARCH QUERY
     | On search query input
     | change, remove disabled if query isn't
     | empty
     =========================================*/
    function checkSearchQuery() {

        $inputs.each(function() {

            // identify our elements
            $input = $(this);
            $form = $input.closest('form');

            if (($input.val() == '') || ($input.val() == 'Search content, people, units, classes or applications')) {
                $input.val('');
                $form.find('.typeahead').typeahead('val', '');
                $form.find(".search-submit").attr('disabled', 'disabled');

                $form.find(".searchClear").hide();
                //console.log('was empty');
            } else {
                $form.find(".searchClear").show();
                $form.find(".search-submit").removeAttr('disabled');
                //console.log('not empty');
            }

        })
    }


    /*========================================
     | ease of life to switch off form elements
     =========================================*/
    function facetsOff() {
        $('#solrquest-facets .facetFilter:input').prop("checked", false);
    }


    /*========================================
     | ease of life to switch off form elements
     =========================================*/
    function allOff() {
        facetsOff();
    }


    /*========================================
     | Ajax to run our analytics
     =========================================*/
    function registerLinkClick(queryTerm, rank, linkText, url, documentId, searchActionId) {
        var pageNumber = "0";
        var linkClickUrl = $('#solrquest #linkClickUrl').val();

        if (!url || url == "#") {
            url = "undefined";
        }

        var registerLinkClickUrl = linkClickUrl + "&url=" + url + "&rank=" + rank + "&linkText=" + linkText
            + "&documentId=" + documentId + "&queryTerm=" + queryTerm + "&searchActionId=" + searchActionId + "&pageNumber=" + pageNumber;

        // console.log(registerLinkClickUrl);

        jQuery.ajax({
            type: "POST",
            global: false,
            url: registerLinkClickUrl
        });
    }



    /*========================================
     | Run when typeahead runs
     | - checks to see if we need to get our recent searches
     =========================================*/
    function ttTrigger(event) {
        // get our suggestions
        if (typeof window.suggestions == 'undefined') {
            $.ajax({
                url: sqRecent,
                context: document.body
            }).success( function (data) {

                if (typeof data.suggestions != 'undefined' && data.suggestions.length > 0) {
                    window.suggestions = data.suggestions;
                }

                ttPostProcess(event);

            }).fail( function(data) {
                console.log("Error getting suggestion. likely session issue");
            })
        } else {
            ttPostProcess(event);
        }
    };


    /*========================================
     | Our typeahead post processing
     =========================================*/
    function ttPostProcess(event) {
        // identify our elements
        $form = getForm(event);
        $input = $form.find('input.search-input');

        if ($input.val() == 'Search content, people, units, classes or applications') {
            $input.val('');
        }

        if ( typeof window.suggestions != 'undefined' && $input.val().length < 2 && window.SQ.recentSearches) {
            $form.find('.tt-suggestion').remove();

            $.each( window.suggestions, function( index, value ) {
                if (window.suggestions.length > 0) {
                    $form.find('.typeahead-footer').hide();
                    $form.find('.typeahead-heading').text('Your most recent searches');
                    $form.find('.tt-dataset-Keywords').html($form.find('.tt-dataset-Keywords').html() + '<div class="tt-suggestion tt-selectable top-5">' + value.value + '</div>');
                    $form.find('.tt-menu').show();
                    $form.find('.tt-menu').removeClass('tt-empty');
                }
            })

        } else {
            ttMenuQuery = $input.val();
            $form.find('.typeahead-footer em').text(ttMenuQuery);
            $form.find('.typeahead-footer').show();
            $form.find('.typeahead-heading').text('Search suggestions');
        }

    };



	/*========================================
	 | Add functionality to slider
	 | Allows the jquery-ui slider in the edit mode to work
	 =========================================*/
	$(function() {
		$( "#slider" ).slider({
			value:30,
			min: 10,
			max: 90,
			step: 20,
			slide: function( event, ui ) {
				$( "#row-span-label" ).html( ui.value );
				$( "#rows" ).val( ui.value );
			}
		});
		$( "#row-span-label" ).html( $( "#rows" ).val() );
		$( "#slider" ).slider( "value", $( "#rows" ).val() );
	});


    /*========================================
     | HIDDEN PREF SET
     | ajax run to save a pref
     =========================================*/
    function setHiddenPref(name, value) {
        $.ajax($('#hiddenPrefUrl').val() + "&name=" + name + "&value=" + value);
    }

    /*========================================
     | GET PREF
     | ajax run to get a pref
     =========================================*/
    function getPref(name, callback) {
        $.ajax('/delegate/solrquest/service/pref/user/get/recentSearches')
        .success(callback)
        .error(function(){
            console.log('error');
        })
    }


    /* ==================================================================================================
     |
     |          TWITTER TYPEAHEAD STUFF
	 |           ...is all here
	 |
	   ================================================================================================== */

	// resource URL's
	// solrQuestRecentURL = Liferay.PortletURL.createResourceURL();
	// solrQuestRecentURL.setPortletId('SolrQuest_WAR_solrquest');
	// solrQuestRecentURL.setResourceId('recent');
	// solrQuestRecentURL.setParameter('p_p_mode', 'view');
	// sqRecent = solrQuestRecentURL.toString();
	// solrQuestSuggestURL = solrQuestRecentURL;
	// solrQuestSuggestURL.setResourceId('suggest');
	// sqSuggest = solrQuestSuggestURL.toString();

    sqSuggest = "/delegate/solrquest/service/suggest";
    sqRecent = "/delegate/solrquest/service/recent";

	var keywordEngine = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: sqSuggest + "?q=",
            replace: function(url, uriEncodedQuery) {
                return url + uriEncodedQuery;
            },
            filter: function (suggestions) {
                // $.map converts the JSON array into a JavaScript array
                return suggestions.suggestions
            }
        }
    });


	var documentEngine = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		limit: 10,
		remote: {
			url: sqSuggest + "?q=",
            replace: function(url, uriEncodedQuery) {
                return url + uriEncodedQuery;
            },
			filter: function (suggestions) {
				// $.map converts the JSON array into a JavaScript array
				return suggestions.docs
			}
		}
	});

	keywordEngine.initialize();
	documentEngine.initialize();

	$inputs.typeahead(

		{
			hint: false,
			highlight: true,
			minLength: 2
		},
		{
			name: 'Keywords',
			source: keywordEngine.ttAdapter(),
			display: "value",
			templates: {
				header: '<h4 class="typeahead-subheading">Keywords</h4>'
			}
		},
		{
			name: 'Documents',
			source: documentEngine.ttAdapter(),
			display: "value",
			limit: 10,
			templates: {
				suggestion: Handlebars.compile('<div class="{{type}}-tt"><span class="typeahead-icon fa {{icon}}">&nbsp;</span> {{value}} - <span class="typeahead-extra">{{extra}}</span></div>')
			}
		}

	).on('typeahead:selected', function(e, data) {
        console.log('tt selected');

        // identify our elements
        $form = getForm(e);

		if (typeof data.link != 'undefined') {
			registerLinkClick(data.queryTerm, data.rank, data.value, data.link, data.documentId, data.searchActionId);
			window.location.href = data.link;
		} else {

			if (typeof data.type != 'undefined') {
                link = data.type.toUpperCase();
            } else {
                var link = "Suggestion";
            }

			facetsOff();
			registerLinkClick(data.queryTerm, data.rank, data.value, link, data.documentId, data.searchActionId);

			$form.submit();
		}

	}).on('typeahead:render', function(e, data) {

		$form = getForm(e);
        ttval = $form.find('.typeahead').typeahead('val');

        var path = "/web/qut/";

        if (typeof Liferay.Session !== 'undefined') {
            path = "/group/qut/";
        }

		$form.find('.twitter-typeahead .student-tt').first().before('<h4 class="typeahead-subheading clickable"><a href="' + path + 'search?profile=STUDENT&params.query=' + ttval + '">Students</a></h4>');
		$form.find('.twitter-typeahead .staff-tt').first().before('<h4 class="typeahead-subheading clickable" data="STAFF"><a href="' + path + 'search?profile=STAFF&params.query=' + ttval + '">Staff</a></h4>');
		$form.find('.twitter-typeahead .unit-tt').first().before('<h4 class="typeahead-subheading clickable" data="UNIT"><a href="' + path + 'search?profile=UNIT&params.query=' + ttval + '">Units</a></h4>');
		$form.find('.twitter-typeahead .classes-tt').first().before('<h4 class="typeahead-subheading clickable" data="CLASSES"><a href="' + path + 'search?profile=CLASSES&params.query=' + ttval + '">Classes</a></h4>');
		$form.find('.twitter-typeahead .application-tt').first().before('<h4 class="typeahead-subheading clickable" data="APPLICATION"><a href="' + path + 'search?profile=APPLICATION&params.query=' + ttval + '">Applications</a></h4>');
		$form.find('.twitter-typeahead .content-tt').first().before('<h4 class="typeahead-subheading clickable" data="CONTENT"><a href="' + path + 'search?profile=CONTENT&params.query=' + ttval + '">Web</a></h4>');
        $form.find('.twitter-typeahead .service-tt').first().before('<h4 class="typeahead-subheading clickable" data="SERVICE"><a href="' + path + 'search?profile=SERVICE&params.query=' + ttval + '">Services</a></h4>');

		$form.find('.twitter-typeahead .student-tt').last().after('<div class="typeahead-section-link"><a href="' + path + 'search?profile=STUDENT&params.query=' + ttval + '" data="STUDENT">See more student results</a></div>');
		$form.find('.twitter-typeahead .staff-tt').last().after('<div class="typeahead-section-link"><a href="' + path + 'search?profile=STAFF&params.query=' + ttval + '" data="STAFF">See more staff results</a></div>');
		$form.find('.twitter-typeahead .unit-tt').last().after('<div class="typeahead-section-link"><a href="' + path + 'search?profile=UNIT&params.query=' + ttval + '" data="UNIT">See more unit results</a></div>');
		$form.find('.twitter-typeahead .class-tt').last().after('<div class="typeahead-section-link"><a href="' + path + 'search?profile=CLASSES&params.query=' + ttval + '" data="CLASSES">See more class results</a></div>');
		$form.find('.twitter-typeahead .application-tt').last().after('<div class="typeahead-section-link"><a href="' + path + 'search?profile=APPLICATION&params.query=' + ttval + '" data="APPLICATION">See more application results</a></div>');
		$form.find('.twitter-typeahead .content-tt').last().after('<div class="typeahead-section-link"><a href="' + path + 'search?profile=CONTENT&params.query=' + ttval + '" data="CONTENT">See more web results</a></div>');
        $form.find('.twitter-typeahead .service-tt').last().after('<div class="typeahead-section-link"><a href="' + path + 'search?profile=SERVICE&params.query=' + ttval + '" data="SERVICE">See more service results</a></div>');

		if( !$.trim( $form.find('.tt-dataset-Keywords').html() ).length ) {
			$form.find('.tt-dataset-Documents').find('h4').first().addClass('no-border');
		} else {
			$form.find('.tt-dataset-Keywords').find('h4').first().addClass('no-border');
		}

	});

    /* ==================================================================================================
     |
     | EVENT ATTTACHMENTS GO HERE
     |
       ================================================================================================== */


    /*========================================
     | Triggers typeahed post processing
     | on input change
     =========================================*/
	$inputs.on('input', function(event) {
        ttTrigger(event);
	});


    /*========================================
     | Triggers typeahed post processing
     | on input focus
     =========================================*/
	$inputs.on('focus', function(event) {
        ttTrigger(event);
	});


    /*========================================
     | Add functionality to our recent
     | search tt items
     =========================================*/
    $('.tt-menu').on('click', '.top-5', function(event) {

        // identify our elements
        $form = getForm(event);
        $input = $form.find('input.search-input');
        $input.typeahead('val', $(this).text() );
        $form.submit();
    });



    /*========================================
     | Add functionality to our recent
     | search tt items
     =========================================*/
    $('.tt-menu').on('mouseenter', '.top-5', function(event) {

        // identify our elements
        //$form = getForm(event);
        //$input = $form.find('input.search-input');
        //$input.val( $(this).text() );
    });



    /*========================================
     | Runs when you press a key on input
     ========================================= */
    $inputs.keydown( function(event) {

        // identify our elements
        $form = getForm(event);
        $input = $form.find('input.search-input');

        // if user is pressing up and down
        if ( $('.top-5.tt-cursor').length > 0 ) {
            if ( e.keyCode == '38' || e.keyCode == '40' ) {
                $input.val( $form.find('.top-5.tt-cursor').text() );
                event.preventDefault();
            }
        }

    });

    /*========================================
     | Runs when you release a key on input
     ========================================= */
    $inputs.keyup( function(event) {

        //vars used
        e = event || window.event;

        // if user is pressing up and down
        if ( $('.top-5.tt-cursor').length > 0 ) {
            if ( e.keyCode == '38' || e.keyCode == '40' ) {
                event.preventDefault();
            } else if ( e.keyCode == '13' ) {
                console.log(
                    'enter'
                );
                $input = $form.find('input.search-input');
                $input.typeahead('val', $form.find('.top-5.tt-cursor').text() );
                $form.submit();
            }
        }

        checkSearchQuery();
    });


    /*========================================
     | Search clearing button
     =========================================*/
    $(".searchClear").click( function (e) {
        // identify our elements
        $form = getForm(e);
        $input = $form.find('input.search-input');

        //console.log($form);
        //console.log($input);

        $form.find('.typeahead').typeahead('val', '');
        $input.val('').focus();

        checkSearchQuery();
    });


    /*========================================
     | TOGGLE FACET MENU
     | Toggle button to show and/or hide search
     | facet menu.
     =========================================*/
    $('#solrquest-results .filter-toggle, #solrquest-facets .facet-close').click(function() {
        $('#solrquest-facets, #solrquest-results, #solrquest-results .filter-toggle').toggleClass('active');

        setHiddenPref("refine", $('#solrquest-facets').hasClass('active'));

        return false;
    });


    /*========================================
     | TOGGLE FACET TEXT
     | show more/less
     =========================================*/
    $(".toggle-more-facets").click(function(e) {
        $(this).prev('ul').children('li').toggleClass('facet-hide facet-show');

        $(this).html($(this).text() == 'See more' ? 'See less' : 'See more');

        e.preventDefault();
        return false;
    });

    /*========================================
     | LINK CLICK
     | Record link click for analytics
     =========================================*/
    $('#solrquest, #solrquest-help').on('mouseup', 'a', function() {

        var url = $(this).attr('href');
        var linkText = $(this).text();

        //Preferences and Print View
        if (!linkText || !linkText.trim()) {
            linkText = $(this).attr('data-original-title');
        }

        //Launchpad
        if (url == "#" && $(this).attr('data-linkurl')) {
            url = $(this).attr('data-linkurl');
        } else if (!url || url == "#") {
            url = "undefined";
        }

        var documentId = $(this).parents(".result-item").attr('id');
        var queryTerm = $('#solrquest #linkClick-query').val();
        var pageNumber = $('#solrquest #pageNumber').val();
        var rank = $(this).parents(".result-item").attr('rank');
        var searchActionId = $('#solrquest #searchActionId').val();
        var linkClickUrl = $('#solrquest #linkClickUrl').val();

        var registerLinkClickUrl = linkClickUrl + "&url=" + url + "&rank=" + rank + "&linkText=" + linkText
            + "&documentId=" + documentId + "&queryTerm=" + queryTerm + "&searchActionId=" + searchActionId + "&pageNumber=" + pageNumber;

        if (url != '#') {
            jQuery.ajax({
                type: "POST",
                global: false,
                url: registerLinkClickUrl
            });
        }

    });

    /*========================================
     | attach print call to print ubtton
     =========================================*/
    $('#search-print').on("click", function() {
        printView();
    });

    /*========================================
     | RESET FACET MENU
     | Reset facets when button pressed
     =========================================*/
    $('#solrquest-facets .facet-reset').click(function(event) {
        facetsOff();
        $( event.target ).closest( "form").submit();
    });

    /*========================================
     | SEARCH WITH FACET
     | Perform new search with chosen facet
     =========================================*/
    $('.facet-content').on("change", ".facetFilter", function(event) {
        $( event.target ).closest( "form").submit();
    });

    /*========================================
     | UPDATE SEARCH ON SORT
     | Perform new search with sort menu changed
     =========================================*/
    $('#result-options-sort').on("change", function(event) {
        $( event.target ).closest( "form").submit();
    });

    /*========================================
     | DISABLE ACTIVE TAB
     | Don't allow active tab to load to page
     | as it's not needed.
     =========================================*/
    $('.nav-tabs .active a').click(function(e) {
        e.preventDefault();
    });

    /*========================================
     | DISABLED PAGINATION BUTTONS
     | Used primarily for IE9 as it doesn't
     | respect the disabled attribute
     =========================================*/
    $('.result-pagination a.disabled').click(function(){
        $(this).preventDefault();
    });


    /*========================================
     | CLEAR SEARCH BOX
     | If anything has been entered in the search
     | box, show a clickable grey X to enable
     | user to clear the search box contents.
     =========================================*/
    //$(" .hasSearchClear").keyup(function () {
    //    var t = $(this);
    //    t.parent().next('span').toggle(Boolean(t.val()));
    //});


    /*========================================
     | DATATABLE EVENTS FOR UNITS
     | Toggles the class list info for DT
     =========================================*/
    $('.class-info-action ').click(function(e) {

		// Toggle button / link text
        $(this).text(function(i, text){
          return text === "Show classes" ? "Hide classes" : "Show classes";
      	})

        // identify table based on click
        $extra = $(this).closest('.search-unit-info').siblings('.search-unit-extra');

        // slide open datatable div
        $extra.slideToggle();

        // identify table based on click
        $table = $extra.find('.dt-target');

        // get data from table
        unitcd = $table.attr('data').split("|")[0];
        tpid= $table.attr('data').split("|")[1];
        uver= $table.attr('data').split("|")[2];

        // instantiate if this has not been done before
        if ( ! $.fn.DataTable.isDataTable( $table ) ) {

            // get unit extra info
            //$extra.find('.loading').slideDown();

            var classTable = $table.DataTable({
                "paging": false,
                "info": false,
                "searching": false,
                "sDom": "lfrBtip",
				"buttons": [
					{
			            extend: 'pdfHtml5',
			            orientation: 'landscape',
			            pageSize: 'A4',
			            title: 'QUTDigitalWorkplace-ClassList',
						exportOptions: {
                    		columns: ':visible'
                		}
			        },
			        {
			            extend: 'csvHtml5',
			            title: 'QUTDigitalWorkplace-ClassList',
						exportOptions: {
                    		columns: ':visible'
                		}
			        }
		        ],
                "ajax": "/delegate/solrquest/service/classes?unit_cd=" + unitcd + "&time_period_id=" + tpid,
                "order": [[0, "asc"], [1, "asc"]],
                "oLanguage": {
	                "sEmptyTable": "No class information currently available."
	            },
                "drawCallback": function( settings ) {
                    // Output the data for the visible rows to the browser's console
                    if (this.api().rows( {page:'current'} ).data().length <= 0) {
                        $table.children('thead').hide();
                    } else {
                        $table.children('thead').show();
                        $table.addClass('not-empty');
                        $('.not-empty').prev('.dt-buttons').show();
						// Adding tooltip to export buttons
						$('a.buttons-pdf').tooltip({container: 'body', placement: 'top', title: 'Export as PDF'});
						$('a.buttons-csv').tooltip({container: 'body', placement: 'top', title: 'Export as CSV'});
                    }
                },
                "columnDefs": [
                    {
                        "targets": [0],
                        "visible": false,
                        "searchable": false,
                        "data": "SORT"
                    },
                    {
                        "targets": [1],
                        "visible": false,
                        "searchable": false,
                        "data": "CLASS_TIME_ORDER"
                    },
                    {
	                    "targets": [2],
	                    "className": "class-activity",
	                    "data": "DESCRIPTION",
	                    "orderable": false
                    },
                    {
	                    "targets": [3],
	                    "className": "class-no",
	                    "data": "CLASS_NO",
	                    "orderable": false
                    },
                    {
	                    "targets": [4],
	                    "className": "class-day",
	                    "data": "CLASS_START_DAY",
	                    "orderable": false
                    },
                    {
	                    "targets": [5],
	                    "className": "class-time",
	                    "data": "CLASS_TIME_DISPLAY",
	                    "orderable": false
                    },
                    {
	                    "targets": [6],
	                    "className": "class-location",
	                    "data": "LOCATION",
	                    "orderable": false
                    },
                    {
	                    "targets": [7],
	                    "className": "class-staff",
	                    "data": "STAFF",
	                    "orderable": false
                    }]
            });

            /*$.ajax({
                dataType: "json",
                url: '/delegate/solrquest/service/classlist',
                data: 'unit_cd=' + unitcd + '&time_period_id=' + tpid + '&unit_version_number=' + uver,
                success: function(data) {
                    if (!isEmpty(data.stats)) {

                        for (sta in data.stats) {
                            $extra.find('.unit-' + sta).text(data.stats[sta]);

                            if (sta == 'average' || sta == 'passrate') {
                                $extra.find('.unit-details-results').show();
                            }
                        }

                        $extra.find('.search-unit-extra-container').toggle();
                    }

                    // get unit extra info
                    $extra.find('.loading').slideUp();
                }
            });*/
        }

        e.preventDefault();
    });

    /* ==================================================================================================
     |
     | ACTUAL JS THAT RUNS WHEN YOU LOAD PAGE!
     |
       ================================================================================================== */

    /*========================================
     | Ajax pools and kills
     =========================================*/

    // Automatically cancel unfinished ajax requests
    // when the user navigates elsewhere.
    $.xhrPool = [];

    $(document).ajaxSend(function(e, jqXHR, options){
        $.xhrPool.push(jqXHR);
    });

    $(document).ajaxComplete(function(e, jqXHR, options) {
        $.xhrPool = $.grep($.xhrPool, function(x){return x!=jqXHR});
    });

    var xhrAbort = function() {
        $.each($.xhrPool, function(idx, jqXHR) {
            jqXHR.abort();
        });
    };

    var oldbeforeunload = window.onbeforeunload;
    window.onbeforeunload = function() {
        var r = oldbeforeunload ? oldbeforeunload() : undefined;
        if (r == undefined) {
            // only cancel requests if there is no prompt to stay on the page
            // if there is a prompt, it will likely give the requests enough time to finish
            console.log("aborted ajax request");
            xhrAbort();
        }
        return r;
    }

    $globalForm.on('submit', function(e) {
        if (typeof $.xhrPool != 'undefined') {
            console.log('whee');
            $inputs.typeahead('close');
            xhrAbort();
        }
    });

    $portletForm.on('submit', function(e) {
        if (typeof $.xhrPool != 'undefined') {
            console.log('whee');
            $inputs.typeahead('close');
            xhrAbort();
        }
    });

    /*========================================
     | Check sq for input alteration
     =========================================*/
    checkSearchQuery();


    /*========================================
     | TOGGLE FACET ITEMS
     | Show more or hide less facet items
     | More then 3 will be hidden on load
     =========================================*/
    $(".facet-list").each(function() {
        $(this).find(".facetItem:gt(2)").addClass('facet-hide');
    });


    /*========================================
     | Triggers typeahed post processing
     | on input focus
     =========================================*/
    $('.tt-menu').prepend('<h3 class="typeahead-heading">Search suggestions</h3>');


    /*========================================
     | CHECK TAB BEING VIEWED
     | Look at the current url and highlight
     | the corresponding tab
     =========================================*/
    if ( profile == 'CONTENT' ) {
        // Add to Launchpad as personal link
        $("#add-launchpad-application-modal").appendTo('body');
        $(".launchpad-add-application").unbind('click').bind('click',function (e) {
            e.preventDefault();

            var $addShortcut =  $('.pers-shortcut');
            var link = $(this).attr('data-linkurl');
            var title = $(this).attr('data-linktitle');
            if (link) {
                if ( link.indexOf("/") == 0) {
                    link = window.location.protocol + "//" + window.location.hostname + link;
                }

                $('#add-application-shortcut').addClass('hidden');
                $('#add-launchpad-application-custom-url').val(link);

                if($addShortcut.hasClass('col-md-6')) {
                    $addShortcut.removeClass('col-md-6');
                    $addShortcut.addClass('col-md-12');
                    $addShortcut.css('border-right','none');
                }
            }
            if (title) {
                // set link title stripped of highlighting
                $('#add-launchpad-application-custom-title').val(title.replace(/(<([^>]+)>)/ig, ""));
            }

            qut.launchpad.showAddShortcut();
        });

        // key dates
        $('.date-description').find('.keydates-more-text').click(function(e){
            // reveal full text on for keydates on click
            e.preventDefault();
            var $previewText = $(this).parents('.keydates-preview-text')
            $previewText.siblings('.keydates-full-text').removeClass('hidden');
            $previewText.remove();
        })
    }

    if ( profile == 'CONTENT' || profile == 'APPLICATION') {
        var $appLinks = $( (profile == 'APPLICATION' ? '#APPLICATION-results':'#result-contextPane') + ' a.app-add-launchpad');
        if ($appLinks.length > 0)
            qut.launchpad.configureToggleApplicationLinks($appLinks);
    }

	/*========================================
	 | SEARCH FEEDBACK MODAL PROCESSING
	 =========================================*/
	$("a.solr-feedback-btn").click(function(e) {
		$('#search-feedback-modal').appendTo('body').modal('show');
		e.preventDefault();
	});

	$('.search-feedback-submit').on('click',function(e) {
		e.preventDefault();
        $('.search-feedback-submit').attr("disabled","disabled");
		var $form = $('#search-feedback-form');
		var $modal = $('#search-feedback-modal');
        var $feedbackTA = $("#solrq_feedback-description");
        var userAgent = navigator.userAgent;
        var location= window.location.href;
        var height= window.screen.availHeight;
        var width = window.screen.availWidth;
        var resolution = width +" x " + height;

        var formData = $form.serializeArray();
        formData.push({name: 'location', value: location});
        formData.push({name: 'resolution', value: resolution});
        formData.push({name: 'user-agent', value: userAgent});

		$.ajax({
			url: $form.attr("action"),
			type: "POST",
			data: formData
		}).done(function (data) {
            $feedbackTA.val("");
			$modal.modal('hide');
            if (data.result=="ok") {
                toastr.success(data.successMessage);
            } else {
                toastr.options.timeOut=10000;
                toastr.error(data.errorMessage);
                toastr.options.timeOut=2000;
            }
		}).fail(function (data) {
            $feedbackTA.val("");
			$modal.modal('hide');
            toastr.options.timeOut=10000;
            toastr.error(data.errorMessage);
            toastr.options.timeOut=2000;
		});
	});

    $("#search-feedback-modal").on("hidden.bs.modal", function(){
        $("#solrq_feedback-description").val("");
        $('.search-feedback-submit').removeAttr("disabled");
    });

    $("#search-feedback-modal").on("hide.bs.modal", function (e) {
        var feedback = $("#solrq_feedback-description").val();
        if(feedback.trim().length > 0)
            return e.preventDefault();
    });

    $("#solrq_btnClose").on('click', function(){
        var feedback = $("#solrq_feedback-description").val();
        if(feedback.trim().length > 0)
            solrq_confirmDialog(feedback);
    });

    function solrq_confirmDialog(feedback){
        var solrq_fClose = function(){
            $("#solrq_feedback-description").val("");
            $("#solrq_confirmModal").modal("hide");
            $("#search-feedback-modal").modal("hide");
        };
        var solrq_fShow = function(e){
            $("#solrq_confirmModal").modal("hide");
            $("#search-feedback-modal").modal("show");
            $("#solrq_feedback-description").val(feedback);
        };
        $("#solrq_feedback-description").val("");
        $("#solrq_confirmModal").modal({backdrop: 'static', keyboard: false});
        $("#solrq_confirmOk").one('click', solrq_fClose);
        $("#solrq_confirmCancel").one("click", solrq_fShow);
    }

});