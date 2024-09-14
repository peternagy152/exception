<?php
require_once '../wp-content/themes/mitchdesigns/header.php';
mitch_validate_logged_in();
global $current_user;
?>
<?php 
// Get Points General Settings 
$points_settings  = get_field('points_settings' , "options");
$level_name = $points_settings['groups'][0]['level_name'];
$account_start = $points_settings['general_settings']['account_creation_start_points'];

//User Data 
$user_points_info = MD_get_user_points_info($current_user->ID);
$next_level_info =  MD_check_if_level_available($user_points_info , $points_settings);


// Points System 
$user_balance = $user_points_info -> current_points ;
$user_cash = $user_points_info -> current_cash ;
$user_points_history = MD_get_user_point_history() ;
$user_points_history = array_reverse($user_points_history);

?>
<div id="page" class="site">
<?php require_once '../wp-content/themes/mitchdesigns/theme-parts/main-menu.php';?>
    <!--start page-->
    <div class="site-content page_myaccount">
        <div class="grid">
            <div class="page_content">
                <div class="section_nav">
                    <div class="section_title">
                        <span class="<?php echo strtolower( $user_points_info->user_type) ; ?>"><?php echo $user_points_info->user_type ; ?></span>
                        <h3 class="name">
                            <?php echo get_user_meta($current_user->ID, 'first_name', true).' '.get_user_meta($current_user->ID, 'last_name', true);?>
                        </h3>
                    </div>
                    <?php include_once 'myaccount-sidebar.php';?>
                </div>
                <div class="dashbord">
                    <div class="my-wallet">
                        <ul class="MD-breadcramb">
                            <li><a href="<?php echo home_url();?>">Home</a></li>
                            <li>My Account</li>
                            <li>My wallet</li>
                        </ul>
                        <div class="topbBox section">
                            <div class="left">
                                <h1 class="dashboard-title">My Wallet</h1>
                                <p class="description">Wallet balance are available to be used on your upcoming order,
                                    Can’t be refund in cash</p>
                            </div>

                            <a href="#add-points" class="MD-btn js-MD-popup-opener">Charge Wallet</a>

                        </div>

                        <div class="points section">
                            <p>Wallet Balance</p>

                            <div class="right">
                                <div class="title">
                                    <h4><?php echo $user_balance ?> Points <span>(<?php echo $user_cash?> EGP)</span></h4>
                                   
                                </div>
                                <div class="progress">
                                    <?php  if($next_level_info['level'] == 1){ ?>
                                    <?php $percentage = ( $user_points_info->total_money / $points_settings['groups'][$user_points_info->level_number + 1]['start_from']  ) * 100?>
                                    <?php  } ?>
                                    <div class="bar" style="width:<?php if($next_level_info['level'] == 1){ echo $percentage ;} else {echo '100' ;}?>%"></div>
                                </div>
                                <?php if($next_level_info['level'] == 1){ ?>
                                <span class="message"><?php echo $next_level_info['next_level_remaining_points'] ; ?> Points to <?php echo $next_level_info['next_level_name'] ; ?></span>
                                <?php }  ?>
                            </div>

                        </div>
                        <div class="boxes section">
                            <div class="single-box">
                                <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/new_icons/login.png"
                                    alt="">
                                <p class="title">Create Account</p>
                                <span><?php echo $account_start ?> Points</span>
                            </div>
                            <div class="single-box">
                                <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/wallet-b.png" alt="">
                                <p class="title">Make A Purchase</p>
                                <span>  1 EGP /  <?php   echo  $points_settings['groups'][$user_points_info->level_number]['currency_to_points'] ?> Points </span>
                            </div>
                            <div class="single-box">
                                <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/share-b.png" alt="">
                                <p class="title">Share on </br>Social Media <span>(Once a Month)</span></p>
                                <span> <?php   echo  $points_settings['groups'][$user_points_info->level_number]['share_on_social_media'] ?>  Points</span>
                            </div>
                            <div class="single-box">
                                <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/birthday-b.png" alt="">
                                <p class="title">Birthday Bonus</p>
                                <span> <?php   echo  $points_settings['groups'][$user_points_info->level_number]['birthday_bonus'] ?>  Points</span>
                            </div>
                            <div class="single-box">
                                <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/friends-b.png" alt="">
                                <p class="title">Refer Friends</p>
                                <span> <?php   echo  $points_settings['groups'][$user_points_info->level_number]['refer_to_friends'] ?>  Points</span>
                            </div>
                        </div>
                        <div class="button">
                            <a href="#add-points" class="MD-btn js-MD-popup-opener">Charge Wallet</a>
                        </div>
                        <div class="points-history section">
                            <h3 class="section-title-basic">Points History</h3>
                        <?php if(!wp_is_mobile()){ ?>
                            <div class="desktop">
                                <table>
                                    <tr>
                                        <th>Points</th>
                                        <th>Date</th>
                                        <th>Reason</th>
                            
                                        <th>Total Points</th>
                                    </tr>
                                    <?php $history_number = 0 ; ?>
                                    <?php foreach($user_points_history as $one_history){ ?>
                                        <?php $history_number++;?>
                                        <?php if($history_number == 25){ break ;} ?>
                                    <tr class="<?php if($one_history -> type == 'Increase'){echo "green";}else{echo "red" ;} ?>">
                                        <td class="points-details"> <?php echo $one_history -> points_number ?> Points</td>
                                        <td> <?php echo  explode(' ' , $one_history-> date )[0]  ?></td>
                                        <td> <?php echo $one_history -> msg ?> </td>
                                       
                                        <td> <?php echo $one_history -> points_after ?> Points</td>
                                    </tr>
                                    <?php }  ?>


                                </table>
                            </div>
                        <?php } ?>
                        <?php if(wp_is_mobile()){ ?>
                            <div class="mobile">
                            <table>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <?php $history_number = 0 ; ?>
                                    <?php foreach($user_points_history as $one_history){ ?>
                                        <?php $history_number++;?>
                                        <?php if($history_number == 25){ break ;} ?>
                                    <tr class="<?php if($one_history -> type == 'Increase'){echo "green";}else{echo "red" ;} ?>">
                                        <td class="points-details"> <?php echo $one_history -> points_number ?> Points</td>
                                        <td> <?php echo  explode(' ' , $one_history-> date )[0]  ?></td>
                                        <td> <?php echo $one_history -> msg ?> </td>
                                       
                                        <td> <?php echo $one_history -> points_after ?> Points</td>
                                    </tr>
                                    <?php }  ?>
                            </table>
                            </div>
                        <?php } ?>

                           
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