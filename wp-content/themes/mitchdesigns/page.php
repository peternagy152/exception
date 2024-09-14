<?php require_once 'header.php'; global $post; //var_dump($post);?>
<div id="page" class="site">
  <?php
  require_once 'theme-parts/main-menu.php';
  $cate = get_queried_object();
  if(is_product_category() && $cate){
    require_once 'theme-parts/page/category.php';
  }else{
    require_once 'theme-parts/page/page.php';
  }
  ?>
</div>
<?php require_once 'footer.php';?>
