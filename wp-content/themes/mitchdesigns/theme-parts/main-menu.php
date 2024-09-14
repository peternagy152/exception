<!--start header-->
<header>
  <?php
  if(!wp_is_mobile()){
    include_once 'header/desktop.php';
  }else{
    include_once 'header/mobile.php';
  }
  ?>
</header>
<!--end header-->
