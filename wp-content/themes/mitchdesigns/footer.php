    <?php if(!is_checkout() && !get_post(3019)){ ?>
        <?php  include_once 'theme-parts/home/instgram-section.php';?>
    <?php } ?>

  <?php //include_once 'theme-parts/home/footer-banners.php';?>
  <!--start footer-->
  <footer>
      <?php include_once 'theme-parts/footer/desktop.php';?>
      <?php include_once 'theme-parts/footer/mobile.php';?>
  </footer>
  
    <a class="section_whatsapp" href="https://wa.me/201099335774">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icons/whatsapp.png" alt="" width="25" height="25">
    </a>
       
  <!--end footer-->
  <div id="overlay" class="overlay"></div>
  <div id="overlay_header" class="overlay_header"></div>
  <div id="overlay_header_mob" class="overlay_header_mob"></div>

  <div id="overlay_sort" class="overlay_sort"></div>
  <?php include_once 'theme-parts/popups.php';?>

  <?php
  $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
//   if (strpos($url,'myaccount') !== false) {
//     include_once 'theme-parts/MD-popups.php';
//   }
  
  ?>
<!-- Start Calendar -->
    <?php if(get_post(3019) || is_checkout() ) { ?>
        <div id="popup-date" class="popup date">
            <div class="popup__window select_date">
                    <div class="top">
                            <h3> <?php if($language == 'en'){echo 'Choose The Date' ; }else{echo 'اختار تاريخ الاستلام' ;} ?> </h3>
                            <button type="button" class="popup__close material-icons js-popup-closer">close</button>
                    </div>
                    <form class="section_content" method="post">
                            <div class="container">
                                    <div id="calendar1"></div>
                                    <div id="calendar2"></div>
                                    <div id="result_date">...</div>
                            </div>

                            <div class="section_time">
                                    <h3 class="section_title"> <?php if($language == 'en'){echo 'Time' ; }else{echo ' الوقت' ;} ?></h3>
                                    <div class="options time_option">
                                            <div class="s_option">
                                                    <select class="s_time" name="time" id="time_option">
                                                            <option value="false" disabled  > <?php if($language == 'en'){echo 'choose Time' ; }else{echo ' اختر الوقت' ;} ?>   </option>
                                                            <option value="1-4" selected> من 1:00 مساءً إلى 4:00 مساءً </option>
                                                            <option value="4-8"> من 4:00 مساءً إلى 8:00 مساءً </option>
                                                            <option value="8-12"> من 8:00 مساءً إلى 12:00 مساءً </option>
                                                    </select>
                                            </div>
                                    </div>
                            </div>
                            <div class="section_next_pop">
                                    <div class="next">
                                            <button type="button" id="add_custom_cake_to_cart" class="btn_add_cart disabled"> <?php if($language == 'en'){echo 'Add To Cart' ; }else{echo 'اتمام الطلب' ;} ?> </button>
                                            <div class="price">
                                                    <h6>الإجمالي</h6>
                                                    <p class = "total-cake-price">0.00 </p> <span>ج م </span> 
                                            </div>
                                    </div>
                                    <div class="prev">
                                            <button id="prevButton" type="button" class="js-popup-closer btn_prev"></button>
                                    </div>
                            </div>
                        
                    </form>
                    
            </div>
        </div>
        <script>
            // $('#calendar').datepicker({
            //         inline:true,
            //         firstDay: 1,
            //         showOtherMonths:true,
            //         dayNamesMin:['Sat','Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
            //         minDate: 0, // This sets the minimum selectable date to the current date
            //         onSelect: function(dateText) {
            //             $("#result_date").html(dateText);
            //             $(".N_delivery_time #date").val(dateText);
            //             $(".N_delivery_time #l-date").attr("for", dateText);
            //             $("#set-date").html(dateText);
            //             $(".option_date").addClass('e_show');
                        
            //             //close pop calendar
            //             $("#popup-date").removeClass('popup_visible');
            //             $("#overlay").removeClass('overlay_visible');
            //             $('html, body').css('overflow', 'visible');
            //         }
            //     });

            
                // First calendar
                    $('#calendar1').datepicker({
                        inline: true,
                        firstDay: 1,
                        showOtherMonths: true,
                        dayNamesMin: ['Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
                        minDate: 2,
                        onSelect: function(dateText) {
                            $("#result_date").html(dateText);
                            $("#add_custom_cake_to_cart").removeClass('disabled');

                        }
                    });

                // Second calendar
                $('#calendar2').datepicker({
                    inline: true,
                    firstDay: 1,
                    showOtherMonths: true,
                    dayNamesMin: ['Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
                    minDate: 1,
                    onSelect: function(dateText) {
                        $(".N_delivery_time #date").val(dateText);
                        $(".N_delivery_time #l-date").attr("for", dateText);
                        $("#billing-delivery-date").html(dateText);
                        $("#billing_delivery_date").html(dateText);
                        $("#set-date").html(dateText);
                        $(".option_date").addClass('e_show');

                        //close pop calendar
                        $("#popup-date").removeClass('popup_visible');
                        $("#overlay").removeClass('overlay_visible');
                        $('html, body').css('overflow', 'visible');
                    }
                });

        </script>
    <?php } ?>
<!-- End Calendar -->
<div id="popup-banner" class="popup banner">
  <div class="popup__window banner">
    <button type="button" class="popup__close material-icons js-popup-closer">close</button>
      <img src="<?php echo $theme_settings['theme_url']; ?>/assets/img/pop_up.png" alt="popup alt"/>
  </div>
</div>
<div id="popup-promocode" class="popup promocode">
    <div class="popup__window promocode">
        <button type="button" class="popup__close material-icons js-popup-closer close_mobile">close</button>
            <div class="section_content">
                <div class="sec_img">
                    <img src="https://cloudhosta.com:63/wp-content/uploads/2023/03/unsplash_QNyRp21hb5I_2_11zon_2_11zon.jpg" alt="">
                </div>
                <form class="section_form" action="">
                    <div class="top">
                        <h3> <?php if($language == 'en'){echo 'Subscribe to us and get 10% off your first order' ; }else{echo 'اشترك معنا لدينا واحصل على خصم 10٪ على طلبك الأول' ;} ?> </h3>
                        <button type="button" class="popup__close material-icons js-popup-closer">close</button>
                    </div>
                    <div class="s_field half_full">
                        <label for=""><?php if($language == 'en'){echo 'First Name' ; }else{echo 'الاسم الاول' ;} ?><span>*</span></label>
                        <input type="text" name="first_name" required>
                    </div>
                    <div class="s_field half_full">
                        <label for=""><?php if($language == 'en'){echo 'Last Name' ; }else{echo 'الاسم الاخير' ;} ?><span>*</span></label>
                        <input type="text" name="last_name" required>
                    </div>
                    <div class="s_field">
                        <label for=""><?php if($language == 'en'){echo 'Email' ; }else{echo 'البريد الالكتروني' ;} ?><span>*</span></label>
                        <input type="email" name="user_email" required>
                    </div>
                    <div class="s_field">
                        <label for=""><?php if($language == 'en'){echo 'Phone Number' ; }else{echo 'رقم الهاتف' ;} ?><span>*</span></label>
                        <input type="text" name="phone_number" required>
                    </div>
                    <div class="section_bottom">
                        <div class="s_field checkbox">
                                <input type="checkbox" id="agree" name="agree" data-price = "" value="">
                                <label for="agree">  <?php if($language == 'en'){echo 'I agree to the Privacy Policy and Terms of Service.' ; }else{echo 'بالاشتراك ، أوافق على سياسة الخصوصية وشروط الخدمة.' ;} ?>  </label>
                        </div>
                        <div class="button">
                                <button id="" type="button">
                                    <?php if($language == 'en'){echo 'Subscribe' ; }else{echo 'أشترك' ;} ?>
                                </button>
                        </div>
                    </div>
                </form>
            </div>
           
    </div>
</div>



  <script src="<?php echo $theme_settings['theme_url'];?>/assets/js/jquery-3.2.1.min.js"></script>
  <!-- <script src="<?php echo $theme_settings['theme_url'];?>/assets/js/jquery.cookie.js"></script> -->
  <script src="<?php echo $theme_settings['theme_url'];?>/assets/js/main.js?nocash=1"></script>
  <script src="<?php echo $theme_settings['theme_url'];?>/assets/js/branches.js"></script>

  
  <!-- <script type="text/javascript" src="<?php //echo get_stylesheet_directory_uri(); ?>/assets/js/jquery.ez-plus.js"></script> -->
  <!-- <script src="<?php //echo get_stylesheet_directory_uri(); ?>/assets/js/jquery.elevatezoom.js"></script> -->
  <!-- <script type="text/javascript">
mqList = window.matchMedia("(min-width: 999px)");
if (mqList.matches) {
    $('.slider-main-img').ezPlus({
        zoomWindowFadeIn: 500,
        zoomWindowFadeOut: 500,
        lensFadeIn: 500,
        lensFadeOut: 500,
        zoomWindowPosition: 10,
        zoomType: 'lens',
    lensShape: 'round',
    lensSize: 200
    });

    
}
  </script> -->
  <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/aos.js"></script>
  <!-- <script>
$(".zoom").elevateZoom({
    zoomType: "inner",
    cursor: "crosshair",
    easing: true,
});
  </script> -->
  <script>
AOS.init();
if ($('body').hasClass('rtl')) {
    var is_ar = false;
} else {
    var is_ar = true;
}
  </script>
  <?php if(is_product_category() || is_shop()){?>
  <script>
jQuery(function($) {
  $(window).bind('load',function () {
    get_products_ajax_count();
  });
});
  </script>
  <?php  }?>
  <script src="<?php echo $theme_settings['theme_url'];?>/assets/js/slick.min.js" defer></script>
  <script>
var mitch_ajax_url = '<?php echo admin_url('admin-ajax.php');?>';
  </script>
  <script src="<?php echo $theme_settings['theme_url'];?>/backend_functions.js?no_cash=1"></script>
  <script type="text/javascript">
$(document).ready(function() {
    $('#gsearch').keyup(function() {
        var searchField = $(this).val();
        if (searchField === '') {
            $('#search_results').html('');
            $('#search_results').hide('slow');
            return;
        }
        $('#search_results').show('slow');
        var regex = new RegExp(searchField, "i");
        var output = '<div class="row">';
        var count = 1;

        $.each(data, function(key, val) {
            if ((val.sku.search(regex) != -1) || (val.product_name.search(regex) != -1)) {
                output += '<a href="' + val.product_url + '"><div class="col-md-6 well">';
                output +=
                    '<div class="col-md-3"><img class="img-responsive" width="80px" src="' + val
                    .product_image + '" alt="' + val.product_name + '" /></div>';
                output += '<div class="col-md-7">';
                output += '<h5>' + val.product_name + '</h5><h6>' + val.product_price + '</h6>';
                output += '</div>';
                output += '</div></a>';
                if (count % 2 == 0) {
                    output += '</div><div class="row">'
                }
                count++;
            }
        });
        if (count == 1) {
            output += '<div class="not_results">Sorry, Not Found Any Result!</div>';
        }
        output += '</div>';
        $('#search_results').html(output);
    });
});
var divToHide = document.getElementById('search_results');
if (divToHide) {
    document.onclick = function(e) {
        if (e.target.id !== 'search_results') {
            //element clicked wasn't the div; hide the div
            divToHide.style.display = 'none';
        }
    };
}
  </script>
  <script>
function copyText() {

    /* Copy text into clipboard */
    navigator.clipboard.writeText("www.exception.com/ref=1-02o0;20409");
    $('.copied-message').addClass('active');
    setTimeout(() => {
		$('.copied-message').removeClass('active');
	}, 1000);
    
}

  </script>
  <?php
  wp_footer();
     if(is_checkout()){ ?>
  <script>
jQuery(function($) {
    jQuery(document).on('submit', '.checkout_coupon', function(e) {
        // Get the coupon code
        var code = jQuery('#coupon_code').val();
        var data = {
            coupon_code: code,
            security: '<?php echo wp_create_nonce("apply-coupon") ?>'
        };
        $.ajax({
            method: 'post',
            url: '/?wc-ajax=apply_coupon',
            data: data,
            success: function(data) {
                jQuery('.woocommerce-notices-wrapper').html(data);
                jQuery(document.body).trigger('update_checkout');
            }
        });
        e.preventDefault(); // prevent page from redirecting
    });
});
jQuery('.validate-required').removeClass('.woocommerce-invalid');
  </script>
  <!-- <style>
        .page_checkout .grid .checkout-content #customer_details .form-row.woocommerce-invalid .input-text {border: 1px solid #222 !important;}
      </style> -->
  <?php //wp_footer();?>
  <?php }
      // if(isset($_GET['filter'])){
      //   if(wp_is_mobile()){
      //     ?>
  <script>
//get_products_ajax("", "mobile");
  </script>
  <?php 
      //   }else{
      //     ?>
  <script>
//get_products_ajax("", "desktop");
  </script>
  <?php 
      //   }
      // }
      ?>
  <script>
/*jQuery('.select2').select2({
          placeholder: 'Select an option'
        });*/
$.ajax({
    type: 'POST',
    dataType: 'JSON',
    url: $('body').attr("data-mitch-ajax-url"),
    data: {
        action: "get_cart_content_fresh",
        lang : current_lang ,
    },
    success: function(data) {
        $('#cart_total_count').html(data.cart_count);
        $('.non-fixed').html(data.cart_content);
        if (data.cart_count == 0) {
            $('#side_mini_cart_content').addClass('empty');
        } else {
            $('#side_mini_cart_content').removeClass('empty');
        }

    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
        //alert("Error:" + errorThrown); //"Status: " + textStatus +
        //$('#ajax_loader').hide();
    }
});
$('input[name="delivery_date"]:radio').change(function() {
    $(".radio-btns label").removeClass("selected");
    $("input[name='delivery_date']:checked").parent().addClass("selected");
    $("body").trigger("update_checkout");
});

</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  </body>

  </html>