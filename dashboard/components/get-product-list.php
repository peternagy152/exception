<?php 
$products_per_page = 30;
if(isset($_GET['page'])){
   
    $current_page = $_GET['page'];
    $previous_page = $current_page - 1 ;
    $next_page = $current_page + 1 ;
    
}else{
    $next_page = 2 ; 
    $current_page = 1;
    $previous_page = 0 ;
}

if(isset($_GET['search'])){
    $product_ids = get_posts(array(
        'numberposts'    => -1,
        'fields'         => 'ids',
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'orderby'        => array('meta_value_num' => 'desc', 'date' => 'desc'),
        'order'          => 'desc',
        'meta_key'       => 'total_sales',
        'meta_query' => array(
          'relation' => 'OR',
          array(
            'key' => 'product_data_arabic_title',
            'value' => $_GET['search'],
            'compare' => 'LIKE'
          ),
        ),
        'tax_query'      => array(
            'relation'       => 'AND',
            array(
                'taxonomy'         => 'product_visibility',
                'terms'            => array('exclude-from-catalog', 'exclude-from-search'),
                'field'            => 'name',
                'operator'         => 'NOT IN',
                'include_children' => false,
            ), 
        )
      ));
    
}else if(isset($_GET['cat'])){

    $product_ids = get_posts(array(
        'numberposts'    => $products_per_page,
        'paged'          => $current_page,
        'fields'         => 'ids',
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'orderby'        => array('meta_value_num' => 'desc', 'date' => 'desc'),
        'order'          => 'desc',
        'meta_key'       => 'total_sales',
        'tax_query'      => array(
            'relation'       => 'AND',
            array(
                'taxonomy'         => 'product_visibility',
                'terms'            => array('exclude-from-catalog', 'exclude-from-search'),
                'field'            => 'name',
                'operator'         => 'NOT IN',
                'include_children' => false,
            ), 
            array(
              'taxonomy'         => 'product_cat',
              'terms'            => $_GET['cat'],
              'field'            => 'term_id',
              'operator'         => 'IN',
            )
          ),
    ));
    
    }else{
      $product_ids = get_posts(array(
        'numberposts'    => $products_per_page,
        'paged'          => $current_page,
        'fields'         => 'ids',
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'orderby'        => array('meta_value_num' => 'desc', 'date' => 'desc'),
        'order'          => 'desc',
        'meta_key'       => 'total_sales',
        'tax_query'      => array(
            'relation'       => 'AND',
            array(
                'taxonomy'         => 'product_visibility',
                'terms'            => array('exclude-from-catalog', 'exclude-from-search'),
                'field'            => 'name',
                'operator'         => 'NOT IN',
                'include_children' => false,
            ), 
          ),
    ));
    }