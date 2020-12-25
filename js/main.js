$(document).ready(function () {
    $(".open-menu").bind("click", function () {
        var left = parseInt($(".menu").css("left"));
        $(this).toggleClass("click");
        if (left == -220) {
            $("ul.menu").animate({left: "0"}, 150);

        }
        else if (left == 0) {
            $("ul.menu").animate({left: "-220"}, 150);
        }
    });
    $(".main").on("click", ".socks .like-logged .like-click, .like-logged .like-click", function () {
        var id_socks = $(this).next().attr("id").split("-")[1];
        var $this = $(this);

        if ($this.hasClass("socks-liked")) {
            $this.removeClass("like-click-animate");
            $this.removeClass("socks-liked");
            $this.addClass("socks-notliked");
        }
        else {
            $this.addClass("like-click-animate");
            $this.addClass("socks-liked");
            $this.removeClass("socks-notliked");
        }
        $.get("add-remove-like.php?id_socks=" + id_socks, function (data) {
            $this.next().html(data);
        });
    });
    $(".main").on("click", ".socks .not-logged .like-click, .not-logged .like-click", function () {
        $this = $(this);
        $this.next().stop(true).fadeIn(150, function () {
            $this.next().delay(1000).fadeOut(150);
        });
    });
    console.log("Made by simon in 2017\n\nThanks to:\nhttp://jquery.com/\nhttp://imagesloaded.desandro.com/\nhttp://fontawesome.io/\nhttps://codepen.io/bbodine1/pen/novBm");
});