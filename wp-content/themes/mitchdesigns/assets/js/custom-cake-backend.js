//Start Empty Data 
const base_url = "https://cloudhosta.com:63/cake_images_optimized/";
function get_image_url(decoration){
  if(decoration == 'color'){
    if( customized_cake['color'] == ""){
      return base_url +  customized_cake['shape'] + '_' + customized_cake['flavor'] + '_' + customized_cake['toping'] + '.webp';
    }else{
      return base_url +  customized_cake['shape'] + '_' + customized_cake['flavor'] + '_' + customized_cake['color'] + '.webp';
    }
  }else{
    return base_url +  customized_cake['shape'] + '_' + customized_cake['flavor'] + '_' + customized_cake['toping'] + '.webp';
  }
  
}
var selected_base_price = 0 ;
let customized_cake = {
    shape: 'rectangle',
    size: '',
    height: '',
    flavor: '',
    filling: '',
    color : 'c-white',
    toping : '' ,
    shapes3d : [] ,
    text_on_cake:'',
    text_on_base:'', 
    notes_on_order : '' , 
    delivery_date : '' , 
    delivery_time : '' ,
    full_price: [
        { key: 'base_price', value: 0 },
        { key: 'filling_price', value: 0 },
        { key: 'topping_price', value: 0 },
        { key: 'shape3d_price', value: 0 },
        { key: 'writing_price', value: 0 },

    ],
};

// Moving to  next step 
let allow_steps = {
  two: "dont_allow" ,
  three: "dont_allow",
  four:"allow",
  five : "allow",

};

// Changing the Shape options -> update Size Options DropDown
jQuery(document).on("change", ".shape_option input[type='radio']", function () {
    var selected_shape = $(this).val();

    // Remove All Selected Items And Remove All Prices
    customized_cake['shape'] = selected_shape ;
    customized_cake['color'] = 'c-white' ; 
    customized_cake['toping'] = '' ;
    customized_cake['flavor'] = 'white' ; 
    customized_cake['filling'] = 'without' ;

    customized_cake.full_price.find(item => item.key === 'base_price').value = 0;  
    customized_cake.full_price.find(item => item.key === 'topping_price').value = 0;   
    customized_cake.full_price.find(item => item.key === 'filling_price').value = 0;   
    let sum = customized_cake.full_price.reduce((total, item) => total + item.value, 0);
    $('.total-cake-price').html(new Intl.NumberFormat().format(sum));
    $("#cake_container").attr("src", get_image_url("color"));
    $.ajax({
      
        type: 'POST',
        dataType: 'JSON',
        url: $('body').attr("data-mitch-ajax-url"),
        data: {
          action: "sbs_change_shape",
          selected_shape: selected_shape,
          lang : current_lang ,
        },
        success: function (data) {
            // $('#ajax_loader').hide();
            //Change Size 
            $('#size_option').html(data.size);
            //Change the Height 
            $("#height_option").val($("#height_option option:first").val());
            allow_steps['two'] = 'dont_allow';

        },
      });

});

// jQuery(document).on("change", "#cake_type_option", function () {
//   $('#size_option').removeClass('hidden_height');
//   $('#c_option1').removeClass('active');
//   $('#c_option2').removeClass('active');


//   //Reset Size and Height Dropdown and close the next button 
//   $("#size_option").val("false"); 
//   $("#size_option").change() ; 


//   //Reset Step 5 
//   //Js Array 
//   customized_cake['toping'] = "";
//   customized_cake['color'] = "c-white"; 

//   //Default values 
//   $('input[name="gender"][value="c-white"]').prop("checked", true); 
//   $("#cake_container").attr("src", get_image_url("color"));
//   $(".list_icons").html(""); 

//   customized_cake.full_price.find(item => item.key === 'shape3d_price').value = 0 ;
//   customized_cake.full_price.find(item => item.key === 'topping_price').value = 0 ;

//   let sum = customized_cake.full_price.reduce((total, item) => total + item.value, 0);
//   $('.total-cake-price').html(new Intl.NumberFormat().format(sum));
  

//   // Changes in Step 5 
//   if($(this).val() == 'suger-cake'){
//     $('#c_option1').addClass('active');
    
//   }else{
//     $('#c_option2').addClass('active');
  
//   }

// });

jQuery(document).on("click", ".single_step", function () {
     $('.btn_next').removeClass('hidden_next');
});


//Step 5 Handling Changes between Diferent values 
jQuery(document).on("click", "#f_option1", function () {
  $('#c_option1').addClass('active');
  //Reset Data 
   //Reset Size and Height Dropdown and close the next button 
  $("#size_option").val("false"); 
  $("#size_option").change() ; 

  allow_steps['five'] = "allow";
  //Reset Step 5 
  //Js Array 
  customized_cake['toping'] = "";
  customized_cake['color'] = "c-white"; 

  //Default values 
  $('input[name="gender"][value="c-white"]').prop("checked", true); 
  $("#cake_container").attr("src", get_image_url("color"));
  $(".list_icons").html(""); 

  customized_cake.full_price.find(item => item.key === 'shape3d_price').value = 0 ;
  customized_cake.full_price.find(item => item.key === 'topping_price').value = 0 ;

  let sum = customized_cake.full_price.reduce((total, item) => total + item.value, 0);
  $('.total-cake-price').html(new Intl.NumberFormat().format(sum));


});

jQuery(document).on("click", "#f_option2", function () {
  $('#c_option2').addClass('active');

  //Reset Data 
   //Reset Size and Height Dropdown and close the next button 
  $("#size_option").val("false"); 
  $("#size_option").change(); 
  allow_steps['five'] = "dont_allow";


  //Reset Step 5 
  //Js Array 
  customized_cake['toping'] = "";
  customized_cake['color'] = "c-white"; 

  //Default values 
  $('input[name="gender"][value="c-white"]').prop("checked", true); 
  $("#cake_container").attr("src", get_image_url("color"));
  $(".list_icons").html(""); 

  customized_cake.full_price.find(item => item.key === 'shape3d_price').value = 0 ;
  customized_cake.full_price.find(item => item.key === 'topping_price').value = 0 ;

  let sum = customized_cake.full_price.reduce((total, item) => total + item.value, 0);
  $('.total-cake-price').html(new Intl.NumberFormat().format(sum));
  //عجينة السكر 


});

// Changing the Size options -> update the prices of Height option -> update toping Section 
jQuery(document).on("change", "#size_option", function () {
    let selected_size = $(this).val();
    customized_cake['size'] = selected_size ;
    customized_cake['color'] = 'c-white' ; 
    customized_cake['toping'] = '' ;
    customized_cake['flavor'] = 'white' ; 

    customized_cake.full_price.find(item => item.key === 'base_price').value = 0;  
    customized_cake.full_price.find(item => item.key === 'topping_price').value = 0;   
    customized_cake.full_price.find(item => item.key === 'filling_price').value = 0;   
    
  if ($('#f_option1').hasClass('active')) {
    var cake_type = "suger-cake";
    } else {
       var cake_type = "sponge-cake";
    }
    let sum = customized_cake.full_price.reduce((total, item) => total + item.value, 0);
    $('.total-cake-price').html(new Intl.NumberFormat().format(sum));
    $("#cake_container").attr("src", get_image_url("color"));
    //Reset
    $("#flavor_option").val("false"); 
    allow_steps['three'] = "dont_allow" ;
    

    console.log(customized_cake);
    $('#height_option').addClass("hidden_height");
    $('.btn_next').addClass('hidden_next');
    $.ajax({
        type: "POST",
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
          action: "sbs_change_size",
          selected_cake_type :cake_type ,
          selected_shape : customized_cake['shape'] ,
          selected_size: selected_size,
          lang : current_lang ,
        },
        success: function (data) {
            $("#height_option").html(data.height);
            $("#toping_option").html(data.top);
            if(current_lang == 'en'){
              $("#write_base").html(data.base + ".00 EGP");
            }else {
              $("#write_base").html(data.base + ".00 ج.م");
            }
           
            $("#addtext").data("price", data.base);
            $('#height_option').removeClass("hidden_height");
        },
      });

});

// Changing the Height options -> update the prices 
jQuery(document).on("change", "#height_option", function () {

    var selectedPrice = $(this).find(":selected").data("price");
    customized_cake['height'] = $(this).val();
    if( customized_cake.full_price.find(item => item.key === 'topping_price').value > 0 ){

    }else{
      customized_cake.full_price.find(item => item.key === 'base_price').value = selectedPrice; 
      selected_base_price = selectedPrice ; 
    }
   
  
    let sum = customized_cake.full_price.reduce((total, item) => total + item.value, 0);
    $('.total-cake-price').html(new Intl.NumberFormat().format(sum));
    console.log(customized_cake);
    $('.btn_next').removeClass('hidden_next');
    allow_steps['two']="allow";


});

//Changing the Flavor 
jQuery(document).on("change", "#flavor_option", function () {

     customized_cake['flavor'] = $(this).val();
    customized_cake['filling'] = 'without' ;
    customized_cake.full_price.find(item => item.key === 'filling_price').value = 0 ;
     console.log(customized_cake);
     $("#cake_container").attr("src", get_image_url("color"));
     $.ajax({
        type: "POST",
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
          action: "sbs_change_flavor",
          selected_flavor : $(this).val() , 
          lang : current_lang ,
        },
        success: function (data) {
            $("#filling_option").html(data.filling);
            $('.btn_next').removeClass('hidden_next');
            var firstOption = $("#filling_option .s_option:first input");
            var dataPrice = firstOption.data("price");
            var value = firstOption.val();
            customized_cake['filling'] =  value ;  
            customized_cake.full_price.find(item => item.key === 'filling_price').value = dataPrice;   
            let sum = customized_cake.full_price.reduce((total, item) => total + item.value, 0);
            $('.total-cake-price').html(new Intl.NumberFormat().format(sum));

            // Display the values (you can use them as needed)
            allow_steps['three']= 'allow';
                  },
      });



});

jQuery(document).on("change", "#filling_option input[type='radio']", function () {
    let filling_price = ($(this).data('price'));
    let selected_filling = $(this).val(); 
    customized_cake['filling'] = selected_filling ;
    customized_cake.full_price.find(item => item.key === 'filling_price').value = filling_price;
    let sum = customized_cake.full_price.reduce((total, item) => total + item.value, 0);
    $('.total-cake-price').html(new Intl.NumberFormat().format(sum));
    console.log(customized_cake);
});

jQuery(document).on("change", "#color_option input[type='radio']", function () {
  let selected_color= $(this).val(); 
  customized_cake['color'] = selected_color ;
  $("#cake_container").attr("src", get_image_url("color"));
  console.log(customized_cake);
    $('.btn_next').removeClass('hidden_next');
});






jQuery(document).on("click", "#nextButton", function () {

  let activeElement = $('.step.active');
  let classList = activeElement.attr('class').split(' ');
  let activeClasses = classList.filter(className => className !== 'active');

  if(allow_steps[activeClasses[1]] == 'dont_allow'){
     $('.btn_next').addClass('hidden_next');
  }

});
 jQuery(document).on("click", "#prevButton", function () {
  let activeElement = $('.step.active');
  let classList = activeElement.attr('class').split(' ');
  let activeClasses = classList.filter(className => className !== 'active');
  //console.log(activeClasses);
  // if(activeClasses[1] == 'three' || activeClasses[1] == 'two' ){
  //   allow_steps['three']="dont_allow";
  // }
 });


$(document).on('click', '#add-shape3d', function(e){
  e.preventDefault();
  var activeElements = $(".min_widget.active");
  var activeSlugs = [];
  let shape3d_full_price = 0 ;
 
  activeElements.each(function() {
    var slug = $(this).data("slug");
    var price = $(this).data("price");
    shape3d_full_price = shape3d_full_price + price ;
    activeSlugs.push(slug);
  });

  customized_cake.shapes3d = [];
  customized_cake.shapes3d.push(activeSlugs);
  $.ajax({
    type: "POST",
    dataType: 'JSON',
    url: mitch_ajax_url,
    data: {
      action: "sbs_add_3dshape",
      activeSlugs : activeSlugs, 
      lang : current_lang ,
    },
    success: function (data) {
         $(".list_icons").html(data.shapes3d);
         $(".js-popup-closer").trigger("click");
         customized_cake.full_price.find(item => item.key === 'shape3d_price').value = 0 ; 
         customized_cake.full_price.find(item => item.key === 'shape3d_price').value = shape3d_full_price;
         let sum = customized_cake.full_price.reduce((total, item) => total + item.value, 0);
        $('.total-cake-price').html(new Intl.NumberFormat().format(sum));
      console.log(customized_cake);
        $('.min_widget').removeClass('active');
        $('.min_widget').removeClass('disable');


        },
  });



});


$(document).on('click', '.material-icons.unselect_icon', function(e){
  var price = $(this).closest(".outside").data("price");
  $(this).closest(".outside").remove();

  customized_cake.full_price.find(item => item.key === 'shape3d_price').value -= price;
  let sum = customized_cake.full_price.reduce((total, item) => total + item.value, 0);
  $('.total-cake-price').html(new Intl.NumberFormat().format(sum));
});


console.log("Step By Step Cake Js Loaded " );


// Changing the Toping  (Ramy)
jQuery(document).on("change", "#toping_option", function () {
    customized_cake['toping'] = $(this).val();
    customized_cake['color'] = '' ;
    $("#cake_container").attr("src", get_image_url("topping"));
  //update price 
  $('.btn_next').removeClass('hidden_next');

    var selectedPrice = $(this).find(":selected").data("price");
    customized_cake.full_price.find(item => item.key === 'topping_price').value = selectedPrice;
    customized_cake.full_price.find(item => item.key === 'base_price').value = 0;
    let sum = customized_cake.full_price.reduce((total, item) => total + item.value, 0);
    $('.total-cake-price').html(new Intl.NumberFormat().format(sum));
  $('.btn_next').removeClass('hidden_next');
    allow_steps['five'] = "allow";
    console.log(customized_cake);


});


// Writing on the Cake 
$('#cake_text').on('input', function() {
  var cakeText = $(this).val(); // Get the text entered in the textarea
  customized_cake['text_on_cake'] = cakeText ;
});


$('#cake_text_base').on('input', function() {
  customized_cake['text_on_base'] = $(this).val() ;
  var isEmpty = $(this).val().trim() === '';
  $('.btn_next').toggleClass('hidden_next', isEmpty);
});


$('#order_notes').on('input', function() {
  customized_cake['notes_on_order'] = $(this).val() ;
});

$("#addtext").on("click", function () {
  if ($(this).prop("checked")) {
    customized_cake.full_price.find(item => item.key === 'writing_price').value = parseInt($(this).data("price"));
    let sum = customized_cake.full_price.reduce((total, item) => total + item.value, 0);
    $('.total-cake-price').html(new Intl.NumberFormat().format(sum));
    var isEmpty =    $('#cake_text_base').val().trim() === ''; 
    if(isEmpty){
      $('.btn_next').addClass('hidden_next');
    }else{
      $('.btn_next').removeClass('hidden_next');
    }
  

  } else {
    $('.btn_next').removeClass('hidden_next');
    customized_cake.full_price.find(item => item.key === 'writing_price').value = 0 ;
    let sum = customized_cake.full_price.reduce((total, item) => total + item.value, 0);
    $('.total-cake-price').html(new Intl.NumberFormat().format(sum));
    customized_cake['text_on_base'] = '';
  }

  console.log(customized_cake);
});


jQuery(document).on("change", "#writing_option input[type='radio']", function () {

  if($(this).val() == 'without-writing'){
    $('.btn_next').removeClass('hidden_next');
  }else {
    if($('#addtext').prop("checked")){
      var isEmpty = $('#cake_text_base').val().trim() === ''; 
      if(isEmpty){
        $('.btn_next').addClass('hidden_next');
      }else{
        $('.btn_next').removeClass('hidden_next');
      }
    }

  }

  console.log($(this).val());
 });




// Review Order 
jQuery(document).on("click", "#nextButton", function () {
  if ($(".seven").hasClass("active")) {
   // Load Cake Data 

   $.ajax({
    type: "POST",
    dataType: 'JSON',
    url: mitch_ajax_url,
    data: {
      action: "sbs_cake_review",
      shape : customized_cake['shape'] ,
      size : customized_cake['size'] ,
      height : customized_cake['height'] ,
      flavor : customized_cake['flavor'] ,
      filling : customized_cake['filling'] ,
      color :  customized_cake['color'] , 
      toping: customized_cake['toping'], 
      shapes : customized_cake['shapes3d'], 
      lang : current_lang ,
    },
    success: function (data) {
      $(".shape-review").html(data.shape);
      if(current_lang == 'en'){
        $(".size-review").html( customized_cake['size'] + "- Enough for " + data.size +  " people" );
      } else {
        if (data.size < 10) {
          $(".size-review").html( customized_cake['size'] + " تكفي " + data.size +  " افراد" );
      
        } else {
          $(".size-review").html( customized_cake['size'] + " تكفي " + data.size +  " فرد" );
      
        }
      
      }
   
      $(".height-review").html( customized_cake['height']); 
      $(".flavor-review").html(data.flavor);
      $(".filling-review").html(data.filling);

      if(customized_cake.full_price.find(item => item.key === 'topping_price').value == 0){
        $(".topping-review").html(data.color);
        $(".topping-price").html(customized_cake.full_price.find(item => item.key === 'shape3d_price').value);
         $('.shapes-review').html(data.shapes_final);
       }else{
        $(".topping-review").html(data.toping);
        $(".topping-price").html(customized_cake.full_price.find(item => item.key === 'topping_price').value);
       }

        },
  });

   
  
   if(customized_cake.full_price.find(item => item.key === 'writing_price').value == 0 ){
    if(current_lang == 'en'){
      $(".writing-review").html("Without writing on base ");
    }else{
      $(".writing-review").html("بدون كتابة علي القاعدة ");
    }
   
   }else{
    if(current_lang == 'en'){
      $(".writing-review").html("With writing on base");
    }else{
      $(".writing-review").html("مع كتابة علي القاعدة ");
    }
   }


   // Load Cake 
   $(".base-price").html(customized_cake.full_price.find(item => item.key === 'base_price').value);
   $(".filling-price").html(customized_cake.full_price.find(item => item.key === 'filling_price').value);
   $(".topping-price").html(customized_cake.full_price.find(item => item.key === 'topping_price').value);
   $(".writing-price").html(customized_cake.full_price.find(item => item.key === 'writing_price').value);
  }
});

jQuery(document).on("click", "#add_custom_cake_to_cart", function () {
  let sum = customized_cake.full_price.reduce((total, item) => total + item.value, 0);
  customized_cake['delivery_date'] = $("#result_date").text(); 
  customized_cake['delivery_time'] = $('#time_option').val(); 
  if (customized_cake['shapes3d'].length == 0) {
    var shapes3d = ""; 
  } else {
    var shapes3d = customized_cake['shapes3d'][0].join(' , ');
  }
  $.ajax({
    type: "POST",
    dataType: 'JSON',
    url: mitch_ajax_url,
    data: {
      action: "sbs_add_to_cart",
      shape : customized_cake['shape'] ,
      size : customized_cake['size'] ,
      height : customized_cake['height'] ,
      flavor : customized_cake['flavor'] ,
      filling : customized_cake['filling'] ,
      color :  customized_cake['color'] , 
      toping: customized_cake['toping'], 
      shapes3d : shapes3d ,
      text_on_cake : customized_cake['text_on_cake'] ,
      text_on_base : customized_cake['text_on_base'] ,
      notes_on_order : customized_cake['notes_on_order'] ,
      delivery_date : customized_cake['delivery_date'] ,
      delivery_time: customized_cake['delivery_time'], 
      lang : current_lang , 
      


      price : sum ,
    },
    success: function (data) {
      window.location.href = data.redirect ;

        },
  });

});

// Handling Next And Previous Experince 
