$(document).ready(function () {
    var ajaxStarted = false;
    $(window).bind("scroll", function () {
        if (!ajaxStarted && $(window).scrollTop() > $(document).height() - $(window).height() - 100) {
            $(".loader").show();
            ajaxStarted = true;
            var orderBy = "new";
            if (window.location.href.indexOf("order_by=popular") > 0) {
                orderBy = "popular";
            }
            $.get("get-socks.php?count=1", function (data) {
                if (data != $(".main .socks").length) {
                    $.get("get-socks.php?offset=" + $(".main .socks").length + "&order_by=" + orderBy, function (data) {
                        $(".main").append(data);
                    });
                    $(document).bind("ajaxStart.call", function () {
                        ajaxStarted = true;
                        $(".loader").show();
                    });
                    $(document).bind("ajaxStop.call", function () {
                        ajaxStarted = false;
                        $(".loader").hide();
                        $(".main").find(".socks .socks-img a .inner-img").each(function () {
                            var $this = $(this);
                            $this.imagesLoaded({background: true}, function () {
                                $this.parent().parent().find(".image-overlay").fadeOut(500);
                            });
                        });
                    });
                }
                else {
                    $(document).unbind(".call");
                    ajaxStarted = true;
                    $(".loader").hide();
                    $(window).unbind("scroll");
                }
            })


        }
    });
});