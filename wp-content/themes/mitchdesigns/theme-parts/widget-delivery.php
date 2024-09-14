<!-- <?php 
// $after_three_days  = date("l d M Y", strtotime("+ 3 days")); 
// if(date('l', strtotime($after_three_days)) == "Friday"){
//     $after_three_days = date("l d M Y", strtotime($after_three_days . " + 1 days"));
// }

// $after_five_days = date("l d M Y", strtotime("+ 5 days"));
// if(date('l', strtotime($after_five_days)) == "Friday"){
//     $after_five_days = date("l d M Y", strtotime($after_five_days . " + 1 days"));
// }
// $from_3_to_5_days = "from ".$after_three_days." to ".$after_five_days;
// $during_24_hour   = date("l d M Y", strtotime("+24 hour"));
?>
<div class="delivery-component">
    <h3>Choose Delivery Date</h3>
    <div class="radio-btns">
        <label for="from_3_to_5_days" class="from_3_to_5_days selected">
            <input type="radio" id="from_3_to_5_days" name="delivery_date" value="<?php echo $from_3_to_5_days;?>"/>
            <div class="right">
                <p class="national">Delivery within 3-5 days</p>
                <span class="placeholder-text-with-icon national-format-date">
                    <span><?php echo $from_3_to_5_days;?></span>
                </span>
            </div>
            <div class="left">
                <span>75 EGP</span>
            </div>
        </label>
        <label for="delivery_day_tomorrow" class="delivery_day_tomorrow">
            <input type="radio" id="delivery_day_tomorrow" name="delivery_date" value="Delivery During 24h: <?php echo $during_24_hour;?>"/>
            <div class="right">
                <p>Delivery within 24 Hours</p>                        
                <span><?php echo $during_24_hour; ?></span>
            </div>
            <div class="left">
                <span>130 EGP</span>
            </div>
        </label>
    </div>
</div> -->