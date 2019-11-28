$(function(){
    "use strict";
    $('.res-btn').on('click',function(){
        if($(this).hasClass('response')){
            $(this).parent().siblings('#resCom').fadeOut(800);
            $(this).removeClass('response');
        }else{
            $(this).parent().siblings().fadeIn(1000);
            $(this).addClass("response");
        }
    });
});
$('i#like').on('click',function(){
        $.get('_ajax.php',{
            countLike:$(this).siblings('#countLike').val()
        },function(res){
            $(this).html(res)
        });
        $(this).css({'color':'#399dc2'});
    });
    $('i#dislike').on('click',function(){
        $(this).css({'color':'#db5858'});
    });
