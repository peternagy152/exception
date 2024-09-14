<style>
.section_filter_mobile .sorting p {
    margin-bottom: 8px;
}
</style>
<?php
global $language;
//Get All Subcategories
$page_object = get_queried_object();
$termchildren = get_terms('product_cat',array('child_of' => $page_object->term_taxonomy_id));
$collections = false ;
 $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
 if (strpos($url,'collections') !== false) {  
    $collections = true ;

 }
?>

<div class="sectin_filter_sticky">
<?php if (!$collections) {  ?>
    <form action="" class="section_filter_mobile">
        <div class="nav_filter hidden_overlay">
            <div class="icon">
                <a class="click filter js-popup-opener" href="#popup-filter">
                    <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/icons/filter.png" alt="">
                    Filter
                </a>
                <p class="click sort" href="">

                    <span>Sort</span>Most Popular <img
                        src="<?php echo $theme_settings['theme_url'];?>/assets/img/icons/arrow_down_gray.png" alt="">
                </p>
            </div>
            <div class="cart">
                <!-- <a href="<?php// echo home_url('cart');?>"> -->
                <a href="#popup-min-cart" class="js-popup-opener">
                    <div class="section_icon_cart">
                        <?php //echo WC()->cart->get_total();?>
                        <span id="cart_total_count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                        <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/icons/cart.png" alt="">
                    </div>
                </a>
            </div>
        </div>
        <?php if (!$collections) {  ?>
        <div class="section_ranking">
            <!-- <label for="">Sort</label> -->
            <div class="sec_sort">
                <div class="sorting sort" data-slug="<?php if(!is_shop() && isset($term_slug)){echo $term_slug;}?>"
                    data-type="<?php if(!is_shop() && isset($term->taxonomy)){echo $term->taxonomy;}else{echo 'shop';}?>">
                    <p class="sortby active" onclick="mitch_sort_by('popularity');">
                        <?php echo ($language == 'en')? 'Most Popular' : 'الاكثر طلباً' ?>
                    </p>
                    <p class="sortby" data-value = "New Arrivals" onclick="mitch_sort_by('date');">
                        <?php echo ($language == 'en')? 'New Arrivals': 'وصل حديثاً' ?>
                    </p>
                    <p class="sortby" onclick="mitch_sort_by('stock');">
                        <?php echo ($language == 'en')? 'Available': 'المتاح أولاً' ?>
                    </p>
                    <p class="sortby" onclick="mitch_sort_by('price');">
                        <?php echo ($language == 'en')? 'Low Price first': 'السعر الأقل أولاً' ?>
                    </p>
                    <p class="sortby" onclick="mitch_sort_by('price-desc');">
                        <?php echo ($language == 'en')? 'High Price first': ' السعر الأعلي أولاً ' ?>
                    </p>
                </div>
            </div>
        </div>
        <?php }  ?>
    </form>
    <?php }  ?>
</div>
<div id="popup-filter" class="popup filter">
    <div class="popup__window filter">
        <div id="filter" class="form-content">
            <div class="head">
                <h4>Filter</h4>
                <button type="button" class="popup__close material-icons js-popup-closer">close</button>
            </div>
            <div class="list_filter">

                <div class="form-checkbox <?php //echo ($id == $product_category->term_id)?'open':'';?>">
                    <!-- <h3 class="category_link">Category</h3> -->
                    <div class="content_filter">

                        <div class="more-cats more-cats-action">
                            <!-- <p class="more result">More</p> -->
                            <div class="all_form_checkbox active">

                            <?php foreach($termchildren as $one_category){ ?>
                                <?php if($one_category->slug == 'uncategorized' || $one_category->slug == 'add-ons'){continue;} ?>
                        <div class="<?php //echo $count_cats.' '.$all_count;?> form-checkbox-content">
                            <input type="checkbox" class="filled-in filter_input filter-cat checkbox-box"
                                value="<?php echo $one_category->slug;?>" id="checkbox-cat-" />
                            <label class="checkbox-label" for="checkbox-cat-">
                                <?php  if( $language == 'en') { ?>
                                    <?php echo $one_category->name; ?>
                                  <?php } else { ?>
                                    <?php echo get_field('attribute_in_arabic', 'product_cat_' . $one_category->term_id) ; ?>
                                <?php } ?>
                            </label>
                        </div>

                        <?php } ?>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="section_action">
            <p class="botton_filter">Apply Filters</p>
            <a href="" class="clear">Clear Filters</a>
        </div>
    </div>
</div>