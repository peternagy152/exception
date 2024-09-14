<div class="MD-popup" id="change-password">
    <div class="popup__window">
        <button class="MD-close js-MD-popup-closer"><span class="material-symbols-rounded">
                close
            </span></button>
        <h2 class="MD-popup-title"> <?php echo Popup('Current_password' , $language) ?> </h2>
        <div class="password-message  success-message">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/new_icons/star.png" alt="">
            <div class="message-info">
                <p>Thank You For Joining mitchdesigns</p>
            </div>

        </div>
        <form class="MD-inputs" id="change_password" action="#" method="post">
            <div class="MD-field ">
                <label for=""> <?php echo Popup('Current_password' , $language) ?> <span>*</span></label>
                <!-- <span class="MD-show-password"></span> -->
                <input type="password" name="current_password" required>
                <a class="MD-link" href="<?php if($language == 'en'){echo $theme_settings['site_url'] . '/myaccount/forgot_password.php?lang=en' ; }else{echo $theme_settings['site_url'] . '/myaccount/forgot_password.php' ;}?>"> <?php echo Popup('forgot_password' , $language) ?> </a>
            </div>
            <div class="MD-field ">
                <label for=""><?php echo Popup('New_password' , $language) ?> <span>*</span></label>
                <!-- <span class="MD-show-password"></span> -->
                <input type="password" name="new_password" required>
            </div>
            <div class="MD-field">
                <label for=""><?php echo Popup('Confirm_new_password' , $language) ?> <span>*</span></label>
                <!-- <span class="MD-show-password"></span> -->
                <input type="password" name="confirm_password" required>
            </div>
            <button type="submit" class="MD-btn"> <?php echo Popup('account_change_password' , $language) ?> </button> 
        </form>
    </div>

</div>
<?php
$all_govs = MD_get_all_data_govs();
?>
<div class="MD-popup" id="add-new-addresss">
    <div class="popup__window">
        <button class="MD-close js-MD-popup-closer"><span class="material-symbols-rounded">
                close
            </span></button>
        <!-- <h2 class="MD-popup-title add-address"> <?php //echo Myaccount_translation('shipping_add_new_address' , $language) ?> </h2> -->
        <h2 class="MD-popup-title"> 
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/MD_myaccount_icon/menu/addresse.png" alt="" width="25" height="25">
          <?php echo Myaccount_translation('shipping_add_new_address' , $language) ?>
        </h2>
        <?php
        $main_address    = mitch_get_user_main_address($current_user_id);
        ?>
        <form id="form-add" class="MD-inputs" method="#" action="POST"
            data-where="<?php if(empty($main_address)){ echo "add" ;} ?>">
            <div class="MD-field">
                <label for=""><?php echo Myaccount_translation('shipping_city' , $language) ?> <span>*</span></label>
                <select name="city" id="city" required>
                    <?php $gov_name  = "gov_name_" . $language ;?>
                    <option value=""><?php echo Popup('choose_city' , $language)  ?></option>
                    <?php foreach($all_govs as $one_gov){ ?>
                    <option  value="<?php echo $one_gov->gov_id ?>"><?php echo $one_gov->$gov_name ?></option>
                    <?php }  ?>

                </select>
            </div>
            <div class="MD-field">
                <label for=""><?php echo Myaccount_translation('shipping_area' , $language) ?> <span>*</span></label>
                <select name="area" id="add_address_area" required="required" >
                <option value=""><?php echo Popup('choose_area' , $language)  ?></option>
                </select>
            </div>
            <div class="MD-field">
                <label for=""><?php echo Myaccount_translation('shipping_district' , $language) ?> <span>*</span></label>
                <select name="district" id="add_area_district">
                <option value=""><?php echo Popup('choose_district' , $language)  ?></option>

                </select>
            </div>
            <div class="MD-field">
                <label for=""><?php echo Myaccount_translation('shipping_street' , $language) ?> <span>*</span></label>
                <input class="full-address" type="text" name="street_info" required >
            </div>
            <div class="MD-field half_full">
                <label for=""><?php echo Myaccount_translation('shipping_floor' , $language) ?><span>*</span></label>
                <input class="floor" type="number" name="floor" required>
            </div>
            <div class="MD-field half_full">
                <label for=""><?php echo Myaccount_translation('shipping_apartment' , $language) ?> <span>*</span></label>
                <input class="apartment" type="number" name="apartment" required>
            </div>
            <button type="submit" class="MD-btn add-address ">  <?php echo Myaccount_translation('shipping_add_new_address' , $language) ?>  </button>
    </div>
    </form>

</div>
<div class="MD-popup" id="edit-addresss">
    <div class="popup__window">
        <button class="MD-close js-MD-popup-closer"><span class="material-symbols-rounded">
                close
            </span></button>
        <!-- <h2 class="MD-popup-title edit-address"> <?php //echo Myaccount_translation('shipping_edit_address' , $language) ?> </h2> -->
        <h2 class="MD-popup-title"> 
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/MD_myaccount_icon/menu/addresse.png" alt="" width="25" height="25">
          <?php echo Myaccount_translation('shipping_edit_address' , $language) ?>
        </h2>
        <form id="edit-address" class="MD-inputs" action="#" method="post" data-edit="">
            <div class="MD-field">
                <label for=""><?php echo Myaccount_translation('shipping_city' , $language) ?><span>*</span></label>
                <select name="city" id="edit_city">
                    <?php foreach($all_govs as $one_gov){ ?>
                    <option  value="<?php echo $one_gov->gov_id ?>"><?php echo $one_gov->$gov_name ?></option>
                    <?php }  ?>
                </select>
            </div>
            
            <div class="MD-field">
                <label for=""><?php echo Myaccount_translation('shipping_area' , $language) ?><span>*</span></label>
                <select name="area" id="edit_area">
                </select>
            </div>
            <div class="MD-field">
                <label for=""><?php echo Myaccount_translation('shipping_district' , $language) ?><span>*</span></label>
                <select name="district" id="edit_district">
                </select>
            </div>
            <div class="MD-field">
                <label for=""><?php echo Myaccount_translation('shipping_street' , $language) ?><span>*</span></label>
                <input id="street_info" type="text" name="street_info">
            </div>
            <div class="MD-field half_full">
                <label for=""><?php echo Myaccount_translation('shipping_floor' , $language) ?><span>*</span></label>
                <input id="floor" type="number" name="floor">
            </div>
            <div class="MD-field half_full">
                <label for=""><?php echo Myaccount_translation('shipping_apartment' , $language) ?><span>*</span></label>
                <input id="apartment" type="number" name="apartment">
            </div>
            <button type="submit" class="MD-btn"><?php echo Myaccount_translation('shipping_edit_address' , $language) ?></button>
        </form>
    </div>

</div>

<div class="MD-popup" id="cancel-order">
    <div class="popup__window">
        <button class="MD-close js-MD-popup-closer"><span class="material-symbols-rounded">
                close
            </span></button>
        <div class="press-div">
            <h2 class="MD-popup-title">Cancel Order #<?php echo $order_id; ?></h2>
            <form class="MD-inputs" id="cancellation" data-order="<?php echo $order_id ; ?>" action="#" method="post">
                <div class="MD-field">
                    <label for="">Choose why you want to cancel your order.</label>
                    <select name="reasons" id="reasons">
                        <?php foreach($terms as $one_reason){ ?>

                        <option value="<?php echo  $one_reason -> name  ?>" class="others">
                            <?php echo  $one_reason -> name  ?></option>

                        <?php } // Foreach Reason  ?>
                        <option value="other-reason" id="other-reason">Other Reason</option>

                    </select>
                </div>
                <div class="MD-field" id="textarea-reasons">
                    <label for="">Write briefed cancelation reason (Optional) </label>
                    <textarea name="other_reasons" id="" cols="4" rows="4"></textarea>
                </div>

                <button type="submit" class="MD-btn-red press-btn">Cancel Order</button>
            </form>
        </div>
        <div class="MD-thanks hide">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/trash.png" alt="">
            <h2 class="thanks-title">Order Canceled</h2>
            <p>Order #<?php echo $order_id ; ?> canceled successfully</p>
            <a class="MD-btn" href="<?php echo home_url();?>">Back To Home</a>

        </div>

    </div>

</div>

<div class="MD-popup return-order" id="return-order">
    <div class="popup__window">
        <button class="MD-close js-MD-popup-closer"><span class="material-symbols-rounded">
                close
            </span></button>
        <div class="MD-thanks hide">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/recycle.png" alt="">
            <h2 class="thanks-title">Order Returned</h2>
            <p>Order #354896 returned successfully</p>
            <a class="MD-btn" href="<?php echo home_url();?>">Back To Home</a>

        </div>

    </div>

</div>

<div class="MD-popup add-points" id="add-points">
    <div class="popup__window">
        <button class="MD-close js-MD-popup-closer"><span class="material-symbols-rounded">
                close
            </span></button>
        <h2 class="MD-popup-title">Do You Have Points Code?</h2>
        <p class="description">Add code and point will be added to your wallet balance</p>

        <div class=" charge-wallet success-message  ">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/new_icons/star.png" alt=""
                class="success-icon">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/new_icons/warning.png" alt=""
                class="error-icon">
            <div class="account-message-info">
                <p> Account Info Changed Successfully </p>
            </div>

        </div>

        <form class="MD-inputs" id="add-more-points" action="#" method="post">
            <div class="MD-field">
                <input type="text" name="code" placeholder="Add Code">
                <p class="note"> <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/note-sign.png"
                        alt="">Can’t Use Code More Than One Time</p>
            </div>

            <button type="submit" class="MD-btn">Apply Code</button>
        </form>
    </div>

</div>