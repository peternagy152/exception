<?php
require_once '../wp-content/themes/mitchdesigns/header.php';
//mitch_validate_logged_in();
//repeat order process
//$user_orders = mitch_get_myorders_list();
// $language = 'ar' ;
?>

<div id="page" class="site">
    <?php require_once '../wp-content/themes/mitchdesigns/theme-parts/main-menu.php';?>
    <!--start page-->
    <div class="site-content page_myaccount f_password">
        <div class="grid">

                        
                <?php 
                if(isset($_POST['reset_password'])){
                    $user_email = $_POST['user_email'];
                    $user = get_user_by('email', $user_email);
                    if($user){
                        $key = wp_generate_password(20, false);
                        update_user_meta($user->ID, 'reset_password_key', $key);
                        update_user_meta($user->ID, 'reset_password_time', time());
                        $reset_link =  $theme_settings['site_url'].'/myaccount/reset-password.php'.'?key='.$key.'&email='.$user_email;
                        $message = 'Click the following link to reset your password: '.$reset_link;
                        wp_mail($user_email, 'Reset Your Password', $message);
                        ?>
                          <div class=" callback-message success-message show-message  ">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/new_icons/star.png"
                                alt="" class="success-icon">

                            <p> <?php echo Myaccount_translation('Forgot_success' , $language )  ?> </p>
                        </div>
                        <?php 
                        echo '<pre>';
                        var_dump($reset_link); 
                        echo '</pre>';
                    }else{
                        ?>
                           <div class=" callback-message error-message show-message  ">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/new_icons/warning.png"
                                alt="" class="error-icon">
                            <p><?php echo Myaccount_translation('Forget_invalid' , $language )  ?> </p>
                        </div>
                        <?php 
                    }
                }
                ?>


            <div class="page_content">
                <div class="forgot-password">
                        <h4> <?php echo Myaccount_translation('Forgot_entry' , $language )  ?></h4>

                        <form class="MD-inputs" action="#" method="post">
                            <div class="MD-field ">
                                <label for=""><?php echo Myaccount_translation('Forgot_username' , $language )  ?></label>
                                <input type="email" name="user_email" id="user_email" required>
                            </div>

                            <input class="MD-btn" type="submit" name="reset_password" value=" <?php echo Myaccount_translation('Reset_password_reset' , $language )  ?> ">
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