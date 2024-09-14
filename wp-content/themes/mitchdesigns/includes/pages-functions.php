<?php
function mitch_get_blog_posts(){
  global $theme_settings;
  $args = array(
    'post_type'     => 'post',
    'order'         => 'DESC',
    'posts_per_page'=> -1,
    // 'tag'           => ''.$theme_settings['current_lang'].'-lang'
  );
  return get_posts($args);
}
 $args=array(
  'post_type'=> 'post',
  'posts_per_page' => -1,
  'post_status' =>'publish',
  'suppress_filters' => false,
);



function mitch_get_main_branch_data(){
  $main_branch_id = get_field('main_branch', 'options');
  if(!empty($main_branch_id)){
    return array(
      'name' => get_the_title($main_branch_id),
      'data' => get_field('branch_details', $main_branch_id),
    );
  }
  return;
}

function mitch_get_branch_data($branch_id){
  if(!empty($branch_id)){
    return array(
      'name' => get_the_title($branch_id),
      'data' => get_field('branch_details', $branch_id),
    );
  }
  return;
}
function mitch_custom_menus() {
  register_nav_menus(
    array(
      'top-nav-menu-ar' => _('Top Nav Menu AR'),
      'top-nav-menu-en' => _('Top Nav Menu EN'),
    )
  );
}
add_action('init', 'mitch_custom_menus');
