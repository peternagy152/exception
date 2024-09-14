<?php
require_once '../wp-content/themes/mitchdesigns/header.php';
mitch_validate_logged_in();
global $current_user;
?>

<?php

// Getting User Meta 
$birth_day = get_user_meta($current_user->ID , 'birth_day');
$birth_month = get_user_meta($current_user->ID , 'birth_month');
$birth_year = get_user_meta($current_user->ID , 'birth_year');



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
                            <span class="silver">Silver</span>
                            <h3 class="name">
                                <?php echo get_user_meta($current_user->ID, 'first_name', true).' '.get_user_meta($current_user->ID, 'last_name', true);?>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="dashbord">
                    <div class="profile_edit">
                        <div class="top">
                            <ul class="MD-breadcramb">
                                <li><a href="<?php echo home_url();?>"><?php echo Myaccount_translation('myaccount_pagination_home' , $language) ?></a></li>
                                <li><?php echo Myaccount_translation('myaccount_page_title' , $language) ?></li>
                                <li><?php echo Myaccount_translation('myaccount_page_sidebare_home' , $language) ?></li>
                            </ul>
                            <h1 class="dashboard-title"><?php echo Myaccount_translation('myaccount_page_sidebare_home' , $language) ?></h1>
                        </div>

                        <?php //if( isset($_GET['accountinfo']) && $_GET['accountinfo'] == "true" ){  ?>
                        <div class="callback-message success-message <?php if( isset($_GET['accountinfo']) && $_GET['accountinfo'] == "true" ){echo 'show-message';}?> ">
                             <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/MD_myaccount_icon/star.png"
                                alt="" class="success-icon">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/MD_myaccount_icon/warning.png"
                                alt="" class="error-icon">
                                <div class="account-message-info">
                                    <p> <?php echo Myaccount_translation('account_info_message' , $language) ?> </p>
                                </div>
                            
                        </div>
                        <?php //} ?>
                        <div class="profile-errors"></div>
                        <div class="section_form">
                            <form  id="edit-profile" class="MD-inputs"  action="#" method="post">
                                <div class="MD-field half_full">
                                    <label
                                        for=""><?php echo Myaccount_translation('account_first_name' , $language) ?><span>*</span></label>
                                    <input value = "<?php echo get_user_meta($current_user->ID, 'first_name', true) ?>" type="text" name="first_name" required>
                                </div>
                                <div class="MD-field half_full">
                                    <label for=""><?php echo Myaccount_translation('account_last_name' , $language) ?> <span>*</span></label>
                                    <input  value = " <?php echo get_user_meta($current_user->ID, 'last_name', true) ?> " type="text" name="last_name" required>
                                </div>
                                <div class="MD-field">
                                    <label for=""><?php echo Myaccount_translation('account_email' , $language) ?><span>*</span></label>
                                    <input value = "<?php echo $current_user -> user_email ?>" type="email" name="user_email" disabled>
                                </div>
                                <div class="MD-field">
                                    <label for=""><?php echo Myaccount_translation('account_mobile' , $language) ?><span>*</span></label>
                                    <input value = "<?php echo get_user_meta($current_user->ID, 'phone_number', true)  ?>" type="text" name="phone_number" required>
                                </div>
                            
                                <div class="MD-field">
                                    <label><?php echo Myaccount_translation('account_birthdate' , $language) ?></label>
                                    <div class="selecting">
                                        <select name="day" id="day">
                                            <option value="" disabled selected >Day</option>
                                            <?php for ($x = 1; $x <= 31; $x++) { ?>
                                            <option <?php if(  $birth_day[0] == $x) {echo 'selected' ;} ?>  value="<?php echo $x ?>"> <?php echo $x ?> </option>
                                            <?php  } ?>
                                        </select>
                                        <select name="month" id="month">
                                            <option value="" disabled selected>Month</option>
                                            <?php 
                                            global $monthTranslations;
                                            ?>
                                             <?php $x = 0; ?>
                                            <?php foreach ($monthTranslations as $month_english => $month_arabic) { ?>
                                                <option  value="<?php echo $x ;  ?>"  <?php if($birth_month[0]== $x ){echo 'selected' ;} ?> > <?php if($language == 'en'){echo $month_english ;}else{echo $month_arabic ;} ?></option>
                                                <?php $x = $x + 1;?>
                                            <?php } ?>
                                        </select>
                                        <select name="year" id="year">
                                            <option value="" disabled selected>Year</option>
                                            <?php for ($x = 1950; $x <= 2016; $x++) { ?>

                                            <option <?php if(  $birth_year[0] == $x) {echo 'selected' ;} ?> value="<?php echo $x ?>"> <?php echo $x ?> </option>
                                            <?php  } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="MD-field">
                                    <label><?php echo Myaccount_translation('account_gender' , $language) ?></label>
                                    <div class="radio-buttons">
                                        <div class="single-radio">
                                            <input value = "M" type="radio" name="gender" id="" <?php if(  get_user_meta($current_user->ID, 'gender', true) == 'M') {echo 'checked' ;} ?>>
                                            <label for="M"><?php echo Myaccount_translation('account_gender_male' , $language) ?></label>
                                        </div>
                                        <div class="single-radio">
                                            <input value = "F" type="radio" name="gender" id="" <?php if(  get_user_meta($current_user->ID, 'gender', true) == 'F') {echo 'checked' ;} ?>>
                                            <label for="F"><?php echo Myaccount_translation('account_gender_female' , $language) ?></label>
                                        </div>

                                    </div>
                                </div>
                                <!-- <div class="MD-field checkbox">
                                    <input  required type="checkbox" name="" id="">
                                    <label>Agree on <a href="<?php //echo home_url('terms-and-conditions');?>">terms &
                                            conditions</a></label>

                                </div> -->

                                <button type="submit" class="MD-btn"><?php echo Myaccount_translation('account_save' , $language) ?></button>
                            </form>
                        </div>
                        <div class="change-passsword-div">
                            <a href="#change-password" class="js-MD-popup-opener"><?php echo Myaccount_translation('account_change_password' , $language) ?></a>
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
