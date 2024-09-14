<?php
    global $language;
    require_once 'header.php';
?>
<div id="page" class="site">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
    <div class="site-content content_branches">
      <div class="grid">
        <div class="page_branches">
            <div class="section_list">
                <div class="section_city">
                    <h1><?php echo ($language == 'en')? 'Branches' : 'الفروع' ?></h1>
                    <?php
                        $taxonomy_1 = 'cities';
                        $product_cats = get_terms(
                          $taxonomy_1,
                            array(
                                'orderby' => 'name',
                                'order' => 'ASC',
                                "hide_empty" => false
                            )
                        );
                      if (!empty($product_cats) && is_array($product_cats)) {
                      $count_menu=1;
                    ?>

                    <div class="list_menu">
                          <div class="branches_menu">
                                <a href="#" class="categories_branches active" data-val="" data-title="All">
                                  <span class="text"> <?php echo ($language == 'en')? 'All' : 'الكل' ?></span>
                                </a>
                                <?php foreach ($product_cats as $product_cat) { 
                                  $title_cat_ar = get_field('attribute_in_arabic', $product_cat);
                                ?>
                               
                                <a href="#city_<?php echo $count_menu ?>" class="categories_branches <?php //echo $count_menu == 1 ? 'active' : ''; ?>" data-val="<?php echo $product_cat->term_id; ?>" data-title="<?php echo $product_cat->name; ?>" >
                                    <span class="text"><?php echo ($language == 'en')? $product_cat -> name : $title_cat_ar ?></span>
                                </a>
                              <?php $count_menu++; } ?>
                            </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="section_branches">
                      <div id="ajax_loader_branch" style="display:none;">
                          <div class="loader"></div>
                      </div>
                    <?php  
                        $args = array(  
                            'post_type' => 'branch',
                            'post_status' => 'publish',
                            'posts_per_page' => -1, 
                            'orderby' => 'date', 
                            'order' => 'asc', 
                        );
                        $the_query = new WP_Query( $args );
                        if ( $the_query->have_posts() ) {
                        $count_list = 1;
                    ?>
                        <div class="branches list_branches" data-cat='' data-count="-1" data-posts="0" data-page="1">
                            
                              <?php   
                                  while ( $the_query->have_posts() ) {
                                  $the_query->the_post();
                                  $title_ar = get_field('branch_arabic_name');
                                  $address = get_field('branch_arabic_address');
                                  $address_en = get_field('branch_english_address');
                                  $branch_open = get_field('branch_open');
                                  $branch_close = get_field('branch_close');
                                  $branch_open_en = get_field('branch_open_en');
                                  $branch_close_en = get_field('branch_close_en');
                                  $branch_map = get_field('location_link');
                                  // $phone = get_field('phone');
                              ?>
                                <a class="single_branch <?php echo $count_list == 1 ? 'active' : ''; ?>"  data-item="<?php echo get_the_ID(); ?>" id="product_<?php echo get_the_ID(); ?>_block" href="#product_<?php echo get_the_ID(); ?>_block <?php //the_permalink(); ?>">
                                      <div class="box">
                                          <h3><?php echo ($language == 'en')? the_title() : $title_ar ?></h3>
                                          <p><?php echo ($language == 'en')?  $address_en : $address ?></p>
                                          <!-- <span class="call">
                                            <img src="<?php //echo get_stylesheet_directory_uri(); ?>/assets/img/icons/call-black.png" alt="" width="15" height="15">
                                            <?php //echo $phone ?>
                                          </span> -->
                                          <ul class="time">
                                            <li>
                                              <h6><?php echo ($language == 'en')? 'Working Hours : ' : '  مواعيد العمل :' ?></h6>
                                            </li>
                                            <li><?php echo ($language == 'en')?  $branch_open_en : $branch_open ?></li>
                                            <span>-</span>
                                            <li><?php echo ($language == 'en')?  $branch_close_en : $branch_close ?></li>
                                          </ul>
                                          <?php $all_kind = get_field('branch_kind'); if( $all_kind ): ?>
                                            <ul class="kind">
                                               <?php if( $all_kind && in_array('pastry', $all_kind ) ) {  ?>
                                                    <li>
                                                      <span><?php echo ($language == 'en')? 'Pastry' : 'حلواني' ?></span>
                                                    </li>
                                                <?php }  if( $all_kind && in_array('pizza', $all_kind ) ) {  ?>
                                                    <li>
                                                      <span><?php echo ($language == 'en')? 'Pizza' : 'بيتزا' ?></span>
                                                    </li>
                                                <?php }  if( $all_kind && in_array('cafe', $all_kind ) ) { ?>
                                                  <li>
                                                    <span><?php echo ($language == 'en')? 'Cafe' : 'كافية' ?></span>
                                                  </li>
                                                <?php } ?>
                                                    
                                            </ul>
                                          <?php endif; ?>
                                      </div>
                                </a>
                              <?php $count_list++; }  ?>
                        </div>
                     <?php wp_reset_postdata(); } ?>

                </div>
            </div>
            <!-- slect map -->
              <?php  
                    $args = array(  
                        'post_type' => 'branch',
                        'post_status' => 'publish',
                        'posts_per_page' => -1, 
                        'orderby' => 'date', 
                        'order' => 'DESC', 
                    );
                    $the_query = new WP_Query( $args );
                    if ( $the_query->have_posts() ) {
                    $count_map = 1;
              ?>
            <div class="section_map" data-cat='' data-count="10" data-posts="0" data-page="1">
                  <?php   
                      while ( $the_query->have_posts() ) {
                      $the_query->the_post();
                      $title_ar = get_field('branch_arabic_name');
                      $address = get_field('branch_arabic_address');
                      $address_en = get_field('branch_english_address');
                      $branch_map = get_field('location_link');
                      // $phone = get_field('phone');
                  ?>
                <div class="single_map <?php echo $count_map == 1 ? 'active' : ''; ?>" data-item="<?php echo get_the_ID(); ?>" id="product_<?php echo get_the_ID(); ?>_block" >
                  <img class="map_image" src="<?php the_post_thumbnail_url(); ?>" alt="">
                  <div class="box_map">
                        <div class="box_bk">
                          <h5><?php echo ($language == 'en')? the_title() : $title_ar ?></h5>
                          <p><?php echo ($language == 'en')?  $address_en : $address ?></p>
                          <?php if($branch_map): ?>
                          <a class="icon_directione" href="<?php echo  $branch_map; ?>" target='_blank'>
                              <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icons/icon_directione.png" alt="" width="20" height="20">
                              <?php echo ($language == 'en')?  'Direction' : 'الاتجاهات' ?>
                          </a>
                          <?php endif; ?>
                        </div>
                  </div>
                </div>
                <?php $count_map++; }  ?>
            </div>
            <?php wp_reset_postdata(); } ?>
        </div>
      </div>
       
    </div>
  <!--end page-->
</div>
<?php require_once 'footer.php';?>
