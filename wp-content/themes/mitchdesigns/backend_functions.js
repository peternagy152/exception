var mitch_home_url     = $('body').attr("data-mitch-home-url");
var mitch_ajax_url     = $('body').attr("data-mitch-ajax-url");
var mitch_logged_in    = $('body').attr("data-mitch-logged-in");
var mitch_current_lang = $('body').attr("data-mitch-current-lang");
const urlParams = new URLSearchParams(window.location.search);
var current_lang = urlParams.get('lang');
if(!current_lang){
  current_lang = 'ar';
}



function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function eraseCookie(name) {
  document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

eraseCookie('current_language');
setCookie('current_language' , current_lang , 7);


//solve issue of slick slider when reload page it's not work
jQuery('.slider-nav').addClass('active');
// jQuery('.product-slider').addClass('active');
$('.product-slider').on('beforeChange', function(event, slick, currentSlide, nextSlide){
  $('.slider-nav img').removeClass('active');
  $('.slider-nav-img-'+nextSlide).addClass('active');
  //console.log(nextSlide);
});
function mitch_show_error(element_id, error_msg){
  // alert('HIFromError');
  $('#'+element_id).html(error_msg);
  $('#'+element_id).show('slow');
}
function mitch_show_error(element_id){
  $('#'+element_id).html('');
  $('#'+element_id).hide('slow');
}
function mitch_ajax_request(ajax_url, ajax_action, form_data, error_element_id, success_alert_type = 'none'){
  $('#ajax_loader').show();
  $.ajax({
    type: 'POST',
    dataType: 'JSON',
    url: ajax_url,
    data: {
      action: ajax_action,
      form_data: form_data,
      lang : current_lang ,
    },
    success: function (data) {
      //alert('form was submitted');
      $('#ajax_loader').hide();
      if(data.status == 'success'){
        if(data.redirect_to){
          window.location.replace(data.redirect_to);
        }
        if(data.cart_count){
          $('#cart_total_count').html(data.cart_count);
        }
        if(data.cart_total){
          $('#cart_total').html(data.cart_total);
        }
        if(data.cart_content){
          $('#side_mini_cart_content').html(data.cart_content);
          $('.js-popup-opener[href="#popup-min-cart"]').click();
        }
        if(success_alert_type == 'popup'){
         
        }else{
          if(data.msg){
            $('#'+error_element_id).html('<div class="alert alert-success">Done '+data.msg+'</div>');
            $('#'+error_element_id).show('slow');
            $("html, body").animate({ scrollTop: 0 }, "slow");
          }
        }
      } else if(data.status == 'error'){

        $('.callback-message').addClass('show-message');
        $('.callback-message').addClass('error-message');
        $('.callback-message').removeClass('success-message');

        $('.message-info').html('<p>' + data.msg + '</p>');
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      // alert("Error:" + errorThrown); //"Status: " + textStatus +
      $('#ajax_loader').hide();
      // Swal.fire({
      //   title: 'Sorry, There is an issue!',
      //   text: errorThrown,
      //   icon: 'error',
      //   showConfirmButton: false,
      //   timer: 1500
      // });
      $('#'+error_element_id).html('<div class="alert alert-danger">Sorry There is an issue!</div>');
      $('#'+error_element_id).show('slow');
    }
  });
}
if(mitch_ajax_url){
  console.log("Backend Function Here!");

  $('#register_form').on('submit', function (e) {
    e.preventDefault();
    $('#ajax_loader').show();
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: mitch_ajax_url,
      data: {
        action: "mitch_register_users",
        form_data: $(this).serialize(),
        lang : current_lang ,
      },
      success: function (data) {
        //alert('form was submitted');
        $('#ajax_loader').hide();
        if(data.status == 'success'){
          if(data.redirect_to){
            window.location.replace(data.redirect_to);
          }
        } else if(data.status == 'error'){
          $('#register_form_alerts').show();
          $('#register_form_alerts').html(data.msg);

        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        // alert("Error:" + errorThrown); //"Status: " + textStatus +
        $('#ajax_loader').hide();
        // Swal.fire({
        //   title: 'Sorry, There is an issue!',
        //   text: errorThrown,
        //   icon: 'error',
        //   showConfirmButton: false,
        //   timer: 1500
        // });
      }
    });
  });

  $('#login_form').on('submit', function (e) {
    e.preventDefault();
    var element_id = 'callback-message';
    var email      = $('#login_email').val();
    var pass       = $('#login_password').val();
    if(email != '' && pass != ''){
      mitch_ajax_request(mitch_ajax_url, 'mitch_login_users', $(this).serialize(), element_id);
    }else{
      if(email == ''){
        $('.callback-message').addClass('show-message');
        $('.callback-message').addClass('error-message');
        $('.callback-message').removeClass('success-message');


        if(current_lang == 'ar'){
          var error_msg  = 'يجب ادخال البريد الاكتروني';
        }else{
          var error_msg  = 'Sorry, Email is required!';
        }
        $('.message-info').html('<p>' + error_msg + '</p>');
      }
      if(pass == ''){
        if(current_lang == 'ar'){
          var error_msg  = 'Password is Required ! ';
        }else{
          var error_msg  = 'يجب ادخال كلمة السر !';
        }
        $('.callback-message').removeClass('success-message');
         $('.callback-message').addClass('show-message');
          $('.callback-message').addClass('error-message');

          if(current_lang == 'ar'){
            var error_msg  = 'يجب ادخال البريد الاكتروني';
          }else{
            var error_msg  = 'Sorry, Email is required!';
          }
        $('.message-info').html('<p>' + error_msg + '</p>');
      }
    }
  });

  function cart_remove_item(cart_item_key, product_id, type = 'cart_page'){
    $('#ajax_loader').show();
    
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: mitch_ajax_url,
      data: {
        action: "cart_remove_item",
        cart_item_key: cart_item_key,
        product_id: product_id ,
        lang : current_lang ,
      },
      success: function (data) {
        if(product_id){
          $('#'+product_id).remove();
          let product_class = ".section_count.product_" + product_id ;
          $(product_class).hide();
           $('.icon_add[data-product_id="'+[product_id]+'"]');
          $('.icon_add.product_'+product_id).show();
          $('.icon_add.product_'+product_id).data("quantity","0");
          $('.decrease_'+product_id).addClass('disabled');
          $('.header_total').html(data.cart_total);


        }
        if(cart_item_key){
          $('#cart_page_'+cart_item_key).remove();
          $('#mini_cart_'+cart_item_key).remove();
        }
        $('#cart_total_count').html(data.cart_count);
        $('#cart_total').html(data.cart_total);
        $('.non-fixed').html(data.cart_content);
        if(data.cart_count == 0) {
          $('#side_mini_cart_content').addClass('empty');
        }
        else{
          $('#side_mini_cart_content').removeClass('empty');
        }
        // alert(data.result);
        if(data.cart_count == 0 && type == 'cart_page'){
          // Simulate an HTTP redirect:
          window.location.replace(mitch_home_url);
        }
        // alert('تم حذف المنتج من سلة المنتجات بنجاح.');
        $('#ajax_loader').hide();
        // Swal.fire({
        //   title: 'تم بنجاح',
        //   text: 'حذف المنتج من سلة المنتجات',
        //   icon: 'success',
        //   showConfirmButton: false,
        //   timer: 1500
        // });
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        // alert("Error:" + errorThrown); //"Status: " + textStatus +
        $('#ajax_loader').hide();
        // Swal.fire({
        //   title: 'Sorry',
        //   text: errorThrown,
        //   icon: 'error',
        //   showConfirmButton: false,
        //   timer: 1500
        // });
      }
    });
  }

  function update_cart_items(cart_item_key, location, max_quantity , product_id){
    $('#ajax_loader').show();
    if(location == 'cart_page'){
      var quantity_number = $('#cart_page_'+cart_item_key+' .number_count').val();
    }else if(location == 'mini_cart'){
      var quantity_number = $('#mini_cart_'+cart_item_key+' .number_count').val();
    }else {
      const myArray = location.split("_");
      var quantity_number = Number(myArray[1]);
    }
    // if(quantity_number > max_quantity){
    //   $('#ajax_loader').hide();
    //   Swal.fire({
    //     title: 'Sorry',
    //     text: 'You exceeded the product stock limit!',
    //     icon: 'error',
    //     showConfirmButton: false,
    //     timer: 1500
    //   });
    // } else 
     {
      $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
          action: "update_cart_items",
          cart_item_key: cart_item_key,
          quantity_number: quantity_number,
          lang : current_lang ,
          product_id: product_id
        },
        success: function (data) {
          
          $('.icon_add.product_'+product_id).data("quantity",quantity_number);
          $('.number_'+ product_id).attr("value" , quantity_number);
          if(quantity_number == 1 ){
            $('.decrease_'+product_id).addClass('disabled');
          }

          $('#cart_total_count').html(data.cart_count);
          $('#cart_total').html(data.cart_total);
          $('#line_subtotal_'+cart_item_key).html(data.item_total);
          $('.non-fixed').html(data.cart_content);
          $('.header_total').html(data.cart_total);

          // alert('تم تعديل سلة المنتجات بنجاح!');
          $('#ajax_loader').hide();
          // Swal.fire({
          //   title: 'تم بنجاح',
          //   text: 'تعديل سلة المنتجات',
          //   icon: 'success',
          //   showConfirmButton: false,
          //   timer: 1500
          // });
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          // alert("Error:" + errorThrown); //"Status: " + textStatus +
          $('#ajax_loader').hide();
          // Swal.fire({
          //   title: 'Sorry There is an issue!',
          //   text: errorThrown,
          //   icon: 'error',
          //   showConfirmButton: false,
          //   timer: 1500
          // });
        }
      });
    }
    
  }

  // var links = document.getElementsByTagName('a');
  // // alert(links.length);
  // for(var i = 0; i< links.length; i++){
  //   alert(links[i].href);
  // }
  /*
  $('#apply_coupon').on('click', function () {
    $('#ajax_loader').show();
    var coupon_code = $('#coupon_code').val();
    if(coupon_code){
      $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
          action: "mitch_apply_coupon",
          coupon_code: coupon_code,
          coupon_from: 'cart'
        },
        success: function (data) {
          //alert('form was submitted');
          $('#ajax_loader').hide();
          if(data.status == 'success'){
            // Swal.fire({
            //   title: 'تم بنجاح',
            //   text: 'تطبيق كوبون الخصمم!',
            //   icon: 'success',
            //   showConfirmButton: false,
            //   timer: 1500
            // });
            if(data.cart_total){
              $('#cart_total').html(data.cart_total);
            }
            if(data.redirect_to){
              window.location.replace(data.redirect_to);
            }
          } else if(data.status == 'error'){
            if(data.code == 401){
              Swal.fire({
                title: 'Sorry',
                text: data.msg,
                icon: 'error',
                showConfirmButton: true,
                // timer: 1500
              });
            }else{
              Swal.fire({
                title: 'Sorry',
                text: data.msg,
                icon: 'error',
                showConfirmButton: false,
                timer: 1500
              });
            }
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          // alert("Error:" + errorThrown); //"Status: " + textStatus +
          $('#ajax_loader').hide();
          Swal.fire({
            title: 'Sorry There is an issue!',
            text: errorThrown,
            icon: 'error',
            showConfirmButton: false,
            timer: 1500
          });
        }
      });
    }else{
      $('#ajax_loader').hide();
      Swal.fire({
        title: 'Sorry',
        text: 'Coupon code is required!',
        icon: 'error',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
  */
  $('#remove_coupon').on('click', function () {
    $('#ajax_loader').show();
    var coupon_code = $('#coupon_code').val();
    if(coupon_code){
      $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
          action: "mitch_remove_coupon",
          coupon_code: coupon_code,
          coupon_from: 'cart' ,
          lang : current_lang , 
        },
        success: function (data) {
          //alert('form was submitted');
          $('#ajax_loader').hide();
          if(data.status == 'success'){
            $('#apply_coupon').show();
            $('#remove_coupon').hide();
            $('.list_pay.discount').hide();
            document.getElementById('coupon_code').value = '';
            // Swal.fire({
            //   title: 'تم بنجاح',
            //   text: 'ازالة كوبون الخصم!',
            //   icon: 'success',
            //   showConfirmButton: false,
            //   timer: 1500
            // });
            if(data.cart_total){
              $('#cart_total').html(data.cart_total);
            }
            $.ajax({
              type: 'POST',
              dataType: 'JSON',
              url: $('body').attr("data-mitch-ajax-url"),
              data: {
                action: "get_cart_content_fresh",
                lang : current_lang ,
              },
              success: function (data) {
                $('#cart_total_count').html(data.cart_count);
                $('.non-fixed').html(data.cart_content);
              },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
                //alert("Error:" + errorThrown); //"Status: " + textStatus +
                //$('#ajax_loader').hide();
              }
            });
            if(data.redirect_to){
              window.location.replace(data.redirect_to);
            }
          } else if(data.status == 'error'){
            if(data.code == 401){
              // Swal.fire({
              //   title: 'Sorry',
              //   text: data.msg,
              //   icon: 'error',
              //   showConfirmButton: true,
              //   // timer: 1500
              // });
            }else{
              // Swal.fire({
              //   title: 'Sorry',
              //   text: data.msg,
              //   icon: 'error',
              //   showConfirmButton: false,
              //   timer: 1500
              // });
            }
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          // alert("Error:" + errorThrown); //"Status: " + textStatus +
          $('#ajax_loader').hide();
          // Swal.fire({
          //   title: 'Sorry There is an issue!',
          //   text: errorThrown,
          //   icon: 'error',
          //   showConfirmButton: false,
          //   timer: 1500
          // });
        }
      });
    }else{
      $('#ajax_loader').hide();
      // Swal.fire({
      //   title: 'Sorry',
      //   text: 'لا يوجد كود خصم!',
      //   icon: 'error',
      //   showConfirmButton: false,
      //   timer: 1500
      // });
    }
  });

  function add_product_to_wishlist(product_id, refresh_page = 'NULL'){
    if(mitch_logged_in == 'yes'){
      $('#ajax_loader').show();
      $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
          action: 'add_product_to_wishlist',
          product_id: product_id,
        },
        success: function (data) {
          $('#ajax_loader').hide();
          if(data.status == 'success'){
            $('#product_'+product_id+'_block .fav_btn').attr("onclick","remove_product_from_wishlist("+product_id+")");
            $('#product_'+product_id+'_block .fav_btn').removeClass('not-favourite');
            $('#product_'+product_id+'_block .fav_btn').addClass('favourite');
            if(refresh_page == 'yes'){
              location.reload();
            }
            // Swal.fire({
            //   title: 'تم بنجاح',
            //   text: 'اضافة المنتج لقائمة المفضلة',
            //   icon: 'success',
            //   showConfirmButton: false,
            //   timer: 1500
            // });
          }else{
            // Swal.fire({
            //   title: 'Sorry There is an issue!',
            //   text: '',
            //   icon: 'error',
            //   showConfirmButton: false,
            //   timer: 1500
            // });
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          $('#ajax_loader').hide();
          // Swal.fire({
          //   title: 'Sorry There is an issue!',
          //   text: errorThrown,
          //   icon: 'error',
          //   showConfirmButton: false,
          //   timer: 1500
          // });
        }
      });
    }else{
      var host = window.location.origin;
      window.location.href = host + '/myaccount/user-login.php';
    }
  }

  function remove_product_from_wishlist(product_id, remove_block = 'NULL', refresh_page = 'NULL'){
    $('#ajax_loader').show();
    // alert(product_id);
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: mitch_ajax_url,
      data: {
        action: 'remove_product_from_wishlist',
        product_id: product_id,
      },
      success: function (data) {
        $('#ajax_loader').hide();
        if(data.status == 'success'){
          $('#product_'+product_id+'_block .fav_btn').attr("onclick","add_product_to_wishlist("+product_id+")");
          $('#product_'+product_id+'_block .fav_btn').removeClass('favourite');
          $('#product_'+product_id+'_block .fav_btn').addClass('not-favourite');
          if(remove_block == 'yes'){
            $('#product_'+product_id+'_block').remove();
          }
         // if(refresh_page == 'yes'){
            location.reload();
          //}
          // Swal.fire({
          //   title: 'تم بنجاح',
          //   text: 'ازالة المنتج من قائمة المفضلة',
          //   icon: 'success',
          //   showConfirmButton: false,
          //   timer: 1500
          // });
        }else{
          // Swal.fire({
          //   title: 'Sorry There is an issue!',
          //   text: '',
          //   icon: 'error',
          //   showConfirmButton: false,
          //   timer: 1500
          // });
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        $('#ajax_loader').hide();
        // Swal.fire({
        //   title: 'Sorry There is an issue!',
        //   text: errorThrown,
        //   icon: 'error',
        //   showConfirmButton: false,
        //   timer: 1500
        // });
      }
    });
  }
  // alert(mitch_logged_in);

  $('.load_form_data').on('click', function () {
    $("#address_id").val($(this).data('id'));
    $("#country").val($(this).data('country'));
    $("#city").val($(this).data('city'));
    $("#building").val($(this).data('building'));
    $("#street").val($(this).data('street'));
    $("#area").val($(this).data('area'));
    $("#operation").val('edit_address');
  });
  $('.add_new_address').on('click', function () {
    $('#edit_address')[0].reset();
    $("#operation").val('add_address');
    $("#address_id").val('');
  });
  $('#edit_address').on('submit', function (e) {
    e.preventDefault();
    $('#ajax_loader').show();
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: mitch_ajax_url,
      data: {
        action: "mitch_edit_address",
        form_data: $(this).serialize(),
      },
      success: function (data) {
        //alert('form was submitted');
        $('#ajax_loader').hide();
        if(data.status == 'success'){
          // Swal.fire({
          //   title: 'تم بنجاح',
          //   text: 'حفظ بيانات العنوان',
          //   icon: 'success',
          //   showConfirmButton: false,
          //   timer: 1500
          // });
          location.reload();
        }
        if(data.status == 'error'){
          // Swal.fire({
          //   title: 'Sorry There is an issue!',
          //   text: errorThrown,
          //   icon: 'error',
          //   showConfirmButton: false,
          //   timer: 1500
          // });
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        // alert("Error:" + errorThrown); //"Status: " + textStatus +
        $('#ajax_loader').hide();
        // Swal.fire({
        //   title: 'Sorry There is an issue!',
        //   text: errorThrown,
        //   icon: 'error',
        //   showConfirmButton: false,
        //   timer: 1500
        // });
      }
    });
  });

  $('#cancel_order_form').on('submit', function (e) {
    e.preventDefault();
    $('#ajax_loader').show();
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: mitch_ajax_url,
      data: {
        action: "mitch_cancel_order",
        form_data: $(this).serialize(),
      },
      success: function (data) {
        //alert('form was submitted');
        $('#ajax_loader').hide();
        if(data.status == 'success'){
          if(data.redirect_to){
            window.location.replace(data.redirect_to);
          }
        } else if(data.status == 'error'){
          if(data.code == 401){
            // Swal.fire({
            //   title: 'Sorry',
            //   html: data.msg,
            //   icon: 'error',
            //   showConfirmButton: true,
            //   // timer: 1500
            // });
          }else{
            // Swal.fire({
            //   title: 'Sorry',
            //   text: data.msg,
            //   icon: 'error',
            //   showConfirmButton: false,
            //   timer: 1500
            // });
          }
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        // alert("Error:" + errorThrown); //"Status: " + textStatus +
        $('#ajax_loader').hide();
        // Swal.fire({
        //   title: 'Sorry There is an issue!',
        //   text: errorThrown,
        //   icon: 'error',
        //   showConfirmButton: false,
        //   timer: 1500
        // });
      }
    });
  });

  // $('#checkout_form').on('submit', function (e) {
  //   //e.preventDefault();
  //   // alert($('input[name="terms-accept"]:checked').length);
  //   var element_id = 'checkout_form_alerts';
  //   var error_msg  = '';
  //   if($('input[name="terms-accept"]:checked').length == 0){
  //     var error_msg = 'برجاء تحقق من الشروط والاحكام!';
  //   }
  //   if($("input[name='building']").val() == '' || $("input[name='area']").val() == '' || $("input[name='street']").val() == ''){
  //     var error_msg = 'برجاء كتابة بيانات العنوان كاملة!';
  //   }
  //   if($("select[name='city']").val() == ''){
  //     var error_msg = 'برجاء اختيار المدينة!';
  //   }
  //   if($("input[name='phone']").val() == ''){
  //     var error_msg = 'برجاء كتابة رقم الجوال!';
  //   }
  //   if($("input[name='email']").val() == ''){
  //     var error_msg = 'برجاء كتابة الايميل!';
  //   }
  //   if($("input[name='lastname']").val() == ''){
  //     var error_msg = 'برجاء كتابة اسم العائلة!';
  //   }
  //   if($("input[name='firstname']").val() == ''){
  //     var error_msg = 'برجاء كتابة الأسم الاول!';
  //   }
  //   if(error_msg == ''){
  //     mitch_ajax_request(mitch_ajax_url, 'mitch_create_order', $(this).serialize(), element_id);
  //   }else{
  //     $('#'+element_id).html('');
  //     $('#'+element_id).append('<div class="alert alert-danger">'+error_msg+'</div>').show('slow');
  //     $('#'+element_id).show('slow');
  //     // window.scrollTo(0, 0);
  //     $("html, body").animate({ scrollTop: 0 }, "slow");
  //   }
  // });
  function show_password_fields(){
    if($('#new_account_button input').is(":checked")){
      $("#password_fields").show('slow');
      $("#new_password").prop('required',true);
      $("#confirm_password").prop('required',true);
    }else{
      $("#password_fields").hide('slow');
      $("#new_password").prop('required',false);
      $("#confirm_password").prop('required',false);
    }
  }
  show_password_fields();
  $('#apply_coupon').on('click', function () {
    $('#ajax_loader').show();
    var coupon_code = $('#coupon_code').val();
    if(coupon_code){
      $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
          action: "mitch_apply_coupon",
          coupon_code: coupon_code,
          coupon_from: 'cart'
        },
        success: function (data) {
          //alert('form was submitted');
          $('#ajax_loader').hide();
          console.log("this code");
          console.log(data);
          if(data.status == 'success'){
            console.log("Promo1");
            $('#message-fail').removeClass("active");
            $('#message-success').addClass("active");
            console.log("Promo2");
            eraseCookie('custom_product_home_visit_time');
            eraseCookie('custom_product_branch_visit');
            eraseCookie('custom_product_visit_type'); 
            $('#apply_coupon').hide();
            $('#remove_coupon').show();
            if(data.cart_total){
              $('#cart_total').html(data.cart_total);
            }
            if(data.cart_discount_div){
              $(data.cart_discount_div).insertAfter("#car_subtotal_div");
            }
            $.ajax({
              type: 'POST',
              dataType: 'JSON',
              url: $('body').attr("data-mitch-ajax-url"),
              data: {
                action: "get_cart_content_fresh",
                lang : current_lang ,
              },
              success: function (data) {
                $('#cart_total_count').html(data.cart_count);
                $('.non-fixed').html(data.cart_content);
              },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
                //alert("Error:" + errorThrown); //"Status: " + textStatus +
                //$('#ajax_loader').hide();
              }
            });
            if(data.redirect_to){
              window.location.replace(data.redirect_to);
            }
          } else if(data.status == 'error'){
            if(data.code == 401){
              var msg = data.msg ;
              if(msg.includes("minimum spend")){
                if(current_lang == 'ar'){
                  $('#message-fail').html("الحد الأدنى للإنفاق لهذه القسيمة هو 500 جنيه");
                }else{
                  $('#message-fail').html("The minimum spend for this coupon 500 EGP");
                }

              }else{
                if(current_lang == 'ar'){
                  $('#message-fail').html("لم يعد الرمز الترويجي الذي أدخلته صالحًا");
                }else{
                  $('#message-fail').html("The Promo Code You Entered is no longer valid");
                }

              }
              $('#message-success').removeClass("active");
              $('#message-fail').addClass("active");
            }else{
              // Swal.fire({
              //   title: 'Sorry',
              //   text: data.msg,
              //   icon: 'error',
              //   showConfirmButton: false,
              //   timer: 1500
              // });
            }
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          // alert("Error:" + errorThrown); //"Status: " + textStatus +
         
          $('#ajax_loader').hide();
          // Swal.fire({
          //   title: 'Sorry There is an issue!',
          //   text: errorThrown,
          //   icon: 'error',
          //   showConfirmButton: false,
          //   timer: 1500
          // });
        }
      });
    }else{
      $('#ajax_loader').hide();
      // Swal.fire({
      //   title: 'Sorry',
      //   text: 'Coupon code is required!',
      //   icon: 'error',
      //   showConfirmButton: false,
      //   timer: 1500
      // });
    }
  });

  $('#remove_coupon').on('click', function () {
    $('#ajax_loader').show();
    var coupon_code = $('#coupon_code').val();
    if(coupon_code){
      $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
          action: "mitch_remove_coupon",
          coupon_code: coupon_code,
          coupon_from: 'checkout',
          lang : current_lang ,

        },
        success: function (data) {
          $('#message-fail').removeClass("active");
          $('#message-success').removeClass("active");
          //alert('form was submitted');
          $('#ajax_loader').hide();
          if(data.status == 'success'){
            $('#apply_coupon').show();
            $('#remove_coupon').hide();
            $('.list_pay.discount').hide();
            document.getElementById('coupon_code').value = '';
            // Swal.fire({
            //   title: 'تم بنجاح',
            //   text: 'ازالة كوبون الخصم!',
            //   icon: 'success',
            //   showConfirmButton: false,
            //   timer: 1500
            // });
            if(data.cart_total){
              $('#cart_total').html(data.cart_total);
            }
            if(data.redirect_to){
              window.location.replace(data.redirect_to);
            }
          } else if(data.status == 'error'){
            if(data.code == 401){
              // Swal.fire({
              //   title: 'Sorry',
              //   text: data.msg,
              //   icon: 'error',
              //   showConfirmButton: true,
              //   // timer: 1500
              // });
            }else{
              // Swal.fire({
              //   title: 'Sorry',
              //   text: data.msg,
              //   icon: 'error',
              //   showConfirmButton: false,
              //   timer: 1500
              // });
            }
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          // alert("Error:" + errorThrown); //"Status: " + textStatus +
          $('#ajax_loader').hide();
          // Swal.fire({
          //   title: 'Sorry There is an issue!',
          //   text: errorThrown,
          //   icon: 'error',
          //   showConfirmButton: false,
          //   timer: 1500
          // });
        }
      });
    }else{
      $('#ajax_loader').hide();
      // Swal.fire({
      //   title: 'Sorry',
      //   text: 'There is no coupon code!',
      //   icon: 'error',
      //   showConfirmButton: false,
      //   timer: 1500
      // });
    }
  });
  function next_button_proceed(){
    if(getCookie('custom_product_home_visit_time') || getCookie('custom_product_branch_visit')){
      $('#next_button').removeClass('disabled');
      $('.next_step').removeClass('disabled');
      $('.breadcramb').removeClass('disabled');
      $('.step-nav-two').removeClass('disabled');
    }else{
      $('#next_button').addClass('disabled');
      $('.next_step').addClass('disabled');
      $('.breadcramb').addClass('disabled');
    }
  }

  $(document).on('click', '.single_box', function(){
    var img  = $(this).data('variation-img'); //one
    var step = $(this).data('variation-step');
    $('.step-nav-'+step+' .min_box').removeClass('emty'); //
    $('.step-nav-'+step+' .min_box').addClass('done');
    $('.step-nav-'+step+' .min_box img').attr('src', img);
  });

  // function checkout_location(){
  //   if($('#home_checkbox').is(":checked")){
  //     $(".home_checkbox_content").show();
  //     $(".branch_checkbox_content").hide();
  //   }else if ($('#branch_checkbox').is(":checked")){
  //     $(".home_checkbox_content").hide();
  //     $(".branch_checkbox_content").show();
  //   }
  // }

  $('#profile_settings').on('submit', function (e) {
    e.preventDefault();
    $('#ajax_loader').show();
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: mitch_ajax_url,
      data: {
        action: "mitch_profile_settings",
        form_data: $(this).serialize(),
      },
      success: function (data) {
        //alert('form was submitted');
        $('#ajax_loader').hide();
        if(data.status == 'success'){
          // Swal.fire({
          //   title: 'تم بنجاح',
          //   text: 'تعديل بيانات الحساب',
          //   icon: 'success',
          //   showConfirmButton: false,
          //   timer: 1500
          // });
        } else if(data.status == 'error'){
          if(data.code == 401){
            // Swal.fire({
            //   title: 'Sorry',
            //   text: data.msg,
            //   icon: 'error',
            //   showConfirmButton: true,
            //   // timer: 1500
            // });
          }else{
            // Swal.fire({
            //   title: 'Sorry',
            //   text: data.msg,
            //   icon: 'error',
            //   showConfirmButton: false,
            //   timer: 1500
            // });
          }
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        // alert("Error:" + errorThrown); //"Status: " + textStatus +
        $('#ajax_loader').hide();
        // Swal.fire({
        //   title: 'Sorry There is an issue!',
        //   text: errorThrown,
        //   icon: 'error',
        //   showConfirmButton: false,
        //   timer: 1500
        // });
      }
    });
  });

  function simple_product_add_to_cart(product_id, product_quantity = 1){
    if(product_quantity){
      var quantity = product_quantity;
    }else{
      var quantity = parseInt($('#product_quantity').val());
    }
    // alert(quantity);
    $('#ajax_loader').show();
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: mitch_ajax_url,
      data: {
        action: "simple_product_add_to_cart",
        product_id: product_id,
        quantity_number: quantity,
        lang : current_lang ,
        add_to_cart_type : $('.single_title_item').attr('data-type'),
        almond_paste : $('#less_than').val(),
        cake_text : $('#cake_text').val(),
        cake_notes : $('#cake_notes').val(),
      },
      success: function (data) {
        //alert('تم اضافة المنتج لسلة المشتريات بنجاح.');
        $('#ajax_loader').hide();
        if(data.status == 'success'){
          $('#cart_total_count').html(data.cart_count);
          $('.non-fixed').html(data.cart_content);
          $('#side_mini_cart_content').removeClass('empty');
          $('.header_total').html(data.cart_total);
          const cartClassExists = document.getElementsByClassName('page_cart').length > 0;
          if(cartClassExists){
            //$('[name="update_cart"]').trigger('click');
            location.reload();
          }
          $('.js-popup-opener[href="#popup-min-cart"]').click();
          if(data.redirect_to){
            window.location.replace(data.redirect_to);
          }
        } else if(data.status == 'error'){
          if(quantity == 0){
            var msg = 'You must select quantity!';
          }else if(data.msg){
            var msg = data.msg;
          }else{
            var msg = 'There is an issue, please try again!';
          }
          if(data.code == 401){
            // Swal.fire({
            //   title: 'Sorry',
            //   html: msg,
            //   icon: 'error',
            //   showConfirmButton: true,
            //   // timer: 1500
            // });
          }else{
            // Swal.fire({
            //   title: 'Sorry',
            //   html: msg,
            //   icon: 'error',
            //   showConfirmButton: false,
            //   timer: 1500
            // });
          }
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        //alert("Error:" + errorThrown); //"Status: " + textStatus +
        $('#ajax_loader').hide();
        // Swal.fire({
        //   title: 'Sorry There is an issue!',
        //   text: errorThrown,
        //   icon: 'error',
        //   showConfirmButton: false,
        //   timer: 1500
        // });
      }
    });
  }
  function variable_product_add_to_cart(product_id){
    // alert($('#product_quantity').val());
    $('#ajax_loader').show();
    var var_items = jQuery('.variation_option.active').map(function() {
      var key       = $(this).data('key');
      var item_arr  = new Object();
      item_arr[key] = $(this).data('value');
      return item_arr;
    }).get();
    // alert(var_items);
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: mitch_ajax_url,
      data: {
        action: "variable_product_add_to_cart",
        product_id: product_id,
        selected_items: var_items,
        lang : current_lang  ,
        add_to_cart_type : $('.single_title_item').attr('data-type'),
        cake_text : $('#cake_text').val(),
        cake_notes : $('#cake_notes').val(),
        quantity_number:  Number($('#number').val()),
      },
      success: function (data) {
        //alert('تم اضافة المنتج لسلة المشتريات بنجاح.');
        $('#ajax_loader').hide();
        if(data.status == 'error'){
          // Swal.fire({
          //   title: 'Sorry There is an issue!',
          //   text: data.msg,
          //   icon: 'error',
          //   showConfirmButton: false,
          //   timer: 1500
          // });
        }else{
          $('#cart_total_count').html(data.cart_count);
          $('.non-fixed').html(data.cart_content);
          $('#side_mini_cart_content').removeClass('empty');
          $('.header_total').html(data.cart_total);
          $('.js-popup-opener[href="#popup-min-cart"]').click();
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        //alert("Error:" + errorThrown); //"Status: " + textStatus +
        $('#ajax_loader').hide();
        // Swal.fire({
        //   title: 'Sorry There is an issue!',
        //   text: errorThrown,
        //   icon: 'error',
        //   showConfirmButton: false,
        //   timer: 1500
        // });
      }
    });
  }
  function custom_cake_add_to_cart(product_id){
    console.log($('#cake_text').val()); 
    console.log($('#cake_notes').val()); 
    $('#ajax_loader').show();
    var var_items = jQuery('.variation_option.active').map(function() {
      var key       = $(this).data('key');
      var item_arr  = new Object();
      item_arr[key] = $(this).data('value');
      return item_arr;
    }).get();
    console.log(var_items);
    // alert(var_items);
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: mitch_ajax_url,
      data: {
        action: "custom_cake_add_to_cart",
        product_id: product_id,
        selected_items: var_items,
        quantity_number:  Number($('#number').val()),
        cake_text : $('#cake_text').val(),
        cake_notes : $('#cake_notes').val(),
      },
      success: function (data) {
        $('#ajax_loader').hide();
        if(data.status == 'error'){
        
        }else{
          $('#cart_total_count').html(data.cart_count);
          $('.non-fixed').html(data.cart_content);
          $('#side_mini_cart_content').removeClass('empty');
          $('.js-popup-opener[href="#popup-min-cart"]').click();
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        $('#ajax_loader').hide();
      }
    });
  }

  $(window).bind("load", function () {
    if($('.variable_middle').length){
      get_availablility_variable_product($('.single_page').attr('data-id'));
    }
    $("body").addClass("fully-loaded");
  });
  function get_availablility_variable_product(product_id){
    $('#ajax_loader').show();
    setTimeout(() => {
      var var_items = jQuery('.variation_option.active').map(function() {
        var key       = $(this).attr('data-key');
        var item_arr  = new Object();
        item_arr[key] = $(this).attr('data-value');
        return item_arr;
      }).get();
    console.log(var_items);
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: mitch_ajax_url,
      data: {
        action: "get_availablility_variable_product",
        product_id: product_id,
        selected_items: var_items,
      },
      success: function (data) {
        $('#ajax_loader').hide();
        $('#number').val('1');
        $('#increase').removeClass('disabled');
        $('#number').attr('data-max','');
        $('.variable_middle .price').html(data.price);
        if(data.quantity && data.quantity!==-1){
          $('#number').attr('data-max',data.quantity);
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        //alert("Error:" + errorThrown); //"Status: " + textStatus +
        $('#ajax_loader').hide();
        // Swal.fire({
        //   title: 'Sorry There is an issue!',
        //   text: errorThrown,
        //   icon: 'error',
        //   showConfirmButton: false,
        //   timer: 1500
        // });
      }
    });
  });
  }

  $('#reviews_form').on('submit', function (e) {
    e.preventDefault();
    var element_id = 'reviews_form_alerts';
    var error_msg  = '';
    if($("select[name='rating']").val() == ''){
      var error_msg = 'Rating is required!';
    }
    if($("input[name='email']").val() == ''){
      var error_msg = 'Email is require!';
    }
    if($("input[name='name']").val() == ''){
      var error_msg = 'Name is required!';
    }
    if(error_msg == ''){
      mitch_ajax_request(mitch_ajax_url, 'mitch_make_product_review', $(this).serialize(), element_id, 'popup');
      this.reset();
      $('.button-submit-review').click();
      $('.button-submit-review').css('display', 'none');
      $('.success-review').css('display', 'block');
    }else{
      $('#'+element_id).html('');
      $('#'+element_id).append('<div class="alert alert-danger">'+error_msg+'</div>').show('slow');
      $('#'+element_id).show('slow');
      // window.scrollTo(0, 0);
      // $("html, body").animate({ scrollTop: 0 }, "slow");
    }
  });

  function bought_together_products_add_to_cart(){
    var element_id   = 'single_product_alerts';
    var products_ids = jQuery('.active-item.single_item').map(function() {
      return $(this).data('id');
    }).get();
    mitch_ajax_request(mitch_ajax_url, 'mitch_bought_together_products', {products_ids: products_ids}, element_id, 'none');
  }
  function bought_item_change(product_id, main_price, variation_price){
    // alert(product_id);
    //$('#' + id).is(":checked")
    var total_bought = parseFloat($('#total_bought').html());
    if($('#btcheck_'+product_id).is(":checked")){
      $('.bought_product_item_'+product_id).show('slow');
      $('.bought_product_item_'+product_id).addClass('active-item');
      var total_bought_after = total_bought + variation_price;
    }else{
      $('.bought_product_item_'+product_id).hide('slow');
      $('.bought_product_item_'+product_id).removeClass('active-item');
      var total_bought_after = total_bought - variation_price;
    }
    $('#total_bought').html(total_bought_after);
  }
}else{
  alert('Sorry Please reload page!');
}

// jQuery(".sort").on("change", function () {
//   $posts_per_page = 20;
//   $(".sortby.active").removeClass("active");
//   $(".products").attr("data-page", 1);
//   $(this).addClass("active");
//   let option = $(this).val();
//   $(".products").attr("data-sort", option);
//   get_products_ajax("sort", "desktop");
//   return false;
// });

jQuery(".sortby").on("click", function () {
  $posts_per_page = 20;
  $(".sortby.active").removeClass("active");
 
  $(".products").attr("data-page", 1);
  $(this).addClass("active");
  let option = $(this).attr("data-value");
  let text = $(this).text(); 
  $('.result_sort ').html(text);
  $('.result_sort').removeClass('active');
  $(this).parent().slideUp();
  $(".products").attr("data-sort", option);
  get_products_ajax("sort", "desktop");
  return false;
});


jQuery(window).scroll(function () {
  if ($(".spinner").is(":visible")) {
    if ($(".product_widget").length) {
      Footeroffset = jQuery(".product_widget").last().offset().top;
    }
    winPosBtn = jQuery(window).scrollTop();
    winH = jQuery(window).outerHeight();
    if (winPosBtn + winH > Footeroffset + 5) {
      get_products_ajax("loadmore");
    }
  }
});
jQuery(document).on("change", ".filter_input", function () {
  //$(".spinner").show();
  $posts_per_page = 20;
  $(".products").attr("data-page", 1);
  get_products_ajax("filter", "desktop");
});


// load more on scroll and click, filter, and sort
$posts_per_page = 20;
$loading_more = false;
var jqxhr_add_get_products_ajax = {abort: function () {}};
function get_products_ajax(action, view = "") {
  
//console.log("called get_products_ajax");
// jqxhr_add_get_products_ajax.abort();
if(action == 'loadmore'){
  // $(".loader").show();

}else{
  $('#ajax_loader').show();
}
var ajax_url = mitch_ajax_url;
$count       = $(".products").attr("data-count");
$page        = $(".products").attr("data-page");
$posts       = parseInt($(".products").attr("data-posts"));
$order       = $(".products").attr("data-sort");
$type        = $(".products").attr("data-type");
$search      = $(".products").attr("data-search");
$lang        = $(".products-list").attr("data-lang");
$slug        = "";
$cat         = "";
$ids         = new Array();
if($type == "shop"){
}else if ($type == "products-list") {
  $ids = $(".products").attr("data-ids");
}else {
   $slug = $(".products").attr("data-slug");
   $cat  = $(".products").attr("data-cat");
}

let min_price   = "";
let max_price   = "";
let max_prices  = new Array();
let min_prices  = new Array();
let cats        = new Array();
let colors      = new Array();
let sizes       = new Array();
let collections = new Array();
let occasions   = new Array();
let forwho      = new Array();
let genders     = new Array();
$(".filter_input:checked").each(function () {
  if ($(this).hasClass("filter-price")) {
    min_prices.push(parseInt($(this).attr("data-min")));
    max_prices.push(parseInt($(this).attr("data-max")));
    max_price =
      parseInt($(this).attr("data-max")) == 0
        ? parseInt($(this).attr("data-max"))
        : Math.max(...max_prices);
    min_price = Math.min(...min_prices);
    $order = "price";
  } else if ($(this).hasClass("filter-cat")) {
    cats.push($(this).val());
  }else if ($(this).hasClass("filter-color")) {
    colors.push($(this).val());
  }else if ($(this).hasClass("filter-size")) {
    sizes.push($(this).val());
  }else if ($(this).hasClass("filter-collection")) {
    collections.push($(this).val());
  }else if ($(this).hasClass("filter-occasion")) {
    occasions.push($(this).val());
  }else if ($(this).hasClass("filter-forwho")) {
    forwho.push($(this).val());
  }else if ($(this).hasClass("filter-gender")) {
    genders.push($(this).val());
  }
});
if (($loading_more || $posts_per_page >= $posts) && action == "loadmore") {
  // console.log("khalstt " + $posts);
  return;
}
//$('#ajax_loader').show();
$loading_more = true;
jqxhr_add_get_products_ajax = $.ajax({
  type: "POST",
  url: ajax_url,
  data: {
    action: "get_products_ajax",
    count: $count,
    page: $page,
    order: $order,
    type: $type,
    slug: $slug,
    min_price: min_price,
    max_price: max_price,
    cat: $cat,
    cats: cats,
    colors: colors,
    sizes: sizes,
    collections: collections,
    occasions: occasions,
    forwho: forwho,
    genders: genders,
    search: $search,
    fn_action: action,
    ids: $ids,
    lang : current_lang ,
  },
  success: function (posts) {
     //$(".loader").hide();
    $('#ajax_loader').hide();

    
    get_products_ajax_count(action);
    $loading_more = false;
    if (action == "loadmore") {
      $(".products").append(posts);
      $(".products").attr("data-page", parseInt($page) + 1);
      // $(".spinner").attr("data-page", parseInt($page) + 1);
      //console.log($(".products").attr("data-page"));
      $posts_per_page += parseInt($count);
      $posts = parseInt($(".products").attr("data-posts"));
      //console.log("$posts_per_page", $posts_per_page);
      //console.log("$posts", $posts);
      if ($posts_per_page >= $posts) {
          $(".spinner").hide();
       
        /// Begin of get out of stock products function
        // $(".spinner").hide();
      } else {
        if ($posts_per_page < $posts) {
           $(".spinner").show();
          
        }
      }
       // $(".loader").hide();
    } else {
      $(".products").html(posts);
      if (parseInt($page) % 2 == 0 && $posts_per_page < $posts) {
         $(".spinner").show();
      } else if (parseInt($page) % 2 == 1 && $posts_per_page < $posts) {
         $(".spinner").show();
      } else if ($posts_per_page >= $posts) {
        /// Begin of get out of stock products function
         $(".spinner").hide();
      }
    }
  },
});
}
var jqxhr_add_get_products_ajax_count = {abort: function () {}};
function get_products_ajax_count(view) {
  // $(".spinner").hide();
jqxhr_add_get_products_ajax_count.abort();
// console.log('get_products_ajax_count');
var ajax_url = mitch_ajax_url;
$count       = $(".products").attr("data-count");
$page        = $(".products").attr("data-page");
$posts       = parseInt($(".products").attr("data-posts"));
$order       = $(".products").attr("data-sort");
$type        = $(".products").attr("data-type");
$search      = $(".products").attr("data-search");
$slug        = "";
$cat         = "";
$ids         = new Array();
if($type == "shop"){
} else if ($type == "products-list") {
  $ids = $(".products").attr("data-ids");
} else {
  $slug = $(".products").attr("data-slug");
  $cat = $(".products").attr("data-cat");
}

let min_price  = "";
let max_price  = "";
let max_prices = new Array();
let min_prices = new Array();
let colors     = new Array();
let sizes      = new Array();
let cats       = new Array();

$(".filter_input:checked").each(function () {
  if ($(this).hasClass("filter-price")) {
    min_prices.push(parseInt($(this).attr("data-min")));
    max_prices.push(parseInt($(this).attr("data-max")));
    max_price =
      parseInt($(this).attr("data-max")) == 0
        ? parseInt($(this).attr("data-max"))
        : Math.max(...max_prices);
    min_price = Math.min(...min_prices);
    $order = "price";
  } else if ($(this).hasClass("filter-cat")) {
    cats.push($(this).val());
  } else if ($(this).hasClass("filter-color")) {
    colors.push($(this).val());
  } else if ($(this).hasClass("filter-size")) {
    sizes.push($(this).val());
  }
});
setTimeout(function () {
  jqxhr_add_get_products_ajax_count = $.ajax({
    type: "POST",
    url: ajax_url,
    data: {
      action: "get_products_ajax_count",
      count: $count,
      page: $page,
      order: $order,
      type: $type,
      slug: $slug,
      min_price: min_price,
      max_price: max_price,
      cat: $cat,
      search: $search,
      cats: cats,
      colors: colors,
      sizes: sizes,
      ids: $ids,
      lang : current_lang,
    },
    success: function (posts) {
      // console.log('posts', posts);
      if (20 >= parseInt(posts)) {
         // $(".loader").hide();
        // console.log("last batch");
          $(".spinner").hide();
      } else if (parseInt(posts) == 0) {
        // console.log("last");
        //$(".spinner").show();
      } else {
        // console.log(" batch");
        //$(".spinner").show();
      }
      $(".products").attr("data-posts", posts);
      // $(".spinner").attr("data-posts", posts);
    },
  });
});
}
$(document.body).on("change","#billing_street", function () {
  //$("#billing_street_field").addClass("blocked");
  let selected_area  = $(this).find(':selected').data('id');

  $('#ajax_loader').show();
  $.ajax({
    type: "POST",
    url: mitch_ajax_url,
    data: {
      action: "get_street",
      selected_area: selected_area,
      lang: current_lang,
    },
    success: function (posts) {
      if(window.location.href.indexOf('addresses')>-1){
      //$("#city").html(posts);
      }else{
      $("#billing_city_field").html(posts);
      }
      $("#billing_city_field").removeClass("blocked");
      $('#ajax_loader').hide();
    },
  });

});

$("#billing_state,#country").on("change", function () {
  let selected_gov  = $(this).find(':selected').data('id');
  if(!selected_gov ){
    selected_gov = 1;
  }
  $('#ajax_loader').show();
  $.ajax({
    type: "POST",
    url: mitch_ajax_url,
    data: {
      action: "get_city",
      selected_gov : selected_gov ,
      lang : current_lang ,
    },
    success: function (posts) {
      $("#billing_street_field").html(posts);
      if(current_lang == 'en'){
        $('#billing_city_field').html('<label for="billing_street" class="">  Disrtict <abbr class="required" title="مطلوب">*</abbr></label><select name="billing_city" id="billing_city" class="city_select select2" autocomplete="address-level2" placeholder="" tabindex="-1" aria-hidden="true"><option value=""> Choose District</option>')

      }else{
        $('#billing_city_field').html('<label for="billing_city" class="">  المنطقة  <abbr class="required" title="مطلوب">*</abbr></label><select name="billing_city" id="billing_city" class="city_select select2" autocomplete="address-level2" placeholder="" tabindex="-1" aria-hidden="true"><option value=""> اختر المنطقة </option>')

      }
      $('#ajax_loader').hide();
    },
  });

});



if ($(".new_search").length) {
  var jqxhr_add = {abort: function () {}};
  var lang = "";
  if (
    /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
      navigator.userAgent
    )
  ) {
    // some code..
  } else {
    window.addEventListener("click", function (e) {
      if (document.getElementById("newSearch").contains(e.target)) {
        if ($(".new-search").val()) {
          $(".search-result").addClass("show");
          $(".sec_search").addClass("show");
          $('html').addClass('no-scroll');
        }
      } else {
        $(".search-result").removeClass("show");
        $(".sec_search").removeClass("show");
        $('html').removeClass('no-scroll');
      }
    });
    $("#newSearch").on("focus", function () {
      if (!$(".search-result").hasClass("show")) {
        if ($(".new-search").val().length >= 1) {
          $(".search-result").addClass("show");
          $(".sec_search").addClass("show");
        }
      }
    });
  }
  jQuery($(".new-search")).keyup(function () {
    jqxhr_add.abort();
    if ($(".search-result").length) {
      // $(".search-result").html("");
      $(".search-result").addClass('loading');
      if ($(".search-result").hasClass("show")) {
        $(".search-result").addClass("show");
        $(".sec_search").removeClass("show");
      }
      if ($(".new-search").val().length >= 1) {
        $('#ajax_loader').show();
        $(".search-result").removeClass('loading');
        jqxhr_add = $.ajax({
          type: "POST",
          url: mitch_ajax_url,
          data: {
            action: "custom_search",
            s: $(".new-search").val(),
             lang: current_lang,
          },
          success: function (data) {
            $('#ajax_loader').hide();
            if (data) {
              $(".search-result").removeClass('loading');
              $(".search-result").addClass("show");
              $(".sec_search").addClass("show");
              $(".loader_search").hide();
              $(".search-result").html(data);
            }
          },
          error: function(){
            $('#ajax_loader').hide();

          },
          
        });
      }
     // $('#ajax_loader').hide();
    }
  });
}
function navigateMyForm() {
  var lang = "";
  var urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has("lang")) {
    lang = "_" + urlParams.get("lang");
  }
  var s = $(".search-formm .new-search").val();
  var site_url    = $('body').attr("data-mitch-home-url");
  if (lang == "_en") {
    window.location.href =
    site_url+"/search/?search=" + s + "&lang=en";
  } else {
    window.location.href =
    site_url+"/search/?search=" + s;
  }
  return true; 
}

$("label[for='property_type_villa']").on("click", function () {
  $(".require-build").addClass("hide");
  $("span.description").hide();
});

$("label[for='property_type_apart']").on("click", function () {
  $(".require-build").removeClass("hide");
  $("span.description").fadeIn();
});


jQuery(document).on('click','#place_order', function(e) {
  jQuery('.checkout').removeClass('remove_border_on_first_load');
});
jQuery(document).on('click','.insta_widget_box', function(e) {
  //var in_img = $(this).attr('data-in-img');
  //alert(in_img);
  e.preventDefault();
  var ajax_url    = $('body').attr("data-mitch-ajax-url");
  var insta_item  = $(this).data('item');
  $.ajax({
       method: 'post',
       url: ajax_url,
       data: {
         action: 'mitch_get_insta_content',
         insta_item: insta_item,
       },
       success: function(data) {
         jQuery('.insta-popup-content').html(data);
         $('.popup').removeClass('popup_visible');
         $('html, body').css('overflow', 'hidden');
         $('#overlay').addClass('overlay_visible');
         $('#popup-insta').addClass('popup_visible');
       }
   });
});
function mitch_sort_by(sort_by){
  // alert(sort_by);
  $(".products").attr("data-sort", sort_by);
  get_products_ajax('sort', 'mobile');
}


// ------------------------------------ Redeem Your Points ---------------------------
// $("#redeem-points").on("click", function () {
//   var order_subtotal = $(this).data('subtotal');

//   // $.ajax({
//   //     type: 'POST',
//   //     dataType: 'JSON',
//   //     url: mitch_ajax_url,
//   //     data: {
//   //         action: "MD_Apply_redeem_discount",
//   //         order_subtotal : order_subtotal ,
        
//   //     },
//   //     success: function (data) {
       
//   //     }
//   // })
//   setTimeout(function () {
//     jQuery('body').trigger('update_checkout');
//     //$('.redeem-container').remove();
// }, 2000);

  

//});

// ---------------------------------- Partial Redeem  Hide And Show ----------------------------
// $(document.body).on('updated_checkout', custom_checkout_field_display_based_on_cart_total);
// function custom_checkout_field_display_based_on_cart_total() {

//   $.ajax({
//     type: 'POST',
//     dataType: 'JSON',
//     url: mitch_ajax_url,
//     data: {
//         action: "MD_remove_partial_checkbox_from_checkout",
//     },
//     success: function (data) {

//       if($('body').data('redeem') == 'true'){
//         $('#message_fields').show();
//       }
//       else{
//         if(data.points == true){
//           $('#message_fields').hide();
//         }else{

//           $('#message_fields').show();
//           let message_points = 'Use Your Current Points Balance Of ' + data.total_points + ' Points To Save ' + data.total_cash + ' EGP';
//           $('#message_redeem').html(message_points);
//          }
//       }
//       if(data.total == 0 && $('body').data('redeem') == 'true'){
//         location.reload();
//       }

       
//     }
// })
// }
// Simple Product [No Variations ]
$(document).on('click', '#simple_add_product_to_cart', function(){
  var product_id       = $('.single_size.active').data('product-id');
  let currrnt_quantity = Number($('#number').val());
   
  simple_product_add_to_cart(product_id, currrnt_quantity);

});
$(document).ready(function() {
 
  $('#less_than').on('input', function() {
    var minValue = parseInt($('#less_than').attr('min'));
    var inputValue = parseInt($(this).val());
    if(inputValue < minValue || Number.isNaN( inputValue )){
      $('.add_to_cart').css('opacity', '.4');
      $('.add_to_cart').css('pointer-events', 'none');
      $('.add_to_cart').prop('disabled', true);
    }else{
      $('.add_to_cart').removeAttr('style');
      $('.add_to_cart').prop('disabled', false);
    }
  });
});

// Add To Cart From Product Widget  
$(document).on('click', '.icon_add', function(e){
  
   var product_id       = $(this).data('product_id');
   var product_type     =$(this).data('product_type');
   //alert(product_type);

   if(product_type == 'simple'){
    event.preventDefault();
    simple_product_add_to_cart(product_id, 1);
    $(this).hide();
    $('.icon_add.product_'+product_id).hide();
    let product_class = ".section_count.product_" + product_id ;
    //Get Product Quantity In Cart  
    let Quantity = Number($(this).data('quantity'));
    $('.number_'+ product_id).attr("value" ,Quantity + 1 ); 
    $('.decrease_'+product_id).addClass('disabled');
    $(product_class).css("display", "flex");

   } 

});

// Prevent Redirect to Single Product Page when Click on Section count in product widget 
$(document).on('click', '.section_count', function(e){
  event.preventDefault();
});

// Increase Item By One 

function increaseValue(product_id){

  simple_product_add_to_cart(product_id, 1); 
  var Current_Quantity =  Number($('.number_'+ product_id).val());
  $('.number_'+ product_id).attr("value" , Current_Quantity + 1);
  $('.decrease_'+product_id).removeClass('disabled');
}

function decreaseValue(cart_key , product_id){

  //New Quantity 
  var New_Quantity =  Number($('.number_'+ product_id).val()) - 1 ;
  update_cart_items(cart_key, 'product_' + New_Quantity, '', product_id );

  // $('.number_'+ product_id).attr("value" , New_Quantity);
  // if(New_Quantity == 1 ){
  //   $('.decrease_'+product_id).addClass('disabled');
  // }

}

// Single Product Functions 
function increaseOne(){
  let currrnt_quantity = Number($('#number').val()); 
  if(currrnt_quantity == 10 ){
    $('#increase').addClass('disabled');
    return;
  }
  $('#decrease').removeClass('disabled');
  $('#number').attr("value" , currrnt_quantity + 1 );
}
function decreaseOne(){
  let currrnt_quantity = Number($('#number').val()); 
  if(currrnt_quantity == 1 ){
    $('#decrease').addClass('disabled');
    return;
  }
  $('#increase').removeClass('disabled');
  $('#number').attr("value" , currrnt_quantity - 1 );
  if(currrnt_quantity -1  == 1 ){
    $('#decrease').addClass('disabled');
    return;
  }
}

// Branch Feature Js  
//Government
$(document).on('click', '.gover-checkbox', function (e) {
      $("#branch_submit button").attr("disabled", "disabled");

  //alert("Changed");
  $('#ajax_loader').show();
  let gover_en = $(this).attr('id'); 

  $.ajax({
    type: 'POST',
    dataType: 'JSON',
    url: mitch_ajax_url,
    data: {
        action: "MD_get_areas_related_gover",
        gover_en: gover_en ,
        lang : current_lang ,
    },
    success: function (data) {

      $('#area').html(data.areas_dropdown);
      $('#street').html(data.street);
      $('#ajax_loader').hide();

       
    }
})
});

// Area 
$(document.body).on("change", "#area", function () {
     $("#branch_submit button").attr("disabled", "disabled");

  // $("#street").addClass("blocked");
  $('#ajax_loader').show();
  let selected_area  = $(this).val();

  $.ajax({
    type: "POST",
    dataType: 'JSON',
    url: mitch_ajax_url,
    data: {
      action: "MD_Get_street_related_area",
      selected_area: selected_area,
      lang: current_lang,
    },
    success: function (data) {
      $('#street').html(data.street);
      $('#ajax_loader').hide();
    },
  });

});
$(document.body).on("change", "#street", function () { 
   $("#branch_submit button").removeAttr("disabled");
});

// Creating a Cookie Or Updating a Cookie Request 
$(document).on('click', '.button_action', function(e){
// //$('.button_action').on("click", function () {
//   $("#branch_submit").on("click", function () {
  let area = $('#area').find(":selected").val();
  let street = $('#street').find(":selected").val(); 


  if(area != 'false' && street != 'false'){
    $('#ajax_loader').show();
    // Get Area And Branch Name 
    $.ajax({
      type: "POST",
      dataType: 'JSON',
      url: mitch_ajax_url,
      data: {
        action: "MD_Get_matched_branch",
        area: area,
        street : street ,
      },
      success: function (data) {
        let arabic_cookie_value =   data.branch_ar + ' - ' + data.area_ar ;
        let english_cookie_value =  data.branch_en + ' - ' +  data.area_en ;

        //Erase Cookie 
        eraseCookie('branch_name_ar');
        eraseCookie('branch_name_en');
        eraseCookie('branch_id');

        // Set the new Values 
        setCookie('branch_name_ar' , arabic_cookie_value , 7);
        setCookie('branch_name_en' , english_cookie_value , 7);
        setCookie('branch_id' , data.branch_id , 7);
        window.location.reload();

       
      },
    });


  }
});


function increaseValueByID(element_id) {
  var value = parseInt(document.getElementById(element_id).value, 10);
  value = isNaN(value) ? 0 : value;
  value++;
  document.getElementById(element_id).value = value;
}

function decreaseValueByID(element_id) {
  var value = parseInt(document.getElementById(element_id).value, 10);
  value = isNaN(value) ? 1 : value;
  value < 2 ? value = 2 : '';
  value--;
  document.getElementById(element_id).value = value;
}

function Set_language_cookie(redirect_link , lang){
  eraseCookie('current_language');
  setCookie('current_language' , lang , 7);
  window.location.replace(redirect_link);
  return false ;

}
$('input[name="downpayment_option"]').change(function() {
  jQuery('body').trigger('update_checkout');
});

$('input[name="shipping_option"]').change(function() {
  if ($(this).val() == 'delivery') {
    if (current_lang == 'en') {
      $('#shipping_method_title').html("Shipping Address");
    } else {
      $('#shipping_method_title').html("عنوان التوصيل");
    }
   
    $('#billing_state_field').show(); 
    $('#billing_street_field').show(); 
    $('#billing_city_field').show(); 
    $('#billing_address_1_field').show(); 
    $('#billing_building_field').show(); 
    $('#billing_building_2_field').show(); 
    $(".address_option.active").click();

    $('#store-select').hide(); 
    $('.user-address').show();

  } else {
    if (current_lang == 'en') {
      $('#shipping_method_title').html("Pickup Store");
    } else {
      $('#shipping_method_title').html("استلام من فرع");
    }
    //Set Shipping to Zero 
    $('#billing_city').val("local-pickup");
    jQuery('body').trigger('update_checkout');
    
    $('#billing_state_field').hide(); 
    $('#billing_street_field').hide(); 
    $('#billing_city_field').hide(); 
    $('#billing_address_1_field').hide(); 
    $('#billing_building_field').hide(); 
    $('#billing_building_2_field').hide(); 
    $('#store-select').show(); 
    $('.user-address').hide();
  }
});

$('.single_pop_branch').on('click', function () {
  $('.single_pop_branch').removeClass('selected');
  $(this).addClass('selected');
  $('#change_store').click();
});

$('#change_store').on('click' , function(e){
  e.preventDefault();
  var selectedElement = $(".single_pop_branch.selected");
  var value = selectedElement.attr("value");
  var dataValueAr = selectedElement.attr("data-value_ar");

  if (current_lang == 'ar') {
    var branch_name = selectedElement.attr("data-value_ar");  
    var address = selectedElement.attr("data-address");  
  } else {
  
    var branch_name = selectedElement.attr("data-value_en");  
    var address = selectedElement.attr("data-address_en");  
  }

  $('.branch_name').html(branch_name + ' <span>' + address + '</span>');
  $('#billing_local_pickup').val(dataValueAr);
  $('.popup__close').click();
});

// Checkout Validations 
function validateEmail(email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  if( !emailReg.test( email ) ) {
      return false;
  } else {
      return true;
  }
}

$('#btncheckout').on('click' , function(e){
  e.preventDefault();
  let Error_Message = ' ';  
  let Error_Found = false;
  
  $('#billing_delivery_date').val($('#billing_delivery_date').text());

  // Billing Info 

  if($("input[name='language']").val() == 'ar'){
    if(!$('#billing_first_name').val().trim()){
      Error_Found = true;
     Error_Message += 'من فضلك أدخل الأسم الأول' + '\n' ;
   }
 
   if(!$('#billing_last_name').val().trim()){
      Error_Found = true;
     Error_Message += 'من فضلك أدخل أسم العائله \n ' ;
   }
 
   if(!$('#billing_email').val().trim()){
      Error_Found = true;
     Error_Message += 'من فضلك أدخل البريد الألكتروني \n ' ;
   }else{
     if(!validateEmail($('#billing_email').val())){
        Error_Found = true;
       Error_Message += 'من فضلك أدخل البريد الألكتروني \n ' ;
     }
   }
   if(!$('#billing_phone').val().trim()){
      Error_Found = true;
     Error_Message += 'الرجاء إدخال رقم الهاتف \n' ;
   }else{
     if($('#billing_phone').val().length < 11){
        Error_Found = true;
       Error_Message += 'رقم الهاتف يجب ان يتكون من 11 رقم \n' ;
     }
   }
 
   // Shipping Info 
   // Delivery Validation 
   if($('input[name="shipping_option"]:checked').val() == 'delivery'){
     if(!$('#billing_street').val().trim()){
        Error_Found = true;
       Error_Message += 'من فضلك أدخل الحي \n ' ;
     }
   
     if($('#billing_city').val() != null){
       if(!$('#billing_city').val().trim()){
         Error_Found = true;
        Error_Message += 'من فضلك أدخل المنطقة \n ' ;
      }
    
     }
   
     if(!$('#billing_address_1').val().trim()){
        Error_Found = true;
       Error_Message += 'من فضلك أدخل المنطقة \n ' ;
     }
   
     if(!$('#billing_building_2').val().trim()){
        Error_Found = true;
       Error_Message += 'من فضلك أدخل رقم العقار \n ' ;
     }
   
     if(!$('#billing_building').val().trim()){
        Error_Found = true;
       Error_Message += 'من فضلك أدخل الدور \n ' ;
     }
   }
  }else{
    // English Validations 
    if(!$('#billing_first_name').val().trim()){
      Error_Found = true;
     Error_Message += 'Billing First name is a required field \n' ;
   }
 
   if(!$('#billing_last_name').val().trim()){
      Error_Found = true;
     Error_Message += 'Billing Last name is a required field \n ' ;
   }
 
   if(!$('#billing_email').val().trim()){
      Error_Found = true;
     Error_Message += 'Email address is a required field \n ' ;
   }else{
     if(!validateEmail($('#billing_email').val())){
        Error_Found = true;
       Error_Message += 'Please Use A Valid Email \n ' ;
     }
   }
   if(!$('#billing_phone').val().trim()){
      Error_Found = true;
     Error_Message += 'Phone Number is a required field \n' ;
   }else{
     if($('#billing_phone').val().length < 11){
        Error_Found = true;
       Error_Message += 'Phone  must contains 11 number \n' ;
     }
   }
 
   // Shipping Info 
   // Delivery Validation 
   if($('input[name="shipping_option"]:checked').val() == 'delivery'){
     if(!$('#billing_street').val().trim()){
        Error_Found = true;
       Error_Message += 'Billing Area is a required field \n ' ;
     }
   
     if($('#billing_city').val() != null){
       if(!$('#billing_city').val().trim()){
         Error_Found = true;
        Error_Message += 'Billing District is a required field \n ' ;
      }
    
     }
   
     if(!$('#billing_address_1').val().trim()){
        Error_Found = true;
       Error_Message += 'Full Address is a required field \n ' ;
     }
   
     if(!$('#billing_building_2').val().trim()){
        Error_Found = true;
       Error_Message += 'Please enter the property number \n ' ;
     }
   
     if(!$('#billing_building').val().trim()){
        Error_Found = true;
       Error_Message += 'Please enter the floor number \n ' ;
     }
   }
  }
  
 

  if(Error_Found){
    swal("", Error_Message , "error");
  }else{
    $('.col-1, .col-2').toggleClass('active');
    $('.breadcramb_checkout li:eq(1)').addClass('visible').removeClass('active');
    $('.breadcramb_checkout li:eq(2)').addClass('active');
    
    $(window).scrollTop(0);

  }
 
  //alert(Error_Message);



});

// Logged In Users Address 
$(".address_option").on("click", function () {
  $("#ajax_loader").attr("id", "new_id");
  // $("#new_id").show();
  $('.btn_checkout').addClass("disabled");
  //$('.btn_checkout').text("جاري تحميل البيانات");

  
  // Get the data attributes when an element with the class "address_option" is clicked
  var gov = $(this).data("gov");
  var area = $(this).data("area");
  var street = $(this).data("street");
  var appertment = $(this).data("app");
  var full_address = $(this).data("full");
  var floor = $(this).data("floor");

  $('#billing_address_1').val(full_address); 
  $('#billing_building').val(floor);
  $('#billing_building_2').val(appertment);

  $('#billing_state').val(gov);
  $('#billing_state').change();

  setTimeout(function() {
    $('#billing_street').val(area);
}, 1000);

setTimeout(function() {
  $('#billing_street').change();
}, 1500);
setTimeout(function() {
  $('#billing_city').val(street);
}, 3000);
setTimeout(function() {
  $('#billing_city').change();
  $('.btn_checkout').removeClass("disabled");
    //$('.btn_checkout').text(" التالي");
}, 3500);

  jQuery('body').trigger('update_checkout');
  // $("#new_id").hide();
  // $("#new_id").attr("id", "ajax_loader");
  

});
$(".checkout-add-address").on("click", function (e) {

  //Gather New Address Data
  e.preventDefault();
  let error_found = false;
  
  if (current_lang == 'en') {
      var msg = "Please fill all the required data"; 
  }else{
    var msg = "من فضلك اكمل جميع البيانات";
  }
  var city = $('#city').val(); 
  var area = $('#add_address_area').val();
  var district =  $('#add_area_district').val();
  var full_address = $('.full-address').val();
  var floor = $('.floor').val();
  var apartment = $('.apartment').val();
  //Where this Form Came From ?
  var came_from = $(this).data('where');

  if(!city.trim()){
    error_found = true;
 }
 
 if(!area.trim()){
   error_found = true;
}
if(!district.trim()){
  error_found = true;
} 
if(!full_address.trim()){
  error_found = true;
}
 if(!floor.trim()){
  error_found = true;
}
 if(!apartment.trim()){
  error_found = true;
}
 if(error_found){
  swal(msg, {
    buttons: false,
    timer: 1000,
  });

 }else{
  $.ajax({
    type: 'POST',
    dataType: 'JSON',
    url: mitch_ajax_url,
    data: {
        action: "MD_add_user_address",
        city: city,
        area: area,
        district : district,
        full_address : full_address ,
        floor : floor ,
        apartment : apartment ,
        came_from : came_from ,

    },
    success: function (data) {
        location.reload();

    }
})
 }


});

console.log("Js Loaded ");




