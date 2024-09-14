<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package glosscairo
 */
//global $language;
// get_header();

$current_user = wp_get_current_user();
$cities = get_field('states_cities','option');
// echo "Peter" ;
foreach($cities as $one_city){
  //var_dump($one_city['branch_and_areas']);
  foreach($one_city['branch_and_areas'] as $one_branch){
    foreach($one_branch['area_settings'] as $one_area){
     // echo $one_area['area_ar'];
    }
  }

}
?>
<?php require_once 'header.php';?>
<div id="page" class="site">
 <?php if(strpos($_SERVER['REQUEST_URI'], "order-received") !== false){ ?>
  <?php require_once 'theme-parts/main-menu.php';?>
  <?php }else{ ?>
    <?php require_once 'theme-parts/main-menu-checkout.php';?>
  <?php }  ?>
<div class="checkout-page page_checkout">
	<div class="grid">
		<?php while (have_posts()) : the_post(); ?>
		<?php the_content(); ?>
  <?php endwhile;?>
  <?php
  //echo do_shortcode('[woocommerce_checkout]');
  ?>
	</div>
</div>
</div>
<?php require_once 'footer.php';?>
<script src="../../myaccount/assets/js/my-account.js"></script>
<script>
    $.ajax({
                type: "POST",
                dataType: 'JSON',
                url: mitch_ajax_url,
                data: {
                  action: "on_checkout_load_change_gov_field",
                  lang : current_lang,
                },
                success: function (data) {
                  $("#billing_state").html(data.gover_checkbox);

                },
    });
</script>
<?php  if(is_user_logged_in()){ ?>
  <script>
    
    // Billing Data 
    $('#billing_first_name').val("<?php echo get_user_meta($current_user->ID, 'first_name', true) ?>");
    $('#billing_last_name').val("<?php echo get_user_meta($current_user->ID, 'last_name', true) ?>");
    $('#billing_email').val("<?php echo $current_user -> user_email ?>");
    $('#billing_phone').val("<?php echo get_user_meta($current_user->ID, 'phone_number', true)  ?>");
    // Shipping Data 
      $(".address_option.active").click();
  </script>
  <?php }else{ ?>
<script>

  if(window.location.href.indexOf('checkout')>-1){
    $("#billing_state").change();
    let selected_gov  = 1;
  }
  if(window.location.href.indexOf('my-account/addresses')>-1){
    $("#country").change();
  }
</script>
<?php }  ?>
<?php
// if(is_user_logged_in()){
//   $main_address    = mitch_get_user_main_address(get_current_user_id());
//   if(!empty($main_address)){
//     ?>
     <script>
//       $('#billing_address_1').val('<?php //echo $main_address -> full_address ?>');
//       $('#billing_state').val('<?php //echo $main_address -> city ?>');
//       $.ajax({
//                 type: "POST",
//                 url: mitch_ajax_url,
//                 data: {
//                   action: "get_city",
//                   state: '<?php //echo $main_address -> city   ?>',
//                 },
//                 success: function (posts) {
//                  // if(window.location.href.indexOf('addresses')>-1){
//                     $("#billing_city").html(posts);
//                     $('#billing_city').val('<?php //echo $main_address -> area   ?>');
//                 // }
//                 },
//     });
//     $('#billing_building').val('<?php //echo $main_address -> Floor ?>');
//     $('#billing_building_2').val('<?php //echo $main_address -> apartment ?>');


//     </script>
     <?php 
//   }
// }
?>
<?php
// get_footer();
