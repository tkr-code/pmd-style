$(function(){
    "use strict";
    $(document).on('click','.btn-copy',function(){
        let data = $(this).data('copy')
        navigator.clipboard.writeText(data)
        .then(function() {
            Swal.fire({
                icon: 'success',
                title: 'Texte copié !',
                showConfirmButton: false,
                timer: 1500
            })
        })
        .catch(function(error) {
            alert('Impossible de copier le texte: ' + error);
        });
    })
    $(document).on('click','.tutoriel-list-btn',function(){
        $('.tutoriel-list-btn').removeClass('active')
        $(this).toggleClass('active')
    })

    const headerHeight = $('header').outerHeight()
    //REDIRIGE VERS L'ANCRE
    $(document).on('click', '.header-link', function (e) {
        e.preventDefault()
        let target = $(this).attr('href');
        $('html,body').animate({
            scrollTop: $(target).offset().top - headerHeight +20
        }, 'slow')
    })
    //------- fixed navbar --------//  
    $(window).scroll(function () {
        var sticky = $('.main-header'),
        scroll = $(window).scrollTop();
        if (scroll >= 100) {
            $('.img-nav').addClass('img-nav-fixed')
            sticky.addClass('position-fixed');
            $('.header-cv').css('display','initial')
        }
        else {
            sticky.removeClass('position-fixed');
            $('.header-cv').css('display','none')
            $('.img-nav').removeClass('img-nav-fixed');
        }
    });
    // scroll to top
    $(document).on('click', '#mainMenu li a', function () {
        $('#mainMenu li a.active').removeClass('active')
        $(this).addClass('active')
    })

    
    //user menu click
    $(document).on('click','#user-icon',function(){
        $('.user-icon-dropdown').toggle('slow')
        $(this).find('i').toggleClass('fa fa-angle-up fa fa-angle-down','slow')

    })

    
    //tutoriel active
    $(document).on('click', '.tutoriel-list-btn', function () {
        $('.tutoriel-list-btn').removeClass('active')
        $(this).addClass('active')
    })

    
    $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 20,
        nav: true,
        autoplay:true, 
        dots: true,
        navText: ['<i class="fa fa-arrow-circle-left fa-2x"></i>', '<i class="fa fa-arrow-circle-right fa-2x">'],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    })
    //scroll active
    AOS.init({
        duration: 1000,
        offset: 120,
    });

    // /* ANIMATION AOS - RECHARGE AOS */
    // AOS.refresh();
})