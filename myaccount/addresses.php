<?php
require_once '../wp-content/themes/mitchdesigns/header.php';
mitch_validate_logged_in();
$current_user_id = get_current_user_id();
$main_address    = mitch_get_user_main_address($current_user_id);
$other_addresses = mitch_get_user_others_addresses_list($current_user_id);

?>
<div id="page" class="site">
<?php require_once '../wp-content/themes/mitchdesigns/theme-parts/main-menu.php';?>
    <!--start page-->
    <div class="site-content page_myaccount">
        <div class="grid">
            <div class="page_content">
                <div class="section_nav">
                    <div class="box_nav">
                        <?php include_once 'myaccount-sidebar.php';?>
                        <div class="section_title">
                            <!-- <img src="<?php // echo get_stylesheet_directory_uri(); ?>/assets/img/new_icons/login.png" alt=""> -->
                            <span class="<?php echo strtolower( "Silver") ; ?>"><?php echo "Silver" ; ?></span>
                            <h3 class="name">
                                <?php echo get_user_meta($current_user->ID, 'first_name', true).' '.get_user_meta($current_user->ID, 'last_name', true);?>
                            </h3>
                        </div>
                    </div>
                    
                </div>
                <div class="dashbord">
                    <div class="addresses">
                        <ul class="MD-breadcramb">
                            <li><a href="<?php echo home_url();?>"><?php echo Myaccount_translation('myaccount_pagination_home' , $language) ?></a></li>
                            <li><?php echo Myaccount_translation('myaccount_page_title' , $language) ?></li>
                            <li><?php echo Myaccount_translation('myaccount_page_sidebare_address' , $language) ?></li>
                        </ul>
                        <h1 class="dashboard-title"> <?php  echo Myaccount_translation('myaccount_page_sidebare_address' , $language)?>
                            <!-- Add this button only when there is any address -->
                            <?php if(!empty($main_address)){ ?>
                            <a href="#add-new-addresss" class="js-MD-popup-opener MD-btn-add"><?php echo Myaccount_translation('shipping_add_new_address' , $language) ?></a>
                            <?php }  ?>
                            <!-- --- -->
                        </h1>

                        <?php if(empty($main_address)){ ?>
                        <div class="empty-content">
                            <p><?php echo Myaccount_translation('shipping_no_address_note' , $language) ?></p>
                            <a href="#add-new-addresss" class="js-MD-popup-opener MD-btn-add"><?php echo Myaccount_translation('shipping_add_new_address' , $language) ?></a>
                        </div>
                        <?php } ?>
                        <div class="real-data">
                            <!--  ------------ Main Address ----------- -->

                            <?php if(!empty($main_address)){ ?>
                            <div class="single-address">
                                <div class="box">
                                    <div class="side_info">

                                        <h4 class="title"><?php echo Myaccount_translation('shipping_default_address' , $language)   ?></h4>
                        
                                        <div class="MD-row small">
                                            <label><?php echo Myaccount_translation('shipping_city' , $language)   ?></label>
                                            <?php $gov_info = get_gov_name_by_id($main_address -> level_1);  ?>
                                            <?php $gov_name = "gov_name_" . $language ;?>
                                            <span> <?php echo $gov_info-> $gov_name ?></span>
                                            
                                        </div>
                                        <div class="MD-row small">
                                            <label><?php echo Myaccount_translation('shipping_area' , $language)   ?></label>
                                            <?php $area_info = MD_Get_area_by_area_id( $main_address -> level_2); ?>
                                            <?php $area_name = "area_name_" . $language ; ?>
                                                <span> <?php echo $area_info -> $area_name  ?></span>
                                        </div>
                                        <div class="MD-row small">
                                            <label><?php echo Myaccount_translation('shipping_district' , $language)   ?></label>
                                            <?php $street_info = get_street_name_by_id( $main_address -> level_3); ?>
                                            <?php $street_name = "street_name_" . $language ; ?>
                                                <span> <?php echo $street_info -> $street_name  ?></span>
                                        </div>
                                        <div class="MD-row">
                                            <label><?php echo Myaccount_translation('shipping_street' , $language)   ?>.</label>
                                                <span> <?php echo $main_address -> full_address  ?></span>
                                        </div>
                                        <div class="MD-row small">
                                            <label><?php echo Myaccount_translation('shipping_floor' , $language)   ?></label>
                                                <span> <?php echo $main_address -> Floor ?></span>
                                        </div>
                                        <div class="MD-row small">
                                            <label><?php echo Myaccount_translation('shipping_apartment' , $language)   ?></label>
                                            <span> <?php echo $main_address -> apartment ?></span>
                                        </div>
                                    </div>
                                    <div class="side_click">
                                        <div class="MD-menu">
                                            <span class="menu-icon"></span>
                                            <div class="list">
                                                <ul> 
                                                    <li class = "edit-address"  data-counter = "0" data-edit = "<?php echo $main_address -> ID ?>"><a class="js-MD-popup-opener" href="#edit-addresss"> <?php echo Myaccount_translation('shipping_edit_address' , $language) ?></a></li>
                                                    <li class="red remove" data-address ="<?php echo $main_address -> ID ?>" data-default="1"><a><?php echo Myaccount_translation('shipping_remove' , $language) ?></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php }  ?>
                            <!--  -----------  Other Addresses  ----------- -->
                            <?php $address_counter =  0 ;?>
                             <?php foreach($other_addresses as $one_address){ ?>
                                <?php $address_counter++ ; ?>
                            <div class="single-address">
                                <div class="box">
                                    <div class="side_info">
                                        <h4 class="title" ><?php echo Myaccount_translation('shipping_address' , $language)   ?> <?php echo ' ' . $address_counter ; ?></h4>
                                
                                        <div class="MD-row small">
                                            <label><?php echo Myaccount_translation('shipping_city' , $language)   ?></label>
                                            <?php $gov_info = get_gov_name_by_id($one_address -> level_1);  ?>
                                            <?php $gov_name = "gov_name_" . $language ;?>
                                                <span> <?php echo $gov_info-> $gov_name ?></span>
                                        </div>
                                        <div class="MD-row small">
                                            <label><?php echo Myaccount_translation('shipping_area' , $language)   ?></label>
                                            <?php $area_info = MD_Get_area_by_area_id( $one_address -> level_2); ?>
                                            <?php $area_name = "area_name_" . $language ; ?>
                                                <span> <?php echo $area_info -> $area_name  ?></span>
                                        </div>
                                        <div class="MD-row small">
                                            <label><?php echo Myaccount_translation('shipping_area' , $language)   ?></label>
                                            <?php $street_info = get_street_name_by_id( $one_address -> level_3); ?>
                                            <?php $street_name = "street_name_" . $language ; ?>
                                                <span> <?php echo $street_info -> $street_name  ?></span>
                                        </div>
                                        <div class="MD-row">
                                            <label><?php echo Myaccount_translation('shipping_street' , $language)   ?>.</label>
                                            <span> <?php echo  $one_address -> full_address ?></span>
                                        </div>
                                        <div class="MD-row small">
                                            <label><?php echo Myaccount_translation('shipping_floor' , $language)   ?></label>
                                            <span> <?php echo  $one_address -> Floor ?></span>
                                        </div>
                                        <div class="MD-row small">
                                            <label><?php echo Myaccount_translation('shipping_apartment' , $language)   ?></label>
                                            <span> <?php echo  $one_address -> apartment ?></span>
                                        </div>
                                    </div>
                                    <div class="side_click">
                                        <div class="MD-menu">
                                            <span class="menu-icon"></span>
                                            <div class="list">
                                                <ul>
                                                    <li class = "edit-address" data-counter = " <?php echo $address_counter ; ?> " data-edit = "<?php echo $one_address -> ID ?>"><a class="js-MD-popup-opener" href="#edit-addresss"> <?php echo Myaccount_translation('shipping_edit_address' , $language) ?></a></li>
                                                    <li class = "change" data-current-default =" <?php echo $main_address-> ID ?>" data-new-default = "<?php echo $one_address -> ID ?>"><a> <?php echo Myaccount_translation('shipping_make_default' , $language) ?></a></li>
                                                    <li  class="remove red " data-default="0" data-address = "<?php echo $one_address -> ID ?>"><a><?php echo Myaccount_translation('shipping_remove' , $language) ?></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if(!empty($main_address)){ ?>
                            <a href="#add-new-addresss" class="js-MD-popup-opener MD-btn-add"><?php echo Myaccount_translation('shipping_add_new_address' , $language) ?></a>
                            <?php }  ?>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end page-->

</div>

<?php require_once '../wp-content/themes/mitchdesigns/footer.php';?>
<?php include_once 'MD-popups.php'; ?>
<script src="assets/js/my-account.js"></script>
<script src="assets/js/frontend.js"></script>

