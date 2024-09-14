<div class="section_collections">
    <div class="section_title">
        <h3 class="title"><?php echo $page_content['collections']['title'];?></h3>
        <p class="subtitle">
            <?php echo $page_content['collections']['subtitle'];?>
        </p>
    </div>
    <div class="all_collection">
      <?php 
      $collections_args = array(
        'taxonomy'   => 'collections',
        'meta_key'   => 'collection_data_featured',
        'meta_value' => true
      );
      $collections = get_terms($collections_args);
      if(!empty($collections)){
        foreach($collections as $collection){
          $collection_data = get_field('collection_data', 'collections_'.$collection->term_id);
          if(!empty($collection_data['image'])){
            $collection_img  = $collection_data['image'];
          }else{
            $collection_img  = wc_placeholder_img_src();
          }
          ?>
          <a href="<?php echo get_term_link($collection->term_id);?>" class="single_collection">
            <img src="<?php echo $collection_img;?>" alt="">
            <div class="box">
              <div class="box_content">
                  <h5 class="title"><?php echo $collection->name;?></h5>
                  <p class="brand">Collection</p>
                  <?php 
                  if(!empty($collection_data['starts_from'])){
                    ?>
                    <span class="price">Starts from <?php echo $collection_data['starts_from'];?> EGP</span>
                    <?php 
                  }
                  ?>
              </div>
            </div>
          </a>
          <?php 
        }
      }
      // echo '<pre>';
      // var_dump($collections);
      // echo '</pre>';
      ?>
    </div>
</div>
