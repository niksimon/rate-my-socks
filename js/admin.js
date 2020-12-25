$(document).ready(function(){
    $(".delete-verify").each(function(){
        $(this).click(function(){
            $(".delete-pop-up-wrap").show();
            $("#delete-yes").attr("href", $(this).attr("data-url"));
        });
    });
    
    $("#delete-no").click(function(){
        $(".delete-pop-up-wrap").hide();
    });
    
    $(".menu-check").each(function(i){
        $(this).change(function(){
            var visible = $(this).attr("value");
            var idMenu = $(this).attr("id").substring(9);
            if(visible == 1)
                $(this).attr("value", 0);
            else
                $(this).attr("value", 1);
            $.get("../admin/admin-ajax.php?id_menu=" + idMenu + "&visible=" + visible, function(data){
               console.log(data);
            });
        });
    });
    
    $(".comment-check").each(function(i){
        $(this).change(function(){
            var visible = $(this).attr("value");
            var idComment = $(this).attr("id").substring(7);
            if(visible == 1)
                $(this).attr("value", 0);
            else
                $(this).attr("value", 1);
            $.get("../admin/admin-ajax.php?id_comment=" + idComment + "&visible=" + visible, function(data){
               console.log(data);
            });
        });
    });
    
    $(".news-check").each(function(i){
        $(this).change(function(){
            var visible = $(this).attr("value");
            var idNews = $(this).attr("id").substring(4);
            if(visible == 1)
                $(this).attr("value", 0);
            else
                $(this).attr("value", 1);
            $.get("../admin/admin-ajax.php?id_news=" + idNews + "&visible=" + visible, function(data){
               console.log(data);
            });
        });
    });
});