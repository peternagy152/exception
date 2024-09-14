$(document).ready(function () {

    //MD-popups

$(document).on('click', '.js-MD-popup-opener', function () {
    var ths = $(this);
    var trgt = $($(this).attr('href'));
    // $(".mobile-nav").removeClass("active");
    // $('.menu_mobile_icon.close').removeClass('show');
    // $('.menu_mobile_icon.open').removeClass('hide');
    $('.MD-popup').removeClass('popup_visible');
    $('html, body').css('overflow', 'hidden');
    $('#overlay').addClass('overlay_visible');
    $(".mobile-nav").removeClass("active");
    trgt.addClass('popup_visible');

    return false;
});
$(document).on('click', '.js-MD-popup-closer', function () {
    $('.MD-popup').removeClass('popup_visible');
    $('#overlay').removeClass('overlay_visible');
    $('html, body').css('overflow', 'visible');
    return false;
});

//Show password text
$(document).on('click', '.MD-show-password', function () {
    var next_iput = $(this).next('input');
    // console.log(next_iput);
    if (next_iput.attr("type") === "password") {
        next_iput.attr("type", "text");
        $(this).addClass('active');
    } else {
        next_iput.attr("type", "password");
        $(this).removeClass('active');
    }
});
//show small menu

$(document).on('click', '.menu-icon:not(.active)', function () {
    // $('.MD-menu').removeClass('active');
    $('.menu-icon').removeClass('active');
    $('.MD-menu .list').slideUp();
    $(this).addClass('active');
    $(this).next().slideDown();
    
});
$(document).on('click', '.MD-menu .menu-icon.active', function () {
    $(this).removeClass('active');
    $(this).next().slideUp();
});

$(document).on('click', '.MD-menu .list ul li a', function () {
    $('.menu-icon').removeClass('active');
    $('.MD-menu .list').slideUp();
});

    
});

 // // start myaccount edit-address hover //
//  $('.list').slideUp();
//  $(document).on('mouseenter', '.MD-menu', function() {
    
//          $(this).find('.menu-icon').addClass("active");
//          $(this).find('.list').slideDown();
//  });

//  $(document).on('mouseleave', '.MD-menu', function() {
//      $(this).find('.menu-icon').removeClass("active");
//      $(this).find('.list').slideUp();
//  });
// // End myaccount edit-address hover //


