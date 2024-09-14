var full_quries = window.location.search;
var all_params = new URLSearchParams(full_quries);
function search(ele) {
    if(event.key === 'Enter') {
       // alert(ele.value); 
       window.location.href = "branch.php?search=" + ele.value ;
    }
}

$("#category").on("change", function () {
    if(this.value == ''){
        window.location.href = "branch.php" ;
    }else{
        window.location.href = "branch.php?page=1&cat=" + this.value ;
    }
   
});



// User Login 
$("#login-branch").on("submit", function (e) {

    e.preventDefault();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
            action: "MD_custom_dashboard_login",
            form_data: $(this).serialize(),
        },
        success: function (data) {
            if(data.status == 'error'){
                $('.message').html(data.msg);
                $('.error_msg').addClass('show');
            }else{
                window.location.href = "branch.php";
            }
          

        }
    })
});

$(".view_branch_details").on("click", function () {
    let branch_id =  $(this).data('branch');

  $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
            action: "MD_view_branch_details",
            branch_id: branch_id ,
        },
        success: function (data) {
            if(data.status == "success"){
                window.location.reload();
            }

        }
    })
 });

 $(".view_master_branch").on("click", function () {
    let branch_id =  0 ;

  $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
            action: "MD_view_branch_details",
            branch_id: branch_id ,
        },
        success: function (data) {
            if(data.status == "success"){
                window.location.reload();
            }
        }
    })
 });

 $(".destroy-session").on("click", function () {
  $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
            action: "MD_destroy_session",
        },
        success: function (data) {
            if(data.status == "success"){
                window.location.reload();
            }
        }
    })
 });


 // Exclude From Branch Feature  
 $(".change_status").on("click", function () {
    let product_id =  $(this).data('product');
    let isChecked = $(this).prop("checked");
    $('#ajax_loader').show();
    $.ajax({
          type: 'POST',
          dataType: 'JSON',
          url: mitch_ajax_url,
          data: {
              action: "MD_change_product_status",
              product_id : product_id,
              isChecked : isChecked
          },
          success: function (data) {
            $('#ajax_loader').hide();
            if(isChecked){
                $('.product_with_' + product_id).removeClass('excluded_from_branch');
                $('.product_status_' + product_id).removeClass('excluded');
                $('.product_status_' + product_id).addClass('included');
                $('.product_with_' + product_id).addClass('included_in_branch');
            }else{
                $('.product_status_' + product_id).addClass('excluded');
                $('.product_status_' + product_id).removeClass('included');
                $('.product_with_' + product_id).removeClass('included_in_branch');
                $('.product_with_' + product_id).addClass('excluded_from_branch');
            }

           
          }
      })
      
   });
  
  



console.log("Dashboard Js Is Loaded") ;