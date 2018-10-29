$(document).ready(function(e) {
    //If the user clicks anywhere on the page, ensure the community menu is closed
    $("body").click(function() {
        $("#community-dropdown").removeClass("community-open");
        $(".community-toggle, #mcommunity-toggle").removeClass("community-highlight");
    });
    //If the user clicks anywhere inside the community menu, keep the menu open
    $("#community-wrapper-large, #community-wrapper-medium, #community-wrapper, #mcommunity-toggle").click(function(e) {
    $("#community-dropdown").toggleClass("community-open");
    $(".community-toggle, #mcommunity-toggle").toggleClass("community-highlight");

    //Hide LaunchPad if it is showing
    $("#launchpad-links").removeClass("launchpad-open");
    $("#launchpad-toggle, #mlaunchpad-toggle").removeClass("launchpad-highlight");

    e.preventDefault();
    e.stopPropagation();
    });

    //If the user clicks the community links or the close button, toggle the view community menu open and closed
    var toggleClickEvent = "";
    if ( navigator.userAgent.match(/iPad/i) != null || navigator.userAgent.match(/iPhone/i) != null )
    toggleClickEvent = "touchend";
    else
    toggleClickEvent = "click";

    $("#community-dropdown .close").on(toggleClickEvent, function(e) {
        $("#community-dropdown").toggleClass("community-open");
        $(".community-toggle, #mcommunity-toggle").toggleClass("community-highlight");

        e.preventDefault();
        e.stopPropagation();
    });
});
