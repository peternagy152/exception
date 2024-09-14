<?php global $language; ?>
<?php
// getting Avaliable Shapes 
$shapes = get_all_shapes();

?>

    <div class="options shape_option" id="shape_option">
        <h3 class="section_title">  <?php if($language == 'en'){echo 'Shape' ; }else{echo 'الشكل' ;} ?></h3>
        <?php $first_active = true ; $count = 1; ?>
        <?php foreach($shapes as $one_shape){ ?>
            <div class="s_option">
                <div class="option <?php if($first_active){echo 'active' ;} ?>"  data-target="img_<?php echo $count; ?>">
                    <input value = "<?php echo $one_shape->shape_slug ; ?>" type="radio" name="gender" id="" <?php if($first_active){echo 'checked' ; $first_active = false;} ?>>
                    <?php $shape_name = "shape_" . $language ; ?>
                    <label for="<?php echo $one_shape->shape_slug ; ?>"><?php echo $one_shape-> $shape_name ?></label>
                </div>
            </div> 
            <?php $count++; }  ?>
    </div>