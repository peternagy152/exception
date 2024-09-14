<?php global $language;

if(isset($_GET['product_cat']) && !empty($_GET['product_cat'])){
  $filtered_category = sanitize_text_field($_GET['product_cat']);
}else{
  $filtered_category = '';
}

if(isset($_GET['occasion']) && !empty($_GET['occasion'])){
  $filtered_occasion = sanitize_text_field($_GET['occasion']);
}else{
  $filtered_occasion = '';
}

if(isset($_GET['product_tag']) && !empty($_GET['product_tag'])){
  $filtered_tag = sanitize_text_field($_GET['product_tag']);
}else{
  $filtered_tag = '';
}

if(isset($_GET['gender']) && !empty($_GET['gender'])){
  $filtered_gender = sanitize_text_field($_GET['gender']);
}else{
  $filtered_gender = '';
}

if(isset($_GET['forwho']) && !empty($_GET['forwho'])){
  $filtered_forwho = sanitize_text_field($_GET['forwho']);
}else{
  $filtered_forwho = '';
}
?>
<?php
//Get All Subcategories
$page_object = get_queried_object();
$termchildren = get_terms('product_cat',array('child_of' => $page_object->term_taxonomy_id));

?>

<?php $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>
<?php if (strpos($url,'collections') == false) {  ?>
<form action="" class="section_filter">
    <div class="section_ranking" style="display:none" >
        <!-- <label for="">Sort</label> -->
        <div class="select_arrow"  >
            <select class="sorting sort" data-slug="<?php if(!is_shop() && isset($term_slug)){echo $term_slug;}?>"
                data-type="<?php if(!is_shop() && isset($term->taxonomy)){echo $term->taxonomy;}else{echo 'shop';}?>">
                <option value="popularity"
                    class="sortby<?php echo (isset($_GET['orderby']) && $_GET['orderby'] == 'popularity')? ' active':''; ?>"
                    selected>
                    <?php echo ($language == 'en')? 'Most Popular' : 'الاكثر طلباً' ?>
                    
                </option>
                <option value="date"
                    class="sortby <?php echo (isset($_GET['orderby']) && $_GET['orderby'] == 'date')? 'active':'';?>">
                    <?php echo ($language == 'en')? 'New Arrivals': 'وصل حديثاً' ?>
                </option>
                <option value="stock"
                    class="sortby <?php echo (isset($_GET['orderby']) && $_GET['orderby'] == 'stock')? 'active':'';?>">
                    <?php echo ($language == 'en')? 'Available first': 'المتاح أولاً' ?>
                </option>
                <option value="price"
                    class="sortby <?php echo (isset($_GET['orderby']) && $_GET['orderby'] == 'price')? 'active':'';?>">
                    <?php echo ($language == 'en')? 'Low Price first': 'السعر الأقل أولاً' ?>
                    
                </option>
                <option value="price-desc"
                    class="sortby <?php echo (isset($_GET['orderby']) && $_GET['orderby'] == 'price-desc')? 'active':'';?>">
                   
                    <?php echo ($language == 'en')? 'High Price first': ' السعر الأعلي أولاً ' ?>
                </option>
            </select>
        </div>
    </div>
    <div class="section_ranking_custom">
        <h3 class="result_sort"> <?php echo ($language == 'en')? 'Most Popular' : 'الاكثر طلباً' ?></h3>
        <ul class="list_sort">
          <li data-value = "popularity" class="sortby active"><?php echo ($language == 'en')? 'Most Popular' : 'الاكثر طلباً' ?> </li>

          <li data-value = "date" class="sortby"><?php echo ($language == 'en')? 'New Arrivals': 'الاجدد' ?></li>

          <li data-value = "price-desc" class="sortby"> <?php echo ($language == 'en')? 'High Price first': ' السعر الأعلي أولاً ' ?></li>

          <li  data-value = "price" class="sortby"> <?php echo ($language == 'en')? 'Low Price first': 'السعر الأقل أولاً' ?></li>
        </ul>
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
</form>
<?php }  ?>