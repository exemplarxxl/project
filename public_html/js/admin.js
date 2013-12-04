function ajaxMoveRequest(url, tableId){
    $.ajax({
        url: url,
        data: {ajax:1},
method: "get",
success: function(){
    $("#"+tableId).yiiGridView.update(tableId);
    }
});
}


function show_loader(box) {

    $('<div class="' + box + '"');
    $(box).centered_loader();
    $(box).show();
    }
function hide_loader(box) {
    $(box).hide();
    //$("#background").delay(100).hide(1);
    }

$(document).ready(function(){

    $.fn.centered_loader = function() {
        this.css("position","fixed");
        this.css("top", (($(window).height() - this.outerHeight()) / 2) + $(window).scrollTop() + "px");
        this.css("left", (($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft() + "px");
        return this;
    }

$(document).ajaxStart(function(){
    show_loader('#ajax_loader');
    });

$(document).ajaxStop(function(){
    hide_loader('#ajax_loader');
    });
});
