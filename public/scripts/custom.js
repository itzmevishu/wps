$(function () {
    var __searchTerm = "all";

    $( "#search_sessions" ).submit(function( event ) {
        __searchTerm = $("#search_terms").val();
        window.location.replace("{{ env('APP_URL') }}/iltsessions/"+ __searchTerm +"/name_asc");
        event.preventDefault();
    });

});