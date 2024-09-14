<?php
require_once '../wp-content/themes/mitchdesigns/header.php';
global $theme_settings ;
$language = 'ar' ;

?>



<div id="page" class="site">
    <?php require_once '../wp-content/themes/mitchdesigns/theme-parts/main-menu.php';?>
    <!--start page-->
    <div class="site-content page_myaccount f_password">
        <div class="grid">

            <div class="page_content">
            <?php
                if(isset($_POST['change_password'])){
                    $key = $_GET['key'];
                    $user_email = $_GET['email'];
               
                if(empty($user_email) || empty($key)){
                    ?>
                    <div class=" callback-message error-message show-message  ">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/new_icons/warning.png"
                        alt="" class="error-icon">
                    <p> <?php echo Myaccount_translation('Reset_no_parameters' , $language )  ?>  </p>
                    </div>
                    <?php 
                }else{
                    // $user_email = $_GET['email'];
                $sanitized_user_email = str_replace('/','',$user_email );
                $user = get_user_by('email', $sanitized_user_email);
                $stored_key = get_user_meta($user->ID, 'reset_password_key', true);
                $stored_time = get_user_meta($user->ID, 'reset_password_time', true);
                if($key === $stored_key && time() - $stored_time < 3600){
                    $new_password = $_POST['new_password'];

                    $valid = true ;
                    //Check New Password  
                    if(strlen($new_password) < 8  ){
                        ?>
                        <div class=" callback-message error-message show-message  ">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/MD_myaccount_icon/warning.png"
                            alt="" class="error-icon">
                        <p><?php echo ($language == 'en') ?'<p> Password Must Be More Than Or Equals 8 Charecters ! </p>' : 'يجب أن تكون كلمة المرور أكثر من أو تساوي 8 رموز!'?></p>
                        </div>
                        <?php 
                     $valid = false ;
                    }else if(!containsSpecialAndUppercase($new_password)){
                        ?>
                        <div class=" callback-message error-message show-message  ">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/MD_myaccount_icon/warning.png"
                            alt="" class="error-icon">
                        <p><?php echo ($language== 'en') ? '<p> Password Must Contain at  one Uppercase letter  ! </p>' :'يجب أن تحتوي كلمة المرور على حرف كبير واحد' ?>
                        </div>
                        <?php 
                      $valid = false ;
                    }

                    if($valid){
                        wp_set_password($new_password, $user->ID); 
                        delete_user_meta($user->ID, 'reset_password_key');
                        delete_user_meta($user->ID, 'reset_password_time');
                
                    ?>
                    <div class=" callback-message success-message show-message  ">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/MD_myaccount_icon/star.png"
                        alt="" class="success-icon">

                    <p>  <?php echo Myaccount_translation('Reset_success_reset' , $language)  ?>  </p> <a href=" <?php  echo $theme_settings['site_url']; ?>/myaccount/user-login.php " >  <?php echo Myaccount_translation('Reset_login_link' , $language)  ?> </a>.
                    </div>
                    
                    <?php
                    }
                }else{
                    ?>
                    <div class=" callback-message error-message show-message  ">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/MD_myaccount_icon/warning.png"
                        alt="" class="error-icon">
                    <p><?php echo Myaccount_translation('Reset_invalid' , $language)  ?></p>
                    </div>
                    <?php 
                    
                }
            }
                }
?>
                <div class="forgot-password">
                        <h4> <?php echo Myaccount_translation('Reset_password_reset' , $language )  ?>  </h4>

                        <form class="MD-inputs" action="#" method="post">
                            <div class="MD-field ">
                            <label for="new_password"><?php echo Myaccount_translation('Reset_forgot' , $language )  ?>:</label>
                            <input type="password" name="new_password" id="new_password" required>
                            </div>

                            <input class="MD-btn" type="submit" name="change_password" value="<?php echo Myaccount_translation('Reset_change_password' , $language) ?>">
                            <!-- <button type="submit" class="MD-btn">Reset Password</button> -->
                        </form>


                    </div>
            </div>
        </div>
    </div>
    <!--end page-->
    <!-- <div id="overlay" class="overlay"></div> -->

</div>
<?php require_once '../wp-content/themes/mitchdesigns/footer.php';?>
<?php include_once 'MD-popups.php'; ?>
<script src="assets/js/my-account.js"></script>