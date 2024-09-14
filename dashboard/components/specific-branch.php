<?php 
  $session_info = explode('-', $_SESSION['admin_dashboard']); 
  $branch_id = $session_info[2] ;
  global $wbdb; 
  $matched_branch =  $wpdb->get_row("SELECT  *  FROM pwa_branches WHERE branch_id = {$branch_id}"  ); 

 
?>
<!-- Start Page -->

<div class="s_branch">
    <div class="section_head">
        <div class="grid">
            <div class="content">
                <div class="logo">
                    <img src="../wp-content/themes/mitchdesigns/assets/img/web_logo.png" alt="">
                </div>
                <div class="info">
                    <h3>
                        <?php echo $session_info[0]?>
                        <a class = "destroy-session" href="#">تسجيل خروج</a>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <div class="grid">
            <div class="dashboard_head ">
                <div class="branch_info">
                    <h2>قائمة الأصناف
                        <span><?php echo $matched_branch -> branch_name_ar ; ?></span>
                    </h2>
                    <?php if($session_info[1] == 'master' ) {  ?>
                        <button class = "view_master_branch" > قائمه الفروع </button>
                    <?php }  ?> 
                </div>
                
                <?php  require_once "components/analytics-bar.php"; ?>
            </div>

            <div class="nav_dashboard_single">
                  <div class="container_single">
                      <div class="section_filter_single">
                          <ul class="branches_filter">
                              <li class="active">
                                  <a href="#">
                                      <span>جميع الأصناف</span>
                                      <!-- <strong>163</strong> -->
                                  </a>
                                  
                              </li>
                              <li>
                                  <a href="#">
                                      <span>أصناف متاحة </span>
                                      <!-- <strong>120</strong> -->
                                  </a>
                              </li>
                              <li>
                                  <a href="#">
                                      <span>أصناف غير متاحة </span>
                                      <!-- <strong>43</strong> -->
                                  </a>                                    
                              </li>
                          </ul>
                      </div>
                      <div class="section_search">
                        <?php require_once 'components/categories-dropdown.php'; ?>
                      </div>
                  </div>
            </div>

            <div class="dashboard_tabel">
                <div class="section_tabel">
                    <table>
                        <tr>                                        
                            <th></th>
                            <th>اسم المنتج </th>
                            <th>النوع </th>
                            <th>السعر </th>
                        </tr>
                           
                            <?php require_once 'components/get-product-list.php'; ?>
                            <?php 
                              foreach($product_ids as $one_product){
                              $product_obj = wc_get_product($one_product);
                              $Excluded_branches = get_post_meta($one_product, '_branches', true);
                              $Excluded = false ;
                              if(!empty($Excluded_branches)){ 
                                  if(in_array($branch_id , $Excluded_branches)){
                                  $Excluded = true;
                                  } 
                              }
                            ?>
                            <tr class = "product_with_<?php echo $one_product ; ?> <?php if($Excluded){echo "excluded_from_branch";}else{echo 'included_in_branch' ;} ?>">
                                <!-- product excluded  -->
                                <td class = "product_status product_status_<?php echo $one_product ; ?> <?php if($Excluded){echo "excluded";}else{echo 'included' ;} ?>"> 
                                    <label class="container">
                                        <input data-product = "<?php echo $one_product ; ?>" class = "change_status"type="checkbox" <?php if(!$Excluded){echo 'checked="checked"' ;} ?>>
                                        <span class="checkmark"></span>
                                    </label>
                                </td>

                                <!-- product Image  -->
                                <td class="product_image">
                                    <div class="sec">
                                      <img  src="<?php  echo get_the_post_thumbnail_url($one_product)  ?>" alt="">
                                      <?php echo get_post_meta($one_product , 'product_data_arabic_title' , true); ?>
                                    </div>
                                </td>

                                <!--  product cat  -->
                                <td>
                                    <?php $categories = $product_obj->get_category_ids(); ?>
                                    <?php foreach($categories as $one_cat) {echo get_field('attribute_in_arabic', 'product_cat_' . $one_cat) . ' , ' ;}?>
                                </td>

                                <!-- product price  -->
                                <td class="price">
                                  <?php echo $product_obj->get_price(); ?> جنيه 
                                </td>

                            </tr>
                            <?php }  ?>
                    </table>
                </div>
            </div>

    </div>
</div>
<!-- End Page -->

<div class="buttons_page grid">
    <?php if(!isset($_GET['search'])){ ?> 
      <?php if($previous_page != 0 ){ ?>
        <a href="<?php if(isset($_GET['cat'])){echo $theme_settings['site_url'] . '/dashboard/branch.php?page=' . $previous_page . '&cat=' . $_GET['cat'] ;}else{echo $theme_settings['site_url'] . '/dashboard/branch.php?page=' . $previous_page ;} ?>"> السابق</a>
    <?php }  ?>
    <?php if(count($product_ids) == 30){ ?>
        <a href="<?php if(isset($_GET['cat'])){echo $theme_settings['site_url'] . '/dashboard/branch.php?page=' . $next_page . '&cat=' . $_GET['cat'] ;}else{echo $theme_settings['site_url'] . '/dashboard/branch.php?page=' . $next_page ;} ?>"> التالى</a>
    <?php } }  ?>
</div>

  
 