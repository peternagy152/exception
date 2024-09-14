<?php require_once 'header.php'; global $post; //var_dump($post);?>
<div id="page" class="site">
    <?php
    require_once 'theme-parts/main-menu.php';
    if(!isset($cate) || empty($cate)){
        $cate = get_queried_object(); 
    }
    // echo '<pre>';
    // var_dump($cate);
    // echo '</pre>';
    require_once 'theme-parts/page/category.php';
    ?>
</div>
<?php require_once 'footer.php';?>
