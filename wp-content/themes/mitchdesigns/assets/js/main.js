// window.onload = function () {
//     $('.page_home .box_gift').addClass('start');
// };

$(window).on('load', function () {
    $('a[href="#popup-banner"]').click();
});

$(document).mouseup(function (e) {
    var browser = $('.MD-menu');
    if (!browser.is(e.target) && browser.has(e.target).length === 0 && $('.MD-menu').hasClass('active')) {
        browser.removeClass('active');
    }
});
$(document).ready(function () {
    if ($('body').hasClass('rtl')) {
        var is_ar = true;
    } else {
        var is_ar = false;
    }

    $(window).on("resize", function () {
        var HeaderFooter =
            $("header").innerHeight() + $("footer").innerHeight();
        $(".site-content").css({
            "min-height": $(window).outerHeight() - HeaderFooter,
        });
        // console.log('HeaderFooter',HeaderFooter);
    })
        .resize();

    $(window).scroll(function () {
        // var sticky = $(".sticky"),
        scroll = $(window).scrollTop();

        if (scroll >= 160)
            //   sticky.addClass("fixed"),
            $("body").addClass("sticky-header"),
                $(".dgwt-wcas-suggestions-wrapp").addClass("scrolled");
        // $(".filter-tab").addClass("top");
        else
            //   sticky.removeClass("fixed"),
            $("body").removeClass("sticky-header"),
                $(".dgwt-wcas-suggestions-wrapp").removeClass("scrolled");
        // $(".filter-tab").removeClass("top");
    });

    // Top slider 


    // $(".section_note").slick({
    //     // autoplay: true,
    //     slidesToShow: 1,
    //     slidesToScroll: 1,
    //     arrows: true,
    //     infinite: true,
    //     speed: 800,
    //     nextArrow: '<div class="next-arrow"><span></span></div>',
    //     prevArrow: '<div class="prev-arrow"><span></span></div>',
    //     // responsive: [
    //     //     {
    //     //         breakpoint: 767,
    //     //         settings: {
    //     //             arrows: false,
    //     //         }
    //     //     },
    //     // ],
    // });

    $(".exstra_link").slick({
        autoplay: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        infinite: true,
        speed: 800,
        fade: true,
        nextArrow: '<div class="next-arrow"><span></span></div>',
        prevArrow: '<div class="prev-arrow"><span></span></div>',
        responsive: [
            {
                breakpoint: 767,
                settings: {
                    arrows: false,
                }
            },
        ],
    });

    // Start product widget slick //

    $(".product_container .products_list.slider_widget").slick({
        rtl: is_ar,
        autoplay: false,
        slidesToShow: 4,
        slidesToScroll: 1,
        arrows: true,
        infinite: false,
        // speed: 800,
        // fade: true,
        nextArrow: '<div class="next-arrow"><span></span></div>',
        prevArrow: '<div class="prev-arrow"><span></span></div>',
        responsive: [
            {
                breakpoint: 999,
                settings: {
                    slidesToShow: 3.2,
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 2.2,
                }
            },
            {
                breakpoint: 479,
                settings: {
                    arrows: false,
                    slidesToShow: 1.8,
                }
            },
        ],
    });
    // End product widget slick //

    //start slick and js single_item //

    $(".product-slider").slick({
        rtl: true,
        autoplay: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        fade: true,
        // asNavFor: ".slider-nav",
        accessibility: false,
        nextArrow: '<div class="next-arrow"><span></span></div>',
        prevArrow: '<div class="prev-arrow"><span></span></div>',
        // responsive: [
        // {
        //     breakpoint: 999,
        //     settings: {
        //     rtl:true,
        //     autoplay: false,
        //     dots: true,
        //     dotsClass: 'custom_paging',
        //     customPaging: function (slider, i) {
        //         return  (i + 1) + '/' + slider.slideCount;
        //     }
        //     }
        // },
        // ],
    });

    $(".slider-nav").slick({
        slidesToShow: 5.5,
        slidesToScroll: 1,
        asNavFor: ".product-slider",
        dots: false,
        arrows: true,
        centerMode: false,
        vertical: true,
        verticalSwiping: true,
        focusOnSelect: false,
        infinite: false,
        autoplay: false,
        responsive: [
            {
                breakpoint: 999,
                settings: {
                    arrows: false,
                    vertical: false,
                }
            },
        ],
    });



    $('.slider-nav .slick-slide').on('click', function (event) {
        $('.slider-nav .slick-slide').removeClass('active');
        $('.product-slider').slick('slickGoTo', $(this).data('slickIndex'));
        $(this).addClass('active');
    });
    $('.product-slider').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
        $('.slick-current img').addClass('active');
    });
    $(window).on("load", function () {
        $(".product-slider").addClass("active");
        $(".slider-nav img:nth-child(1)").addClass("active");
        $(".products-slider").addClass("active");
        $(".product_widget .image").addClass("active");
    });

    $(document).on('click', '.dropdown_info .title_info:not(.active)', function () {
        $('.title_info').removeClass('active');
        $('.content_info').slideUp();

        $(this).next().slideDown();
        $(this).addClass('active');
        return false;
    });

    $(document).on('click', '.dropdown_info .title_info.active', function () {
        $('.content_info').slideUp();
        $(this).removeClass('active');
        return false;
    });


    $(".single_page .sec_info .content_description").each(function () {
        if ($(this).height() > 160) {
            $(this).addClass("more");
        }
    });
    $(document).on('click', '.single_page .sec_info .content_description .more', function () {
        $(this).addClass("hidee");
        $(this).next().removeClass("hidee");
        $('.content_description').addClass('show_more');
    });
    $(document).on('click', '.single_page .sec_info .content_description .less', function () {
        $(this).addClass("hidee");
        $(this).prev().removeClass("hidee");
        $('.content_description').removeClass('show_more');
    });



    //start select size //
    $(document).on('click', '.sizes .single_size', function () {
        $('.single_size').removeClass('active');
        $(this).addClass('active');
    });
    //End  select size //

    //review-section
    $(document).on('click', '.review_rat .box:not(.active)', function () {
        $('.review_rat .box').removeClass('active');

        $(this).addClass('active');
        return false;
    });


    //End slick single_item //

    //Start slick home //
    $(".hero_slider").slick({
        rtl: is_ar,
        autoplay: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        dots: true,
        infinite: true,
        speed: 800,
        fade: true,
        nextArrow: '<div class="next-arrow"><span></span></div>',
        prevArrow: '<div class="prev-arrow"><span></span></div>',
        responsive: [
            {
                breakpoint: 999,
                settings: {
                    dots: true,
                }
            },
        ],
    });

    //End slick home //


    //Start slick About //
    $(".image.slick_about").slick({
        rtl: is_ar,
        autoplay: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        dots: true,
        infinite: true,
        speed: 800,
        fade: true,
        nextArrow: '<div class="next-arrow"><span></span></div>',
        prevArrow: '<div class="prev-arrow"><span></span></div>',
        responsive: [
            {
                breakpoint: 999,
                settings: {
                    dots: true,
                }
            },
        ],
    });

    //End slick About //

    //Start slick special //
    $('.all_img').slick({
        rtl: is_ar,
        // slidesToShow: 1,
        centerMode: true,
        variableWidth: true,
        centerPadding: '50',
        focusOnSelect: true,
        autoplaySpeed: 5000,
        nextArrow: '<div class="next-arrow"><span></span></div>',
        prevArrow: '<div class="prev-arrow"><span></span></div>',
        dots: true,
        responsive: [
            {
                breakpoint: 999,
                settings: {
                    centerMode: false,
                    variableWidth: false,
                    centerPadding: '50',
                    focusOnSelect: false,
                    slidesToShow: 1
                }
            },
            //   {
            //     breakpoint: 480,
            //     settings: {
            //       arrows: false,
            //       centerMode: true,
            //       centerPadding: '40px',
            //       slidesToShow: 1
            //     }
            //   }
        ]
    });
    //End slick special //


    //start dropdown_info //
    // $(document).on('click', '.dropdown_info_mobile .single_info .title_info', function () {
    //     $('.dropdown_info_mobile .single_info').removeClass('active');
    //     $(this).parent().addClass('active');
    // });
    // $(document).on('click', '.dropdown_info_mobile .single_info.active .title_info', function () {
    //     $(this).parent().removeClass('active');
    //     $('.dropdown_info_mobile .single_info').removeClass('active');
    // });

    //End dropdown_info //


    //start open coupon //
    $(document).on('click', '.page_cart .open-coupon', function () {
        $('.page_cart .discount-form').addClass('active');
        $(this).addClass('active');
        return false;
    });

    $(document).on('click', '.page_cart .close-coupon', function () {
        $('.page_cart .discount-form').removeClass('active');
        $('.page_cart .open-coupon').removeClass('active');
        return false;
    });

    $(document).on('click', '.min_cart .open-coupon', function () {
        $('.min_cart .discount-form').addClass('active');
        $(this).addClass('active');
        $('.all_item').addClass('height');
        return false;
    });

    $(document).on('click', '.min_cart .close-coupon', function () {
        $('.min_cart .discount-form').removeClass('active');
        $('.min_cart .open-coupon').removeClass('active');
        $('.all_item').removeClass('height');
        return false;
    });

    $(document).on('click', '.checkout-content .open-coupon', function () {
        $('.checkout_coupon').addClass('active');
        $(this).addClass('active');
        return false;
    });

    $(document).on('click', '.checkout-content .close-coupon', function () {
        $('.checkout_coupon').removeClass('active');
        $('.open-coupon').removeClass('active');
        $(this).removeClass('active');
        return false;
    });

    //End open coupon //



    //start popup //
    $(document).on('click', '.js-popup-opener', function () {
        var ths = $(this);
        var trgt = $($(this).attr('href'));
        $('.popup').removeClass('popup_visible');
        $('html, body').css('overflow', 'hidden');
        $('#overlay').addClass('overlay_visible');
        $(".mobile-nav").removeClass("active");
        trgt.addClass('popup_visible');

        return false;
    });
    $(document).on('click', '.js-popup-closer', function () {
        $('.popup').removeClass('popup_visible');
        $('#overlay').removeClass('overlay_visible');
        $('#overlay_header_mob').removeClass('overlay_visible');
        $('html, body').css('overflow', 'visible');
        return false;
    });

    $(".overlay").on("click", function () {
        $('.popup').removeClass('popup_visible');
        $('.MD-popup').removeClass('popup_visible');
        $('#overlay').removeClass('overlay_visible');
        $('html, body').css('overflow', 'visible');
        $('#popup-banner').removeClass('popup_visible');
    });

    $(".open_login_mobile").on("click", function () {
        $(".mobile-nav").removeClass("active");
        $('.menu_mobile_icon.close').removeClass('show');
        $('.menu_mobile_icon.open').removeClass('hide');
        $("body").removeClass("no-scroll");
    });

    $(".section_header_col_one .top_mobile .js-popup-opener").on("click", function () {
        var ths = $(this);
        var trgt = $($(this).attr('href'));
        $('.popup').removeClass('popup_visible');
        $('html, body').css('overflow', 'hidden');
        $('#overlay').addClass('overlay_visible');
        trgt.addClass('popup_visible');
        $(".mobile-nav").removeClass("active");
        $('#overlay_header_mob').removeClass('overlay_visible');
        $('.menu_mobile_icon.close').removeClass('show');
        $('.menu_mobile_icon.open').removeClass('hide');
        return false;
    });

    //End popup //

    // start menu hover //
    var hoverTimer;
    $(document).on('mouseenter', '.single_menu.has-mega', function () {
        var hotspot = $(this);
        hoverTimer = setTimeout(function () {
            $('.mega-menu').removeClass('active');
            $('#overlay_header').addClass('overlay_visible');
            $('html, body').css('overflow', 'hidden');
            hotspot.find(".mega-menu").addClass('active');
            // hotspot.find(".category_link").addClass('active');
        },);
    });
    $(document).on('mouseleave', '.single_menu.has-mega', function () {
        clearTimeout(hoverTimer);
        $('.mega-menu').removeClass('active');
        $('.category_link').removeClass('active');
        $('#overlay_header').removeClass('overlay_visible');
        $('html, body').css('overflow', 'visible');
    });


    $('.single_menu_list').on('mouseenter', function () {
        var menu = $(this).data('menu'); /* get the image, based on the data attribute (data-image) */
        $('#overlay_header').addClass('overlay_visible');
        $('html, body').css('overflow', 'hidden');
        $('.single_menu_list').removeClass('active');
        $('.single_menu_list_sub').removeClass('active'); /* remove the active class of all .image-info divs */
        $('.single_menu_list_img').removeClass('active'); /* remove the active class of all .image-info divs */
        $(this).addClass('active');
        $('.' + menu).addClass('active'); /* add the active class to the right div */
    });


    //mobile
    $(document).on('click', '.single_menu_mob.has-mega .category_link', function () {
        $(this).addClass('active');
        $(this).next('.mega-menu').addClass('active');
    });
    $(document).on('click', '.single_menu_list', function () {
        $('#overlay_header').removeClass('overlay_visible');
        $(this).next('.single_menu_list_sub').addClass('active');
    });
    $(document).on('click', '.back_menu_button', function () {
        $('.single_menu_list.has-mega').removeClass('active');
        $('.single_menu_list_sub').removeClass('active'); /* remove the active class of all .image-info divs */
    });

    // End menu hover //





    // start myaccount hover //
    var hoverTimer;
    $('.my_account_list').slideUp();
    $(document).on('mouseenter', '.side_left .my_account', function () {
        hoverTimer = setTimeout(function () {
            $('.my_account_list').slideDown();
            $('.title_myaccount').addClass('active');
        }, 500);
    });

    $(document).on('mouseleave', '.side_left .my_account', function () {
        clearTimeout(hoverTimer);
        $('.my_account_list').slideUp();
        $('.title_myaccount').removeClass('active');
    });
    // End myaccount hover //

    //start dropdown faq //
    $(document).on('click', '.single_faq:not(.active) .title_faq', function () {
        $('.single_faq').removeClass('active');
        $('.single_faq .content_faq').slideUp(500);
        $(this).next().slideDown(500);
        $(this).parent().addClass('active');
    });
    $(document).on('click', '.single_faq.active .title_faq', function () {
        $(this).next().slideUp(500);
        $(this).parent().removeClass('active');
    });
    //End dropdown faq //


    // start page filter ///
    // $(document).on('click', '.form-checkbox .category_link', function () {
    //     // $('.form-checkbox').removeClass('active');
    //     $(this).parent().addClass('active');
    // });
    // $(document).on('click', '.form-checkbox.active .category_link', function () {
    //     $(this).parent().removeClass('active');
    //     // $('.form-checkbox').removeClass('active');
    // });
    //End page filter //


    //start reviews_form //
    $(document).on('click', '.button-submit-review:not(.active)', function () {
        $('#reviews_form').slideUp(300);
        $(this).next().slideDown(300);
        $(this).addClass('active');
    });
    $(document).on('click', '.button-submit-review.active', function () {
        $(this).next().slideUp(300);
        $(this).removeClass('active');
    });
    //End reviews_form //


    // start Mobile Nav ///
    $(document).on("click", ".menu_mobile_icon.open", function () {
        $(this).addClass('hide');
        $('.menu_mobile_icon.close').addClass('show');
        $(".mobile-nav").addClass("active");
        $('#overlay_header_mob').addClass('overlay_visible');
        $('html, body').css('overflow', 'hidden');
        return false;
    });
    $(document).on("click", ".menu_mobile_icon.close", function () {
        $(this).removeClass('show');
        $('.menu_mobile_icon.open').removeClass('hide');
        $(".mobile-nav").removeClass("active");
        $('#overlay_header_mob').removeClass('overlay_visible');
        $('html, body').css('overflow', 'visible');
        return false;
    });

    $(".overlay").on("click", function () {
        $(this).removeClass('show');
        $('.menu_mobile_icon.open').removeClass('hide');
        $(".mobile-nav").removeClass("active");
        $('#overlay').removeClass('overlay_visible');
        $('html, body').css('overflow', 'visible');
        $('#popup-banner').removeClass('popup_visible');
        
    });
    $(".overlay_header_mob").on("click", function () {
        $(this).removeClass('show');
        $('.menu_mobile_icon.open').removeClass('hide');
        $(".mobile-nav").removeClass("active");
        $('#overlay').removeClass('overlay_visible');
        $('html, body').css('overflow', 'visible');
    });


    // $(document).on("click", ".mobile-menu .menu-item-has-children:not(.active) .menu-trigger", function () {
    //     $(this).parent().addClass('active').siblings().removeClass('active');
    //     $(this).parent().find('.list_subcategory_mobile').slideDown();
    //     $(this).parent().find('.list_subcategory_mobile').slideDown();
    //     $(this).parent().closest('.menu-item-has-children').siblings().find('.list_subcategory_mobile').slideUp();
    //     return false;
    // });

    // $(document).on("click", ".mobile-menu .menu-item-has-children.active .menu-trigger", function () {
    //     $(this).parent().removeClass('active');
    //     $(this).parent().find('.list_subcategory_mobile').slideUp();
    //     return false;
    // });


    $(document).on('click', '.section_search .icon', function () {
        // $('.form-checkbox').removeClass('active');
        $(this).parent().addClass('active');
        $(this).next().slideDown();
    });
    $(document).on('click', '.section_search.active .icon', function () {
        $(this).parent().removeClass('active');
        $(this).next().slideUp();
        // $('.form-checkbox').removeClass('active');
    });
    $(document).on('click', '.new_search .icon_search', function () {
        $('.search-popup').addClass('popup_visible');
        $('html, body').css('overflow', 'hidden');
        $('#overlay').addClass('overlay_visible');
        $(".mobile-nav").removeClass("active");
        $('#overlay_header_mob').removeClass('overlay_visible');
        $('.menu_mobile_icon.close').removeClass('show');
        $('.menu_mobile_icon.open').removeClass('hide');
    });

    // End Mobile Nav ///


    // start Sort  //
    if (window.location.href.indexOf("product-category") > -1) {
        $(window).scroll(function () {
            // var sticky = $(".sticky"),
            scroll = $(window).scrollTop();

            if (scroll >= 500)
                //   sticky.addClass("fixed"),
                $("body").addClass("sticky-filter"),
                    $(".dgwt-wcas-suggestions-wrapp").addClass("scrolled"),
                    $(".filter-tab").addClass("top");
            else
                //   sticky.removeClass("fixed"),
                $("body").removeClass("sticky-filter"),
                    $(".dgwt-wcas-suggestions-wrapp").removeClass("scrolled"),
                    $(".filter-tab").removeClass("top");
        });
    }

    $(document).on('click', '.section_ranking_custom .result_sort', function () {
        $(this).addClass('active');
        $(this).next().slideDown();
    });
    $(document).on('click', '.section_ranking_custom .result_sort.active', function () {
        $(this).removeClass('active');
        $(this).next().slideUp();
    });
    // $(document).on('click', '.section_ranking_custom .list_sort li ', function () {
    //     $('li').removeClass('active');
    //     $(this).addClass('active');
    //     $('.result_sort').removeClass('active');
    //     $(this).parent().slideUp();
    // });


    // End  Sort  //


    // start filter  //
    // $(document).on('click', '.more-cats-action .result', function () {
    //     $('.more-cats-action .result').addClass('active');
    //     $('.more-cats-action .all_form_checkbox').addClass('active');
    // });
    // $(document).on('click', '.more-cats-action .result.active', function () {
    //     $('.more-cats-action .result').removeClass('active');
    //     $('.more-cats-action .all_form_checkbox').removeClass('active');
    // });

    // $(document).on('click', '.more-colors .result', function () {
    //     $('.more-colors .result').addClass('active');
    //     $('.more-colors .all_form_checkbox').addClass('active');
    // });
    // $(document).on('click', '.more-colors .result.active', function () {
    //     $('.more-colors .result').removeClass('active');
    //     $('.more-colors .all_form_checkbox').removeClass('active');
    // });
    // End filter  //


    // start filter Mobile //

    // $(document).on('click', '.nav_filter.hidden_overlay .icon .sort', function () {
    //     $(this).addClass('active');
    //     $('.section_ranking').slideDown();
    //     // $('.form-checkbox').removeClass('active');
    // });
    // $(document).on('click', '.nav_filter.hidden_overlay .icon .sort.active', function () {
    //     $(this).removeClass('active');
    //     $('.section_ranking').slideUp();
    //     // $('.form-checkbox').removeClass('active');
    // });

    // $(document).on('click', '.nav_filter.show_overlay .icon .sort', function () {
    //     $(this).addClass('active');
    //     $('.section_ranking').slideDown();
    //     // $('.form-checkbox').removeClass('active');
    //     $('#overlay_sort').addClass('overlay_visible');
    //     $('html, body').css('overflow', 'hidden');
    // });
    // $(document).on('click', '.nav_filter.show_overlay .icon .sort.active', function () {
    //     $(this).removeClass('active');
    //     $('.section_ranking').slideUp();
    //     // $('.form-checkbox').removeClass('active');
    //     $('#overlay_sort').removeClass('overlay_visible');
    //     $('html, body').css('overflow', 'visible');
    // });

    // $(document).on('click', '#popup-filter .section_action .botton_filter', function () {
    //     $('.popup').removeClass('popup_visible');
    //     $('#overlay').removeClass('overlay_visible');
    //     $('html, body').css('overflow', 'visible');
    // });

    // if( $('.sectin_filter_sticky').length){
    //     var v = $('.sectin_filter_sticky').offset().top - 50;


    // $(document).scroll(function () {
    //    // console.log($(this).scrollTop() + ' // ' + v);
    //         if ($(this).scrollTop() >= $('.sectin_filter_sticky').offset().top - 50) {
    //             $(".section_filter_mobile").addClass("sticky");
    //             $(".nav_filter").removeClass("hidden_overlay");
    //             $(".nav_filter").addClass("show_overlay");
    //         } else {
    //             $(".section_filter_mobile").removeClass("sticky");
    //             $(".nav_filter").addClass("hidden_overlay");
    //             $(".nav_filter").removeClass("show_overlay");
    //         }
    //     });
    // }

    // // $(document).scroll(function(){
    // //     if($(this).scrollTop() >= $('.').offset().top - 50) {
    // //         $(".").css("background","red");
    // //     } else {
    // //         $(".").css("background","orange");
    // //     }
    // // });

    // $(document).on('click', '.section_filter_mobile .sorting .sortby', function () {
    //     $('.sortby').removeClass('active');
    //     $(this).addClass('active');
    //     $('.nav_filter.hidden_overlay .icon .sort.active').click();
    // });

    // End filter Mobile //



    // start select Branches //
    // $(document).on('click', '.single_city a', function() {
    //     var ths = $(this);
    //     var trgt = $($(this).attr('href'));
    //     $('.single_city').removeClass('active');
    //     $('.section_branches .branches').removeClass('active');
    //     $(this).parent().addClass('active');
    //     trgt.addClass('active');
    //     return false;
    // });
    $(document).on('click', '.single_branch', function () {
        var ths = $(this);
        var trgt = $($(this).attr('href'));
        $('.single_branch').removeClass('active');
        $(this).addClass('active');
        // $('.single_branch').removeClass('active');
        $('.section_map .single_map').removeClass('active');
        // $(this).parent().addClass('active');
        trgt.addClass('active');
        // get_map_ajax("filter", "desktop");
        return false;
    });

    // End select Branches //


    // start Page branches ///

    jQuery(".categories_branches").on("click", function () {
        $(".categories_branches.active").removeClass("active");
        $(this).addClass("active");
        $("#ajax_loader_branch").show();
        $(".list_branches").attr("data-page", 1);
        $(".list_branches").attr("data-cat",
            $(".categories_branches.active").attr('data-val'));
        // setTimeout(() => {
        //   $(".listing-product .section_title .title").html($(".categories_items.active").attr('data-title'));
        // }, 700);
        get_branche_ajax("filter", "desktop");
        return false;
    });
    // End Page Team ///


    // Checkout Change Shipping Method
    $(document).on('click', '.N_shipping_method .single_option', function () {
        $('.N_shipping_method .single_option').removeClass('active');
        $(this).addClass('active'); /* remove the active class of all .image-info divs */
        // $('.btn_next').removeClass('hidden_next');
    });

    $(document).on('click', '.N_delivery_time .single_option', function () {
        $('.N_delivery_time .single_option').removeClass('active');
        $(this).addClass('active'); /* remove the active class of all .image-info divs */
        // $('.btn_next').removeClass('hidden_next');
        if ($(this).hasClass('option_date')) {
            $('a.js-popup-opener[href="#popup-date"]').click();
            $('.popup.date').addClass('checkout');
        }
    });

    $(document).on('click', '.N_address .single_option', function () {
        $('.N_address .single_option').removeClass('active');
        $(this).addClass('active'); /* remove the active class of all .image-info divs */
        // $('.btn_next').removeClass('hidden_next');
    });






    $(document).on('click', '.new_downpayment_options .single_option', function () {
        $('.new_downpayment_options .single_option').removeClass('active');
        $(this).addClass('active'); /* remove the active class of all .image-info divs */
        // $('.btn_next').removeClass('hidden_next');
    });

    // $(document).on('click', '#btncheckout', function() {
    //     // Remove the 'active' class from elements with class 'col-1' and 'col-2'
    //     $(".col-1.active), .col-2.active)").removeClass("active");
    //     // Add the 'active' class to elements that don't have it
    //     $(".col-1:not(.active), .col-2:not(.active)").addClass("active");
    // });

    // $('#btncheckout').on('click' , function(e){
    //     e.preventDefault();
    //    // Remove the 'active' class from elements with class 'col-1' and 'col-2'
    //    $(".col-1.active, .col-2.active").removeClass("active");
    //    // Add the 'active' class to elements that don't have it
    //    $(".col-1:not(.active), .col-2:not(.active)").addClass("active");
    // });
    $('#back_step_checkout').on('click', function (e) {
        e.preventDefault();
        $('.col-1, .col-2').toggleClass('active');
        $('.breadcramb_checkout li:eq(1)').removeClass('visible').addClass('active');
        $('.breadcramb_checkout li:eq(2)').removeClass('active');
        $(window).scrollTop(0);
    });


});




// Placeholder for dropdowns
const $placeholder = $("select[placeholder]");
if ($placeholder.length) {
    $placeholder.each(function () {
        const $this = $(this);

        // Initial
        $this.addClass("placeholder-shown");
        const placeholder = $this.attr("placeholder");
        $this.prepend(`<option value="" selected>${placeholder}</option>`);

        // Change
        $this.on("change", (event) => {
            const $this = $(event.currentTarget);
            if ($this.val()) {
                $this.removeClass("placeholder-shown").addClass("placeholder-hidden");
            } else {
                $this.addClass("placeholder-shown").removeClass("placeholder-hidden");
            }
        });
    });
}




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
    } else {
        next_iput.attr("type", "password");
    }
});

//show small menu

$(document).on('click', '.menu-icon', function () {
    $(this).parent().addClass('active');
});

// $(document).on('click', 'body', function () {
//         $('.MD-menu.active').removeClass('active');
// });

$(document).on('click', '.press-btn', function () {
    $('.press-div').addClass('hide');
    $('.MD-thanks').addClass('show')
});

// ---------------------------------------------------Thanks Page Backend Functions -----------------------------
$(window).bind('load', function () {
    $(document).on('click', '.trending', function () {

        $('.trending').removeClass('active')
        $(this).addClass('active')
        let category_id = $(this).attr("data-cat");
        $('#ajax_loader').show();
        //alert(category_id);

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: mitch_ajax_url,
            data: {
                action: "change_category_selected",
                category_id: category_id,

            },
            success: function (data) {
                $('.trending-container').html(data.trending_product);
                $('#ajax_loader').hide();

            }
        })
    })
});
//------------------------------------------- End BackEnd Function --------------------

$(document).on('click', ' .txt:not(.active)', function () {
    $('.select_view').removeClass('active');
    $(this).addClass('active');
    $(this).parent().find('.select_view').addClass('active');
    $('.overlay-mobile').addClass('overlay_visible');

});

$(document).on('click', ' .txt.active', function () {
    $('.select_view').removeClass('active');
    $(this).removeClass('active');
    $(this).parent().find('.select_view').removeClass('active');
    $('.overlay-mobile').removeClass('overlay_visible');
});

$(document).on('click', ' .overlay-mobile', function () {
    $('.select_view').removeClass('active');
    $('.txt').removeClass('active');
    $('.select_view').removeClass('active');
    $('.overlay-mobile').removeClass('overlay_visible');
});


$(document).on('click', '.select_view li', function () {
    $('.overlay-mobile').removeClass('overlay_visible');
    val = $(this).text();
    $(this).siblings().removeClass('active');
    $(this).addClass('active');
    $(this).closest('.select-time').find('.txt span').text(val);
    $(' .txt').removeClass('active');
    setTimeout(function () {
        $('.select_view').removeClass('active');


    }, 200);
});

// ---------------------------------- Checkout Function  ---------------------------------------------
// $(document).on('updated_checkout', function () {
// at the end of cvv label
//     if (!$('#security-code').parent().find('label i').length) {
//       $('#security-code').parent().find('label').append('<i class="cvc-hint"><img src="https://www.cloudhosta.com:8000/wp-content/themes/glosscairo/assets/img/cvv-card.png" alt=""></i>')
//     }
// at the end of visa payment method label
//     if (!$('.wc_payment_method.payment_method_nodepayment label[for="payment_method_nodepayment"] div').length) {
//   if (lang == 'en') {
//     $('.wc_payment_method.payment_method_nodepayment label[for="payment_method_nodepayment"]').append('<div><i class="cvc-hint two"></i> <div class="content-bank"> <span>E-payment service provided by</span> <img src="https://www.cloudhosta.com:8000/wp-content/themes/glosscairo/assets/img/bank-misr.png"></div> </div>')
//   }
//   else {
// $('.wc_payment_method.payment_method_nodepayment label[for="payment_method_nodepayment"]').append('<div><i class="cvc-hint two"></i> <div class="content-bank"> <img src="https://www.cloudhosta.com:61/wp-content/themes/joula/assets/img/icons/visaicon.png"></div> </div>')

//   }
//     }
//   });
// ------------------------------- Checkout field Annimations And Style -----------------

/*
    $(document).ready(function() {
        setTimeout(
            function() 
            {
                $("#card-number").keyup(function() {
                    if($(this).val()[0] == '4'){
                      $('.form-row.cards').removeClass('master-card')
                     $('.form-row.cards').addClass('visa-card')
                    }
                    else{
                     $('.form-row.cards').removeClass('visa-card')
                     $('.form-row.cards').addClass('master-card')
                    }
                  })
            }, 9000);
     
    }) ;
*/

$('#message_fields input[name=add_gift_box]').change(function () {
    if ($(this).is(':checked')) {
        $('.checkbox').addClass('active');
    } else {
        $('.checkbox').removeClass('active');

    }
}).change();
