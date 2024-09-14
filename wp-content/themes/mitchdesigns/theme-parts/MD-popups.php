<?php  var_dump("Inside Theme"); ?>
<div class="MD-popup" id="change-password">
    <div class="popup__window">
        <button class="MD-close js-MD-popup-closer"><span class="material-symbols-rounded">
                close
            </span></button>
        <h2 class="MD-popup-title">Change Password</h2>
        <div class="password-message  success-message">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/new_icons/star.png" alt="">
            <div class="message-info">
                <p>Thank You For Joining exception</p>
            </div>

        </div>
        <form class="MD-inputs" id="change_password" action="#" method="post">
            <div class="MD-field ">
                <label for="">Please Enter Your Current Password<span>*</span></label>
                <!-- <span class="MD-show-password"></span> -->
                <input type="password" name="current_password" required>
                <a class="MD-link" href="">Forgot Your Password?</a>
            </div>
            <div class="MD-field ">
                <label for="">Enter Your New Password<span>*</span></label>
                <!-- <span class="MD-show-password"></span> -->
                <input type="password" name="new_password" required>
            </div>
            <div class="MD-field">
                <label for="">Confirm Your New Password<span>*</span></label>
                <!-- <span class="MD-show-password"></span> -->
                <input type="password" name="confirm_password" required>
            </div>
            <button type="submit" class="MD-btn">Change Password</button>
        </form>
    </div>

</div>
<?php
$states = get_field('states_cities' , 'options');
//var_dump($states);

?>

<div class="MD-popup" id="add-new-addresss">
    <div class="popup__window">
        <button class="MD-close js-MD-popup-closer"><span class="material-symbols-rounded">
                close
            </span></button>
        <h2 class="MD-popup-title add-address">Add New Address</h2>
        <?php
        $main_address    = mitch_get_user_main_address($current_user_id);
        ?>
        <form id="form-add" class="MD-inputs" method="#" action="POST"
            data-where="<?php if(empty($main_address)){ echo "add" ;} ?>">
            <div class="MD-field">
                <label for="">City<span>*</span></label>
                <select name="city" id="city">
                    <?php foreach($states as $one_state){ ?>
                    <option value="<?php echo $one_state['state_en'] ?>"><?php echo  $one_state['state_en'] ?></option>
                    <?php }  ?>

                </select>
            </div>
            <div class="MD-field">
                <label for="">Area<span>*</span></label>
                <select name="area" id="area" required >
                    <option value="Nasr City">Nasr City</option>
                    <option value="New Cairo">New Cairo</option>
                    <option value="Masr El Gdida">Masr El Gdida </option>
                </select>
            </div>
            <div class="MD-field">
                <label for="">Street & Building No.<span>*</span></label>
                <input class="full-address" type="text" name="street_info" required >
            </div>
            <div class="MD-field">
                <label>Apartment Type</label>
                <div class="radio-buttons">
                    <div class="single-radio">
                        <input value="flat" type="radio" name="apartment_type" id="flat" checked>
                        <label for="flat">Flat</label>
                    </div>
                    <div class="single-radio">
                        <input value="villa" type="radio" name="apartment_type" id="villa">
                        <label for="villa">Villa</label>
                    </div>

                </div>
            </div>
            <div class="MD-field small">
                <label for="">Floor.<span>*</span></label>
                <input class="floor" type="text" name="floor" required>
            </div>
            <div class="MD-field small">
                <label for="">Apartment<span>*</span></label>
                <input class="apartment" type="text" name="apartment" required>
            </div>
            <button type="submit" class="MD-btn add-address ">Add Address</button>
    </div>
    </form>

</div>
<div class="MD-popup" id="edit-addresss">
    <div class="popup__window">
        <button class="MD-close js-MD-popup-closer"><span class="material-symbols-rounded">
                close
            </span></button>
        <h2 class="MD-popup-title edit-address">Edit Address</h2>
        <form id="edit-address" class="MD-inputs" action="#" method="post" data-edit="">
            <div class="MD-field">
                <label for="">City<span>*</span></label>
                <select name="city" id="edit_city">
                <?php foreach($states as $one_state){ ?>
                    <option value="<?php echo $one_state['state_en'] ?>"><?php echo  $one_state['state_en'] ?></option>
                    <?php }  ?>
                </select>
            </div>
            <div class="MD-field">
                <label for="">Area<span>*</span></label>
                <select name="area" id="edit_area">
                    <option value="Cairo">Cairo</option>
                    <option value="Giza">Giza</option>
                    <option value="Alex">Alex</option>
                </select>
            </div>
            <div class="MD-field">
                <label for="">Street & Building No.<span>*</span></label>
                <input id="street_info" type="text" name="street_info">
            </div>
            <div class="MD-field">
                <label>Apartment Type</label>
                <div class="radio-buttons">
                    <div class="single-radio">
                        <input value="flat" type="radio" name="apartment_type" id="">
                        <label for="male">Flat</label>
                    </div>
                    <div class="single-radio">
                        <input value="villa" type="radio" name="apartment_type" id="">
                        <label for="female">Villa</label>
                    </div>

                </div>
            </div>
            <div class="MD-field small">
                <label for="">Floor.<span>*</span></label>
                <input id="floor" type="text" name="floor">
            </div>
            <div class="MD-field small">
                <label for="">Apartment<span>*</span></label>
                <input id="apartment" type="text" name="apartment">
            </div>
            <button type="submit" class="MD-btn">Edit Address</button>
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
        <!-- <div class="press-div">
            <h2 class="MD-popup-title">Return Order #354896</h2>
            <form class="MD-inputs" id="cancellation" action="#" method="post">
                <div class="style">
                    <div class="items">
                        <div class="MD-field">
                            <p class="item-title">Please select items you want to return</p>
                        </div>
                        <div class="MD-field">
                            <input type="checkbox">
                            <div class="product-details">
                                <div class="image">
                                    <img src="https://www.cloudhosta.com:61/wp-content/uploads/2023/01/Rectangle2-300x300.png"
                                        alt="">
                                </div>
                                <div class="details">
                                    <div class="first">
                                        <h3 class="title">Trace Gold Ring</h3>
                                        <ul class="variations">
                                            <li class="size">Size: <span>M</span></li>
                                            <li class="color">Color: <span style="background:#F3E2C0;"></span></li>
                                        </ul>
                                    </div>

                                    <div class="prices">
                                        <p>EGP 5,200</p>
                                    </div>
                                </div>
                            </div>
                            <div class="section_qty">

                                <div class="select_arrow">
                                    <select class="number_count" name="product_quantity">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4" selected="">4</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="MD-field">
                            <input type="checkbox">
                            <div class="product-details">
                                <div class="image">
                                    <img src="https://www.cloudhosta.com:61/wp-content/uploads/2023/01/Rectangle2-300x300.png"
                                        alt="">
                                </div>
                                <div class="details">
                                    <h3 class="title">Trace Gold Ring</h3>
                                    <ul class="variations">
                                        <li class="size">Size: <span>M</span></li>
                                        <li class="color">Color: <span style="background:#F3E2C0;"></span></li>
                                    </ul>
                                    <div class="prices">
                                        <p>EGP 5,200</p>
                                    </div>
                                </div>
                            </div>
                            <div class="section_qty">

                                <div class="select_arrow">
                                    <select class="number_count" name="product_quantity">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4" selected="">4</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="terms-conditions">
                    <input type="checkbox">
                    <label>Agree to return <a href="">terms & conditions</a> </label>
                </div>
                <button type="submit" class="MD-btn press-btn">Return Order</button>
            </form>
        </div> -->
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