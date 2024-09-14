<?php
require_once '../wp-content/themes/mitchdesigns/header.php';
mitch_validate_logged_in();
global $current_user;
$user_points_info = MD_get_user_points_info($current_user->ID);

if(isset($_GET['order_id']))
{
    $order_id  = intval($_GET['order_id']);
    if(get_post_meta($order_id, '_customer_user', true) != get_current_user_id()){
      wp_redirect(home_url('myaccount/orders-list.php'));
      exit;
    }
    $order_obj = wc_get_order($order_id);
} else {
    wp_redirect(home_url('myaccount/orders-list.php'));
}

if(empty($order_obj)){
    
    wp_redirect(home_url('myaccount/orders-list.php'));
}
else {
?>
<div id="page" class="site">
<?php require_once '../wp-content/themes/mitchdesigns/theme-parts/main-menu.php';?>
    <!--start page-->
    <div class="site-content page_myaccount">
        <div class="grid">
            <div class="page_content">
                <div class="section_nav">
                    <div class="section_title">
                        <!-- <img src="<?php // echo get_stylesheet_directory_uri(); ?>/assets/img/new_icons/login.png" alt=""> -->
                        <span class="<?php echo strtolower( $user_points_info->user_type) ; ?>"><?php echo $user_points_info->user_type ; ?></span>
                        <h3 class="name">
                            <?php echo get_user_meta($current_user->ID, 'first_name', true).' '.get_user_meta($current_user->ID, 'last_name', true);?>
                        </h3>
                    </div>
                    <?php include_once 'myaccount-sidebar.php';?>
                </div>
                <div class="dashbord">
                    <div class="return-products">
                        <ul class="MD-breadcramb">
                            <li><a href="<?php echo home_url();?>">Home</a></li>
                            <li>My Account</li>
                            <li>Orders & Returns</li>
                        </ul>
                        <h1 class="dashboard-title"> <a
                                href="<?php echo home_url('myaccount/order-details.php?order_id=' . $order_id );?>"> <i
                                    class="material-icons">chevron_left</i></a> Return Order #<?php echo  $order_id ?></h1>
                        <form data-order = "<?php echo $order_id ?>" id ="return-products" class="MD-inputs" action="#" method="post">
                            <div class="style">
                                <p class="item-title">Please select items you want to return</p>

                                <div class="items">
                                    <?php $product_counter = 0; ?>
                                <?php  foreach($order_obj->get_items() as $key => $values){  ?>
                                    <?php $product_counter++; ?>
                                <?php   $order_item_data = mitch_get_short_product_data($values['product_id']); ?>

                                    <div class="MD-field">
                                        <?php    $product    = $values->get_product(); ?>
                                        <input 
                                        data-value="<?php if(!empty($values->get_variation_id())) {echo $values->get_variation_id(); }else {echo $values['product_id'] ;}  ?>"
                                        data-price = "<?php echo $values['line_total'] / $values['quantity']; ?>"
                                         class = "product_checkbox" type="checkbox"  name = "product_id[]" value = "<?php if(!empty($values->get_variation_id())) {echo $values->get_variation_id(); }else {echo $values['product_id'] ;}  ?>"
                                         > 
                                        <div class="product-details">
                                        <div class="image">
                                                <a href=""><img
                                                        src="<?php echo $order_item_data['product_image'];?>"
                                                        alt="<?php echo $order_item_data['product_title'];?>"></a>
                                            </div>
                                            <div class="details">
                                                <div class="first">
                                                <h3 class="title"><?php echo $order_item_data['product_title'];?></h3>
                                                <ul class="variations">
                                        <?php  
                                     
                                        if( $product->is_type('variation') ){
                                            $variation_attributes = $product->get_variation_attributes();

                                            Call_GLobal_Variables_For_Cart();
                                            global $color_hex_data;
                                            //var_dump($color_hex_data);

                                            foreach($variation_attributes as $attribute_taxonomy => $term_slug ){
                                                $taxonomy = str_replace('attribute_', '', $attribute_taxonomy );
                                                $attribute_name = wc_attribute_label( $taxonomy, $product );
                                                if( taxonomy_exists($taxonomy) ) {
                                                    $attribute_value = get_term_by( 'slug', $term_slug, $taxonomy )->name;
                                                } else {
                                                    $attribute_value = $term_slug; 
                                                }

                                        ?>

                                      <?php  if($attribute_name == 'Color'){ ?>
                                        <?php
                                             $Current_color = str_replace(' ', '', $attribute_value);
                                             $Current_color = str_replace('-' , '' ,$Current_color); 
                                            // var_dump($Current_color);
                                            
                                            ?>
                                        <li class="color">Color: <span style="background:<?php echo get_field('color_hex_code','term_'.$color_hex_data[strtolower($Current_color)].'') ; ?>;"></span></li>
                                        <?php } else { ?>
                                            <li > <?php echo $attribute_name . " : " ?> <span><?php echo $attribute_value ;?></span></li>
                                            <?php } ?>
                                        <?php }  ?>
                                        <?php } ?>
                                    </ul>
                                                </div>

                                                <div class="prices">
                                                <p><?php echo 'EGP ' . number_format($values['line_total'] / $values['quantity']);?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="section_qty">

                                            <div class="select_arrow">
                                                <?php 
                                                     $which = false ;
                                                   if(!empty($values->get_variation_id())) {
                                                    $value = $values->get_variation_id(); 
                                                    $which =true ;
                                                    }else {
                                                        $value = $values['product_id'] ;
                                                        } 
                                                ?>
                                          
                                                <select 
                                                disabled 
                                                data-price = "<?php echo $values['line_total'] / $values['quantity']; ?>"
                                                class="number_count product_quantity_<?php if($which){echo $values->get_variation_id(); }else{echo $values['product_id'] ;} ?>"  name="product_quantity[]" >
                                                <!-- <option value="<?php //echo $x . '-'. $values['product_id'] ; ?>"><?php //echo $x ; ?></option> -->
                                                    <?php for($x=1;$x <= $values['quantity'] ; $x++){ ?>
                                                      
                                                       <?php $value_temp = '';
                                                       $value_temp = $value_temp . $x . '-' . $value ;
                                                       ?>
                                                        <option  value="<?php echo $value_temp ?>"><?php echo $x ; ?></option>
                                                        <?php } ?>
                            
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }  ?>
                                </div>
                            </div>
                            <div class="bottom">
                                <div class="top">
                                    <div class="total MD-row">
                                        <p class="title">Total</p>
                                        <p data-total = "0" class="total-price">EGP 0.00</p>
                                    </div>
                                </div>
                                <!-- <div class="terms-conditions">
                                    <input type="checkbox">
                                    <label>Agree to return <a href="">terms & conditions</a> </label>
                                </div> -->
                                <button type="submit" class="MD-btn press-btn">Return Order</button>
                            </div>

                            </div>
                       </form>
                </div>
            </div>
        </div>
    </div>
    <!--end page-->
</div>
<?php }  ?>

<?php require_once '../wp-content/themes/mitchdesigns/footer.php';?>
<?php include_once 'MD-popups.php'; ?>
<script src="assets/js/my-account.js"></script>