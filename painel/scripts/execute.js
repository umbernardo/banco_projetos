$(document).ready(function() {

    $("#nav-reflection li").append("<span></span>");
    $("#nav-reflection a").hover(function() {
        $(this).stop().animate({marginTop: "-10px"}, 200);
        $(this).parent().find("span").stop().animate({marginTop: "18px", opacity: 0.25}, 200);
    }, function() {
        $(this).stop().animate({marginTop: "0px"}, 300);
        $(this).parent().find("span").stop().animate({marginTop: "1px", opacity: 1}, 300);
    });

    $("#nav-shadow li").append('<img class="shadow" src="images/icons-shadow.jpg" width="81" height="27" alt="" />');

    $("#nav-shadow li").hover(function() {
        var e = this;
        $(e).find("a").stop().animate({marginTop: "-14px"}, 250, function() {
            $(e).find("a").animate({marginTop: "-10px"}, 250);
        });
        $(e).find("img.shadow").stop().animate({width: "80%", height: "20px", marginLeft: "8px", opacity: 0.25}, 250);
    }, function() {
        var e = this;
        $(e).find("a").stop().animate({marginTop: "4px"}, 250, function() {
            $(e).find("a").animate({marginTop: "0px"}, 250);
        });
        $(e).find("img.shadow").stop().animate({width: "100%", height: "27px", marginLeft: "0", opacity: 1}, 250);
    });

});