<header class="hidden-print student-header" id="header">
    <div class="contain-width">
        <div id="banner">
            <div id="qut-dynamic-nav">
                <a class="menu" href="javascript:mobileMenu();void(0)" id="show-nav-menu">
                    <em class="fa fa-bars">
                    </em>
                    <span class="sr-only">
                        Show menu
                    </span>
                </a>
                <a class="position-nav-menu menu" href="javascript:void(0)" id="hide-nav-menu">
                    <em class="fa fa-bars">
                    </em>
                    <span class="sr-only">
                        Hide menu
                    </span>
                </a>
            </div>
            <div class="logo">
                <a class="png" href="https://qutvirtual4.qut.edu.au/group/student/home" tabindex="1" title="learning analytics home">Learning Analytics</a>
            </div>
            <div id="header-search">
                <link href="./qut-home_files/solrquest-tt.css" media="all" rel="stylesheet" type="text/css">
                    <form action="https://qutvirtual4.qut.edu.au/group/qut/search" autocomplete="off" id="global-search-form" method="get" name="solrSearch">
                        <label class="sr-only" for="searchQuery">
                            Search
                        </label>
                        <div class="input-group">
                            <span class="twitter-typeahead" style="position: relative; display: inline-block;">
                                <input autocomplete="off" class="search-input form-control hasSearchClear typeahead tt-input placeholder" dir="auto" id="searchQuery" name="params.query" placeholder="Search content, people, units, classes or applications" spellcheck="false" style="position: relative; vertical-align: top;" type="text">
                                    <pre aria-hidden="true" style='position: absolute; visibility: hidden; white-space: pre; font-family: "Segoe UI", sans-serif; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: auto; text-transform: none;'></pre>
                                    <div class="tt-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;">
                                        <h3 class="typeahead-heading">
                                            Your most recent searches
                                        </h3>
                                        <div class="tt-dataset tt-dataset-Documents">
                                        </div>
                                    </div>
                                </input>
                            </span>
                            <span class="searchClear fa fa-times form-control-feedback" style="display: none;">
                            </span>
                            <input disabled="disabled" id="profile" name="profile" type="hidden">
                                <div class="input-group-btn">
                                    <button class="btn btn-default search-submit" disabled="disabled" onclick="ga('send', 'event', 'TopSearch', 'Click', 'Submit');" type="submit">
                                        <span class="fa fa-search">
                                        </span>
                                        <span class="sr-only">
                                            Search
                                        </span>
                                    </button>
                                </div>
                            </input>
                        </div>
                    </form>
                </link>
            </div>
            <div class="top-icon" id="banner-icons">
                <!--------------- Messages ----------------------->
                <div data-counter-url="/delegate/services/inbox/unread/count" id="messages-wrapper-large">
                    <a class="messages-toggle" data-original-title="Messages" data-placement="bottom" data-toggle="tooltip" href="https://qutvirtual4.qut.edu.au/group/student/inbox" title="">
                        <span class="position">
                            View my messages
                        </span>
                        <span class="fa fa-inbox messages-icon">
                        </span>
                    </a>
                </div>
                <!--------------- Calendar ----------------------->
                <div id="calendar-wrapper-large">
                    <a class="calendar-toggle" data-original-title="Calendar" data-placement="bottom" data-toggle="tooltip" href="https://qutvirtual4.qut.edu.au/group/student/calendar" title="">
                        <span class="position">
                            Calendar
                        </span>
                        <span class="fa fa-calendar calendar-icon">
                        </span>
                    </a>
                </div>
                <!------------- Communities ----------->
                <div id="community-wrapper-large">
                    <a class="community-toggle" data-original-title="Communities" data-placement="bottom" data-toggle="tooltip" href="https://qutvirtual4.qut.edu.au/group/student/home#" title="">
                        <span class="position">
                            My communities
                        </span>
                        <span class="fa fa-users community-icon">
                        </span>
                    </a>
                </div>
                <!------------- Launchpad ------------>
                <div id="launchpad-wrapper">
                    <a class="launchpad" data-original-title="LaunchPad" data-placement="bottom" data-popup-type="modal" data-toggle="tooltip" href="https://qutvirtual4.qut.edu.au/group/student/home#" id="launchpad-toggle" title="">
                        <span class="position">
                            LaunchPad
                        </span>
                        <span class="fa fa-th launchpad-icon">
                        </span>
                    </a>
                </div>
            </div>
            <!----------------- Mobile Tabs --------------------->
            <div class="mtabswrapper">
                <ul class="mtabs">
                    <li id="mcommunity-toggle">
                        <a href="https://qutvirtual4.qut.edu.au/group/student/home#">
                            <i class="fa fa-users community-icon">
                            </i>
                            <span class="sr-only">
                                My communities
                            </span>
                        </a>
                    </li>
                    <li id="msearch-toggle">
                        <a href="https://qutvirtual4.qut.edu.au/group/student/home#">
                            <i class="fa fa-search search-icon">
                            </i>
                            <span class="sr-only">
                                Search
                            </span>
                        </a>
                    </li>
                    <li id="mlaunchpad-toggle">
                        <a href="https://qutvirtual4.qut.edu.au/group/student/home#">
                            <i class="fa fa-th launchpad-icon">
                            </i>
                            <span class="sr-only">
                                LaunchPad
                            </span>
                        </a>
                    </li>
                    <li id="mdock-toggle">
                        <a href="javascript:void(0)">
                            <i class="fa fa-user profile-menu-icon">
                            </i>
                            <span class="sr-only">
                                Profile menu
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="topMenu hidden-print">
                <div class="user-information">
                    <div class="user-profile">
                        <ul>
                            <li class="qut-dropdown">
                                <span id="profilePhotoBox">
                                    <img alt="Image of Student" class="user-profile-image" src="_images/qv_common_image.jpeg" />
                                </span>
                                <span aria-haspopup="true" class="user-name">
                                    <?php echo $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname']; ?>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>