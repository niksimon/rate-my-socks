$(document).ready(function () {
    $(".main").find(".socks .socks-img a .inner-img").each(function () {
        var $this = $(this);
        $this.imagesLoaded({background: true}, function () {
            $this.parent().parent().find(".image-overlay").fadeOut(500);
        });
    });
});