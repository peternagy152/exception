<?php 
    global $language; 
    //$language = $theme_settings['current_lang'];?>
<?php
if(!wp_is_mobile()){
  include_once 'filter/desktop.php';
}else{
  // include_once 'filter/mobile.php';
  include_once 'filter/desktop.php';
}
?>
