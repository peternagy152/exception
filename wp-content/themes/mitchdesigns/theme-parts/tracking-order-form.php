<div class="box">
    <div class="section_title">
      <h2><?php echo $fixed_string['myaccount_page_order_track_title'];?></h2>
      <p><?php echo $fixed_string['myaccount_page_order_track_desc'];?></p>
    </div>
    <form action="<?php echo home_url('tracking-order/');?>">
        <label for=""><?php echo $fixed_string['myaccount_page_orders_orderno'];?></label>
        <div class="action">
          <input type="number" name="order_id" value="<?php if(isset($order_id)){echo $order_id;}?>" lang="en">
          <button type="submit"><?php echo $fixed_string['myaccount_page_order_track'];?></button>
        </div>
    </form>
</div>

