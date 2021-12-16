$(function(){
    "use strict";
    //------- fixed navbar --------//  
    $(window).scroll(function () {
        var sticky = $('.main-header'),
            scroll = $(window).scrollTop();
        if (scroll >= 100) {
            $('.img-nav').addClass('img-nav-fixed')
            sticky.addClass('position-fixed');
        }
        else {
            sticky.removeClass('position-fixed');
            $('.img-nav').removeClass('img-nav-fixed');
        }
    });
})