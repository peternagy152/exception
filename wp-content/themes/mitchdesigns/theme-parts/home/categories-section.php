<div class="section_categories">
    <div class="grid">
        <div class="section_title">
              <h3><?php echo $home_content['categories_title'] ; ?></h3>
              <?php echo $home_content['categories_subtitle'] ; ?>
        </div>
        <div class="all_categories">
          <?php foreach($home_content['categories_content'] as $one_category){?>
            <div class="single_category">
                <a href="<?php echo $one_category['category_link'] ?>">
                    <img src="<?php echo $one_category['category_image'] ?>" alt="">
                    <div class="title_cat">
                      <h4><?php echo $one_category['category_title'] ; ?></h4>
                      <p><?php echo $one_category['category_subtitle'] ; ?></p> 
                    </div>
                </a>
            </div>
          <?php } // End Category Loop  ?>
        </div>
    </div>
</div>