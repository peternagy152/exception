
<?php
// Get All Categories  
$taxonomy     = 'product_cat';
$orderby      = 'name';
$show_count   = 0;  
$pad_counts   = 0;      
$hierarchical = 1;      
$title        = '';
$empty        = 0;

$args = array(
    'taxonomy'     => $taxonomy,
    'orderby'      => $orderby,
    'show_count'   => $show_count,
    'pad_counts'   => $pad_counts,
    'hierarchical' => $hierarchical,
    'title_li'     => $title,
    'hide_empty'   => $empty
);

$categories = get_categories($args);

?>

<div class="input_search">
    <input type="search" onkeydown="search(this)"  placeholder="البحث في المنتجات" autocomplete="off" value="<?php if(isset($_GET['search'])){echo $_GET["search"] ;} ?>">
</div>

<select id="category">
  <option value="">نوع الصنف</option>
  <?php foreach($categories as $one_category){?>
    <option value="<?php echo $one_category->term_id  ?>" <?php if(isset($_GET['cat'])){if( $_GET['cat'] == $one_category->term_id ){echo 'selected';}} ?>> <?php echo get_field('attribute_in_arabic', 'product_cat_' . $one_category->term_id) ?></option>
    <?php }  ?>
</select>


